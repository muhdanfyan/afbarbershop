<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kapster;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $jumlahUser = User::count();
        $jumlahKapster = Kapster::count();
        $jumlahBookingHariIni = Transaksi::whereDate('created_at', now()->toDateString())->count();
        $pendapatanHariIni = Transaksi::whereDate('created_at', now()->toDateString())->sum('total_harga');
        // Statistik penjualan harian (7 hari terakhir)
        $statistikPenjualanHarian = Transaksi::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(total_harga) as total'))
            ->whereDate('created_at', '>=', now()->subDays(6)->toDateString())
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal')
            ->get()
            ->pluck('total', 'tanggal')
            ->toArray();
        // 5 booking terbaru
        $bookingTerbaru = Transaksi::orderByDesc('created_at')->limit(5)->get();
        // Total omzet bulan ini
        $totalOmzet = Transaksi::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_harga');
        // Penghasilan kapster (40% dari jasa) bulan ini
        $totalFeeKapster = 0;
        foreach (Transaksi::with('jasa')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->get() as $transaksi) {
            $totalJasa = $transaksi->jasa->sum('harga');
            $totalFeeKapster += $totalJasa * 0.4;
        }
        // Penghasilan manajemen (60% dari omzet) bulan ini
        $penghasilanManajemen = $totalOmzet * 0.6;

        return view('backend.admin.dashboard', compact(
            'jumlahUser',
            'jumlahKapster',
            'jumlahBookingHariIni',
            'pendapatanHariIni',
            'statistikPenjualanHarian',
            'bookingTerbaru',
            'totalOmzet',
            'totalFeeKapster',
            'penghasilanManajemen'
        ));
    }
}
