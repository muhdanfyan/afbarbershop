<?php

use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/login', [LoginController::class, 'index'])->name('login');