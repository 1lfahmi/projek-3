<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\pembelianController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManageAdminController;
use App\Http\Controllers\MobilController;


// --- HALAMAN USER ---
Route::get('/', function () {
    $mobils = \App\Models\Mobil::all();
    return view('user', compact('mobils'));
});
Route::post('/beli-mobil', [pembelianController::class, 'store'])->name('pembelian.store');


Route::get('/admin/pembelian/{id}/edit', [PembelianController::class, 'edit'])->name('beli.edit');
Route::put('/admin/pembelian/{id}', [PembelianController::class, 'update'])->name('beli.update');
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

    // CRUD Staff Admin
    Route::resource('manage-admin', ManageAdminController::class);

    // Data Pembelian
    Route::get('/admin/pembelian', [pembelianController::class, 'index'])->name('admin.pembelian');
    
    // INI YANG DIPERBAIKI: Namanya diganti jadi beli.destroy agar cocok dengan file blade
    Route::delete('/admin/pembelian/{id}', [pembelianController::class, 'destroy'])->name('beli.destroy');

});