<?php

use App\Http\Controllers\PesertaAuthController;
use App\Http\Controllers\PanitiaAuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminAuthController;

// Welcome page - role selection
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('peserta')->group(function () {
    Route::get('register', [PesertaAuthController::class, 'showRegisterForm'])->name('peserta.register');
    Route::post('register', [PesertaAuthController::class, 'register']);
    Route::get('login', [PesertaAuthController::class, 'showLoginForm'])->name('peserta.login');
    Route::post('login', [PesertaAuthController::class, 'login']);
    Route::middleware('auth:peserta')->group(function () {
        Route::get('dashboard', [PesertaAuthController::class, 'dashboard'])->name('peserta.dashboard');
        Route::get('barcode', [PesertaAuthController::class, 'barcode'])->name('peserta.barcode');
        Route::get('settings', [PesertaAuthController::class, 'settings'])->name('peserta.settings');
        Route::post('settings', [PesertaAuthController::class, 'updateSettings'])->name('peserta.updateSettings');
        Route::post('logout', [PesertaAuthController::class, 'logout'])->name('peserta.logout');
    });
});

Route::prefix('panitia')->group(function () {
    Route::get('register', [PanitiaAuthController::class, 'showRegisterForm'])->name('panitia.register');
    Route::post('register', [PanitiaAuthController::class, 'register']);
    Route::get('login', [PanitiaAuthController::class, 'showLoginForm'])->name('panitia.login');
    Route::post('login', [PanitiaAuthController::class, 'login']);
    Route::get('pending', [PanitiaAuthController::class, 'pending'])->name('panitia.pending');
    Route::middleware('auth:panitia')->group(function () {
        Route::get('dashboard', [PanitiaAuthController::class, 'dashboard'])->name('panitia.dashboard');
        Route::get('settings', [PanitiaAuthController::class, 'settings'])->name('panitia.settings');
        Route::post('settings', [PanitiaAuthController::class, 'updateSettings'])->name('panitia.updateSettings');
        Route::post('logout', [PanitiaAuthController::class, 'logout'])->name('panitia.logout');

        // Attendance routes
        Route::get('scan', [AttendanceController::class, 'showScanForm'])->name('panitia.scan');
        Route::post('scan', [AttendanceController::class, 'scanBarcode'])->name('panitia.scan.post');
        Route::get('attendances/today', [AttendanceController::class, 'getTodayAttendances'])->name('panitia.attendances.today');
        Route::get('attendance-list', [AttendanceController::class, 'showAttendanceList'])->name('panitia.attendance-list');
    });
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('settings', [AdminAuthController::class, 'settings'])->name('admin.settings');
        Route::post('settings', [AdminAuthController::class, 'updateSettings'])->name('admin.updateSettings');
        Route::post('panitia/{id}/approve', [AdminAuthController::class, 'approvePanitia'])->name('admin.approve-panitia');
        Route::post('panitia/{id}/reject', [AdminAuthController::class, 'rejectPanitia'])->name('admin.reject-panitia');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });
});
