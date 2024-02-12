<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->getHost() == self::$EVENT_SITE)
           return view('admin.faq.list', ['items' => FAQ::event()->get()]);
        
        return view('admin.faq.list', ['items' => FAQ::shop()->get()]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if($request->getHost() == self::$EVENT_SITE)
            return response()->json(
                [
                    'status' => 'ok', 
                    'data' => Cache::tags('event')->rememberForever('faq', function () {
                        return FAQ::visible()->event()->orderBy('priority', 'asc')->get();
                    })
                ]
            );

        return response()->json(
                [
                    'status' => 'ok', 
                    'data' => Cache::tags('shop')->rememberForever('faq', function () {
                        return FAQ::visible()->shop()->orderBy('priority', 'asc')->get();
                    })
                ]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq.create');
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
            'title' => 'required|string|min:2',
            'description' => 'required|string|min:2',
            'priority' => 'required|integer|min:1',
            'visibility' => 'nullable|boolean'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        $request['site'] = $request->getHost() == self::$EVENT_SITE ? 'event' : 'shop';
        FAQ::create($request->toArray());
        return Redirect::route('faq.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FAQ  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(FAQ $faq)
    {
        return view('admin.faq.create', ['item' => $faq]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FAQ  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FAQ $faq)
    {
        $validator = [
            'title' => 'nullable|string|min:2',
            'description' => 'nullable|string|min:2',
            'priority' => 'nullable|integer|min:1',
            'visibility' => 'nullable|boolean'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        $faq->visibility = $request->has('visibility') ? $request['visibility'] : $faq->visibility;
        $faq->priority = $request->has('priority') ? $request['priority'] : $faq->priority;
        $faq->title = $request->has('title') ? $request['title'] : $faq->title;
        $faq->description = $request->has('description') ? $request['description'] : $faq->description;

        $faq->save();
        return Redirect::route('faq.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FAQ  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(FAQ $faq)
    {
        $faq->delete();
        return response()->json(['status' => 'ok']);
    }
}
