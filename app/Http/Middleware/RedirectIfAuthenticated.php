<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Tentukan guard admin
        $guards = empty($guards) ? ['admin'] : $guards;

        // Mengecek apakah user sudah login
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Kalau sudah login sebagai admin
                return $guard ===  redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
