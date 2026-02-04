<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Jasa;
use App\Models\Kapster;
use App\Models\Setting;
use App\Models\Gallery;

class FrontController extends Controller
{
    public function index()
    {
        $jasa = Jasa::all();
        $settings = Setting::pluck('value', 'key');
        $galleries = Gallery::latest()->get();
        $kapsters = Kapster::where('status', 'bekerja')->get();
        return view('front.index', compact('jasa', 'settings', 'galleries', 'kapsters'));
    }
}
