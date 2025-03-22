<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Middleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\CourseController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\User\ProfileController;

Route::get('/', function () {
    return view('user.home');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth.admin'])->group(function () {
    Route::get('/admin/dashboard', [Dashboard::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth.user'])->group(function () {
    Route::get('/user/home', [HomeController::class, 'index'])->name('user.home');
});

Route::get('/user/course', [CourseController::class, 'index'], function () {
    return view('course.index');
})->name('course');
