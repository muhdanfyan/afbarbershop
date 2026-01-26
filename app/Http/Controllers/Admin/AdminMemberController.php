<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminMemberController extends Controller
{
    public function index()
    {
        return view('backend.admin.member');
    }
}
