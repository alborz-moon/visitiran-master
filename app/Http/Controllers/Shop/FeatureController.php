<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeatureResource;
use App\Models\Category;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category, Request $request)
    {
        return view('admin.category.features.list', [
            'items' => FeatureResource::collection($category->features)->toArray($request),
            'categoryId' => $category->id,
            'categoryName' => $category->name
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category, string $err = null)
    {
        return view('admin.category.features.create', [
            'categoryId' => $category->id,
            'categoryName' => $category->name,
            'err' => $err
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Category $category, Request $request)
    {
        if($category->sub()->count() > 0)
            return $this->create($category, 'دسته انتخاب شده دارای زیردسته است.');

        $validator = [
            'name' => 'required|string|min:2',
            'unit' => 'nullable|string|min:2',
            'show_in_top' => 'nullable|boolean',
            'effect_on_price' => 'nullable|boolean',
            'effect_on_available_count' => 'nullable|boolean',
            'answer_type' => ['required', Rule::in(['number', 'text', 'longtext', 'multi_choice'])],
            'choices' => 'nullable|array|min:1',
            'choices.*.key' => 'required|string|min:2',
            'choices.*.label' => 'nullable|string|min:2',
            'priority' => 'required|integer|min:1'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        if($request['answer_type'] == 'multi_choice' && !$request->has('choices'))
            return $this->create($category, 'لطفا گزینه های پاسخ را مشخص نمایید.');
            
        if($request['answer_type'] != 'multi_choice' && $request->has('choices'))
            return $this->create($category, 'پارامترهای ورودی معتبر نمی باشند.');

        if($request->has('effect_on_price') && $request->has('effect_on_available_count') && 
            $request['effect_on_available_count'] && $request['effect_on_price']
        )
            return $this->create($category, 'نمی توان همزمان یک ویژگی هم بر روی قیمت و هم موجودی تاثیر گذار باشد.');
            
        $request['category_id'] = $category->id;

        if($request->has('choices')) {
            $choicesStr = "";

            foreach($request['choices'] as $itr) {
                if(empty($itr['label']))
                    $choicesStr .= $itr['key'] . '$$' . $itr['key'] . '__';
                else
                    $choicesStr .= $itr['key'] . '$$' . $itr['label'] . '__';
            }
            
            $request['choices'] = substr($choicesStr, 0, strlen($choicesStr) - 2);
        }

        Feature::create($request->toArray());
        return Redirect::route('category.features.index', ['category' => $category->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature, Request $request, $err = null)
    {
        $cat = $feature->category;
        return view('admin.category.features.create', [
            'item' => FeatureResource::make($feature)->toArray($request),
            'categoryId' => $cat->id,
            'categoryName' => $cat->name,
            'err' => $err
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feature $feature)
    {
        $cat = $feature->category;

        if($cat->sub()->count() > 0)
            return $this->edit($feature, $request, 'دسته انتخاب شده دارای زیردسته است.');

        $validator = [
            'name' => 'nullable|string|min:2',
            'unit' => 'nullable|string|min:2',
            'show_in_top' => 'nullable|boolean',
            'effect_on_price' => 'nullable|boolean',
            'effect_on_available_count' => 'nullable|boolean',
            'answer_type' => ['nullable', Rule::in(['number', 'text', 'longtext', 'multi_choice'])],
            'choices' => 'nullable|array|min:1',
            'choices.*.key' => 'required|string|min:2',
            'choices.*.label' => 'nullable|string|min:2',
            'priority' => 'nullable|integer|min:1'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        if($request->has('answer_type') && $request['answer_type'] == 'multi_choice' && !$request->has('choices'))
            return $this->edit($feature, $request, 'لطفا گزینه های پاسخ را مشخص نمایید.');
            
        if($request->has('answer_type') && $request['answer_type'] != 'multi_choice' && $request->has('choices'))
            return $this->edit($feature, $request, 'پارامترهای ورودی معتبر نمی باشند.');

        if($request->has('choices')) {
            $choicesStr = "";

            foreach($request['choices'] as $itr) {
                if($itr['label'] != null)
                    $choicesStr .= $itr['key'] . '$$' . $itr['label'] . '__';
                else
                    $choicesStr .= $itr['key'] . '$$__';
            }
            
            $request['choices'] = substr($choicesStr, 0, strlen($choicesStr) - 2);
        }

        foreach($request->keys() as $key) {
            
            if($key == '_token')
                continue;

            $feature[$key] = $request[$key];
        }

        $feature->save();

        return Redirect::route('category.features.index', ['category' => $cat->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        if($feature->productFeatures()->count() > 0)
            return response()->json(
                [
                    'status' => 'nok',
                    'msg' => 'محصولاتی از این ویژگی استفاده می کنند و امکان حذف آن وجود ندارد.'
                ]
            );

        $feature->delete();
        return response()->json(['status' => 'ok']);
    }
}
