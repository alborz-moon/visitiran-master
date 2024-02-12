<?php

namespace App\Http\Controllers\Event;

use App\Http\Resources\EventAdminDigest;
use App\Http\Resources\EventGalleryResource;
use App\Http\Resources\EventLauncherDigest;
use App\Http\Resources\EventPhase1Resource;
use App\Http\Resources\EventPhase2Resource;
use App\Http\Resources\EventUserDigest;
use App\Http\Resources\EventUserResource;
use App\Http\Resources\LauncherVeryDigest;
use App\Models\Config;
use App\Models\Event;
use App\Models\EventComment;
use App\Models\EventTag;
use App\Models\Facility;
use App\Models\Launcher;
use App\Models\LauncherFollowers;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class EventController extends EventHelper
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $states = State::orderBy('name', 'asc')->get();
        $mode = 'create';

        if($request->user()->isEditor()) {
            
            $launchers = LauncherVeryDigest::collection(Launcher::all())->toArray($request);
            return view('event.event.create-event', compact('states', 'mode', 'launchers'));
        }

        return view('event.event.create-event', compact('states', 'mode'));
    }

    public function edit(Event $event, Request $request) {
        
        if(!Gate::allows('update', $event))
            return Redirect::route('create-event');

        $states = State::orderBy('name', 'asc')->get();
        $mode = 'edit';
        $id = $event->id;
        
        if($request->user()->isEditor()) {
            $launchers = LauncherVeryDigest::collection(Launcher::all())->toArray($request);
            return view('event.event.create-event', compact('states', 'mode', 'id', 'launchers'));
        }

        return view('event.event.create-event', compact('states', 'mode', 'id'));
    }

    public function addGalleryToEvent(Event $event=null) {

        if($event == null || !Gate::allows('update', $event))
            return Redirect::route('create-event');

        return view('event.event.create-info', [
            'id' => $event->id, 
            'desc' => $event->description, 
            'mode' => $event->status == 'init' ? 'create' : 'edit'
        ]);

    }

    public function addSessionsInfo(Event $event=null) {
        
        if($event == null || !Gate::allows('update', $event))
            return Redirect::route('create-event');

        return view('event.event.create-time', ['id' => $event->id]);
    }
    
    public function addPhase2Info(Event $event=null) {
        
        if($event == null || !Gate::allows('update', $event))
            return Redirect::route('create-event');

        return view('event.event.create-contact', ['id' => $event->id]);
    }

    public function changeStatus(Request $request) {

        $validator = [
            'status' => ['required', Rule::in(['pending', 'confirmed', 'rejected'])],
            'event_id' => 'required|exists:mysql2.events,id'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        $event = Event::whereId($request['event_id'])->first();
        $event->status = $request['status'];
        $event->save();

        return response()->json(['status' => 'ok']);
    }

    
    public function changeIsInTopList(Request $request) {

        $validator = [
            'event_id' => 'required|exists:mysql2.events,id'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        $event = Event::whereId($request['event_id'])->first();
        $event->is_in_top_list = !$event->is_in_top_list;
        $event->save();

        return response()->json(['status' => 'ok']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = self::build_filters($request, false, false)->get();
        $events = EventAdminDigest::collection($events)->toArray($request);
        
        $launcherFilter = $request->query('launcher', null);
        $tagFilter = $request->query('tag', null);
        $typeFilter = $request->query('type', null);
        $visibilityFilter = $request->query('visibility', null);
        $statusFilter = $request->query('status', null);
        $isInTopListFilter = $request->query('isInTopList', null);
        $orderByTypeFilter = $request->query('orderByType', null);
        $orderBy = $request->query('orderBy', null);

        $launchers = DB::select('select l.id, l.company_name from events.events e, events.launchers l where e.launcher_id = l.id group by l.id');
        $tags = DB::select('select label from events.event_tags where 1');

        $fromCreatedAt = $request->query('fromCreatedAt', null);
        $toCreatedAt = $request->query('toCreatedAt', null);

        return view('admin.event.list', [
            'items' => $events,
            'launchers' => $launchers,
            'tags' => $tags,
            'launcherFilter' => $launcherFilter,
            'fromCreatedAtFilter' => $fromCreatedAt,
            'toCreatedAtFilter' => $toCreatedAt,
            'isInTopListFilter' => $isInTopListFilter,
            'orderByType' => $orderByTypeFilter,
            'orderBy' => $orderBy,
            'tagFilter' => $tagFilter,
            'typeFilter' => $typeFilter,
            'statusFilter' => $statusFilter,
            'visibilityFilter' => $visibilityFilter
        ]);
    }

    public function getDesc(Event $event, Request $request) {
        Gate::authorize('getPhaseInfo', $event);
        return response()->json([
            'status' => 'ok',
            'data' => $event->description
        ]);
    }

    public function getPhase1Info(Event $event, Request $request) {
        
        Gate::authorize('getPhaseInfo', $event);
        $isEditor = $request->user()->isEditor();

        if(!$isEditor)
            return response()->json([
                'status' => 'ok',
                'data' => EventPhase1Resource::make($event)->toArray($request)
            ]);

        $eventTmp = EventPhase1Resource::make($event)->toArray($request);
        $eventTmp['launcher'] = LauncherVeryDigest::make($event->launcher)->toArray($request);


        return response()->json([
            'status' => 'ok',
            'data' => $eventTmp
        ]);
    }

    public function getPhase2Info(Event $event, Request $request) {
        Gate::authorize('getPhaseInfo', $event);
        return response()->json([
            'status' => 'ok',
            'data' => EventPhase2Resource::make($event)->toArray($request)
        ]);
    }

    public function sendForReview(Event $event, Request $request) {

        Gate::authorize('update', $event);

        $errs = [];

        if($event->price == null)
            array_push($errs, 'ثبت نام و تماس');
        
        if($event->img == null || $event->description == null)
            array_push($errs, 'اطلاعات تکمیلی');

        if($event->sessions()->count() == 0)
            array_push($errs, 'زمان برگزاری');

        if(count($errs) == 0) {

            if($request->user()->isEditor() && $event->status != Event::$INIT_STATUS)
                return response()->json(['status' => 'ok']);

            $event->status = Event::$PENDING_STATUS;
            $event->save();
            return response()->json(['status' => 'ok']);
        }
        
        return response()->json(['status' => 'nok', 'data' => 'لطفا اطلاعات ضروری در بخش های زیر را پرنمایید.<br/>' . implode('<br/>', $errs)]);
    }

    
    public function search(Request $request) {

        $validator = [
            // 'key' => 'required|persian_alpha|min:2|max:15',
            'key' => 'required|min:2|max:15',
            'tag' => 'nullable|string|exists:events.event_tags,name',
            'return_type' => ['required', Rule::in(['digest', 'card'])]
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        $request['return_type'] = 'digest';

        $events = Event::like($request['key'], 
            $request->has('tag') ? $request['tag'] : null,
            $request['return_type']
        );

        
        // if($request['return_type'] == 'digest')
            return response()->json([
                'status' => 'ok',
                'data' => EventUserDigest::collection($events)->toArray($request)
            ]);
        // return response()->json([
        //     'status' => 'ok',
        //     'data' => ProductDigestUser::collection($products)->toArray($request)
        // ]);
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

        $limit = $request->query('limit', 30);
        $key = $request->query('key', null);
        $page = $request->query('page', 1);


        if($key != null && $page > 1)
            return abort(401);

        $filters = self::build_filters($request, true, $key != null);

        if($key == null) {
            
            if($limit != 30)
                $filters->where('is_in_top_list', true);

            $events = $filters->skip(($page - 1) * $limit)->take($limit)->get();
        }
        else {
            $events = Event::like($key, null, 'digest', $filters);
        }

        return response()->json([
            'status' => 'ok',
            'data' =>  EventUserDigest::collection($events)->toArray($request)
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
        return $this->addOrUpdate($request);
    }

    public function launcherUpdate(Event $event, Request $request)
    {
        
        Gate::authorize('update', $event);

        $validator = [
            'start_registry_date' => ['nullable', 'regex:/^[1-4]\d{3}\/((((0[1-6])|([1-6]))\/((3[0-1])|([1-2][0-9])|((0[1-9])|([1-9]))))|((1[0-2]|(((0[7-9])|[7-9])))\/(30|([1-2][0-9])|(((0[1-9])|([1-9]))))))$/'],
            'start_registry_time' => 'nullable|date_format:H:i',
            'end_registry_date' => ['nullable', 'regex:/^[1-4]\d{3}\/((((0[1-6])|([1-6]))\/((3[0-1])|([1-2][0-9])|((0[1-9])|([1-9]))))|((1[0-2]|(((0[7-9])|[7-9])))\/(30|([1-2][0-9])|(((0[1-9])|([1-9]))))))$/'],
            'end_registry_time' => 'nullable|date_format:H:i',
            'price' => 'nullable|integer|min:0',
            'capacity' => 'nullable|integer|min:0',
            'visibility' => 'nullable|boolean'
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);
        
        if($request->has('start_registry_date') != $request->has('start_registry_time'))
            return abort(401);

        if($request->has('end_registry_date') != $request->has('end_registry_time'))
            return abort(401);

            
        $start_registry = $event->start_registry;
        $end_registry = $event->end_registry;

        if($request->has('start_registry_date')) {
            $request["start_registry"] = strtotime(self::ShamsiToMilady($request["start_registry_date"]) . " " . $request["start_registry_time"]);
            $start_registry = $request["start_registry"];
        }

        if($request->has('end_registry_date')) {
            $request["end_registry"] = strtotime(self::ShamsiToMilady($request["end_registry_date"]) . " " . $request["end_registry_time"]);
            $end_registry = $request["end_registry"];
        }


        if($start_registry >= $end_registry)
            return response()->json([
                'status' => 'nok',
                'msg' => 'زمان آغاز باید کوچک تر از زمان پایان باشد'
            ]);

        unset($request['start_registry_date']);
        unset($request['start_registry_time']);
        unset($request['end_registry_date']);
        unset($request['end_registry_time']);

        foreach($request->keys() as $key) {
            
            if($key == '_token')
                continue;

            $event[$key] = $request[$key];
        }

        $event->save();
        return response()->json(['status' => 'ok']);

    }


    public function store_phase2(Event $event, Request $request)
    {

        Gate::authorize('update', $event);

        $validator = [
            'start_registry_date' => ['required', 'regex:/^[1-4]\d{3}\/((((0[1-6])|([1-6]))\/((3[0-1])|([1-2][0-9])|((0[1-9])|([1-9]))))|((1[0-2]|(((0[7-9])|[7-9])))\/(30|([1-2][0-9])|(((0[1-9])|([1-9]))))))$/'],
            'start_registry_time' => 'required|date_format:H:i',
            'end_registry_date' => ['required', 'regex:/^[1-4]\d{3}\/((((0[1-6])|([1-6]))\/((3[0-1])|([1-2][0-9])|((0[1-9])|([1-9]))))|((1[0-2]|(((0[7-9])|[7-9])))\/(30|([1-2][0-9])|(((0[1-9])|([1-9]))))))$/'],
            'end_registry_time' => 'required|date_format:H:i',
            'ticket_description' => 'nullable|string|min:2',
            'price' => 'required|integer|min:0',
            'capacity' => 'nullable|integer|min:0',
            'site' => 'nullable|url',
            'email' => 'nullable|email',
            'phone_arr' => 'nullable|array|min:1',
            'phone_arr.*' => 'required|numeric|digits_between:7,11',
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);
        $phone_arr = [];
        if($request->has('phone_arr')) {
            
            foreach($request['phone_arr'] as $p) {
                array_push($phone_arr, $p);
            }

            $request['phone'] = implode('_', $phone_arr);
        }


        $request["start_registry"] = strtotime(self::ShamsiToMilady($request["start_registry_date"]) . " " . $request["start_registry_time"]);
        $request["end_registry"] = strtotime(self::ShamsiToMilady($request["end_registry_date"]) . " " . $request["end_registry_time"]);

        if($request['start_registry'] >= $request['end_registry'])
            return response()->json([
                'status' => 'nok',
                'msg' => 'زمان آغاز باید کوچک تر از زمان پایان باشد'
            ]);

            //todo: complete this section
        // if($request['end_registry'] > $event->start)
        //     return response()->json([
        //         'status' => 'nok',
        //         'msg' => 'زمان ثبت نام باید کوچک تر از زمان آغاز باشد'
        //     ]);

        unset($request['start_registry_date']);
        unset($request['start_registry_time']);
        unset($request['end_registry_date']);
        unset($request['end_registry_time']);
        unset($request['phone_arr']);

        foreach($request->keys() as $key) {
            
            if($key == '_token')
                continue;

            $event[$key] = $request[$key];
        }
        
        $isEditor = $request->user()->isEditor();
        if(!$isEditor && $event->status != Event::$INIT_STATUS)
            $event->status = Event::$PENDING_STATUS;

        $event->save();
        return response()->json(['status' => 'ok']);
    }

    public function store_desc(Event $event, Request $request)
    {
        Gate::authorize('update', $event);

        $validator = [
            'description' => 'required|string|min:2'
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);
        $event->description = $request['description'];
        
        $isEditor = $request->user()->isEditor();
        if(!$isEditor && $event->status != Event::$INIT_STATUS)
            $event->status = Event::$PENDING_STATUS;

        $event->save();
        
        return response()->json(['status' => 'ok']);
    }

    public function set_main_img(Event $event, Request $request)
    {
        Gate::authorize('update', $event);

        $validator = [
            'main_img' => 'required|image'
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);
        
        $filename = $request->main_img->store('public/events');
        $filename = str_replace('public/events/', '', $filename);   
            
        if($event->img != null && !empty($event->img) && 
            file_exists(__DIR__ . '/../../../../public/storage/events/' . $event->img))
            unlink(__DIR__ . '/../../../../public/storage/events/' . $event->img);

        $event->img = $filename;
        
        $isEditor = $request->user()->isEditor();
        if(!$isEditor && $event->status != Event::$INIT_STATUS)
            $event->status = Event::$PENDING_STATUS;

        $event->save();
        return response()->json(['status' => 'ok']);
    }

    public function get_main_img(Event $event, Request $request)
    {           
        return response()->json(['status' => 'ok', 'img' => $event->img != null ? asset('storage/events/' . $event->img) : '']);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Event $event, string $slug)
    {
        if(!$event->visibility ||
            ($event->slug != null && $slug != $event->slug) ||
            ($event->slug == null && $slug != $event->title)
        )
            return Redirect::route('403');

        $event->seen = $event->seen + 1;
        $event->save();

        $launcher = $event->launcher;
        $launcherHref = route('show-launcher', ['launcher' => $launcher->id, 'slug' => 'sample']); //$launcher->company_name

        $user = $request->user();

        if($user == null)
            return view('event.event', [
                'galleries' => EventGalleryResource::collection($event->galleries()->orderBy('priority', 'asc')->get())->toArray($request),
                'launcherHref' => $launcherHref,
                'event' => array_merge(
                    EventUserResource::make($event)->toArray($request), [
                        'is_bookmark' => false,
                        'launcher_is_following' => false,
                        'user_rate' => null,
                        'has_comment' => false,
                    ]), 
                    'critical_point' => Config::where('site', 'event')->first()->critical_point,
                    'is_login' => false,
            ]);

        $comment = EventComment::userComment($event->id, $user->id);

        // dd(EventUserResource::make($event)->toArray($request));
        return view('event.event', [
            'galleries' => EventGalleryResource::collection($event->galleries()->orderBy('priority', 'asc')->get())->toArray($request),
            'launcherHref' => $launcherHref,
            'event' => array_merge(
                EventUserResource::make($event)->toArray($request), 
                [
                    'is_bookmark' => $comment != null && $comment->is_bookmark != null ? $comment->is_bookmark : false,
                    'user_rate' => $comment != null ? $comment->rate : null,
                    'has_comment' => $comment != null && $comment->msg != null,
                    'launcher_is_following' => LauncherFollowers::where('user_id', $user->id)->where('launcher_id', $launcher->id)->count() > 0,
                ]), 
                'is_login' => true,
                'critical_point' => Config::where('site', 'event')->first()->critical_point,
        ]);
    }



    private function addOrUpdate(Request $request, $event = null) {

        $validator = [
            'title' => 'required|string|min:2',
            'age_description' => ['required', Rule::in(['child', 'teen', 'adult', 'all', 'old'])],
            'level_description' => ['required', Rule::in(['national', 'state', 'local', 'pro'])],
            'tags_arr' => 'required|array',
            'tags_arr.*' => 'required|exists:mysql2.event_tags,id',
            'language_arr' => 'required|array',
            'language_arr.*' => ['required', Rule::in(['fa', 'en', 'ar', 'fr', 'gr', 'tr'])],
            'facilities_arr' => 'nullable|array',
            'facilities_arr.*' => 'required|integer|exists:mysql2.event_facilities,id',
            'type' => ['required', Rule::in(['online', 'offline'])],
            'x' => ['required_if:type,offline','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'y' => ['required_if:type,offline','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'city_id' => 'required_if:type,offline|exists:mysql2.cities,id',
            'postal_code' => 'required_if:type,offline|regex:/[1-9][0-9]{9}/',
            'address' => 'required_if:type,offline|string|min:2',
            'link' => 'required_if:type,online|url',
            'launcher_id' => 'nullable|exists:mysql2.launchers,id'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        if($request->has('link') && $request['type'] == 'offline')
            return abort(401);

        if(
            (
                $request->has('address') || $request->has('city_id') || 
                $request->has('x') || $request->has('y')
            ) && $request['type'] == 'online'
        )
            return abort(401);

        $lang_arr = [];
        foreach($request['language_arr'] as $lang)
            array_push($lang_arr, $lang);


        $tags_arr = [];
        foreach($request['tags_arr'] as $tagId) {
            $tag = EventTag::whereId($tagId)->first();
            if($tag != null)
                array_push($tags_arr, $tag->label);
        }

        if($request->has('facilities_arr')) {
            $facilities_arr = [];
            foreach($request['facilities_arr'] as $facId) {
                $facility = Facility::whereId($facId)->first();
                if($facility != null)
                    array_push($facilities_arr, $facility->label);
            }
            $request['facilities'] = implode('_', $facilities_arr);
        }

        $isEditor = $request->user()->isEditor();
        if(
            (!$isEditor && $request->has('launcher_id')) ||
            ($event == null && $isEditor && !$request->has('launcher_id'))
        )
            return abort(401);
            
        $request['tags'] = implode('_', $tags_arr);
        $request['language'] = implode('_', $lang_arr);

        unset($request['type']);
        unset($request['tags_arr']);
        unset($request['facilities_arr']);
        unset($request['language_arr']);

        if($event == null) {
            
            $request['launcher_id'] = $isEditor ? $request['launcher_id'] : $request->user()->launcher->id;
            $request['status'] = 'init';

            $event = Event::create($request->toArray());

            return response()->json([
                'status' => 'ok',
                'id' => $event->id
            ]);
        }

        foreach($request->keys() as $key) {
            
            if($key == '_token')
                continue;

            $event[$key] = $request[$key];
        }

        if(!$isEditor && $event->status != Event::$INIT_STATUS)
            $event->status = 'pending';

        $event->save();
        return response()->json(['status' => 'ok']);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        Gate::authorize('update', $event);
        return $this->addOrUpdate($request, $event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {

        if($event->img != null && !empty($event->img) && 
            file_exists(__DIR__ . '/../../../../public/storage/events/' . $event->img)
        )
            unlink(__DIR__ . '/../../../../public/storage/events/' . $event->img);

        $event->delete();
        return response()->json(['status' => 'ok']);
    }

    public function myEvents(Request $request) {

        $launcher = $request->user()->launcher;
        if($launcher == null)
            abort(401);

        return response()->json([
            'status' => 'ok',
            'data' => EventLauncherDigest::collection($launcher->events)->toArray($request)
        ]);
    }

    public function getMyBookmarks(Request $request) {

        $events = EventUserDigest::collection
        (
            Event::whereIn('id', 
                EventComment::where('user_id', $request->user()->id)->where('is_bookmark', true)->pluck('event_id')->toArray()
            )->get()
        )->toArray($request);

        return response()->json(
            [
                'status' => 'ok',
                'data' => $events
            ]
        );
    }
}