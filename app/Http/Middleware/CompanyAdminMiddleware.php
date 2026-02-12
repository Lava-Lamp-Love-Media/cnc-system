<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanyAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isCompanyAdmin()) {
            abort(403, 'Unauthorized - Company Admin access only');
        }

        return $next($request);
    }
}
