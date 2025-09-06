<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Panitia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();

        // Get panitia pending approval
        $pendingPanitias = Panitia::where('approval_status', 'pending')->get();

        // Get approved panitias
        $approvedPanitias = Panitia::where('approval_status', 'approved')->get();

        return view('admin.dashboard', compact('admin', 'pendingPanitias', 'approvedPanitias'));
    }

    public function approvePanitia(Request $request, $id)
    {
        $panitia = Panitia::findOrFail($id);
        $panitia->update(['approval_status' => 'approved']);

        return redirect()->route('admin.dashboard')->with('success', 'Panitia berhasil disetujui!');
    }

    public function rejectPanitia(Request $request, $id)
    {
        $panitia = Panitia::findOrFail($id);
        $panitia->update(['approval_status' => 'rejected']);

        return redirect()->route('admin.dashboard')->with('success', 'Panitia berhasil ditolak!');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
