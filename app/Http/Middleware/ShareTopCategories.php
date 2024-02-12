<?php

namespace App\Http\Middleware;

use App\Http\Resources\CategoryVeryDigest;
use App\Models\Category;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ShareTopCategories
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
        View::share('top_categories',
            CategoryVeryDigest::collection(Category::head()->visible()->get())->toArray($request)
        );
        return $next($request);
    }
}
