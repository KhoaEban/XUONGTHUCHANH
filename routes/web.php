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
use App\Http\Controllers\Teacher\CourseControllerTeacher;
use App\Http\Controllers\Teacher\LessonController;
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
Route::middleware(['check.role:instructor'])->group(function () {
    Route::get('/instructor/home', [HomeControllerInstructor::class, 'index'])->name('instructor.dashboard');


    // Quản lý khóa học
    Route::prefix('instructor')->group(function () {
        Route::get('/courses', [CourseControllerTeacher::class, 'index'])->name('instructor.courses.index');
        Route::get('/courses/create', [CourseControllerTeacher::class, 'create'])->name('instructor.courses.create');
        Route::post('/courses', [CourseControllerTeacher::class, 'store'])->name('instructor.courses.store');
        Route::get('/courses/edit/{course}', [CourseControllerTeacher::class, 'edit'])->name('instructor.courses.edit');
        Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
        Route::put('/courses/{course}', [CourseControllerTeacher::class, 'update'])->name('instructor.courses.update');
        Route::delete('/courses/{course}', [CourseControllerTeacher::class, 'destroy'])->name('instructor.courses.destroy');
    });
    // Quản lý bài học
    Route::prefix('instructor')->group(function () {
        Route::get('/lesson', [LessonController::class, 'index'])->name('instructor.lesson.index');
        Route::get('/create', [LessonController::class, 'create'])->name('instructor.lesson.create');
        Route::post('/store', [LessonController::class, 'store'])->name('instructor.lesson.store');
        Route::get('/edit/{lesson}', [LessonController::class, 'edit'])->name('instructor.lesson.edit');
        Route::put('/update/{lesson}', [LessonController::class, 'update'])->name('instructor.lesson.update');
        Route::delete('/delete/{lesson}', [LessonController::class, 'destroy'])->name('instructor.lesson.destroy');
    });
});



// User
Route::prefix('user')->group(function () {
    // Danh mục
    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

    Route::get('/course', [CourseController::class, 'index'])->name('course');
    Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course.show');
    Route::get('/lesson', [LessonController::class, 'index'])->name('lessons');
    Route::get('/lesson/{id}', [LessonController::class, 'show'])->name('lessons.show');
    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::post('/support', [SupportController::class, 'submit'])->name('support');

    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::get('/simulation', [SimulationController::class, 'index'])->name('simulation');
});

// 404
Route::fallback(function () {
    return view('errors.404');
});
