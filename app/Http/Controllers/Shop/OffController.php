<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryDigest;
use App\Http\Resources\OffResource;
use App\Http\Resources\SellerResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Off;
use App\Models\Seller;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $site = $request->getHost() == self::$EVENT_SITE ? 'event' : 'shop';
        $filter = Off::where('site', $site);
        
        $expired = $request->query('expired', null);
        $general = $request->query('general', null);
        $type = $request->query('type', null);
        $brand_id = $request->query('brand', null);
        $category_id = $request->query('category', null);
        $seller_id = $request->query('seller', null);
        $from_expiration = $request->query('from_expiration', null);
        $to_expiration = $request->query('to_expiration', null);

        $order_by = $request->query('order_by', null);
        $order_by_type = $request->query('order_by_type', null);

        $today = (int)self::getToday()['date'];

        if($expired == null || !$expired)
            $filter->where('off_expiration', '>=', $today);
        else
            $filter->where('off_expiration', '<', $today);

        if($type != null)
            $filter->where('off_type', $type);

        if($from_expiration != null) {
            $from_expiration = (int)self::convertDateToString($from_expiration);
            $filter->where('off_expiration', '>=', $from_expiration);
        }
        
        if($to_expiration != null) {
            $to_expiration = (int)self::convertDateToString($to_expiration);
            $filter->where('off_expiration', '<=', $to_expiration);
        }

        if($general != null && $general)
            $filter->whereNull('user_id');
        else if($general != null)
            $filter->whereNotNull('user_id');

        if($brand_id != null)
            $filter->where('brand_id', $brand_id);
            
        if($category_id != null)
            $filter->where('category_id', $category_id);
            
        if($seller_id != null)
            $filter->where('seller_id', $seller_id);

        if($order_by == null ||
            ($order_by != 'createdAt' && $order_by != 'expiredAt')
        ) {
            $order_by = 'createdAt';
            $order_by_type = 'asc';
            $filter->orderBy('id', 'desc');
        }
        else {
            if($order_by_type != 'asc' && $order_by_type != 'desc')
                $order_by_type = 'asc';

            if($order_by == 'createdAt')
                $filter->orderBy('id', $order_by_type);

            if($order_by == 'expiredAt')
                $filter->orderBy('off_expiration', $order_by_type);
        }

        $offs = $filter->paginate(20);

        if($site == 'event')
            return view('admin.off.event_list', [
                'items' => OffResource::collection($offs)->toArray($request),
                'links' => $offs->links(),
                'categories' => CategoryDigest::collection(Category::all())->toArray($request),
                'brands' => BrandResource::collection(Brand::all())->toArray($request),
                'sellers' => SellerResource::collection(Seller::all())->toArray($request),
            ]);
            
        return view('admin.off.list', [
            'items' => OffResource::collection($offs)->toArray($request),
            'links' => $offs->links(),
            'categories' => CategoryDigest::collection(Category::all())->toArray($request),
            'brands' => BrandResource::collection(Brand::all())->toArray($request),
            'sellers' => SellerResource::collection(Seller::all())->toArray($request),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $err=null)
    {
        if($request->getHost() == self::$SHOP_SITE)
            return view('admin.off.create', [
                'categories' => CategoryDigest::collection(Category::all())->toArray($request),
                'brands' => Brand::all(),
                'sellers' => Seller::all(),
                'err' => $err
            ]);
        
        return view('admin.off.create', [
            'err' => $err
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
            
        if($request->has('category_id') && $request['category_id'] == -1)
            $request['category_id'] = null;
            
        if($request->has('brand_id') && $request['brand_id'] == -1)
            $request['brand_id'] = null;

        $validator = [
            'amount' => 'required|integer|min:0',
            'off_type' => ['required', Rule::in(['value', 'percent'])],
            'off_expiration' => 'required|date',
            'username' => 'nullable|exists:users,phone',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'seller_id' => 'nullable|exists:sellers,id',
            'code' => 'nullable|string|min:3'
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if($request['off_type'] == 'percent' && ($request['amount'] > 100  || $request['amount'] < 1))
            return $this->create($request, 'میزان تخفیف باید بین 1 تا 100 باشد.');

        if($request['off_type'] == 'value' && !$request->has('username'))
            return $this->create($request, 'کد تخفیف مقداری تنها به کاربران داده میشود');

        $today = (int)self::getToday()['date'];
        $expiration = (int)self::convertDateToString($request['off_expiration']);

        if($today >= $expiration)
            return $this->create($request, 'زمان انقضا باید از امروز بزرگ تر باشد');

        $request['off_expiration'] = $expiration;
        $site = $request->getHost() == Controller::$EVENT_SITE ? 'event' : 'shop';

        $request['site'] = $site;
        if($request->has('username')) {
            $user = User::where('phone', $request['username'])->first();
            if($user != null) {
                unset($request['username']);
                $request['user_id'] = $user->id;
            }
        }

        Off::create($request->toArray());
        return Redirect::route('off.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Off  $off
     * @return \Illuminate\Http\Response
     */
    public function edit(Off $off, Request $request, $err=null)
    {
        return view('admin.off.create', [
            'categories' => CategoryDigest::collection(Category::all())->toArray($request),
            'brands' => Brand::all(),
            'sellers' => Seller::all(),
            'item' => OffResource::make($off)->toArray($request),
            'err' => $err
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Off  $off
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Off $off)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Off  $off
     * @return \Illuminate\Http\Response
     */
    public function destroy(Off $off)
    {
        $off->delete();
        return response()->json(['status' => 'ok']);
    }


    public function check(Request $request) {

        $validator = [
            'code' => 'required|string|min:2',
            'amount' => 'required|integer'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);
        $site = $request->getHost() == Controller::$EVENT_SITE ? 'event' : 'shop';
        $userId = $request->user()->id;

        try {
            $off = $this::check_code($site, $userId, $request->code);
            $newAmount = $off->off_type == 'percent' ? number_format((100 - $off->amount) * $request['amount'] / 100, 0) : 
                number_format(max(0, $request['amount'] - $off->amount), 0);
    
            $msg = $off->off_type == 'percent' ? $off->amount . '٪' : number_format(min($off->amount, $request['amount']), 0) . ' تومان';
    
            return response()->json([
                'status' => 'ok',
                'msg' => $msg . ' کد تخفیف اعمال شد',
                'new_amount' => $newAmount,
                'off_amount' => max(0, $request['amount'] - $off->amount)
            ]);
        }
        catch(\Exception $x) {
            
            if($x->getMessage() == 'null')
                return response()->json(['status' => 'nok', 'msg' => 'کد وارد شده نامعتبر است']);

            if($x->getMessage() == 'expired')
                return response()->json(['status' => 'nok', 'msg' => 'کد موردنظر منقضی شده است']);

            if($x->getMessage() == 'double_spend')
                return response()->json(['status' => 'nok', 'msg' => 'این کد قبلا استفاده شده است']);    

            dd($x->getMessage());
        }
        
    }

    public static function check_code($site, $userId, $code) {

        $off = Off::where(function($query) use ($userId) {
            return $query->where('user_id', $userId)->orWhereNull('user_id');
        })
            ->where('site', $site)->where('code', $code)->first();

        if($off == null)
            throw new Exception('null');

        if($off->off_expiration * 1000 < time())
            throw new Exception('expired');

        if($off->user_id == null && 
            Transaction::where('user_id', $userId)
                ->where('status', Transaction::$COMPLETED_STATUS)
                ->where('off_id', $off->id)->count() > 0
        )
            throw new Exception('double_spend');

        return $off;
    }
}
