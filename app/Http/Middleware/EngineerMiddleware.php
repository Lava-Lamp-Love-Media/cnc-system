<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EngineerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isEngineer()) {
            abort(403, 'Unauthorized - Engineer access only');
        }

        return $next($request);
    }
}
