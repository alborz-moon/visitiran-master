<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Shop\Utility\ProductHelper;
use App\Http\Resources\CategoryDigest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryUserDigest;
use App\Http\Resources\CategoryVeryDigest;
use App\Http\Resources\FeatureResourceUser;
use App\Http\Resources\HeadCategoryResource;
use App\Http\Resources\ProductDigestUser;
use App\Imports\CategoryImport;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{


    public function search(Request $request) {

        $validator = [
            // 'key' => 'required|persian_alpha|min:2|max:15',
            'key' => 'required|min:2|max:15'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);
        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        $categories = Category::where('name', 'like', '%' . $request['key'] . '%')
            ->get();
        
        return response()->json([
            'status' => 'ok',
            'data' => CategoryDigest::collection($categories)->toArray($request)
        ]);
    }


    public function get_top_categories_products(Request $request)
    {
        $categories = Category::topProducts()->visible()->get();
        $arr = [];

        foreach($categories as $category) {
            
            $products = $category->products()->visible()->get();
            
            if(count($products) == 0)
                continue;

            $items = ProductDigestUser::collection($products)->toArray($request);
            array_push($arr, [
                'id' => $category->id,
                'name' => $category->name,
                'products' => $items
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'data' => $arr
        ]);
    }

    public function uploadCategories(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        $import = new CategoryImport;
        $import->import($request->file);
        $errors = [];

        foreach ($import->failures() as $failure) {
            array_push($errors, "row " . $failure->row() . ' ' . $failure->errors()[0]);
        }
        
        if(count($errors) > 0)
            return view('admin.category.list')->with(compact('errors'));

        return redirect()->route('category.index');
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = CategoryVeryDigest::collection(Category::all())->toArray($request);
        return view('admin.category.create', compact('categories'));
    }

    public function edit(Category $category, Request $request, string $err = null) {
        
        $categories = Category::all();
        $arr = [];
        foreach($categories as $cat) {
            
            if($cat->products()->count() > 0)
                continue;

            array_push($arr, $cat);
        }

        return view('admin.category.create', [
            'item' => CategoryResource::make($category)->toArray($request),
            'categories' => CategoryVeryDigest::collection($arr)->toArray($request),
            'err' => $err
        ]);

    }

    public function show(Category $category, Request $request) {
        
        if(!$category->visibility)
            return Redirect::route('403');

        $where = "";
        if($category->products()->count() > 0)
            $where = 'category_id = ' . $category->id;
        else {
            $catIds = ProductHelper::get_all_subs_ids($category);
            $where = "(";
            $where .= 'category_id = ' . $category->id;
            $first = false;

            foreach($catIds as $catId) {
                if($first) {
                    $where .= 'category_id = ' . $catId;
                    $first = false;
                }
                else
                    $where .= ' or category_id = ' . $catId;
            }
            $where .= ")";
        }

        $catId = $category->id;
        $whereClause = "products.visibility = true and " . $where;
        
        $minMax = DB::select('select max(price) as maxPrice, min(price) as minPrice from products where ' . $whereClause);
        $sellers = DB::select('select distinct(seller_id) as id, sellers.name from sellers, products where seller_id = sellers.id and ' . $whereClause);
        $brands = DB::select('select distinct(brand_id) as id, brands.name from products, brands where brand_id = brands.id and ' . $whereClause);

        $path = [
            [
                'label' => 'خانه',
                'href' => route('home')
            ]
        ];

        $currNode = $category;
        while($currNode->parent_id != null) {
            
            $currNode = $currNode->parent;

            array_push($path, [
                'label' => $currNode->name,
                'href' => route('single-category', ['category' => $currNode->id, 'slug' => $currNode->name])
            ]);
        }
        
        array_push($path, [
            'label' => $category->name,
            'href' => route('single-category', ['category' => $category->id, 'slug' => $category->name])
        ]);

        return view('shop.list', [
            'path' => $path,
            'parent' => $category->parent_id == null ? null : $path[1],
            'name' => $category->name,
            'id' => $category->id,
            'has_sub' => count($category->sub) > 0,
            'sellers' => $sellers,
            'brands' => $brands,
            'maxPrice' => $minMax[0]->maxPrice,
            'minPrice' => $minMax[0]->minPrice,
            'features' => FeatureResourceUser::collection($category->features()->multiChoice()->get())->toArray($request)
        ]);
    }

    
    public function allCategories(string $orderBy, Request $request) {
        
        $catId = null;
        $whereClause = $catId == null ? "products.visibility = true" : "products.visibility = true and category_id = " . $catId;
        $minMax = DB::select('select max(price) as maxPrice, min(price) as minPrice from products where ' . $whereClause);
        $categories = DB::select('select distinct(category_id) as id, categories.name from products, categories where category_id = categories.id and ' . $whereClause);
        $sellers = DB::select('select distinct(seller_id) as id, sellers.name from sellers, products where seller_id = sellers.id and ' . $whereClause);
        $brands = DB::select('select distinct(brand_id) as id, brands.name from products, brands where brand_id = brands.id and ' . $whereClause);
        
        return view('shop.list', [
            'path' => [],
            'orderBy' => $orderBy,
            'name' => 'تازه ترین ها',
            'features' => [],
            'has_sub' => false,
            'categories' => $categories,
            'sellers' => $sellers,
            'brands' => $brands,
            'maxPrice' => $minMax[0]->maxPrice,
            'minPrice' => $minMax[0]->minPrice,
        ]);

    }


    public function sub(Category $category, Request $request) {
        return view('admin.category.list', [
                'categories' => CategoryDigest::collection($category->sub()->get())->toArray($request),
                'name' => $category->name,
                'hasProduct' => $category->products()->count() > 0,
                'isHead' => $category->parent_id == null,
                'parent_id' => $category->parent_id == null ? -1 : $category->parent_id,
            ]
        );
    }

    public function index(Request $request) {

        if($request->user() != null && 
            (
                $request->user()->level == User::$ADMIN_LEVEL ||
                $request->user()->level == User::$EDITOR_LEVEL
            )
        ) {
            return view('admin.category.list', [
                'categories' => CategoryDigest::collection(Category::head()->get())->toArray($request),
                'name' => '',
                'isHead' => true,
            ]);
        }

        $cats = Category::visible()->top()->get();
        $menuCats = Category::visible()->head()->get();

        return response()->json(
            [
                'data' => [
                    "top" => CategoryUserDigest::collection($cats)->toArray($request),
                    "menu" => HeadCategoryResource::collection($menuCats)->toArray($request),
                ],
                'status' => 'ok'
            ]
        );
    }

    public function top(Request $request, Category $category = null) {

        if($category == null)
            $cats = Category::visible()->top()->get();
        
        else {

            $cats = [];
            $queue = Category::where('parent_id', $category->id)->visible()->get()->toArray();
            
            while(count($queue) > 0) {

                $cat = array_pop($queue);

                array_push($cats, $cat);
                $tmp = Category::where('parent_id', $cat['id'])->visible()->get()->toArray();
                foreach($tmp as $itr) {
                    array_push($queue, $itr);
                }
                
            }
        }

        

        return response()->json(
            [
                'data' => CategoryUserDigest::collection($cats)->toArray($request),
                'status' => 'ok'
            ]
        );
    }

    public function list(Request $request) {

        $menuCats = Category::visible()->head()->get();

        return response()->json(
            [
                'data' => HeadCategoryResource::collection($menuCats)->toArray($request),
                'status' => 'ok'
            ]
        );
    }

    public function store(Request $request) {
        
        $request->validate([
            'name' => 'required|string|min:1',
            'img_file' => 'nullable|image',
            'visibility' => 'nullable|boolean',
            'priority' => 'required|integer',
            'alt' => 'nullable|string|min:1'
        ]);

        if($request->has('img_file')) {
            $filename = $request->img_file->store('public/categories');
            $filename = str_replace('public/categories/', '', $filename);

            $request['img'] = $filename;
        }
        Category::create($request->toArray());
        return Redirect::route('category.index');
    }

    
    public function update(Category $category, Request $request) {
        
        $validator = [
            'name' => 'nullable|string|min:1',
            'image_file' => 'nullable|image',
            'visibility' => 'nullable|boolean',
            'priority' => 'nullable|integer|min:1',
            'alt' => 'nullable|string|min:1',
            'keywords' => 'nullable|string|min:1',
            'tags' => 'nullable|string|min:1',
            'digest' => 'nullable|string|min:1',
            'parent_id' => 'nullable|exists:categories,id',
            'show_in_first_page' => 'nullable|boolean',
            'show_items_in_first_page' => 'nullable|boolean',
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);
        if(empty($request['parent_id']))
            unset($request['parent_id']);
        
        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);
        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        if($request->has('parent_id')) {
            $cat = Category::whereId($request['parent_id'])->first();
            if($cat->products()->count() > 0)
                return $this->edit($category, $request, '.دسته بالادستی موردنظر دارای محصول است');

            $category->parent_id = $request['parent_id'];
        }
        else
            $category->parent_id = null;

        if($request->has('image_file')) {
            $filename = $request->image_file->store('public/categories');
            $filename = str_replace('public/categories/', '', $filename);
            
            if($category->img != null && file_exists(__DIR__ . '/../../../../public/storage/categories/' . $category->img))
                unlink(__DIR__ . '/../../../../public/storage/categories/' . $category->img);
            
            $category->img = $filename;
        }

        foreach($request->keys() as $str) {
            
            if($str == "_token" || $str == "image_file")
                continue;

            $category[$str] = $request[$str];
        }

        $category->save();

        return Redirect::route('category.index');
    }

    public function destroy(Category $category) {

        if($category->products()->count() > 0)
            return response()->json(['status' => 'nok', 'msg' => 'لطفا ابتدا محصولات این دسته را حذف نمایید']);

        if($category->img != null && file_exists(__DIR__ . '/../../../../public/storage/categories/' . $category->img))
            unlink(__DIR__ . '/../../../../public/storage/categories/' . $category->img);

        $category->delete();
        return response()->json(['status' => 'ok']);
    }
}
