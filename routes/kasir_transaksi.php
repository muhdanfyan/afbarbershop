<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminKasirTransaksiController;

Route::middleware('auth')->group(function () {
    Route::get('/admin/kasir-transaksi', [AdminKasirTransaksiController::class, 'index'])->name('admin.kasir.transaksi');
});
