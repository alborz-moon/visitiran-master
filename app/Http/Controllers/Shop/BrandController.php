<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.brand.list', ['items' => BrandResource::collection(Brand::all())->toArray($request)]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
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
            'name' => 'required|string|min:2',
            'image_file' => 'nullable|image',
            'alt' => 'nullable|string|min:2'
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        if($request->has('image_file')) {
            $filename = $request->image_file->store('public/brands');
            $request['logo'] = str_replace('public/brands/', '', $filename);
        }

        Brand::create($request->toArray());
        return Redirect::route('brand.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand, Request $request)
    {
        return view('admin.brand.create', ['item' => BrandResource::make($brand)->toArray($request)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        
        $validator = [
            'name' => 'nullable|string|min:2',
            'image_file' => 'nullable|image',
            'alt' => 'nullable|string|min:2'
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        if($request->has('image_file')) {
           
            $filename = $request->image_file->store('public/brands');
            $filename = str_replace('public/brands/', '', $filename);

           if($brand->logo != null &&
                file_exists(__DIR__ . '/../../../../public/storage/brands/' . $brand->logo)
            ) {
                unlink(__DIR__ . '/../../../../public/storage/brands/' . $brand->logo);
            }

            $brand->logo = $filename;
        }

        $brand->alt = $request->has('alt') ? $request['alt'] : $brand->alt;
        $brand->name = $request->has('name') ? $request['name'] : $brand->name;

        $brand->save();
        return Redirect::route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $deleted = $brand->delete();
        if($deleted && $brand->logo != null && 
            file_exists(__DIR__ . '/../../../../public/storage/brands/' . $brand->logo)
        )
            unlink(__DIR__ . '/../../../../public/storage/brands/' . $brand->logo);

        if($deleted)
            return response()->json(['status' => 'ok']);
        
        return response()->json(['status' => 'nok', 'msg' => 'لطفا ابتدا محصولاتی که از این برند استفاده می کنند را حذف نمایید.']);
    }
}
