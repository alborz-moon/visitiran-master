<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LauncherAccess
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

        if($user == null || (
            $user->level != User::$LAUNCHER_LEVEL &&
            $user->level != User::$ADMIN_LEVEL &&
            $user->level != User::$EDITOR_LEVEL
        ))
            return Redirect::route('403');

        return $next($request);
    }
}