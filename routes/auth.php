<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('register', 'pages.auth.register')
        ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('roles', 'pages.roles.index')->name('roles.index');
    Volt::route('roles/create', 'pages.roles.form')->name('roles.create');
    Volt::route('roles/{role}/edit', 'pages.roles.form')->name('roles.edit');

    Volt::route('users', 'pages.users.index')->name('users.index');
    Volt::route('users/create', 'pages.users.form')->name('users.create');
    Volt::route('users/{user}/edit', 'pages.users.form')->name('users.edit');
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});
