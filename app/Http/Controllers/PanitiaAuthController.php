<?php

namespace App\Http\Controllers;

use App\Models\Panitia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PanitiaAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('panitia.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:panitias,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        // Generate barcode string unik
        $barcode = Str::uuid()->toString();

        $panitia = Panitia::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'address' => $request->address,
            'barcode' => $barcode,
            'approval_status' => 'pending', // Menunggu approval admin
        ]);

        // Tidak langsung login, redirect ke halaman pending
        return redirect()->route('panitia.pending')->with('success', 'Pendaftaran berhasil! Menunggu approval dari admin.');
    }

    public function showLoginForm()
    {
        return view('panitia.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('panitia')->attempt($credentials)) {
            $panitia = Auth::guard('panitia')->user();

            // Check if panitia is approved
            if (!$panitia->isApproved()) {
                Auth::guard('panitia')->logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum disetujui oleh admin.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('panitia.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    public function dashboard()
    {
        $panitia = Auth::guard('panitia')->user();
        return view('panitia.dashboard', compact('panitia'));
    }

    public function pending()
    {
        return view('panitia.pending');
    }

    public function logout(Request $request)
    {
        Auth::guard('panitia')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('panitia.login');
    }
}
