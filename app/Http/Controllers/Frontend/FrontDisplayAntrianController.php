<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Kapster;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontDisplayAntrianController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        $kapster = Kapster::all();
        $playlists = \App\Models\Playlist::where('status', true)->orderBy('urutan', 'asc')->get();
        return view('front.displayantrian', compact('settings', 'kapster', 'playlists'));
    }

    public function getQueueData()
    {
        $today = now()->toDateString();
        
        $today = now()->toDateString();
        
        // Optimize: Fetch kapsters with their active 'proses' transactions for today in one go
        $kapsters = \App\Models\Kapster::with(['transaksis' => function($query) use ($today) {
            $query->where('tanggal', $today)
                  ->where('status', 'proses')
                  ->with('jasa');
        }])->get()->map(function($k) {
            $currentTrx = $k->transaksis->first();
            
            return [
                'id' => $k->id,
                'name' => $k->nama,
                'avatar' => $k->foto ? asset('storage/' . $k->foto) : 'https://ui-avatars.com/api/?name='.urlencode($k->nama).'&background=2a2a2a&color=d4af37',
                'status' => $currentTrx ? 'serving' : ($k->status === 'bekerja' ? 'available' : 'busy'),
                'currentQueue' => $currentTrx ? ($currentTrx->invoice ? substr($currentTrx->invoice, -4) : 'PROC') : null,
                'service' => $currentTrx ? ($currentTrx->jasa->pluck('nama')->implode(', ') ?: 'Service') : null,
            ];
        });

        $queue = \App\Models\Transaksi::where('status', 'menunggu')
            ->where('tanggal', $today)
            ->orderBy('waktu', 'asc') // Queue on display is ASC (earliest first)
            ->with('jasa')
            ->get()
            ->map(function($t) {
                return [
                    'number' => $t->invoice ? substr($t->invoice, -4) : 'WAIT',
                    'service' => $t->jasa->pluck('nama')->implode(', ') ?: 'Service',
                    'time' => $t->waktu,
                ];
            });

        $totalWaiting = \App\Models\Transaksi::where('status', 'menunggu')->where('tanggal', $today)->count();
        $servedToday = \App\Models\Transaksi::where('status', 'selesai')->where('tanggal', $today)->count();

        return response()->json([
            'kapsters' => $kapsters,
            'queue' => $queue,
            'totalWaiting' => $totalWaiting,
            'servedToday' => $servedToday,
            'activeKapsters' => $kapsters->where('status', 'available')->count() + $kapsters->where('status', 'serving')->count(),
        ]);
    }
}
