<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $addresses = $user->addresses;
        $find_address = false;

        foreach($addresses as $address) {
            if($address->is_default) {
                $find_address = true;
                break;
            }

        }

        if(!$find_address && count($addresses) > 0) {
            $addresses[0]->is_default = true;
            $addresses[0]->save();
        }

        return response()->json(
            [
                'status' => 'ok',
                'data' => AddressResource::collection($addresses)->toArray($request)
            ]
        );
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
            'name' => 'required|string|min:2',
            'x' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'y' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'recv_name' => 'required|string|min:2',
            'recv_last_name' => 'required|string|min:2',
            'recv_phone' => 'required|regex:/(09)[0-9]{9}/',
            'city_id' => 'required|exists:mysql2.cities,id',
            'postal_code' => 'required|regex:/[1-9][0-9]{9}/',
            'address' => 'required|string|min:2',
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        $request['user_id'] = $request->user()->id;
        Address::create($request->toArray());

        return response()->json(['status' => 'ok']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address = null)
    {
        if($address == null || $request->user()->id != $address->user_id)
            abort(401);
        
        $validator = [
            'name' => 'required|string|min:2',
            'x' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'y' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'recv_name' => 'required|string|min:2',
            'recv_last_name' => 'required|string|min:2',
            'recv_phone' => 'required|regex:/(09)[0-9]{9}/',
            'city_id' => 'required|exists:mysql2.cities,id',
            'postal_code' => 'required|regex:/[1-9][0-9]{9}/',
            'address' => 'required|string|min:2',
            'is_defailt' => 'nullable|boolean'
        ];
        
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);
        
        foreach($request->keys() as $key) {
            
            if($key == '_token')
                continue;

            $address[$key] = $request[$key];
        }

        $address->save();
        return response()->json(['status' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Address $address = null)
    {
        if($address == null || $request->user()->id != $address->user_id)
            return abort(401);
        
        $address->delete();
        return response()->json(['status' => 'ok']);
    }
}
