<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Jasa;
use App\Models\Kapster;
use App\Models\Setting;

class FrontController extends Controller
{
    public function index()
    {
        $jasa = Jasa::all();
        $kapster = Kapster::all();
        $kapsterStats = $kapster->map(function ($k) {
            return [
                'id' => $k->id,
                'nama' => $k->nama,
                'foto' => $k->foto,
                'menunggu' => $k->transaksis()->where('status', 'menunggu')->count(),
                'proses' => $k->transaksis()->where('status', 'proses')->count(),
                'selesai' => $k->transaksis()->where('status', 'selesai')->count(),
            ];
        });
        $settings = Setting::pluck('value', 'key');
        return view('front.index', compact('jasa', 'kapster', 'kapsterStats', 'settings'));
    }
}
