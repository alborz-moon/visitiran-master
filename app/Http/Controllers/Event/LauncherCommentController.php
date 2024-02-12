<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\ABS_Comment;
use App\Models\Launcher;
use App\Models\LauncherComment;
use Illuminate\Http\Request;

class LauncherCommentController extends ABS_Comment
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Launcher $launcher, Request $request)
    {
        return self::abs_index($launcher, $request, 
            route('launcher.launcher_comment.index', ['launcher' => $launcher->id]),
            route('launcher.index')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Launcher $launcher, Request $request)
    {
        return self::abs_list($launcher, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Launcher $launcher, Request $request)
    {
        return self::abs_store($launcher, $request, LauncherComment::class, 'launcher_id');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LauncherComment  $launcherComment
     * @return \Illuminate\Http\Response
     */
    public function show(LauncherComment $launcherComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LauncherComment  $launcherComment
     * @return \Illuminate\Http\Response
     */
    public function edit(LauncherComment $launcher_comment, Request $request)
    {
        return self::abs_edit($launcher_comment, $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LauncherComment  $launcherComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LauncherComment $launcher_comment)
    {
        return self::abs_update($request, $launcher_comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LauncherComment  $launcherComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(LauncherComment $launcher_comment)
    {
        return self::abs_destroy($launcher_comment);
    }
}
