<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\BeliController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManageAdminController;
use App\Http\Controllers\MobilController;


// --- HALAMAN USER ---
// web.php
Route::get('/', function () {
    $mobils = \App\Models\Mobil::all();
    return view('user', compact('mobils'));
});
Route::post('/beli-mobil', [BeliController::class, 'store'])->name('pembelian.store');

// --- LOGIN & LOGOUT ---
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// --- AREA ADMIN (DIPROTEKSI LOGIN) ---
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // CRUD Mobil
    Route::resource('mobil', MobilController::class);
    Route::delete('/mobil/{id}', [MobilController::class, 'destroy'])->name('mobil.destroy');

    // CRUD Staff Admin
    Route::resource('manage-admin', ManageAdminController::class);

    // Data Pembelian
    Route::get('/admin/pembelian', [BeliController::class, 'index'])->name('admin.pembelian');
    Route::delete('/admin/pembelian/{id}', [BeliController::class, 'destroy'])->name('pembelian.destroy');
});