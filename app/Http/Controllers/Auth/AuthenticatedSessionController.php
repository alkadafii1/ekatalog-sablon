<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\View\View;

// class AuthenticatedSessionController extends Controller
// {
//     public function create(Request $request): View
//     {
//         $guard = $request->route()->defaults['guard'] ?? 'web';

//         return $guard === 'admin'
//             ? view('auth.admin-login')
//             : view('auth.user-login');
//     }

//     public function store(Request $request)
//     {

//         // Validasi input
//         $credentials = $request->validate([
//             'email' => ['required', 'string', 'email'],
//             'password' => ['required', 'string'],
//         ]);

//         // Tentukan guard dari route yang dipanggil
//         $guard = $request->route()->defaults['guard'] ?? 'web';

//         // Login sesuai guard
//         if (Auth::guard($guard)->attempt($credentials, $request->boolean('remember'))) {
//             $request->session()->regenerate();

//             $user = Auth::guard($guard)->user();

//             // Jika user admin
//             if ($user->role === 'admin') {
//                 return redirect()->intended('/admin/dashboard');
//             }

//             // Jika user biasa
//             if ($user->role === 'user') {
//                 return redirect()->intended('/');
//             }

//             // Jika role tidak terdeteksi
//             Auth::guard($guard)->logout();
//             return back()->withErrors(['email' => 'Role tidak dikenali.']);
//         }

//         return back()->withErrors([
//             'email' => 'Email atau password salah.',
//         ])->onlyInput('email');
//     }


//     public function destroy(Request $request): RedirectResponse
//     {
//         Auth::logout();

//         $request->session()->invalidate();
//         $request->session()->regenerateToken();

//         return redirect()->route('user.login');
//     }
// }
