<?php

namespace App\Http\Controllers\Event;

use App\Events\EventRegistry;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Shop\OffController;
use App\Http\Resources\EventBuyerResource;
use App\Http\Resources\EventSessionResource;
use App\Http\Resources\MyEventsDigest;
use App\Models\Event;
use App\Models\EventBuyer;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\NID;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $event, Request $request)
    {
        Gate::authorize('update', $event);

        return response()->json([
            'status' => 'ok',
            'data' => EventBuyerResource::collection($event->buyers)->toArray($request)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Event $event, Request $request)
    {
        $validator = [
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'phone' => 'required|regex:/(09)[0-9]{9}/',
            'nid' => ['nullable', 'regex:/[0-9]{10}/', new NID],
            'count' => 'required|integer|min:1|max:100',
            'paid' => 'required|integer|min:0',
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        $request['event_id'] = $event->id;
        $user = User::where('phone', $request['phone'])->first();

        if($user != null)
            $request['user_id'] = $user->id;

        $reminder['created_ts'] = Carbon::now()->timestamp;
        
        $tmp = EventBuyer::create($request->toArray());
        $createdAt = self::MiladyToShamsi3($tmp->created_at->timestamp);
        
        self::createEventListener($event, 
            $request['phone'], $user != null ? $user->mail : null, 
            $request['first_name'] . ' ' . $request['last_name']
        );

        return response()->json([
            'status' => 'ok',
            'id' => $tmp->id,
            'created_at' => $createdAt
        ]);
    }


    public static function doGenerateTicketPDF(Event $event) {

        $eventBuyers = EventBuyer::where('event_id', $event->id)->paid()->get();
        $all_data = [];

        foreach($eventBuyers as $eventBuyer) {

            $validationUrl = 'https://techvblogs.com/blog/generate-qr-code-laravel-8';

            $filename = 'tmp/' . time() . '.png';
            QrCode::size(100)->generate($validationUrl, storage_path($filename)); 
    
            $data = [
                'title' => $event->title,
                'launcher' => $event->launcher->company_name,
                'type' => $event->city_id == null ? 'مجازی' : 'حضوری',
                'address' => $event->city_id == null ? $event->link : $event->address,
                'name' => $eventBuyer->first_name . ' ' . $eventBuyer->last_name,
                'phone' => $eventBuyer->phone,
                'tel' => $eventBuyer->tel,
                'email' => $eventBuyer->email,
                'site' => $eventBuyer->site,
                'count' => $eventBuyer->count,
                'ticket_desc' => $event->ticket_description,
                'tracking_code' => $eventBuyer->transaction->tracking_code,
                'nid' => $eventBuyer->nid,
                'created_at' => self::MiladyToShamsi3($eventBuyer->created_at->timestamp),
                'qr' => storage_path($filename),
                'days' => EventSessionResource::collection($event->sessions)
            ];

            array_push($all_data, $data);
        }
        
        view()->share('data', $data);

        $pdf = Pdf::loadView('event.event.ticket', ['data' => $all_data], [], 
            [
                'format' => 'A5-L',
                'display_mode' => 'fullpage'
            ]
        );

        return $pdf;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function generateTicketPDF(Event $event, Request $request)
    {
        self::createEventListener($event, "09214915905", "mghaneh1375@yahoo.com", "محمد قانع");
        $pdf = self::doGenerateTicketPDF($event);
        return $pdf->download('pdf_file.pdf');
    }


    public static function doGenerateRecpPDF($mail, $eventId, $eventTitle) {

        $transactions = Transaction::where('ref_id', $eventId)->event()->complete()->get();
        $all_data = [];

        foreach($transactions as $transaction) {

            $total = 0;
            $totalOff = 0;
            $totalAll = 0;

            $eventBuyers = EventBuyer::where('transaction_id', $transaction->id)
                ->paid()->get();

            $eventBuyer = $eventBuyers[0];
            $counter = 0;

            foreach($eventBuyers as $tmp) {
                $counter += $tmp->count;
            }

            $t = $eventBuyer->unit_price * $counter;

            $total += $t;
            $totalOff += $transaction->off_amount;
            $totalAll += $t - $transaction->off_amount;

            $data = [
                'email' => $mail == null ? '' : $mail,
                'tel' => $eventBuyer->phone,
                'nid' => $eventBuyer->nid,
                'tracking_code' => $transaction->tracking_code,
                'created_at' => Controller::MiladyToShamsi($transaction->created_at),
                'name' => $eventBuyer->first_name . ' ' . $eventBuyer->last_name,
                'products' => [
                    [
                        'id' => 1,
                        'title' => $eventTitle,
                        'count' => $counter,
                        'price' => number_format($eventBuyer->unit_price, 0),
                        'total' => number_format($t, 0),
                        'off' => number_format($transaction->off_amount, 0),
                        'total_after_off' => number_format($t - $transaction->off_amount, 0),
                        'total_after_off_tax' => 0,
                        'all' => number_format($t - $transaction->off_amount, 0)
                    ]
                ],
                'total' => [
                    'total' => number_format($total, 0),
                    'off' => number_format($totalOff, 0),
                    'total_after_off' => number_format($total - $totalOff, 0),
                    'total_after_off_tax' => 0,
                    'all' => number_format($totalAll, 0)
                ]
            ];

            array_push($all_data, $data);
        }


        view()->share('data', $all_data);
        $pdf = Pdf::loadView('event.event.receipt_event', ['data' => $all_data], [], 
            [
                'format' => 'A4-L',
                'display_mode' => 'fullpage'
            ]
        );

        return $pdf;
    }

        /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventBuyer  $eventBuyer
     * @return \Illuminate\Http\Response
     */
    public function generateRecpPDF(Event $event, Request $request)
    {
        $pdf = self::doGenerateRecpPDF($request->user()->mail, $event->id, $event->title);
        return $pdf->download('pdf_file.pdf');
    }


    public function register(Event $event, Request $request)
    {
        
        if(!Event::isActiveForRegistry($event))
            return abort(401);

        $validator = [
            'code' => 'nullable|string|min:2',
            'users' => 'required|array|min:1',
            'users.*.first_name' => 'required|string|min:2',
            'users.*.last_name' => 'required|string|min:2',
            'users.*.phone' => 'required|regex:/(09)[0-9]{9}/',
            'users.*.nid' => ['required', 'regex:/[0-9]{10}/', new NID],
            'count' => 'required|integer|min:1|max:100',
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        if($request['count'] != count($request['users']))
            return abort(401);

        $reminder = $event->capacity - $event->buyers()->sum('count');
        if($reminder <= 0)
        return response()->json(['status' => 'nok', 'msg' => 'ظرفیت رویداد موردنظر به اتمام رسیده است']);

        // todo: check off
        $unit_price = $event->price;

        $price = $unit_price * $request['count'];
        $off_amount = null;
        $off = null;
        
        if($request->has('code')) {

            $userId = $request->user()->id;

            try {
                $off = OffController::check_code('event', $userId, $request->code);
                $price_after_off = $off->off_type == 'percent' ? (100 - $off->amount) * $price / 100 : 
                    max(0, $price - $off->amount);

                $off_amount = $price - $price_after_off;
                $price = $price_after_off;
        
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

        $find_diff = false;

        for($i = 0; $i < count($request['users']); $i++) {

            for($j = $i + 1; $j < count($request['users']); $j++) {

                foreach($request['users'][$i] as $key => $val) {

                    if($request['users'][$j][$key] != $val) {
                        $find_diff = true;
                        break;
                    }

                }

                if($find_diff)
                    break;
            }

            if($find_diff)
                break;
        }

        $user = $request->user();

        $u = $request['users'][0];
        if(
            $user->first_name == null || $user->last_name == null ||
            $user->nid == null
        ) {

            if($user->first_name == null)
                $user->first_name = $u['first_name'];

            if($user->last_name == null)
                $user->last_name = $u['last_name'];

            if($user->nid == null)
                $user->nid = $u['nid'];
            
            $user->save();
        }

        $now = Carbon::now()->timestamp;
        $paid_status = EventBuyer::$PENDING;
        $amount = $price;
        $tracking_code = random_int(100000, 999999);
        $transaction_status = Transaction::$INIT_STATUS;

        if($price < 1000) {
            $paid_status = EventBuyer::$PAID;
            $amount = 0;
            $transaction_status = Transaction::$COMPLETED_STATUS;
        }

        $amount *= 10;
        $unit_price *= 10;
        if($off_amount != null)
            $off_amount *= 10;

        $t = Transaction::create([
            'amount' => $amount,
            'user_id' => $user->id,
            'ref_id' => $event->id,
            'site' => 'event',
            'status' => $transaction_status,
            'off_id' => $off != null ? $off->id : null,
            'off_amount' => $off_amount,
            'tracking_code' => $tracking_code
        ]);
        
        
        if($find_diff) {
        
            foreach($request['users'] as $u) {

                EventBuyer::create([
                    'first_name' => $u['first_name'],
                    'last_name' => $u['last_name'],
                    'nid' => $u['nid'],
                    'phone' => $u['phone'],
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                    'transaction_id' => $t->id,
                    'unit_price' => $unit_price,
                    'status' => $paid_status,
                    'count' => 1,
                    'created_ts' => $now,
                ]);
            }

            if($paid_status == EventBuyer::$PAID)
                $u = $request['users'][0];
        }
        else {
            $u = $request['users'][0];
            EventBuyer::create([
                'first_name' => $u['first_name'],
                'last_name' => $u['last_name'],
                'nid' => $u['nid'],
                'phone' => $u['phone'],
                'user_id' => $user->id,
                'event_id' => $event->id,
                'count' => $request['count'],
                'transaction_id' => $t->id,
                'unit_price' => $unit_price,
                'status' => $paid_status,
                'created_ts' => $now,
            ]);
        }

        if($paid_status == EventBuyer::$PAID) {
            EventBuyerController::createEventListener(
                $event, $u['phone'], $user->mail,
                $u['first_name'] . ' ' . $u['last_name']
            );
            return response()->json(['status' => 'ok', 'action' => 'registered']);
        }


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://sep.shaparak.ir/onlinepg/onlinepg");
        curl_setopt($ch, CURLOPT_POST, 1);

        $payload = json_encode([
            "action" => "token",
            "TerminalId" => "13158674",
            "Amount" => $amount,
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
            'status' => 'nok', 
            'msg' => 'خطایی در برقراری اتصال به درگاه پرداخت به وجود آمده است', 
            'msg2' => $res
        ]);
    }


    public static function createEventListener(Event $event, $phone, $mail, $name) {

        event(new EventRegistry(
            $name, $phone, $mail, $event
        ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        
        $eventBuyers = EventBuyer::where('user_id', $request->user()->id)->paid()->get();
        $events = [];

        foreach($eventBuyers as $eventBuyer) {

            $event = null;
            foreach($events as $e) {
                if($e->event_id == $eventBuyer->event_id) {
                    $event = $e;
                    break;
                }
            }

            if($event == null)
                array_push($events, $eventBuyer);
            else
                $event->count += $eventBuyer->count;
        }

        return response()->json([
            'status' => 'ok',
            'data' => MyEventsDigest::collection($events)->toArray($request)
        ]);
    }


    public function callback(Request $request) {

        $request->validate([
            'Status' => 'required|integer',
            'ResNum' => 'required',
        ]);

        if($request['status'] == 2 || 1 == 1) {

            $t = Transaction::find($request['ResNum']);
            if($t == null)
                dd("null");
    
            $t->status = Transaction::$COMPLETED_STATUS;
            $t->save();

            $eventBuyers = EventBuyer::where('transaction_id', $t->id)->get();

            $userId = $t->user_id;
            $user = User::find($userId);
            $event = Event::find($t->ref_id);
            
            foreach($eventBuyers as $eventBuyer) {
                $eventBuyer->status = EventBuyer::$PAID;
                $eventBuyer->save();
            }

            self::createEventListener(
                $event, $eventBuyers[0]->phone, $user->mail, 
                $eventBuyers[0]->first_name . ' ' . $eventBuyers[0]->last_name
            );

            Auth::login($user);
        }

        return Redirect::route('checkout-successful', ['transaction' => $t->id]);
    }

}
