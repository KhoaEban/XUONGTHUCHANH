<?php

namespace App\Http\Middleware;

use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

class Role
{
    public function handle($request, Closure $next, ...$roles)
    {
        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        return abort(403);
    }
}
