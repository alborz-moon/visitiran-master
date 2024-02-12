<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Shop\Utility\ProductHelper;
use App\Exports\ProductExport;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryDigest;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\OrderDigestResource;
use App\Http\Resources\ProductDigest;
use App\Http\Resources\ProductDigestUser;
use App\Http\Resources\ProductFeatureResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceForUsers;
use App\Http\Resources\ProductVeryDigestResouece;
use App\Http\Resources\SellerResource;
use App\Imports\ProductImport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Config;
use App\Models\Product;
use App\Models\PurchaseItems;
use App\Models\Seller;
use App\Models\Similar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends ProductHelper
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', null);
        $cat = $request->query('category', null);
        $brand = $request->query('brand', null);
        $category = $request->query('category', null);
        $seller = $request->query('seller', null);
        $visibility = $request->query('visibility', null);
        $orderBy = $request->query('orderBy', null);
        $orderByType = $request->query('orderByType', null);
        $isInTopList = $request->query('isInTopList', null);
        $max = $request->query('max', null);
        $min = $request->query('min', null);
        $off = $request->query('off', null);
        $comment = $request->query('comment', null);
        $fromCreatedAt = $request->query('fromCreatedAt', null);
        $toCreatedAt = $request->query('toCreatedAt', null);
        
        $filters = self::build_filters($request);
        $products = $filters->paginate($limit == null ? 30 : $limit);
        

        if($request->user() != null && (
            $request->user()->level == User::$ADMIN_LEVEL ||
            $request->user()->level == User::$EDITOR_LEVEL
        )) {
            
            $categories = Category::all();
            $arr = [];
            foreach($categories as $cat) {
                if($cat->sub()->count() > 0)
                    continue;
                array_push($arr, $cat);
            }

            $output = ProductDigest::collection($products);

            return view('admin.product.list', [
                'items' => $output->toArray($request),
                'links' => $output->links(),
                'total_count' => $output->total(),
                'visibilityFilter' => $visibility,
                'isInTopListFilter' => $isInTopList,
                'sellerFilter' => $seller,
                'brandFilter' => $brand,
                'categoryFilter' => $category,
                'maxFilter' => $max,
                'minFilter' => $min,
                'orderBy' => $orderBy,
                'orderByType' => $orderByType,
                'offFilter' => $off,
                'commentFilter' => $comment,
                'fromCreatedAtFilter' => $fromCreatedAt,
                'toCreatedAtFilter' => $toCreatedAt,
                'categories' => CategoryDigest::collection($arr)->toArray($request),
                'brands' => BrandResource::collection(Brand::all())->toArray($request),
                'sellers' => SellerResource::collection(Seller::all())->toArray($request),
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'data' =>  ProductDigestUser::collection($products)->toArray($request)
        ]);
    }


    public function search(Request $request) {

        $validator = [
            // 'key' => 'required|persian_alpha|min:2|max:15',
            'key' => 'required|min:2|max:15',
            'category_id' => 'nullable|integer|exists:categories,id',
            'return_type' => ['required', Rule::in(['digest', 'card'])]
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        $products = Product::like($request['key'], 
            $request->has('category_id') ? $request['category_id'] : null,
            $request['return_type']
        );

        
        if($request['return_type'] == 'digest')
            return ProductVeryDigestResouece::collection($products)->toArray($request);
        
        return response()->json([
            'status' => 'ok',
            'data' => ProductDigestUser::collection($products)->toArray($request)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {

        $validator = [
            'key' => 'nullable|persian_alpha|min:2|max:15'
        ];

        $validator = Validator::make($request->query(), $validator);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $limit = $request->query('limit', 8);
        $key = $request->query('key', null);
        $page = $request->query('page', 1);

        if($key != null && $page > 1)
            return abort(401);
        
        $filters = self::build_filters($request, true, $key != null);

        if($key == null) {
            $products = $filters->skip(($page - 1) * $limit)->take($limit)->get();
        }
        else {
            $products = Product::like($key, null, 'card', $filters);
        }

        return response()->json([
            'status' => 'ok',
            'count' => count($products),
            'data' => ProductDigestUser::collection($products)->toArray($request),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function similars(Product $product, Request $request)
    {
        
        $products = Similar::where('product_id', $product->id)->first();
        if($products == null) {
            return response()->json([
                'status' => 'ok',
                'data' =>  []
            ]);
        }

        $data = $products->getAttributes();

        $similars = [];

        for($i = 1; $i < 9; $i++) {
            
            if($data['sim_' . $i] == null)
                break;
            
            array_push($similars,
                ProductDigestUser::make(Product::find($data['sim_' . $i]))->toArray($request)
            );
        }
        
        
        return response()->json([
            'status' => 'ok',
            'data' => $similars
        ]);
    }

    public function excel(Request $request) {
        $filters = self::build_filters($request);
        $products = ProductDigest::collection($filters->get())->toArray($request);
        $export = new ProductExport($products);
        return Excel::download($export, 'products.xlsx');
    }

    public function addBatchProducts(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        $import = new ProductImport;
        $import->import($request->file);
        $errors = [];

        foreach ($import->failures() as $failure) {
            array_push($errors, "row " . $failure->row() . ' ' . $failure->errors()[0]);
        }
        
        if(count($errors) > 0)
            return view('admin.product.list')->with(compact('errors'));

        return redirect()->route('product.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $categories = Category::all();
        $arr = [];
        foreach($categories as $cat) {
            if($cat->sub()->count() > 0)
                continue;
            array_push($arr, $cat);
        }

        return view('admin.product.create', [
            'brands' => BrandResource::collection(Brand::all())->toArray($request),
            'sellers' => SellerResource::collection(Seller::all())->toArray($request),
            'categories' => CategoryDigest::collection($arr)->toArray($request),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('seller_id') && $request['seller_id'] == -1)
            $request['seller_id'] = null;

        $validator = [
            'name' => 'required|string|min:2',
            'slug' => 'nullable|string|min:2',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'seller_id' => 'nullable|exists:sellers,id',
            'description' => 'nullable|string|min:2',
            'digest' => 'nullable|string|min:2',
            'keywords' => 'nullable|string|min:2',
            'tags' => 'nullable|string|min:2',
            'price' => 'required|integer|min:0',
            'priority' => 'required|integer|min:0',
            'is_in_top_list' => 'required|boolean',
            'visibility' => 'required|boolean',
            'img_file' => 'nullable|image',
            'alt' => 'nullable|string|min:2',
            'guarantee' => 'nullable|integer|min:0',
            'introduce' => 'nullable|string|min:2',
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        if($request->has('img_file')) {
            $filename = $request->img_file->store('public/products');
            $filename = str_replace('public/products/', '', $filename);

            $request['img'] = $filename;
        }

        Product::create($request->toArray());
        return Redirect::route('product.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, Request $request, $err = null)
    {
        
        $categories = Category::all();
        $arr = [];
        foreach($categories as $cat) {

            if($cat->sub()->count() > 0)
                continue;

            array_push($arr, $cat);
        }

        return view('admin.product.create', [
            'item' => ProductResource::make($product)->toArray($request),
            'brands' => BrandResource::collection(Brand::all())->toArray($request),
            'sellers' => SellerResource::collection(Seller::all())->toArray($request),
            'categories' => CategoryDigest::collection($arr)->toArray($request),
            'err' => $err
        ]);   
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function editOff(Product $product, $err=null)
    {
        return view('admin.product.off', [
            'item' => [
                'off' => $product->off,
                'off_expiration' => $product->off_expiration == null ? '' : self::convertStringToDate($product->off_expiration),
                'off_type' => $product->off_type,
                'name' => $product->name,
                'id' => $product->id,
            ],
            'err' => $err
        ]);   
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function removeOff(Product $product)
    {
        $product->off = null;
        $product->off_type = null;
        $product->off_expiration = null; 
        $product->save();

        return response()->json([
            'status' => 'ok'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if($request->has('seller_id') && $request['seller_id'] == -1)
            $request['seller_id'] = null;

        $validator = [
            'name' => 'nullable|string|min:2',
            'slug' => 'nullable|string|min:2',
            'category_id' => 'nullable|exists:categories,id',
            'seller_id' => 'nullable|exists:sellers,id',
            'digest' => 'nullable|string|min:2',
            'keywords' => 'nullable|string|min:2',
            'tags' => 'nullable|string|min:2',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string|min:2',
            'price' => 'nullable|integer|min:0',
            'off' => 'nullable|integer|min:0',
            'visibility' => 'nullable|boolean',
            'off_type' => ['nullable', Rule::in('value', 'percent')],
            'off_expiration' => 'nullable|date',
            'available_count' => 'nullable|integer|min:0',
            'priority' => 'nullable|integer|min:0',
            'is_in_top_list' => 'nullable|boolean',
            'img_file' => 'nullable|image',
            'alt' => 'nullable|string|min:2',
            'guarantee' => 'nullable|integer|min:0',
            'introduce' => 'nullable|string|min:2',
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        if($request->has('slug') && $request['slug'] != $product->slug && 
            Product::where('slug', $request['slug'])->count() > 0)
            return $this->edit($product, $request, 'slug وارد شده در سیستم موجود است.');


        if($request->has('off_expiration')) {
            $today = self::getToday()['date'];
            $expiration = self::convertDateToString($request['off_expiration']);
            if((int)$today >= (int)$expiration)
                return $this->editOff($product, 'تاریخ انقضا باید از امروز بزرگتر باشد.');

            $request['off_expiration'] = $expiration;
        }

        if($request->has('off')) {
            
            if(!$request->has('off_type') && $product->off_type == null)
                return $this->editOff($product, 'لطفا نوع کد نخفیف را مشخص نمایید.');
            
            $product->off_type = $request->has('off_type') ? $request['off_type'] : $product->off_type;
            if($product->off_type == 'percent' && ($request['off'] > 100  || $request['off'] < 1))
                return $this->editOff($product, 'میزان تخفیف باید بین 1 تا 100 باشد.');
        }
        
        if($request->has('img_file')) {
         
            $filename = $request->img_file->store('public/products');
            $filename = str_replace('public/products/', '', $filename);   
                
            if($product->img != null && !empty($product->img) && 
                file_exists(__DIR__ . '/../../../../public/storage/products/' . $product->img))
                unlink(__DIR__ . '/../../../../public/storage/products/' . $product->img);

            $product->img = $filename;
        }

        foreach($request->keys() as $key) {
            if($key == '_token' || $key == 'img_file')
                continue;
            $product[$key] = $request[$key];
        }

        $product->save();
        return Redirect::route('product.index');
    }
    
    /**
     * show the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        if(!$product->visibility)
            return Redirect::route('403');

        return response()->json([
            'status' => 'ok', 
            'galleries' => GalleryResource::collection($product->galleries()->orderBy('priority', 'asc')->get())->toArray($request),
            'features' => ProductFeatureResource::collection($product->featuresWithValue())->toArray($request)
        ]);
    }

    
    /**
     * show the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function showDetail(Request $request, Product $product, string $slug) {

        if(!$product->visibility || 
            ($product->slug != null && $slug != $product->slug) ||
            ($product->slug == null && $slug != $product->name)
        )
            return Redirect::route('home');

        $product->seen = $product->seen + 1;
        $product->save();
        
        $user = $request->user();
        
        if($user == null)
            return view('shop.product', [
                'product' => array_merge(
                    ProductResourceForUsers::make($product)->toArray($request), [
                        'is_bookmark' => false,
                        'user_rate' => null,
                        'has_comment' => false,
                    ]), 
                    'critical_point' => Config::where('site', 'shop')->first()->critical_point,
                    'is_login' => false,
            ]);
            
        $comment = Comment::userComment($product->id, $user->id);
        return view('shop.product', [
            'product' => array_merge(
                ProductResourceForUsers::make($product)->toArray($request), 
                [
                    'is_bookmark' => $comment != null && $comment->is_bookmark != null ? $comment->is_bookmark : false,
                    'user_rate' => $comment != null ? $comment->rate : null,
                    'has_comment' => $comment != null && $comment->msg != null,
                ]), 
                'is_login' => true,
                'critical_point' => Config::where('site', 'shop')->first()->critical_point,
        ]);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function changeVisibility(Request $request, Product $product = null)
    {
        if($product == null)
            return;

        $validator = [
            'visibility' => 'required|boolean',
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);
        $product->visibility = $request['visibility'];

        $product->save();
        return response()->json(['status' => 'ok']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function updateAvailableCount(Request $request, Product $product = null)
    {
        if($product == null)
            return;

        $validator = [
            'available_count' => 'required|integer|min:0',
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        $product->available_count = $request['available_count'];

        $product->save();
        return response()->json(['status' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if(PurchaseItems::where('product_id', $product->id)->count() > 0) {
            return response()->json(['status' => 'nok', 'msg' => 'فردی این محصول را خریداری کرده است و امکان حذف آن وجود ندارد.']);
        }

        $productGalleryController = new GalleryController();
        foreach($product->galleries as $gallery)
            $productGalleryController->destroy($gallery);

        $deleted = $product->delete();
        if($deleted) {
            if($product->img != null && 
                file_exists(__DIR__ . '/../../../../public/storage/products/' . $product->img))
                unlink(__DIR__ . '/../../../../public/storage/products/' . $product->img);

            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'nok', 'msg' => 'خطا در حذف محصول موردنظر']);
    }

    public function getMyBookmarks(Request $request) {

        $products = ProductDigestUser::collection
        (
            Product::whereIn('id', 
                Comment::where('user_id', $request->user()->id)->where('is_bookmark', true)->pluck('product_id')->toArray()
            )->get()
        )->toArray($request);

        return response()->json(
            [
                'status' => 'ok',
                'data' => $products
            ]
        );
    }
}
