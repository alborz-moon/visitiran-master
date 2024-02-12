<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventSessionLauncherResource;
use App\Http\Resources\EventSessionResource;
use App\Models\Event;
use App\Models\EventSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $event, Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'mode' => $event->status == 'init' ? 'create' : 'edit',
            'data' => EventSessionLauncherResource::collection($event->sessions)->toArray($request)
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
            'start_date' => ['required', 'regex:/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/'],
            'start_time' => 'required|date_format:H:i',
            'end_date' => ['required', 'regex:/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/'],
            'end_time' => 'required|date_format:H:i'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        $request["start"] = strtotime(self::ShamsiToMilady($request["start_date"]) . " " . $request["start_time"]);
        $request["end"] = strtotime(self::ShamsiToMilady($request["end_date"]) . " " . $request["end_time"]);

        $request['event_id'] = $event->id;
        unset($request['start_date']);
        unset($request['start_time']);
        unset($request['end_date']);
        unset($request['end_time']);

        $session = EventSession::create($request->toArray());

        $isEditor = $request->user()->isEditor();
        if(!$isEditor && $event->status != Event::$INIT_STATUS) {
            $event->status = Event::$PENDING_STATUS;
            $event->save();
        }

        return response()->json([
            'status' => 'ok',
            'id' => $session->id,
            'data' => EventSessionLauncherResource::make($session)->toArray($request)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventSession  $eventSession
     * @return \Illuminate\Http\Response
     */
    public function show(EventSession $eventSession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventSession  $eventSession
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, EventSession $eventSession)
    {
        Gate::authorize('destroy', $eventSession->event);
        $eventSession->delete();

        $isEditor = $request->user()->isEditor();
        $event = $eventSession->event;

        if(!$isEditor && $event->status != Event::$INIT_STATUS) {
            $event->status = Event::$PENDING_STATUS;
            $event->save();
        }

        return response()->json(['status' => 'ok']);
    }
}
