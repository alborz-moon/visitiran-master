<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\SellerResource;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.seller.list', ['items' => SellerResource::collection(Seller::all())->toArray($request)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.seller.create');
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
            $filename = $request->image_file->store('public/sellers');
            $request['logo'] = str_replace('public/sellers/', '', $filename);
        }

        Seller::create($request->toArray());
        return Redirect::route('seller.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Seller $seller, Request $request)
    {
        return view('admin.seller.create', ['item' => SellerResource::make($seller)->toArray($request)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller)
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
           
            $filename = $request->image_file->store('public/sellers');
            $filename = str_replace('public/sellers/', '', $filename);

           if($seller->logo != null &&
                file_exists(__DIR__ . '/../../../public/storage/sellers/' . $seller->logo)
            ) {
                unlink(__DIR__ . '/../../../public/storage/sellers/' . $seller->logo);
            }

            $seller->logo = $filename;
        }

        $seller->alt = $request->has('alt') ? $request['alt'] : $seller->alt;
        $seller->name = $request->has('name') ? $request['name'] : $seller->name;

        $seller->save();
        return Redirect::route('seller.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        $deleted = $seller->delete();
        if($deleted && $seller->logo != null && 
            file_exists(__DIR__ . '/../../../public/storage/sellers/' . $seller->logo)
        )
            unlink(__DIR__ . '/../../../public/storage/sellers/' . $seller->logo);

        if($deleted)
            return response()->json(['status' => 'ok']);
        
        return response()->json(['status' => 'nok', 'msg' => 'لطفا ابتدا محصولاتی که از این فروشنده استفاده می کنند را حذف نمایید.']);
    }
}
