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
}
