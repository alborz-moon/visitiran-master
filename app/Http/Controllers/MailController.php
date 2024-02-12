<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserMailResource;
use App\Models\UserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    
    public function submitMail(Request $request) {

        $validator = [
            'mail' => 'required|email'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        UserMail::create($request->toArray());
        return response()->json(['status' => 'ok']);
    }

    public function users(Request $request) {
        $users = UserMail::paginate(30);
        return view('admin.mail.users', [
            'items' => UserMailResource::collection($users)->toArray($request),
            'links' => $users->links()
        ]);
    }

}
