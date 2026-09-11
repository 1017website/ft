<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequireDeveloper
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless($request->user()?->is_developer, 403);

        return $next($request);
    }
}
