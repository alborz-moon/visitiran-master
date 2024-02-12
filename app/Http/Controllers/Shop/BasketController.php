<?php

namespace App\Http\Controllers\Shop;

use App\Events\BuyEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderAdminDigestResource;
use App\Http\Resources\OrderDigestResource;
use App\Http\Resources\OrderResource;
use App\Models\Address;
use App\Models\EventBuyer;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItems;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class BasketController extends Controller {
    

    private function do_check_counts($products, $build_basket=false, $userId=null) {

        $errs = [];
        $orders = [];

        foreach($products as $product) {

            $needCheck = true;
            $counter = 0;

            foreach($orders as $order) {

                if($order['id'] == $product['id'] && (
                    $order['feature'] == null ||
                    ($order['feature'] != null && isset($product['feature']) 
                        && $order['feature'] == $product['feature'])
                )) {
                    if($order['available'] < $order['wanted'] + $product['count'])
                        array_push($errs, ['موجودی محصول ' . $order['name']]);
                    else {
                        if($build_basket)
                            $orders[$counter] = [
                                'id' => $order['id'],
                                'name' => $order['name'],
                                'available' => $order['available'],
                                'wanted' => $order['wanted'] + (int)$product['count'],
                                'unit_price' => $order['unit_price'],
                                'off_amount' => $order['off_amount'],
                                'off' => $order['off'],
                                'feature' => $order['feature'],
                                'feature_label' => $order['feature_label'],
                            ];
                        else 
                            $orders[$counter] = [
                                'id' => $order['id'],
                                'name' => $order['name'],
                                'available' => $order['available'],
                                'wanted' => $order['wanted'] + (int)$product['count'],
                                'feature' => $order['feature'],
                                'feature_label' => $order['feature_label'],
                            ];
                    }

                    $needCheck = false;
                    break;
                }

                $counter++;

            }

            if(!$needCheck)
                continue;

            $p = Product::find($product['id']);

            $features = $p->productEffectiveFeatures();
            if($features != null && !isset($product['feature'])) {
                dd($features);
                throw new Exception('invalid data');
            }

            $idx = -1;
            $unit_price = -1;
            $feature = null;
            $feature_label = null;

            if($features != null) {
                $vals = explode('$$', explode('__', $features->value)[0]);
                $idx = array_search($product['feature'], $vals);
                if($idx === false)
                    throw new Exception('invalid data');
                
                if($features->price != null) {
                    $prices = explode('$$', $features->price);
                    if($idx < count($prices)) {
                        $unit_price = (int)str_replace(',', '', $prices[$idx]);
                        $feature = $product['feature'];
                            
                        $f = Feature::find($features->category_feature_id);
                        if($f != null)
                            $feature_label = $f->name == 'multicolor' ?
                                'رنگ ' . $product['feature'] : 
                                $f->name . ' ' . $product['feature'];
                        else
                            $feature_label = $product['feature'];

                    }
                }
            }
            
            if($unit_price == -1)
                $unit_price = $p->price;

            $off = null;
            $off_amount = 0;
            $price_after_off = $unit_price;

            if($build_basket) {

                $off = $p->activeOff($userId);

                if($off != null) {
                    
                    if($off['type'] == 'percent') {
                        $price_after_off = (100 - $off['value']) * $unit_price / 100;
                        $off_amount = $off['value'] * $unit_price / 100;
                    }
                    else {
                        $price_after_off = max(0, $unit_price - $off['value']);
                        $off_amount = min($unit_price, $off['value']);
                    }
                }
            }

            $obj = $build_basket ? [
                'id' => $p->id,
                'name' => $p->name,
                'available' => $p->available_count,
                'wanted' => (int)$product['count'],
                'feature' => $feature,
                'feature_label' => $feature_label,
                'unit_price' => number_format($unit_price, 0),
                'price_after_off' => $price_after_off,
                'off' => $off,
                'off_amount' => $off_amount,
            ] : [
                'id' => $p->id,
                'name' => $p->name,
                'available' => $p->available_count,
                'wanted' => (int)$product['count'],
                'feature' => $feature,
                'feature_label' => $feature_label,
            ];

            $available_count_tmp = $p->available_count;

            if(isset($product['feature']) && $features->available_count != null) {
                $counts = explode('$$', $features->available_count);
                if(count($counts) > $idx) {
                    
                    $f = Feature::find($features->category_feature_id);
                    if($f != null)
                        $obj['feature_label'] = $f->name == 'multicolor' ?
                             'رنگ ' . $product['feature'] : 
                             $f->name . ' ' . $product['feature'];
                    else
                        $obj['feature_label'] = $product['feature'];

                    $available_count_tmp = $counts[$idx];
                    $obj['available'] = $counts[$idx];
                    $obj['feature'] = $product['feature'];
                }
            }

            if($available_count_tmp < $product['count'])
                array_push($errs, ['موجودی محصول ' . $p->name]);
            
            array_push($orders, $obj);
        }

        if($build_basket)
            return [$errs, $orders];

        return $errs;
    }


    public function refresh_basket(Request $request)
    {
        $validator = [
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.count' => 'required|integer|min:1',
            'products.*.feature' => 'nullable',
        ];

        $request->validate($validator, self::$COMMON_ERRS);
        try {
            $output = $this->do_check_counts($request['products'], true, $request->user()->id);
        }
        catch(Exception $x) {
            dd($x->getMessage());
            return abort(401);
        }
        
        $errs = $output[0];
        $orders = $output[1];

        return response()->json([
            'status' => 'ok',
            'orders' => $orders,
            'errs' => $errs
        ]);
    }



    public function check_basket(Request $request)
    {
        $validator = [
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.count' => 'required|integer|min:1',
            'products.*.feature' => 'nullable',
        ];

        $request->validate($validator, self::$COMMON_ERRS);
        try {
            $errs = $this->do_check_counts($request['products']);
        }
        catch(Exception $x) {
            return abort(401);
        }
        

        if(count($errs) > 0)
            return response()->json([
                'status' => 'nok',
                'errs' => $errs
            ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }

    private function update_count($productId, $decAmount, $feature=null) {

        $product = Product::find($productId);
        if($product == null)
            throw new Exception('incorrect Id');

        $features = $product->productEffectiveFeatures();
        if($features == null && $feature != null)
            throw new Exception('feature should be null');
        
        if($features != null && $feature != null) {
            $vals = explode('$$', explode('__', $features->value)[0]);
            $idx = array_search($feature, $vals);
            if($idx === false)
                throw new Exception('invalid feature');
                    
            if($features->available_count != null) {   
                $counts = explode('$$', $features->available_count);
                if(count($counts) > $idx)
                    $counts[$idx] -= min($decAmount, $counts[$idx]);
            }
        }

        $product->available_count -= min($decAmount, $product->available_count);
        $product->save();
    }

    private static function createBuyEvent($user, $purchase) {
        event(new BuyEvent($user, $purchase));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventBuyer  $eventBuyer
     * @return \Illuminate\Http\Response
     */
    public function generateRecpPDF(Purchase $purchase, Request $request)
    {
        $user = $request->user();

        if($purchase->user_id != $user->id || $purchase->payment_status == EventBuyer::$PENDING)
            return abort(401);

        $pdf = self::doGenerateRecpPDF($user, $purchase);
        return $pdf->download('pdf_file.pdf');
    }


    public static function doGenerateRecpPDF($user, $purchase) {

        $transaction = Transaction::find($purchase->transaction_id);
        $all_data = [];

        $total = 0;
        $totalAll = 0;
        $counter = 0;

        $items = $purchase->items();
        $products = [];
        $counter = 1;
        $offs = 0;

        foreach($items as $item) {
            
            $t = $item->unit_price * $item->count;
            $offs += $item->off_amount;
            $total += $t;

            array_push($products, [
                'id' => $counter++,
                'title' => $item->name,
                'count' => $item->count,
                'desc' => $item->feature == null ? '' : $item->feature,
                'price' => number_format($item->unit_price, 0),
                'total' => number_format($t),
                'off' => number_format($item->off_amount, 0),
                'total_after_off' => number_format($t - $item->off_amount),
                'total_after_off_tax' => 0,
                'all' => number_format($t - $item->off_amount),
            ]);
        }

        $total += $transaction->transfer;
        $totalOff = $transaction->off_amount + $offs;
        $totalAll = $total - $totalOff;

        $data = [
            'email' => $user->mail == null ? '' : $user->mail,
            'tel' => $user->phone,
            'nid' => $user->nid == null ? '' : $user->nid,
            'tracking_code' => $transaction->tracking_code,
            'address' => $purchase->address,
            'created_at' => Controller::MiladyToShamsi($transaction->created_at),
            'name' => $user->first_name != null && $user->last_name != null ? 
                $user->first_name . ' ' . $user->last_name : '',
            'products' => $products,
            'total' => [
                'total' => number_format($total, 0),
                'off' => number_format($totalOff, 0),
                'total_after_off' => number_format($totalAll, 0),
                'total_after_off_tax' => 0,
                'all' => number_format($totalAll, 0)
            ],
            'transfer' => [
                'price' => number_format($transaction->transfer, 0),
                'off' => 0,
                'total_after_off' => number_format($transaction->transfer, 0),
                'total_after_off_tax' => 0,
                'all' => number_format($transaction->transfer, 0),
            ]
        ];

        view()->share('data', $all_data);
        $pdf = Pdf::loadView('shop.receipt_shop', $data, [],
            [
                'format' => 'A4-L',
                'display_mode' => 'fullpage'
            ]
        );

        return $pdf;
    }


    public function finalize_basket(Request $request)
    {
        $validator = [
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.count' => 'required|integer|min:1',
            'products.*.feature' => 'nullable',
            'off' => 'nullable|string|min:1',
            'address_id' => 'required|integer|exists:address,id',
            'time' => 'required'
        ];

        $request->validate($validator, self::$COMMON_ERRS);

        $user = $request->user();
        $userId = $user->id;

        $address = Address::find($request['address_id']);

        if($address == null || $address->user_id != $userId)
            return abort(401);


        $out = $this->do_check_counts($request['products'], true, $userId);
        $errs = $out[0];

        if(count($errs) > 0)
            return response()->json([
                'status' => 'nok',
                'errs' => $errs
            ]);

        $orders = $out[1];
        $total = 0;

        foreach($orders as $order)
            $total += $order['wanted'] * $order['price_after_off'];
        
        $off = null;
        $off_amount = null;

        if($request->has('off')) {

            try {
                $off = OffController::check_code('shop', $userId, $request['off']);
                $price_after_off = $off->off_type == 'percent' ? (100 - $off->amount) * $total / 100 : 
                    max(0, $total - $off->amount);

                $off_amount = $total - $price_after_off;
                $total = $price_after_off;
            }
            catch(\Exception $x) {
                
                if($x->getMessage() == 'null')
                    return response()->json(['status' => 'nok', 'msg' => 'کد وارد شده نامعتبر است']);

                if($x->getMessage() == 'expired')
                    return response()->json(['status' => 'nok', 'msg' => 'کد موردنظر منقضی شده است']);

                if($x->getMessage() == 'double_spend')
                    return response()->json(['status' => 'nok', 'msg' => 'این کد قبلا استفاده شده است']);    

            }
        }

        $tracking_code = random_int(100000, 999999);
        $transaction_status = Transaction::$INIT_STATUS;
        $payment_status = EventBuyer::$PENDING;

        if($total < 1000) {
            $transaction_status = Transaction::$COMPLETED_STATUS;
            $payment_status = EventBuyer::$PAID;
            $total = 0;
            
            foreach($orders as $order) {
                $this->update_count($order['id'], $order['wanted'], $order['feature']);
            }
        }

        $total *= 10;
        $transfer = 20000;

        if($off_amount != null)
            $off_amount *= 10;

        $transfer *= 10;
        
        $t = Transaction::create([
            'status' => $transaction_status,
            'amount' => $total,
            'site' => 'shop',
            'user_id' => $userId,
            'off_id' => $off == null ? null : $off->id,
            'off_amount' => $off_amount,
            'tracking_code' => $tracking_code,
            'transfer' => $transfer,
        ]);

        $p = Purchase::create([
            'user_id' => $userId,
            'transaction_id' => $t->id,
            'payment_status' => $payment_status,
            'status' => Purchase::$SENDING,
            'payment_type' => Purchase::$ONLINE,
            'delivery' => $request['time'],
            'address' => $address->address,
            'recv_name' => $address->recv_name,
            'recv_phone' => $address->recv_phone,
            'postal_code' => $address->postal_code,
            'city_id' => $address->city_id,
            'x' => $address->x,
            'y' => $address->y,
        ]);

        foreach($orders as $order) {
            PurchaseItems::create([
                'off_amount' => $order['off_amount'] * 10,
                'count' => $order['wanted'],
                'unit_price' => ((int)str_replace(',', '', $order['unit_price'])) * 10,
                'feature' => $order['feature_label'],
                'product_id' => $order['id'],
                'purchase_id' => $p->id
            ]);
        }

        if($total == 0) {
            // self::createBuyEvent(
            //     $user, $p
            // );
            return response()->json([
                'status' => 'ok',
                'action' => 'registered'
            ]);
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://sep.shaparak.ir/onlinepg/onlinepg");
        curl_setopt($ch, CURLOPT_POST, 1);

        $payload = json_encode([
            "action" => "token",
            "TerminalId" => "13158674",
            "Amount" => $total,
            "ResNum" => $t->id,
            "RedirectUrl" => route('event.callback'),
            "CellNumber" => $request->user()->phone
        ]);

        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Accept:application/json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($server_output, true);
        if(isset($res['status']) && $res['status'] == '1' && isset($res['token'])) {
            $token = $res['token'];
            return response()->json(['status' => 'ok', 'action' => 'pay', 'token' => $token]);
        }

        return response()->json([
            'status' => 'nok2'
        ]);

    }


    public function getMyOrders(Request $request) {

        $status = $request->query('status', null);
        if($status == null || $status == 'sending')
            $orders = Purchase::where('user_id', $request->user()->id)
            ->paid()->sending()->orderBy('created_at', 'desc')->get();
        else if($status == 'delivered')
            $orders = Purchase::where('user_id', $request->user()->id)
                ->paid()->delivered()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'ok',
            'data' => OrderDigestResource::collection($orders)
        ]);

    }

    public function getOrder(Purchase $purchase, Request $request) {

        if($purchase->user_id != $request->user()->id || $purchase->payment_status != EventBuyer::$PAID)
            return abort(401);

        return response()->json([
            'status' => 'ok',
            'data' => OrderResource::make($purchase)
        ]);
    }


    public function report(Request $request) {
        return view('admin.orders.list', [
            'items' => OrderAdminDigestResource::collection(
                Purchase::paid()->orderBy('created_at', 'desc')->get()
            )->toArray($request)
        ]);
    }

}
