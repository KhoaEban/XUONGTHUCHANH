<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
   */
  public function handle(Request $request, Closure $next): Response{
      if (!Auth::check()) {
          return redirect('/login');}

        $user = Auth::user();

        if ($user->role !== 'admin') {
            // abort(403, 'Bạn không có quyền truy cập!');
            return redirect('/404');
        }

        return $next($request);
    }
}