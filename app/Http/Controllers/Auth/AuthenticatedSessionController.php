<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Requests\Auth\UserLoginRequest; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
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
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
{
     $guard = $request->route()->defaults['guard'] ?? 'web';

    if ($guard === 'admin') {
        return $this->loginAdmin(app(AdminLoginRequest::class), $request);
    } else {
        return $this->loginUser(app(UserLoginRequest::class), $request);
    }
}

protected function loginUser(UserLoginRequest $request): RedirectResponse
{
    $request->authenticate(); 

    $request->session()->regenerate();

    return redirect()->intended(route('home'));

}

protected function loginAdmin(AdminLoginRequest $request): RedirectResponse
{
    $request->authenticate(); 

    $request->session()->regenerate();

    return redirect()->intended(route('dashboard'));
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        
        $guard = $request->route()->defaults['guard'] ?? 'web';

        // Logout sesuai guard
        Auth::guard($guard)->logout();

        // Hapus session dan regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
