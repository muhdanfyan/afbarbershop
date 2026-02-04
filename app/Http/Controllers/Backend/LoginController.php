<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('backend.login');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
