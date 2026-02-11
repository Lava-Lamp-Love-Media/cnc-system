<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user || !$user->isSuperAdmin()) {
            abort(403);
        }

        return $next($request);
    }
}
