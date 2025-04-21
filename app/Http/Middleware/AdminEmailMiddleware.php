<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminEmailMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        
        $adminEmail = 'tolyshimarev@gmail.com';

        if (Auth::check() && Auth::user()->email === $adminEmail) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'У вас нет доступа к админке.');
    }
}

