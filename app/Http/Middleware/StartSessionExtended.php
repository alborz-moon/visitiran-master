<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;


class StartSessionExtended extends StartSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

public function handle($request, Closure $next)
    {
        return parent::handle($request, $next); // defer to the right stuff
    }


protected function storeCurrentUrl(Request $request, $session)
    {
        if (
            $request->method() === 'GET' &&
            $request->route() && !$request->ajax()
        ) {
            $session->setPreviousUrl($request->fullUrl());
        }
    }

}
