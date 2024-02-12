<?php

namespace App\Http\Controllers;

use App\Models\Launcher;
use App\Models\LauncherFollowers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LauncherFollowersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Launcher $launcher) {

        Gate::authorize('show', $launcher);

        $validator = [
            'follow' => 'required|boolean'
        ];

        $request->validate($validator);

        if($request['follow']) {
            try {
                $tmp = LauncherFollowers::create([
                    'user_id' => $request->user()->id, 
                    'launcher_id' => $launcher->id
                ]);
                if($tmp != null && $tmp) {
                    $launcher->follower_count = $launcher->follower_count + 1;
                    $launcher->save();
                }
            }
            catch(\Exception $x) {}
        }
        else {
            try {
                
                $tmp = LauncherFollowers::where('user_id', $request->user()->id)
                    ->where('launcher_id', $launcher->id)->delete();

                if($tmp) {
                    $launcher->follower_count = $launcher->follower_count - 1;
                    $launcher->save();
                }

            }
            catch(\Exception $x) {}
            
        }

        return response()->json(['status' => 'ok']);
    }


}
