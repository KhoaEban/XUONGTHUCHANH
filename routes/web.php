<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('user.home');
})->name('home');

Route::middleware(['role:user'])->group(function () {
    Route::get('/home', [App\Http\Controllers\User\HomeController::class, 'index']);
});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\Dashboard::class, 'index']);
});

