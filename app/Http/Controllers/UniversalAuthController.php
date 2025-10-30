<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UniversalAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|in:peserta,panitia,admin',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $role = $request->role;
        $credentials = $request->only('email', 'password');

        $guard = $role; // 'peserta', 'panitia', or 'admin'

        if (Auth::guard($guard)->attempt($credentials)) {
            $user = Auth::guard($guard)->user();

            // Special check for panitia approval
            if ($role === 'panitia' && !$user->isApproved()) {
                Auth::guard($guard)->logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum disetujui oleh admin.',
                ]);
            }

            $request->session()->regenerate();

            // Redirect based on role
            switch ($role) {
                case 'peserta':
                    return redirect()->intended(route('peserta.dashboard'));
                case 'panitia':
                    return redirect()->intended(route('panitia.dashboard'));
                case 'admin':
                    return redirect()->intended(route('admin.dashboard'));
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }
}
