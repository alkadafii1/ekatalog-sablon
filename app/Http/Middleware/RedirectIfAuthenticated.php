<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (auth($guard)->check()) {
                // Redirect berdasarkan guard
                return match ($guard) {
                    'admin' => redirect('/admin/dashboard'),
                    default => redirect('/'),
                };
            }
        }

        return $next($request);
    }
}
