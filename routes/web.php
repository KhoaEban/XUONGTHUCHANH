<?php

use Illuminate\Support\Facades\Route;
// Admin
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\CourseControllerAdmin;

// User
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CourseController;
use App\Http\Controllers\User\FaqController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\SimulationController;


Route::get('/', function () {
    return view('user.home');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [Dashboard::class, 'index'])->name('admin.dashboard');
    // Quản lý người dùng
    Route::get('/admin/user', [AuthController::class, 'index'])->name('admin.user.index');
    // Quản lý khóa học
    Route::get('/admin/course', [CourseControllerAdmin::class, 'index'])->name('admin.course.index');
    Route::get('/admin/course/create', [CourseControllerAdmin::class, 'create'])->name('admin.course.create');
    Route::post('/admin/course', [CourseControllerAdmin::class, 'store'])->name('admin.course.store');
    // Quản lý danh mục
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/home', [HomeController::class, 'index'])->name('user.home');
});

Route::get('/user/course', [CourseController::class, 'index'], function () {
    return view('course.index');
})->name('course');
Route::get('/user/support', [SupportController::class, 'index'])->name('user.support');
Route::post('/user/support/submit', [SupportController::class, 'submit'])->name('user.support.submit');

Route::get('/user/faq', [FaqController::class, 'index'])->name('user.faq');
Route::get('/user/simulation', [SimulationController::class, 'index'])->name('user.simulation');
