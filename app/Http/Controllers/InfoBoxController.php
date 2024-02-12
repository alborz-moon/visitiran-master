<?php

namespace App\Http\Controllers;

use App\Http\Resources\InfoBoxResource;
use App\Models\InfoBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InfoBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    
        if($request->getHost() == self::$EVENT_SITE)
            $items = InfoBoxResource::collection(InfoBox::event()->get())->toArray($request);
        else
            $items = InfoBoxResource::collection(InfoBox::shop()->get())->toArray($request);

        return view('admin.infobox.list', compact('items'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {    
        if($request->getHost() == self::$EVENT_SITE)
            $info = InfoBox::event()->first();
        else
            $info = InfoBox::shop()->first();

        if($info == null)
            return response()->json([
                'status' => 'ok',
                'data' => []
            ]);

        return InfoBoxResource::make($info)->additional(['status' => 'ok']);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InfoBox  $infobox
     * @return \Illuminate\Http\Response
     */
    public function edit(InfoBox $infobox, Request $request)
    {
        return view('admin.infobox.create', ['item' => InfoBoxResource::make($infobox)->toArray($request)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.infobox.create');
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
            'alt' => 'nullable|string|min:2',
            'href' => 'nullable|string|url',
            'image_file_large' => 'required|image',
            'image_file_mid' => 'nullable|image',
            'image_file_small' => 'nullable|image',
            'collapse_from' => ['required', Rule::in(['right', 'left', 'center'])]
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        $request['img_large'] = $request->image_file_large->store('public/infobox');
        $request['img_large'] = str_replace('public/infobox/', '', $request['img_large']);
        
        if($request->has('image_file_mid')) {
            $request['img_mid'] = $request->image_file_mid->store('public/infobox');
            $request['img_mid'] = str_replace('public/infobox/', '', $request['img_mid']);
        }
        
        if($request->has('image_file_small')) {
            $request['img_small'] = $request->image_file_small->store('public/infobox');
            $request['img_small'] = str_replace('public/infobox/', '', $request['img_small']);
        }

        $request['site'] = $request->getHost() == self::$EVENT_SITE ? 'event' : 'shop';
        InfoBox::create($request->toArray());
        return Redirect::route('infobox.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InfoBox  $infobox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfoBox $infobox)
    {
        $validator = [
            'alt' => 'nullable|string|min:2',
            'href' => 'nullable|url',
            'image_file_large' => 'nullable|image',
            'image_file_mid' => 'nullable|image',
            'image_file_small' => 'nullable|image',
            'collapse_from' => ['nullable', Rule::in(['right', 'left', 'center'])]
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();
            
        if($request->has('image_file_large')) {
            $filename = $request->image_file_large->store('public/infobox');
            $filename = str_replace('public/infobox/', '', $filename);

            if(file_exists(__DIR__ . '/../../../public/storage/infobox/' . $infobox->img_large))
                unlink(__DIR__ . '/../../../public/storage/infobox/' . $infobox->img_large);
            
            $infobox->img_large = $filename;
        }

        if($request->has('image_file_mid')) {
            $filename = $request->image_file_mid->store('public/infobox');
            $filename = str_replace('public/infobox/', '', $filename);
            
            if($infobox->img_mid != null && file_exists(__DIR__ . '/../../../public/storage/infobox/' . $infobox->img_mid))
                unlink(__DIR__ . '/../../../public/storage/infobox/' . $infobox->img_mid);
            
            $infobox->img_mid = $filename;
        }
        
        if($request->has('image_file_small')) {
            $filename = $request->image_file_small->store('public/infobox');
            $filename = str_replace('public/infobox/', '', $filename);
            
            if($infobox->img_small != null && file_exists(__DIR__ . '/../../../public/storage/infobox/' . $infobox->img_small))
                unlink(__DIR__ . '/../../../public/storage/infobox/' . $infobox->img_small);
            
            $infobox->img_small = $filename;
        }

        $infobox->href = $request->has('href') ? $request['href'] : $infobox->href;
        $infobox->alt = $request->has('alt') ? $request['alt'] : $infobox->alt;
        $infobox->collapse_from = $request->has('collapse_from') ? $request['collapse_from'] : $infobox->collapse_from;

        $infobox->save();
        return Redirect::route('infobox.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InfoBox  $infobox
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfoBox $infobox)
    {
        if(file_exists(__DIR__ . '/../../../public/storage/infobox/' . $infobox->img_large))
            unlink(__DIR__ . '/../../../public/storage/infobox/' . $infobox->img_large);

        if($infobox->img_mid != null && !empty($infobox->img_mid) && file_exists(__DIR__ . '/../../../public/storage/infobox/' . $infobox->img_mid))
            unlink(__DIR__ . '/../../../public/storage/infobox/' . $infobox->img_mid);

        if($infobox->img_small != null && !empty($infobox->img_small) && file_exists(__DIR__ . '/../../../public/storage/infobox/' . $infobox->img_small))
            unlink(__DIR__ . '/../../../public/storage/infobox/' . $infobox->img_small);

        $infobox->delete();
        return response()->json(['status' => 'ok']);
    }
}
