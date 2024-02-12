<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\State;
use Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    
    public function uploadImg(Request $request) {

        $request->validate([
            'upload' => 'required|image'
        ]);

        $filename = $request->upload->store('public/ck');
        $filename = str_replace('public/ck/', '', $filename);

        return response()->json(['status' => 'ok', 'url' => asset('storage/ck/' . $filename)]);
    }
    
    public function testUpload(Request $request) {

        $request->validate([
            'img_file' => 'required|image'
        ]);

        $filename = $request->img_file->store('public/ck');
        $filename = str_replace('public/ck/', '', $filename);

        return response()->json(['status' => 'ok', 'url' => asset('storage/ck/' . $filename)]);
    }

    public function getDesc(Request $request, Category $category = null) {
        
        $config = Config::where('site', $request->getHost() === self::$EVENT_SITE ? 'event' : 'shop')->first();

        if($category == null) {
            return response()->json([
                'status' => 'ok',
                'data' => $config == null ? '' : $config->desc_default
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'data' => $config == null ? '' : $config->desc_default
        ]);
    }

    public function getCities(Request $request) {
        
        $validator = [
            'state_id' => 'required|exists:mysql2.states,id'
        ];

        $validator = Validator::make($request->query(), $validator);

        if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
        }

        return response()->json([
            'status' => 'ok',
            'data' => State::whereId($request['state_id'])->first()->cities()->orderBy('name', 'asc')->get()
        ]);

    }
}
