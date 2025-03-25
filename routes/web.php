<?php

use Illuminate\Support\Facades\Route;
// Admin
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\CourseControllerAdmin;
use App\Http\Controllers\Admin\CategoryControllerAdmin;
use App\Http\Controllers\Admin\KhoaController;
use App\Http\Controllers\Admin\CongngheControllerAdmin;

// User
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\CourseController;
use App\Http\Controllers\User\FaqController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\SimulationController;

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');


// Đăng nhập, đăng ký
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
    Route::prefix('admin/category')->group(function () {
        Route::get('/', [CategoryControllerAdmin::class, 'index'])->name('admin.category.index');
        Route::get('/create', [CategoryControllerAdmin::class, 'create'])->name('admin.category.create');
        Route::post('/store', [CategoryControllerAdmin::class, 'store'])->name('admin.category.store');
        Route::get('/edit/{category}', [CategoryControllerAdmin::class, 'edit'])->name('admin.category.edit');
        Route::put('/update/{category}', [CategoryControllerAdmin::class, 'update'])->name('admin.category.update');
        Route::delete('/delete/{category}', [CategoryControllerAdmin::class, 'destroy'])->name('admin.category.destroy');
        // Route danh mục con
        Route::get('/children/{id}', [CategoryControllerAdmin::class, 'getChildren']);
        Route::get('/create/{parent_id}', [CategoryControllerAdmin::class, 'createChild'])->name('admin.category.create.child');
        Route::post('/assignChild', [CategoryControllerAdmin::class, 'assignChild'])->name('admin.category.assignChild');
        Route::delete('/unlink/{id}', [CategoryControllerAdmin::class, 'unlinkCategory'])->name('admin.category.unlink');
    });

    // Khóa
    Route::prefix('admin/khoa')->group(function () {
        Route::get('/', [KhoaController::class, 'index'])->name('admin.khoa.index');
        Route::get('/create', [KhoaController::class, 'create'])->name('admin.khoa.create');
        Route::post('/store', [KhoaController::class, 'store'])->name('admin.khoa.store');
        Route::get('/edit/{khoa}', [KhoaController::class, 'edit'])->name('admin.khoa.edit');
        Route::put('/update/{khoa}', [KhoaController::class, 'update'])->name('admin.khoa.update');
        Route::delete('/delete/{khoa}', [KhoaController::class, 'destroy'])->name('admin.khoa.destroy');

    });

    // Công Nghê
    Route::prefix('admin/congnghe')->group(function () {
        Route::get('/', [CongngheControllerAdmin::class, 'index'])->name('admin.congnghe.index');
        Route::get('/create', [CongngheControllerAdmin::class, 'create'])->name('admin.congnghe.create');
        Route::post('/store', [CongngheControllerAdmin::class, 'store'])->name('admin.congnghe.store');
        Route::get('/edit/{congnghe}', [CongngheControllerAdmin::class, 'edit'])->name('admin.congnghe.edit');
        Route::put('/update/{congnghe}', [CongngheControllerAdmin::class, 'update'])->name('admin.congnghe.update');
        Route::delete('/delete/{congnghe}', [CongngheControllerAdmin::class, 'destroy'])->name('admin.congnghe.destroy');

    });
});


// User
Route::middleware(['auth'])->group(function () {
    Route::get('/user/home', [HomeController::class, 'index'])->name('user.home');
});

// Danh mục
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');


Route::get('/user/course', [CourseController::class, 'index'], function () {
    return view('course.index');
})->name('course');
Route::get('/user/support', [SupportController::class, 'index'])->name('user.support');
Route::post('/user/support/submit', [SupportController::class, 'submit'])->name('user.support.submit');

Route::get('/user/faq', [FaqController::class, 'index'])->name('user.faq');
Route::get('/user/simulation', [SimulationController::class, 'index'])->name('user.simulation');
