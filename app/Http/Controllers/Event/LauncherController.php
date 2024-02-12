<?php

namespace App\Http\Controllers\Event;

use App\Http\Resources\LauncherCard;
use App\Http\Resources\LauncherDigest;
use App\Http\Resources\LauncherFilesResource;
use App\Http\Resources\LauncherFirstStepResource;
use App\Http\Resources\LauncherResourceAdmin;
use App\Models\Event;
use App\Models\Launcher;
use App\Models\LauncherComment;
use App\Models\LauncherFollowers;
use App\Models\State;
use App\Models\User;
use App\Rules\NID;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class LauncherController extends LauncherHelper
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $launchers = self::build_filters($request, false, false)->get();

        return view('admin.launcher.list', [
            'items' => LauncherResourceAdmin::collection($launchers)->toArray($request)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function top(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'data' => LauncherCard::collection(Launcher::active()->whereNotNull('rate')->orderBy('rate', 'desc')->take(8)->get())->toArray($request)
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

        $request->validate($validator, self::$COMMON_ERRS);

        $limit = 30;
        $key = $request->query('key', null);
        $page = $request->query('page', 1);


        if($key != null && $page > 1)
            return abort(401);

        $filters = self::build_filters($request, true, $key != null);

        if($key == null) {
            $events = $filters->skip(($page - 1) * $limit)->take($limit)->get();
        }
        // else {
        //     $events = Event::like($key, null, 'digest', $filters);
        // }


        return response()->json([
            'status' => 'ok',
            'data' => LauncherCard::collection(Launcher::active()->orderBy('rate', 'desc')->take(8)->get())->toArray($request)
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Launcher  $launcher
     * @return \Illuminate\Http\Response
     */
    public function showFiles(Request $request, Launcher $launcher)
    {

        Gate::authorize('update', $launcher);

        return response()->json([
            'status' => 'ok',
            'data' => LauncherFilesResource::make($launcher)->toArray($request)
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
        
        $isEditor = $request->user()->isEditor();

        $validator = [
            'user_phone' => $isEditor ? 'bail|required|regex:/(09)[0-9]{9}/|exists:users,phone' : 'nullable|string',
            'img_file' => 'required|image',
            'back_img_file' => 'nullable|image',
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'about' => 'nullable|string',
            'phone' => 'required|regex:/(09)[0-9]{9}/|unique:mysql2.launchers,phone',
            'user_NID' => ['bail', 'required','regex:/[0-9]{10}/', new NID], //'unique:mysql2.launchers,user_NID',
            'user_email' => 'required|email|unique:mysql2.launchers,user_email',
            'user_birth_day' => 'required', //|date
            'launcher_type' => ['required', Rule::in(['haghighi', 'hoghoghi'])],
            'company_name' => 'required|string|min:2',
            'company_type' => ['required_if:launcher_type,hoghoghi', Rule::in(['agency', 'art', 'limit', 'spec', 'public'])],
            'postal_code' => 'required_if:launcher_type,hoghoghi|regex:/[1-9][0-9]{9}/',
            'code' => 'required_if:launcher_type,hoghoghi|numeric',
            'launcher_address' => 'required|string|min:2',
            'launcher_email' => 'nullable|email',
            'launcher_site' => 'nullable|string|min:2',
            'launcher_phone' => 'nullable|array|min:1',
            'launcher_phone.*' => 'required|numeric|digits_between:7,11',
            'launcher_city_id' => 'required|exists:mysql2.cities,id',
            'launcher_x' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'launcher_y' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        if($request->has('user_phone')) {
            $user = User::where('phone', $request['user_phone'])->first();
            if($user->launcher != null)
                return response()->json(['status' => 'nok', 'msg' => 'کاربر مدنظر این فرم را قبلا پر کرده است']);

            $request['user_id'] = $user->id;
        }
        else
            $request['user_id'] = $request->user()->id;


        if($request['launcher_type'] == 'haghighi') {
            $request['company_type'] = null;
            $request['code'] = null;
        }
        
        if($request->has('launcher_phone')) {
            $launcher_phone_str = "";

            foreach($request['launcher_phone'] as $itr)
                $launcher_phone_str .= $itr . '__';
            
            $request['launcher_phone'] = substr($launcher_phone_str, 0, strlen($launcher_phone_str) - 2);
        }

        if($request->has('img_file')) {
            $filename = $request->img_file->store('public/launchers');
            $filename = str_replace('public/launchers/', '', $filename);   
            $request['img'] = $filename;
        }

        if($request->has('back_img_file')) {
            $filename = $request->back_img_file->store('public/launchers');
            $filename = str_replace('public/launchers/', '', $filename);   
            $request['back_img'] = $filename;
        }

        try {
            $launcher = Launcher::create($request->toArray());

            return response()->json([
                'status' => 'ok',
                'id' => $launcher->id
            ]);
        }
        catch(\Exception $x) {
            return response()->json([
                'status' => 'nok',
                'msg' => 'شما یکبار این فرم را پر کرده اید.'
            ]);

        }
    }

    public function show_user(Request $request, Launcher $launcher) {
        
        if($launcher->status != 'confirmed')
            return Redirect::route(403);

        return response()->json([
            'status' => 'ok',
            'data' => LauncherDigest::make($launcher)->toArray($request)
        ]);
    }
    
    public function show_detail(Request $request, Launcher $launcher, string $slug) {
        
        if($launcher->status != 'confirmed')
            return Redirect::route(403);

        $launcher->seen = $launcher->seen + 1;
        $launcher->save();

        $user = $request->user();
        
        if($user == null)
            return view('event.launcher', [
                    'launcher' => array_merge(
                        LauncherDigest::make($launcher)->toArray($request), [
                            'is_bookmark' => false,
                            'user_rate' => null,
                            'has_comment' => false,
                            'launcher_is_following' => false        
                        ]), 
                    'is_login' => false,
                ]);

                
        $comment = LauncherComment::userComment($launcher->id, $user->id);
        
        // dd(LauncherDigest::make($launcher)->toArray($request));
        return view('event.launcher', [
            'launcher' => array_merge(
                LauncherDigest::make($launcher)->toArray($request), 
                [
                    'is_bookmark' => $comment != null && $comment->is_bookmark != null ? $comment->is_bookmark : false,
                    'user_rate' => $comment != null ? $comment->rate : null,
                    'has_comment' => $comment != null && $comment->msg != null,
                    'launcher_is_following' => LauncherFollowers::where('user_id', $user->id)->where('launcher_id', $launcher->id)->count() > 0,
                ]), 
                'is_login' => true
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Launcher  $launcher
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Launcher $launcher)
    {
        return response()->json([
            'status' => 'ok',
            'data' => LauncherFirstStepResource::make($launcher)->toArray($request)
        ]);
    }

    public function getPlaceInfo(Launcher $launcher=null) {
        
        if($launcher == null)
            abort(401);
        
        Gate::authorize('update', $launcher);
        $city = $launcher->city;

        return response()->json([
            'status' => 'ok',
            'data' => [
                'state_id' => $city->state_id,
                'city_id' => $city->id,
                'postal_code' => $launcher->postal_code,
                'address' => $launcher->launcher_address,
                'y' => $launcher->launcher_y,
                'x' => $launcher->launcher_x
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Launcher  $launcher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Launcher $launcher)
    {
        Gate::authorize('update', $launcher);
        
        $validator = [
            'img_file' => 'nullable|image',
            'back_img_file' => 'nullable|image',
            'first_name' => 'nullable|string|min:2',
            'last_name' => 'nullable|string|min:2',
            'phone' => 'nullable|regex:/(09)[0-9]{9}/',
            'user_NID' => ['nullable', 'regex:/[0-9]{10}/', new NID],
            'user_email' => 'nullable|email',
            'user_birth_day' => 'nullable', //|date
            'launcher_type' => ['nullable', Rule::in(['haghighi', 'hoghoghi'])],
            'company_name' => 'nullable|string|min:2',
            'company_type' => ['nullable', Rule::in(['agency', 'art', 'limit', 'spec', 'public'])],
            'postal_code' => 'nullable|regex:/[1-9][0-9]{9}/',
            'code' => 'nullable|numeric',
            'about' => 'nullable|string',
            'launcher_address' => 'nullable|string|min:2',
            'launcher_email' => 'nullable|email',
            'launcher_site' => 'nullable|string|min:2',
            'launcher_phone' => 'nullable|array|min:1',
            'launcher_phone.*' => 'required|numeric|digits_between:7,11',
            'launcher_city_id' => 'nullable|exists:mysql2.cities,id',
            'launcher_x' => ['nullable','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'launcher_y' => ['nullable','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'company_newspaper_file' => 'nullable|image',
            'company_last_changes_file' => 'nullable|image',
            'user_nid_card_file' => 'nullable|image',
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        if($request->has('phone') && $request['phone'] != $launcher->phone && 
            Launcher::where('phone', $request['phone'])->count() > 0
        )
            return response()->json([
                'status' => 'nok',
                'msg' => 'شماره وارد شده برای رابط در سیستم موجود است.'
            ]);

        if($request->has('user_NID') && $request['user_NID'] != $launcher->user_NID && 
            Launcher::where('user_NID', $request['user_NID'])->count() > 0
        )
            return response()->json([
                'status' => 'nok',
                'msg' => 'کد ملی وارد شده برای رابط در سیستم موجود است.'
            ]);


        if($request->has('user_email') && $request['user_email'] != $launcher->user_email && 
            Launcher::where('user_email', $request['user_email'])->count() > 0
        )
            return response()->json([
                'status' => 'nok',
                'msg' => 'پست الکترونیک وارد شده برای رابط در سیستم موجود است.'
            ]);

        if($request['launcher_type'] == 'haghighi') {
            $request['company_type'] = null;
            $request['code'] = null;
        }

        if($request->has('launcher_phone')) {
            $launcher_phone_str = "";

            foreach($request['launcher_phone'] as $itr)
                $launcher_phone_str .= $itr . '__';
            
            $request['launcher_phone'] = substr($launcher_phone_str, 0, strlen($launcher_phone_str) - 2);
        }
        
        if($request->has('img_file')) {
         
            $filename = $request->img_file->store('public/launchers');
            $filename = str_replace('public/launchers/', '', $filename);   
                
            if($launcher->img != null && !empty($launcher->img) && 
                file_exists(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->img))
                unlink(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->img);

            $launcher->img = $filename;
        }

        if($request->has('back_img_file')) {
         
            $filename = $request->back_img_file->store('public/launchers');
            $filename = str_replace('public/launchers/', '', $filename);   
                
            if($launcher->back_img != null && !empty($launcher->back_img) && 
                file_exists(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->back_img))
                unlink(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->back_img);

            $launcher->back_img = $filename;
        }

        if($request->has('company_newspaper_file')) {
         
            $filename = $request->company_newspaper_file->store('public/launchers');
            $filename = str_replace('public/launchers/', '', $filename);   
                
            if($launcher->company_newspaper != null && !empty($launcher->company_newspaper) && 
                file_exists(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->company_newspaper))
                unlink(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->company_newspaper);

            $launcher->company_newspaper = $filename;
        }


        if($request->has('company_last_changes_file')) {
         
            $filename = $request->company_last_changes_file->store('public/launchers');
            $filename = str_replace('public/launchers/', '', $filename);   
                
            if($launcher->company_last_changes != null && !empty($launcher->company_last_changes) && 
                file_exists(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->company_last_changes))
                unlink(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->company_last_changes);

            $launcher->company_last_changes = $filename;
        }



        if($request->has('user_nid_card_file')) {
         
            $filename = $request->user_nid_card_file->store('public/launchers');
            $filename = str_replace('public/launchers/', '', $filename);   
                
            if($launcher->user_NID_card != null && !empty($launcher->user_NID_card) && 
                file_exists(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->user_NID_card))
                unlink(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->user_NID_card);

            $launcher->user_NID_card = $filename;
        }


        try {
            
            foreach($request->keys() as $key) {
                
                if($key == '_token' || $key == 'user_nid_card_file' || $key == 'img_file' ||
                    $key == 'back_img_file' ||
                    $key == 'company_last_changes_file' || $key == 'company_newspaper_file')
                    continue;


                $launcher[$key] = $request[$key];
            }

            $isEditor = $request->user()->isEditor();

            if(!$isEditor && $launcher->status != Event::$INIT_STATUS)
                $launcher->status = 'pending';

            $launcher->save();

            return response()->json([
                'status' => 'ok'
            ]);
        }
        catch(\Exception $x) {

            return response()->json([
                'status' => 'nok',
                'msg' => $x->getMessage()
            ]);

        }

    }

    public function removeFile(Launcher $launcher, Request $request) {


        Gate::authorize('update', $launcher);

        $request->validate([
            'mode' => ['required', Rule::in('news_paper', 'last_changes', 'NID', 'cert')],
            'id' => 'nullable|exists:mysql2.launcher_certifications,id'
        ]);

        if($request['mode'] === 'news_paper') {
            if($launcher->company_newspaper != null && !empty($launcher->company_newspaper) &&
                file_exists(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->company_newspaper)
            )
                unlink(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->company_newspaper);
            
            $launcher->company_newspaper = null;
        }
        
        if($request['mode'] === 'last_changes') {
            if($launcher->company_last_changes != null && !empty($launcher->company_last_changes) &&
                file_exists(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->company_last_changes)
            )
                unlink(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->company_last_changes);
            
            $launcher->company_last_changes = null;
        }
        
        if($request['mode'] === 'NID') {
            if($launcher->user_NID_card != null && !empty($launcher->user_NID_card) &&
                file_exists(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->user_NID_card)
            )
                unlink(__DIR__ . '/../../../../public/storage/launchers/' . $launcher->user_NID_card);
            
            $launcher->user_NID_card = null;
        }

        if($request['mode'] === 'cert') {

            if(!$request->has('id'))
                return abort(401);

            $cert = $launcher->certs()->where('id', $request['id'])->first();
            if($cert == null)
                return abort(401);

            if($cert->file != null && !empty($cert->file) &&
                file_exists(__DIR__ . '/../../../../public/storage/launchers/' . $cert->file)
            )
                unlink(__DIR__ . '/../../../../public/storage/launchers/' . $cert->file);
            
            $cert->delete();
            return response()->json(['status' => 'ok']);
        }

        $launcher->save();
        return response()->json(['status' => 'ok']);
    }

    public function changeStatus(Request $request) {

        $validator = [
            'status' => ['required', Rule::in(['pending', 'confirmed', 'rejected'])],
            'launcher_id' => 'required|exists:mysql2.launchers,id'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        $launcher = Launcher::whereId($request['launcher_id'])->first();

        $user = User::find($launcher->user_id);

        if($user != null) {
            if($request['status'] === 'confirmed')
                $user->level = User::$LAUNCHER_LEVEL;
            else
                $user->level = User::$USER_LEVEL;

            $user->save();
        }

        $launcher->status = $request['status'];
        $launcher->save();

        return response()->json(['status' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Launcher  $launcher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Launcher $launcher)
    {
        Gate::authorize('destroy', $launcher);
        
        //todo : check dependencies
        //todo : remove dependencies
        //todo : remove files

        $launcher->delete();
        return response()->json(['status' => 'ok']);
    }

    public function documents(Request $request, $formId=null) {

        if($formId == null)
            return view('errors.403');

        $launcher = Launcher::find($formId);
        if($launcher == null)
            return view('errors.403');
    
        Gate::authorize('update', $launcher);
        $type = $launcher->launcher_type;
        $mode = $launcher->status == 'init' ? 'create' : 'edit';

        return view('event.launcher.launcher-document', compact('formId', 'type', 'mode'));
    }

    public function registry(Request $request) {

        $user = Auth::user();
        $editor = $user->isEditor();
        
        if(!$editor) {
            $tmp = Launcher::where('user_id', $user->id)->first();
            if($tmp != null)
                return Redirect::route('launcher-edit', ['launcher' => $tmp->id]);
        }

        $states = State::orderBy('name', 'asc')->get();
        $mode = 'create';
        return view('event.launcher.launcher-register', compact('states', 'mode'));

    }

    public function editRegistry(Launcher $launcher) {

        Gate::authorize('update', $launcher);

        $states = State::orderBy('name', 'asc')->get();
        return view('event.launcher.launcher-register', [
            'mode' => 'edit', 
            'states' => $states, 
            'formId' => $launcher->id,
            'status' => $launcher->status
        ]);

    }



    public function sendForReview(Launcher $launcher, Request $request) {

        Gate::authorize('update', $launcher);

        $errs = [];
        
        if($launcher->launcher_type == 'hoghoghi' && (
            $launcher->company_newspaper == null || 
            empty($launcher->company_newspaper) ||
            $launcher->company_last_changes == null || 
            empty($launcher->company_last_changes)
        ))
            array_push($errs, 'مدارک');

        if(count($errs) == 0 && (
            $launcher->user_NID_card == null || 
            empty($launcher->user_NID_card)
        ))
            array_push($errs, 'مدارک');

        if(count($errs) == 0) {

            if($request->user()->isEditor() && $launcher->status != Event::$INIT_STATUS)
                return response()->json(['status' => 'ok']);

            $launcher->status = Event::$PENDING_STATUS;
            $launcher->save();
            return response()->json(['status' => 'ok']);
        }
        
        return response()->json(['status' => 'nok', 'data' => 'لطفا اطلاعات ضروری در بخش های زیر را پرنمایید.<br/>' . implode('<br/>', $errs)]);
    }


}
