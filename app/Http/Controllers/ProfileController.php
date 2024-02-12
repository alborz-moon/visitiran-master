<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\User;
use App\Rules\NID;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    
    public function editInfo(Request $request) {

        $validator = [
            'first_name' => 'nullable|string|min:2',
            'last_name' => 'nullable|string|min:2',
            'mail' => 'nullable|email',
            'nid' => ['nullable', 'regex:/[0-9]{10}/', new NID],
            'birth_day' => 'nullable|date',
            'payment_back' => ['nullable', Rule::in([User::$PAYMENT_BACK_WALLET, User::$PAYMENT_BACK_ONLINE])],
        ];

        $request->validate($validator, self::$COMMON_ERRS);

        $user = $request->user();

        if($request->has('nid') && $request['nid'] != $user->nid) {
            if(User::where('nid', $request['nid'])->count() > 0)
                return response()->json([
                    'status' => 'nok',
                    'msg' => 'کد ملی وارد شده در سیستم موجود است'
                ]);
        }
        
        if($request->has('mail') && $request['mail'] != $user->mail) {
            if(User::where('mail', $request['mail'])->count() > 0)
                return response()->json([
                    'status' => 'nok',
                    'msg' => 'پست الکترونیک وارد شده در سیستم موجود است'
                ]);
        }

        foreach($request->keys() as $key) {
            
            if($key == '_token')
                continue;

            $user[$key] = $request[$key];
        }

        $user->save();
        return response()->json(['status' => 'ok']);
    }

    public function addresses() {
        $states = State::orderBy('name', 'asc')->get();
        return view('shop.profile.profile-addresses', compact('states'));
    }

    public function comments() {
        return view('shop.profile.profile-comments');
    }
     
    public function favorites() {
        return view('shop.profile.profile-favorites');
    }

    public function myOrderDetail() {
        return view('shop.profile.profile-my-order-detail');
    }
    
    public function myOrders() {
        return view('shop.profile.profile-my-orders');
    }

    public function notification() {
        return view('shop.profile.profile-notification');
    }
    
    
    public function personalInfo(Request $request) {
        
        $user = $request->user();
        $birth_day = $user->birth_day;

        if($birth_day != null) {
           $birth_day = explode('/', $birth_day);
        }

        return view('shop.profile.profile-personal-info', compact('user', 'birth_day'));
    }

    public function ticketsAdd() {
        return view('shop.profile.profile-tickets-add');
    }

    public function ticketsDetail() {
        return view('shop.profile.profile-tickets-detail');
    }
    
    public function myTickets() {
        return view('shop.profile.profile-tickets');
    }

    public function report() {
        return view('event.profile-report');
    }

    public function myTransaction() {
        return view('shop.profile.profile-my-transaction');
    }

    public function profileOffCode() {
        return view('shop.profile.profile-offcode');
    }

}
