<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PesertaAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('peserta.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pesertas,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        // Generate barcode string unik (misal UUID)
        $barcode = Str::uuid()->toString();

        $peserta = Peserta::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'address' => $request->address,
            'barcode' => $barcode,
            'is_confirmed' => false, // set to false initially, will be confirmed after scanning
        ]);

        Auth::guard('peserta')->login($peserta);

        return redirect()->route('peserta.dashboard');
    }

    public function showLoginForm()
    {
        return view('peserta.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('peserta')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('peserta.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    public function dashboard()
    {
        $peserta = Auth::guard('peserta')->user();
        // Refresh peserta data to get latest is_confirmed status after scanning
        $peserta->refresh();
        return view('peserta.dashboard', compact('peserta'));
    }

    public function barcode()
    {
        $peserta = Auth::guard('peserta')->user();
        // Refresh peserta data to get latest is_confirmed status after scanning
        $peserta->refresh();
        return view('peserta.barcode', compact('peserta'));
    }

    public function logout(Request $request)
    {
        Auth::guard('peserta')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('peserta.login');
    }
}
