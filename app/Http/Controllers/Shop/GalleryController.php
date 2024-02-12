<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product, Request $request)
    {
        return view('admin.product.galleries.list', [
            'items' => GalleryResource::collection($product->galleries)->toArray($request),
            'productId' => $product->id,
            'productName' => $product->name
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('admin.product.galleries.create', [
            'productId' => $product->id,
            'productName' => $product->name
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product, Request $request)
    {
        $validator = [
            'img_file' => 'required|image',
            'alt' => 'nullable|string|min:2',
            'priority' => 'required|integer|min:1'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        $filename = $request->img_file->store('public/products');
        $filename = str_replace('public/products/', '', $filename);

        $request['img'] = $filename;
        $request['product_id'] = $product->id;

        ProductGallery::create($request->toArray());
        return Redirect::route('product.productGallery.index', ['product' => $product->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductGallery $productGallery)
    {
        if(file_exists(__DIR__ . '/../../../../public/storage/products/' . $productGallery->img))
            unlink(__DIR__ . '/../../../../public/storage/products/' . $productGallery->img);

        $productGallery->delete();
        
        return response()->json([
            'status' => 'ok'
        ]);
    }
}
