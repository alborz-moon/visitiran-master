<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EditorAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if($user == null || 
            (
                $user->level != User::$ADMIN_LEVEL &&
                $user->level != User::$EDITOR_LEVEL
            )
        )
            return Redirect::route('403');
        
        if($request->getHost() == Controller::$SHOP_SITE && 
            $user->access != User::$ACCESS_BOTH &&
            $user->access != User::$ACCESS_SHOP
        )
            return Redirect::route('403');
            
        if($request->getHost() == Controller::$EVENT_SITE && 
            $user->access != User::$ACCESS_BOTH &&
            $user->access != User::$ACCESS_EVENT
        )
            return Redirect::route('403');

        return $next($request);
    }
}
