<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::view('login', 'auth.login')->name('auth.login');
Route::post('login', [AuthController::class, 'authenticate'])->middleware('throttle:login')->name('auth.authenticate');
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('auth.logout');
