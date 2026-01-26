<?php
use App\Models\Transaksi;

Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Admin\AdminJasaController;
use App\Http\Controllers\Admin\AdminKasirController;
use App\Http\Controllers\Admin\AdminBarangController;
use App\Http\Controllers\Admin\AdminLaporanTransaksi;
use App\Http\Controllers\Admin\AdminMemberController;
use App\Http\Controllers\Admin\AdminProfilController;
use App\Http\Controllers\Admin\AdminSettingController;

use App\Http\Controllers\Frontend\FrontLoginController;
use App\Http\Controllers\Admin\AdminBarbermanController;
use App\Http\Controllers\Backend\AdminDashboardController;



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
    // Livewire Kapster
    Route::view('/admin/kapster', 'backend.admin.kapster')->name('admin.kapster');

    Route::get('/admin/transaksi', [\App\Http\Controllers\Admin\AdminTransaksiController::class, 'index'])->name('admin.transaksi');
    Route::get('/admin/transaksi/{id}', [\App\Http\Controllers\Admin\AdminTransaksiController::class, 'show'])->name('admin.transaksi.show');
    Route::get('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

    // CRUD Jasa
    Route::resource('/admin/jasa', AdminJasaController::class);

    Route::get('/admin/profile', [AdminProfilController::class, 'index'])->name('user.profile');

    Route::view('/admin/user', 'backend.admin.user')->name('admin.user');
    Route::get('/admin/kasir', \App\Livewire\Admin\KasirTransaksi::class)->name('admin.kasir.transaksi');
    Route::get('/admin/laporan', [AdminLaporanTransaksi::class, 'index'])->name('admin.laporan.transaksi');
    Route::get('/admin/member', [AdminMemberController::class, 'index'])->name('admin.member');
    Route::get('/admin/setting', [AdminSettingController::class, 'index'])->name('admin.setting');

});