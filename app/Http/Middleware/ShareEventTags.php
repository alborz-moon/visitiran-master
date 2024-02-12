<?php

namespace App\Http\Middleware;

use App\Http\Resources\EventTagShare;
use App\Models\EventTag;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ShareEventTags
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
        View::share('eventTags',
            EventTagShare::collection(EventTag::visible()->get())->toArray($request)
        );
        return $next($request);
    }
}
