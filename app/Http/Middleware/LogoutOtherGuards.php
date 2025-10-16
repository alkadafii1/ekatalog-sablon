<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutOtherGuards
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $currentGuard)
    {
        // Daftar semua guard yang digunakan di sistem kamu
        $guards = ['web', 'admin'];

        // Logout semua guard kecuali guard yang sedang digunakan
        foreach ($guards as $guard) {
            if ($guard !== $currentGuard && Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        return $next($request);
    }
}
