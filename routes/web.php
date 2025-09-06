<?php

use App\Http\Controllers\PesertaAuthController;
use App\Http\Controllers\PanitiaAuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminAuthController;

Route::prefix('peserta')->group(function () {
    Route::get('register', [PesertaAuthController::class, 'showRegisterForm'])->name('peserta.register');
    Route::post('register', [PesertaAuthController::class, 'register']);
    Route::get('login', [PesertaAuthController::class, 'showLoginForm'])->name('peserta.login');
    Route::post('login', [PesertaAuthController::class, 'login']);
    Route::middleware('auth:peserta')->group(function () {
        Route::get('dashboard', [PesertaAuthController::class, 'dashboard'])->name('peserta.dashboard');
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
        Route::post('logout', [PanitiaAuthController::class, 'logout'])->name('panitia.logout');

        // Attendance routes
        Route::post('scan', [AttendanceController::class, 'scanBarcode'])->name('panitia.scan');
        Route::get('attendances/today', [AttendanceController::class, 'getTodayAttendances'])->name('panitia.attendances.today');
    });
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('panitia/{id}/approve', [AdminAuthController::class, 'approvePanitia'])->name('admin.approve-panitia');
        Route::post('panitia/{id}/reject', [AdminAuthController::class, 'rejectPanitia'])->name('admin.reject-panitia');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });
});
