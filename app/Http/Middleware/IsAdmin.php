<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user() && Auth::user()->is_admin == 1) {
            return $next($request);
        }

        return redirect('/');
    }
}
