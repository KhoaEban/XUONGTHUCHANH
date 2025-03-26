<?php

use Illuminate\Support\Facades\Route;
// Admin
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\CourseControllerAdmin;
use App\Http\Controllers\Admin\CategoryControllerAdmin;

// User
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\CourseController;
use App\Http\Controllers\User\FaqController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\SimulationController;

// Instructor
use App\Http\Controllers\Teacher\HomeControllerInstructor;

// Trang chủ
Route::get('/', [HomeController::class, 'index']);


// Đăng nhập, đăng ký
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::middleware(['check.role:student'])->group(function () {
//     Route::get('/user/home', [HomeController::class, 'index'])->name('home');
// });


// Admin
Route::middleware(['check.role:admin'])->group(function () {
    // Trang chủ Admin
    Route::get('/admin/dashboard', [Dashboard::class, 'index'])->name('admin.dashboard');
    // Quản lý người dùng
    Route::get('/admin/user', [AuthController::class, 'index'])->name('admin.user.index');
    
    // Quản lý khóa học
    Route::prefix('admin/course')->group(function () {
        Route::get('/', [CourseControllerAdmin::class, 'index'])->name('admin.course.index');
        Route::get('/create', [CourseControllerAdmin::class, 'create'])->name('admin.course.create');
        Route::post('/store', [CourseControllerAdmin::class, 'store'])->name('admin.course.store');
        Route::get('/edit/{course}', [CourseControllerAdmin::class, 'edit'])->name('admin.course.edit');
        Route::put('/update/{course}', [CourseControllerAdmin::class, 'update'])->name('admin.course.update');
        Route::delete('/delete/{course}', [CourseControllerAdmin::class, 'destroy'])->name('admin.course.destroy');
    });

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

});


// Instructor
Route::middleware(['check.role:admin,instructor'])->group(function () {
    Route::get('/instructor/home', [HomeControllerInstructor::class, 'index'])->name('instructor.dashboard');

});


// User
Route::prefix('user')->group(function () {
    // Danh mục
    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

    Route::get('/course', [CourseController::class, 'index'])->name('course');
    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::post('/support', [SupportController::class, 'submit'])->name('support');

    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::get('/simulation', [SimulationController::class, 'index'])->name('simulation');
});

// 404
Route::fallback(function () {
    return view('errors.404');
});
