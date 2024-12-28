<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('test', [TestController::class,'index']);

require __DIR__.'/auth.php';
