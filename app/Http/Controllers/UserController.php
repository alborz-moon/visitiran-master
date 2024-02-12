<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Rules\NID;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $level = $request->query('level', null);
        if($level == null)
            return abort(401);

        $accessFilter = $request->query('access', null);
        $statusFilter = $request->query('status', null);

        $items = null;
        $levelFa = "";

        $filter = User::where('id', '>', 0);
        if($accessFilter != null)
            $filter->where('access', $accessFilter);

        if($statusFilter != null)
            $filter->where('status', $statusFilter);

        if($level == 'admin') {
            $filter->admin();
            $levelFa = 'ادمین ها';
        }
        
        else if($level == 'editor') {
            $filter->editor();
            $levelFa = 'ویرایش کنندگان';
        }
        
        else if($level == 'report') {
            $filter->report();
            $levelFa = 'گزارش گیرندگان';
        }
        
        else if($level == 'finance') {
            $filter->finance();
            $levelFa = 'گزارش گیرندگان مالی';
        }
        
        else if($level == 'news') {
            $filter->news();
            $levelFa = 'مدیریت بلاگها';
        }

        $items = UserResource::collection($filter->get())->toArray($request);

        return view('admin.users.list', 
            compact('items', 'levelFa', 'level', 'accessFilter', 'statusFilter')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {  
        $level = $request->query('level', null);

        if($level == null)
            return abort(401);

        return view('admin.users.create', ['level' => $level]);
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
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'mail' => 'required|email',
            'nid' => ['bail', 'required', 'regex:/[0-9]{10}/', new NID],
            'password' => 'required|string|min:6',
            'phone' => 'required|regex:/(09)[0-9]{9}/',
            'access' => ['required', Rule::in(['both', 'event', 'shop'])],
            'level' => ['required', Rule::in(['admin', 'editor', 'finance', 'news', 'report'])],
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();
        
        $user = User::where('nid', $request['nid'])->orWhere('mail', $request['mail'])
            ->orWhere('phone', $request['phone'])->first();

        if($user != null) {
            
            $errMsg = "";
            if($user->phone == $request['phone'])
                $errMsg = "شماره همراه وارد شده در سیستم موجود است";
            else if($user->nid == $request['nid'])
                $errMsg = 'کدملی وارد شده در سیستم موجود است';
            else
                $errMsg = 'ایمیل وارد شده در سیستم موجود است';

            return Redirect::back()->withErrors(['message' =>  $errMsg])->withInput();
        }

        $request['password'] = Hash::make($request['password']);
        $request['status'] = 'active';

        User::create($request->toArray());
        return Redirect::route('users.index', ['level' => $request['level']]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request)
    {
        $level = $request->query('level', null);

        if($level == null)
            return abort(401);

        return view('admin.users.create', ['level' => $level, 'item' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = [
            'first_name' => 'nullable|string|min:2',
            'last_name' => 'nullable|string|min:2',
            'mail' => 'nullable|email',
            'nid' => ['bail', 'nullable', 'regex:/[0-9]{10}/', new NID],
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|regex:/(09)[0-9]{9}/',
            'status' => ['nullable', Rule::in(['init', 'active'])],
            'access' => ['nullable', Rule::in(['both', 'event', 'shop'])],
            'level' => ['nullable', Rule::in(['admin', 'editor', 'finance', 'news', 'report'])],
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);
        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        if($request->has('nid') && $user->nid != $request['nid'] && 
            User::where('nid', $request['nid'])->first()
        ) {
            
            $errMsg = 'کدملی وارد شده در سیستم موجود است';
            return Redirect::back()->withErrors(['message' =>  $errMsg])->withInput();
        }
        
        if($request->has('mail') && $user->mail != $request['mail'] && 
            User::where('mail', $request['mail'])->first()
        ) {
            
            $errMsg = 'ایمیل وارد شده در سیستم موجود است';
            return Redirect::back()->withErrors(['message' =>  $errMsg])->withInput();
        }

        if($request->has('phone') && $user->phone != $request['phone'] && 
            User::where('phone', $request['phone'])->first()
        ) {
            
            $errMsg = 'شماره همراه وارد شده در سیستم موجود است';
            return Redirect::back()->withErrors(['message' =>  $errMsg])->withInput();
        }

        if($request->has('password'))
            $request['password'] = Hash::make($request['password']);
            
        foreach($request->keys() as $key) {
            
            if($key == '_token' || $key == 'password')
                continue;

            $user[$key] = $request[$key];
        }


        $user->save();
        return Redirect::route('users.index', ['level' => $request['level']]);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request)
    {
        $validator = [
            'user_id' => 'required|integer|exists:users,id',
            'status' => ['nullable', Rule::in(['init', 'active'])],
            'access' => ['nullable', Rule::in(['both', 'event', 'shop'])],
            'level' => ['nullable', Rule::in(['admin', 'editor', 'finance', 'news', 'report'])],
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);
        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        $user = User::whereId($request['user_id'])->first();
        foreach($request->keys() as $key) {
            
            if($key == '_token' || $key == 'user_id')
                continue;

            $user[$key] = $request[$key];
        }

        $user->save();
        return response()->json(['status' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['status' => 'ok']);
    }

    public function searchUsersForLauncherCandidate(Request $request) {

        $validator = [
            'phone' => 'required|regex:/(09)[0-9]{9}/|exists:users,phone',
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $request->validate($validator, self::$COMMON_ERRS);
        $user = User::where('phone', $request['phone'])->first();
        if($user->level != User::$USER_LEVEL)
            return response()->json([
                'status' => 'nok',
                'msg' => 'کاربر مدنظر عادی نمی باشد'
            ]);

        return response()->json([
            'status' => 'ok',
            'data' => [
                'name' => $user->first_name != null && $user->last_name ? 
                    $user->first_name . ' ' . $user->last_name : null,
                'phone' => $user->phone,
                'mail' => $user->mail,
                'birth_day' => $user->birth_day,
                'nid' => $user->nid
            ]
        ]);
    }
    
}
