<?php

use App\Http\Controllers\Admin\AdminBarangController;
use App\Http\Controllers\Admin\AdminBarbermanController;
use App\Http\Controllers\Admin\AdminKasirController;
use App\Http\Controllers\Backend\AdminDashboardController;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Frontend\FrontLoginController;


Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/member-logout', [FrontLoginController::class, 'logout'])->name('logout');
Route::get('/member-login', [FrontLoginController::class, 'index'])->name('member.login');


// routes/web.php
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/barang', [AdminBarangController::class, 'index'])->name('admin.barang');
    Route::get('/admin/barberman', [AdminBarbermanController::class, 'index'])->name('admin.barberman');
    Route::get('/admin/kasir', [AdminKasirController::class, 'index'])->name('admin.kasir');
    Route::get('/admin/transaksi', [Transaksi::class, 'index'])->name('admin.transaksi');
    Route::get('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

});