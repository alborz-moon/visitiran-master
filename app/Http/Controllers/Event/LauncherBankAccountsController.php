<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Resources\LauncherBankAccountResource;
use App\Models\LauncherBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LauncherBankAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $launcher = $request->user()->launcher;
        if($launcher == null)
            return abort(401);

        return response()->json([
            'status' => 'ok',
            'data' => LauncherBankAccountResource::collection($launcher->banks)->toArray($request)
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

        $launcher = $request->user()->launcher;

        if($launcher == null)
            return abort(401);
        
        $validator = [
            'shaba_no' => 'required|digits:24'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        $request['launcher_id'] = $launcher->id;
        $request['is_default'] = count($launcher->banks) == 0;

        $bank = LauncherBank::create($request->toArray());
        $bank->status = 'pending';

        return response()->json([
            'status' => 'ok',
            'data' => 
                LauncherBankAccountResource::make($bank)->toArray($request)
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LauncherBank  $launcherBank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LauncherBank $launcherBank=null)
    {

        if($launcherBank == null)
            return abort(401);

        $launcher = $launcherBank->launcher;

        if($request->user()->id != $launcher->user_id)
            return abort(401);

        $validator = [
            'is_default' => 'required|boolean'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        DB::connection('mysql2')->update('update launcher_bank_accounts set is_default = false where launcher_id = '. $launcher->id);
        $launcherBank->is_default = true;
        $launcherBank->save();

        return response()->json([
            'status' => 'ok'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LauncherBank  $launcherBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, LauncherBank $launcherBank=null)
    {
        
        if($launcherBank == null)
            return abort(401);

        $launcher = $launcherBank->launcher;

        if($request->user()->id != $launcher->user_id)
            return abort(401);

        $launcherBank->delete();
        
        return response()->json([
            'status' => 'ok'
        ]);
    }
}
