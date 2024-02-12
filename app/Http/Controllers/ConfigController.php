<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.config.config', [
            'item' => Config::where('site', $request->getHost() === self::$EVENT_SITE ? 'event' : 'shop')->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = [
            'can_pay_cash' => 'nullable|boolean',
            'sell_list_period' => 'nullable|integer|min:1',
            'seen_list_period' => 'nullable|integer|min:1',
            'home_banner_limit' => 'nullable|integer|min:1',
            'detail_banner_limit' => 'nullable|integer|min:1',
            'list_banner_limit' => 'nullable|integer|min:1',
            'critical_point' => 'nullable|integer|min:1',
            'desc_default' => 'nullable|string|min:2'
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);

        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();

        $config = Config::where('site', $request->getHost() === self::$EVENT_SITE ? 'event' : 'shop')->first();
        $config->can_pay_cash = $request->has('can_pay_cash') ? $request['can_pay_cash'] : $config->can_pay_cash;
        $config->sell_list_period = $request->has('sell_list_period') ? $request['sell_list_period'] : $config->sell_list_period;
        $config->seen_list_period = $request->has('seen_list_period') ? $request['seen_list_period'] : $config->seen_list_period;
        $config->home_banner_limit = $request->has('home_banner_limit') ? $request['home_banner_limit'] : $config->home_banner_limit;
        $config->detail_banner_limit = $request->has('detail_banner_limit') ? $request['detail_banner_limit'] : $config->detail_banner_limit;
        $config->list_banner_limit = $request->has('list_banner_limit') ? $request['list_banner_limit'] : $config->list_banner_limit;
        $config->critical_point = $request->has('critical_point') ? $request['critical_point'] : $config->critical_point;
        $config->desc_default = $request->has('desc_default') ? $request['desc_default'] : $config->desc_default;

        $config->save();
        return Redirect::route('config.index');
    }

}
