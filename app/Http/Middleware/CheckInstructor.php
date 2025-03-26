<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckInstructor
{
    /**
   */
  public function handle(Request $request, Closure $next): Response{
      if (!Auth::check()) {
          return redirect('/login');}

        $user = Auth::user();

        if ($user->role !== 'instructor') {
            return redirect('/404');
        }

        return $next($request);
    }
}