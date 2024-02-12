<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\ABS_Comment;
use App\Http\Resources\CommentResourceWithEvent;
use App\Models\EventComment;
use App\Models\Event;
use Illuminate\Http\Request;

class EventCommentController extends ABS_Comment
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $event, Request $request)
    {
        return self::abs_index($event, $request, 
            route('event.event_comment.index', ['event' => $event->id]),
            route('event.index')
        );
    }

    public function getMyComments(Request $request) {
        
        $comments = CommentResourceWithEvent::collection
        (
            EventComment::where('user_id', $request->user()->id)->whereNotNull('msg')->get()
        )->toArray($request);

        return response()->json([
            'status' => 'ok',
            'data' => $comments
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Event $event, Request $request)
    {
        return self::abs_list($event, $request);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Event $event, Request $request)
    {
        return self::abs_store($event, $request, EventComment::class, 'event_id');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventComment  $EventComment
     * @return \Illuminate\Http\Response
     */
    public function show(EventComment $EventComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventComment  $EventComment
     * @return \Illuminate\Http\Response
     */
    public function edit(EventComment $event_comment, Request $request)
    {   
        return self::abs_edit($event_comment, $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventComment  $EventComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventComment $event_comment)
    {
        return self::abs_update($request, $event_comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventComment  $EventComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventComment $event_comment)
    {
        return self::abs_destroy($event_comment);
    }
}
