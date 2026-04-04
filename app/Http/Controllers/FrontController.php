<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Jasa;
use App\Models\Kapster;
use App\Models\Setting;
use App\Models\Gallery;
use App\Models\Barang;

use Illuminate\Support\Facades\Cache;

class FrontController extends Controller
{
    public function index()
    {
        /** @var array $settings */
        $settings = Cache::remember('site_settings', 3600, function () {
            return Setting::pluck('value', 'key')->toArray();
        });

        /** @var \Illuminate\Database\Eloquent\Collection $jasa */
        $jasa = Cache::remember('site_services', 3600, function () {
            return Jasa::all();
        });

        /** @var \Illuminate\Database\Eloquent\Collection $galleries */
        $galleries = Cache::remember('site_galleries', 3600, function () {
            return Gallery::latest()->get();
        });

        /** @var \Illuminate\Database\Eloquent\Collection $kapsters */
        $kapsters = Cache::remember('site_kapsters', 3600, function () {
            return Kapster::where('status', 'bekerja')->get();
        });

        /** @var \Illuminate\Database\Eloquent\Collection $barangs */
        $barangs = Cache::remember('site_products', 3600, function () {
            return Barang::where('stok', '>', 0)->get();
        });

        return view('front.index', compact('jasa', 'settings', 'galleries', 'kapsters', 'barangs'));
    }
}
