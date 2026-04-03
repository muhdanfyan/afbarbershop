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
        return view('front.displayantrian', compact('settings', 'kapster'));
    }

    public function getQueueData()
    {
        $today = now()->toDateString();
        $kapsters = \App\Models\Kapster::all()->map(function($k) use ($today) {
            $currentTrx = \App\Models\Transaksi::where('kapster_id', $k->id)
                ->where('tanggal', $today)
                ->where('status', 'proses')
                ->first();
            
            return [
                'id' => $k->id,
                'name' => $k->nama,
                'avatar' => $k->foto ? asset('storage/' . $k->foto) : 'https://picsum.photos/seed/'.$k->id.'/100/100',
                'status' => $currentTrx ? 'serving' : ($k->is_active ? 'available' : 'busy'),
                'currentQueue' => $currentTrx ? ($currentTrx->invoice ? substr($currentTrx->invoice, -4) : 'PROC') : null,
                'service' => $currentTrx ? ($currentTrx->layanan->nama ?? 'Service') : null,
            ];
        });

        $queue = \App\Models\Transaksi::where('status', 'menunggu')
            ->where('tanggal', $today)
            ->orderBy('waktu', 'asc')
            ->get()
            ->map(function($t) {
                return [
                    'number' => $t->invoice ? substr($t->invoice, -4) : 'WAIT',
                    'service' => $t->layanan->nama ?? 'Service',
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
