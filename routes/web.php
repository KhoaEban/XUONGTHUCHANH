<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('user.home');
})->name('home');

Route::middleware(['role:user'])->group(function () {
    Route::get('/home', [App\Http\Controllers\User\HomeController::class, 'index']);
});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\Dashboard::class, 'index']);
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
