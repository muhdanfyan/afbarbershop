<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FrontLoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('member.login');
    }
}
