<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'menunggu');
        $transaksis = \App\Models\Transaksi::with(['jasa', 'kapster'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.transaksi', compact('transaksis'));
    }

    public function show($id)
    {
        $trx = \App\Models\Transaksi::with(['jasa', 'kapster'])->findOrFail($id);
        return view('admin.transaksi-show', compact('trx'));
    }

    public function transaksiByStatus(Request $request, $status)
    {
        $transaksis = \App\Models\Transaksi::with(['jasa', 'kapster'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.transaksi', compact('transaksis'));
    }
}
