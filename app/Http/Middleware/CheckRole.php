<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/user/login'); // atau route login user
        }

        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
