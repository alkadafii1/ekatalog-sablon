<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan form login sesuai guard.
     */
    public function create(Request $request): View
    {
        $guard = $request->route()->defaults['guard'] ?? 'web';

        if ($guard === 'admin') {
            return view('auth.admin-login');
        }

        return view('auth.user-login');
    }

    /**
     * Proses login sesuai guard.
     */
    public function store(Request $request): RedirectResponse
    {
        $guard = $request->route()->defaults['guard'] ?? 'web';

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::guard($guard)->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::guard($guard)->user();

        // Pastikan role sesuai dengan guard
        if ($guard === 'admin' && $user->role !== 'admin') {
            Auth::guard($guard)->logout();
            return redirect()->route('admin.login')->withErrors(['email' => 'Role tidak sesuai.']);
        }

        if ($guard === 'web' && $user->role !== 'user') {
            Auth::guard($guard)->logout();
            return redirect()->route('user.login')->withErrors(['email' => 'Role tidak sesuai.']);
        }

        return redirect()->intended($guard === 'admin' ? 'admin/dashboard' : '/dashboard');
    }


    /**
     * Proses logout sesuai guard.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $guard = $request->route()->defaults['guard'] ?? 'web';

        Auth::guard($guard)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($guard === 'admin' ? 'admin.login' : 'user.login');
    }

}
