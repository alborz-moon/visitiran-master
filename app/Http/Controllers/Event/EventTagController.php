<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventTagResource;
use App\Http\Resources\EventTagShare;
use App\Http\Resources\EventUserDigest;
use App\Models\EventTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EventTagController extends Controller
{


    public function search(Request $request) {

        //todo : uncomment
        $validator = [
            // 'key' => 'required|persian_alpha|min:2|max:15',
            'key' => 'required|min:2|max:15'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        $categories = EventTag::where('label', 'like', '%' . $request['key'] . '%')
            ->get();
        
        return response()->json([
            'status' => 'ok',
            'data' => EventTagShare::collection($categories)->toArray($request)
        ]);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.eventTag.list', 
            ['items' => EventTagResource::collection(EventTag::all())->toArray($request)]
        );
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'data' => EventTagResource::collection($request->user()->isEditor() ? EventTag::visible()->get() : EventTag::all())->toArray($request)
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.eventTag.create');
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
            'label' => 'required|string|min:2',
            'visibility' => 'required|boolean'
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);
        
        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);
        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        EventTag::create($request->toArray());
        return Redirect::route('eventTags.index');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(EventTag $eventTag)
    {
        return view('admin.eventTag.create', ['item' => $eventTag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  EventTag $eventTag
     * @return \Illuminate\Http\Response
     */
    public function update(EventTag $eventTag, Request $request)
    {
        $validator = [
            'label' => 'required|string|min:2',
            'visibility' => 'nullable|boolean'
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);
        
        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);
        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        $eventTag->label = $request['label'];
        $eventTag->visibility = $request->has('visibility') ? $request['visibility'] : $eventTag->visibility;
        $eventTag->save();
        
        return Redirect::route('eventTags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EventTag  $eventTag
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventTag $eventTag)
    {
        $deleted = $eventTag->delete();
        if($deleted)
            return response()->json(['status' => 'ok']);
            
        return response()->json([
            'status' => 'nok', 
            'msg' => 'رویدادی از این آیتم استفاده می کند و امکان حذف آن وجود ندارد.'
        ]);
    }


    public function list(EventTag $tag) {
    
        if(!$tag->visibility)
            return Redirect::route('403');

        $label = $tag->label;
        $whereClause = "events.visibility = true and end_registry > " . time() . " and tags like '%" . $label . "%'";
        return $this->returnListPage($whereClause, $tag);    
    }

    public function allCategories(string $orderBy, Request $request) {
        
        $tag = $request->query('tag', null);
        $launcher = $request->query('launcher', null);
        $city = $request->query('city', null);

        $whereClause = "events.visibility = true and end_registry > " . time();
        $whereClause2 = "";

        if($tag != null)
            $whereClause2 .= " and tags like '%" . $tag . "%'";
        
        if($launcher != null)
            $whereClause2 .= " and launcher_id = " . $launcher;

        if($city != null)
            $whereClause2 .= " and city_id = " . $city;

        return $this->returnListPage($whereClause, null, $whereClause2, $request);
    }


    private function returnListPage($whereClause, $tag=null, $initialSet=null, $request=null) {

        $attrs = DB::connection('mysql2')->select('select price, language, facilities, age_description, level_description from events where ' . $whereClause);
        $cities = DB::connection('mysql2')->select('select cities.id, cities.name from events, cities where city_id is not null and city_id = cities.id and ' . $whereClause . ' group by(cities.id)');
        $launchers = DB::connection('mysql2')->select('select distinct(launcher_id) as id, launchers.company_name from launchers, events where launcher_id = launchers.id and ' . $whereClause);
        
        $tags = EventTag::visible()->get();

        $minPrice = null;
        $maxPrice = null;
        $langs = [];
        $facilities = [];
        $ages = [];
        $levels = [];

        foreach($attrs as $attr) {

            if($minPrice == null || $minPrice > $attr->price)
                $minPrice = $attr->price;

            if($maxPrice == null || $maxPrice < $attr->price)
                $maxPrice = $attr->price;

            if(array_search($attr->level_description, $levels) === false)
                array_push($levels, $attr->level_description);

            if(array_search($attr->age_description, $ages) === false)
                array_push($ages, $attr->age_description);

            $facils = explode('_', $attr->facilities);

            foreach($facils as $facil) {

                if(empty($facil))
                    continue;

                if(array_search($facil, $facilities) === false)
                    array_push($facilities, $facil);
            }

            $l = explode('_', $attr->language);
            foreach($l as $itr) {
                if(array_search($itr, $langs) === false)
                    array_push($langs, $itr);
            }
            
        }

        if($tag == null) {
            if($initialSet == null)
                return view('event.list', [
                    'launchers' => $launchers,
                    'maxPrice' => $maxPrice,
                    'minPrice' => $minPrice,
                    'cities' => $cities,
                    'tags' => $tags,
                    'facilities' => $facilities,
                    'langs' => $langs,
                    'ages' => $ages,
                    'levels' => $levels
                ]);

            return view('event.list', [
                'launchers' => $launchers,
                'maxPrice' => $maxPrice,
                'minPrice' => $minPrice,
                'tags' => $tags,
                'cities' => $cities,
                'facilities' => $facilities,
                'langs' => $langs,
                'ages' => $ages,
                'levels' => $levels,
                'initialSet' => EventUserDigest::collection(
                    DB::connection('mysql2')->select('select events.*, launchers.company_name, cities.name as city from launchers, events left join cities on events.city_id = cities.id where events.launcher_id = launchers.id and ' . $whereClause . $initialSet)
                )->toArray($request)
            ]);
        }
            

        return view('event.list', [
            'name' => $tag->label,
            'id' => $tag->id,
            'launchers' => $launchers,
            'maxPrice' => $maxPrice,
            'minPrice' => $minPrice,
            'cities' => $cities,
            'facilities' => $facilities,
            'langs' => $langs,
            'ages' => $ages,
            'levels' => $levels,
        ]);
    }

    
}
