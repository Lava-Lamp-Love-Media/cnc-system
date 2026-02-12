<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShopMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isShop()) {
            abort(403, 'Unauthorized - Shop access only');
        }

        return $next($request);
    }
}
