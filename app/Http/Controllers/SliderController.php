<?php

namespace App\Http\Controllers;

use App\Http\Resources\SliderResource;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    
        if($request->getHost() == self::$EVENT_SITE)
            return view('admin.slider.list', [
                'items' => SliderResource::collection(Slider::event()->get())->toArray($request)
            ]);

        return view('admin.slider.list', [
                'items' => SliderResource::collection(Slider::shop()->get())->toArray($request)
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if($request->getHost() == self::$EVENT_SITE)
            return SliderResource::collection(Cache::tags('event')->rememberForever('slides', function() {
                return Slider::visible()->event()->orderBy('priority', 'desc')->get();
            }))->additional(['status' => 'ok']);

        return SliderResource::collection(Cache::tags('shop')->rememberForever('slides', function() {
            return Slider::visible()->shop()->orderBy('priority', 'desc')->get();
        }))->additional(['status' => 'ok']);
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider, Request $request)
    {
        return view('admin.slider.create', [
            'item' => SliderResource::make($slider)->toArray($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = [
            'alt' => 'nullable|string|min:2',
            'href' => 'nullable|string|url',
            'image_file_large' => 'required|image',
            'image_file_mid' => 'nullable|image',
            'image_file_small' => 'nullable|image',
            'priority' => 'required|integer',
            'visibility' => 'nullable|boolean',
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);
        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        $request['img_large'] = $request->image_file_large->store('public/slider');
        $request['img_large'] = str_replace('public/slider/', '', $request['img_large']);
        
        if($request->has('image_file_mid')) {
            $request['img_mid'] = $request->image_file_mid->store('public/slider');
            $request['img_mid'] = str_replace('public/slider/', '', $request['img_mid']);
        }
        
        if($request->has('image_file_small')) {
            $request['img_small'] = $request->image_file_small->store('public/slider');
            $request['img_small'] = str_replace('public/slider/', '', $request['img_small']);
        }

        $request['site'] = $request->getHost() == self::$EVENT_SITE ? 'event' : 'shop';
        slider::create($request->toArray());
        return Redirect::route('slider.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $validator = [
            'alt' => 'nullable|string|min:2',
            'href' => 'nullable|url',
            'image_file_large' => 'nullable|image',
            'image_file_mid' => 'nullable|image',
            'image_file_small' => 'nullable|image',
            'priority' => 'nullable|integer',
            'visibility' => 'nullable|boolean',
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        if($request->has('image_file_large')) {
            $filename = $request->image_file_large->store('public/slider');
            $filename = str_replace('public/slider/', '', $filename);

            if(file_exists(__DIR__ . '/../../../public/storage/slider/' . $slider->img_large))
                unlink(__DIR__ . '/../../../public/storage/slider/' . $slider->img_large);
            
            $slider->img_large = $filename;
        }

        if($request->has('image_file_mid')) {
            $filename = $request->image_file_mid->store('public/slider');
            $filename = str_replace('public/slider/', '', $filename);
            
            if($slider->img_mid != null && file_exists(__DIR__ . '/../../../public/storage/slider/' . $slider->img_mid))
                unlink(__DIR__ . '/../../../public/storage/slider/' . $slider->img_mid);
            
            $slider->img_mid = $filename;
        }
        
        if($request->has('image_file_small')) {
            $filename = $request->image_file_small->store('public/slider');
            $filename = str_replace('public/slider/', '', $filename);
            
            if($slider->img_small != null && file_exists(__DIR__ . '/../../../public/storage/slider/' . $slider->img_small))
                unlink(__DIR__ . '/../../../public/storage/slider/' . $slider->img_small);
            
            $slider->img_small = $filename;
        }

        $slider->href = $request->has('href') ? $request['href'] : $slider->href;
        $slider->alt = $request->has('alt') ? $request['alt'] : $slider->alt;
        $slider->visibility = $request->has('visibility') ? $request['visibility'] : $slider->visibility;
        $slider->priority = $request->has('priority') ? $request['priority'] : $slider->priority;

        $slider->save();
        return Redirect::route('slider.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        if(file_exists(__DIR__ . '/../../../public/storage/slider/' . $slider->img_large))
            unlink(__DIR__ . '/../../../public/storage/slider/' . $slider->img_large);

        if($slider->img_mid != null && !empty($slider->img_mid) && file_exists(__DIR__ . '/../../../public/storage/slider/' . $slider->img_mid))
            unlink(__DIR__ . '/../../../public/storage/slider/' . $slider->img_mid);

        if($slider->img_small != null && !empty($slider->img_small) && file_exists(__DIR__ . '/../../../public/storage/slider/' . $slider->img_small))
            unlink(__DIR__ . '/../../../public/storage/slider/' . $slider->img_small);

        $slider->delete();
        return response()->json(['status' => 'ok']);
    }
}
