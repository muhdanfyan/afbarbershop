<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminBarbermanController extends Controller
{
    public function index()
    {
        return view('backend.admin.barberman');
    }

}
