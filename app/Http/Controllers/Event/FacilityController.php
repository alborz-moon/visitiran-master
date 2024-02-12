<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacilityResource;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.facility.list', 
            ['items' => FacilityResource::collection(Facility::all())->toArray($request)]
        );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Facility $facility)
    {
        return view('admin.facility.create', ['item' => $facility]);
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
            'data' => FacilityResource::collection(Facility::visible()->get())->toArray($request)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.facility.create');
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
            'visibility' => 'nullable|boolean',
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);
        
        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();
        
        Facility::create($request->toArray());
        return Redirect::route('facilities.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function update(Facility $facility, Request $request)
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
            
        $facility->label = $request['label'];
        $facility->visibility = $request->has('visibility') ? $request['visibility'] : $facility->visibility;
        $facility->save();
        
        return Redirect::route('facilities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facility $facility)
    {
        $deleted = $facility->delete();
        if($deleted)
            return response()->json(['status' => 'ok']);
            
        return response()->json([
            'status' => 'nok', 
            'msg' => 'رویدادی از این آیتم استفاده می کند و امکان حذف آن وجود ندارد.'
        ]);
    }
}
