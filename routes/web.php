<?php

use Illuminate\Support\Facades\Route;
// Admin
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\CourseControllerAdmin;
use App\Http\Controllers\Admin\CategoryControllerAdmin;
use App\Http\Controllers\Admin\LessonControllerAdmin;
use App\Http\Controllers\Admin\QuizControllerAdmin;
use App\Http\Controllers\Admin\QuestionControllerAdmin;
use App\Http\Controllers\Admin\QuizResultControllerAdmin;
use App\Http\Controllers\Admin\AnswerControllerAdmin;
use App\Http\Controllers\Admin\AdminCommentsController;
// User
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\CourseController;
use App\Http\Controllers\User\FaqController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\SimulationController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\QuizController;
use App\Http\Controllers\User\ProfileController;

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
Route::get('/admin/instructors/{instructorId}/courses', [CourseController::class, 'coursesByInstructor'])
    ->name('admin.instructors.courses');


// Admin
Route::middleware(['check.role:admin'])->group(function () {
    // Trang chủ Admin
    Route::get('/admin/dashboard', [Dashboard::class, 'index'])->name('admin.dashboard');
    // Quản lý người dùng
    Route::get('/admin/user', [AuthController::class, 'index'])->name('admin.user.index');

    // Quản lý khóa học
    Route::prefix('admin/courses')->group(function () {
        Route::get('/', [CourseControllerAdmin::class, 'index'])->name('admin.courses.index');
        Route::get('/show/{create}', [CourseControllerAdmin::class, 'show'])->name('admin.courses.show');
        Route::get('/create', [CourseControllerAdmin::class, 'create'])->name('admin.courses.create');
        Route::post('/store', [CourseControllerAdmin::class, 'store'])->name('admin.courses.store');
        Route::get('/edit/{id}', [CourseControllerAdmin::class, 'edit'])->name('admin.courses.edit');
        Route::put('/update/{id}', [CourseControllerAdmin::class, 'update'])->name('admin.courses.update');
        Route::delete('/delete/{id}', [CourseControllerAdmin::class, 'destroy'])->name('admin.courses.destroy');
    });

    // Quản lý bài học
    Route::prefix('admin/lessons')->group(function () {
        Route::get('/', [LessonControllerAdmin::class, 'index'])->name('admin.lessons.index');
        Route::get('/show/{lesson}', [LessonControllerAdmin::class, 'show'])->name('admin.lessons.show');
        Route::get('/create', [LessonControllerAdmin::class, 'create'])->name('admin.lessons.create');
        Route::post('/store', [LessonControllerAdmin::class, 'store'])->name('admin.lessons.store');
        Route::get('/edit/{lesson}', [LessonControllerAdmin::class, 'edit'])->name('admin.lessons.edit');
        Route::put('/update/{lesson}', [LessonControllerAdmin::class, 'update'])->name('admin.lessons.update');
        Route::delete('/delete/{lesson}', [LessonControllerAdmin::class, 'destroy'])->name('admin.lessons.destroy');
    });
    // Quản lý bình luận
    Route::prefix('admin/comments')->group(function ()  {
        Route::get('/', [AdminCommentsController::class, 'index'])->name('admin.comments.index');
        Route::post('/admin/comments/hide/{id}', [AdminCommentsController::class, 'hide'])->name('admin.comments.hide');
        Route::post('/admin/comments/show/{id}', [AdminCommentsController::class, 'show'])->name('admin.comments.show');
        Route::delete('/admin/comments/{id}', [AdminCommentsController::class, 'destroy'])->name('admin.comments.destroy');
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


    // Quản lý bài tập
    Route::prefix('admin/quizzes')->group(function () {
        Route::get('/', [QuizControllerAdmin::class, 'index'])->name('admin.quizzes.index');
        Route::get('/create', [QuizControllerAdmin::class, 'create'])->name('admin.quizzes.create');
        Route::post('/store', [QuizControllerAdmin::class, 'store'])->name('admin.quizzes.store');
        Route::get('/edit/{quiz}', [QuizControllerAdmin::class, 'edit'])->name('admin.quizzes.edit');
        Route::put('/update/{quiz}', [QuizControllerAdmin::class, 'update'])->name('admin.quizzes.update');
        Route::delete('/delete/{quiz}', [QuizControllerAdmin::class, 'destroy'])->name('admin.quizzes.destroy');
        Route::get('/get-lessons/{courseId}', [QuizControllerAdmin::class, 'getLessons']);
    });

    // Quản lý câu hỏi
    Route::prefix('admin/questions')->group(function () {
        Route::get('/', [QuestionControllerAdmin::class, 'index'])->name('admin.questions.index');
        Route::get('/create', [QuestionControllerAdmin::class, 'create'])->name('admin.questions.create');
        Route::post('/store', [QuestionControllerAdmin::class, 'store'])->name('admin.questions.store');
        Route::get('/edit/{question}', [QuestionControllerAdmin::class, 'edit'])->name('admin.questions.edit');
        Route::put('/update/{question}', [QuestionControllerAdmin::class, 'update'])->name('admin.questions.update');
        Route::delete('/delete/{question}', [QuestionControllerAdmin::class, 'destroy'])->name('admin.questions.destroy');
        Route::get('/get-quizzes/{lessonId}', [QuestionControllerAdmin::class, 'getQuizzesByLesson']);
    });

    // Quản lý kết quả bài tập
    Route::prefix('admin/quiz-results')->group(function () {
        Route::get('/', [QuizResultControllerAdmin::class, 'index'])->name('admin.quiz_results.index');
        Route::get('/create', [QuizResultControllerAdmin::class, 'create'])->name('admin.quiz_results.create');
        Route::post('/store', [QuizResultControllerAdmin::class, 'store'])->name('admin.quiz_results.store');
        Route::get('/edit/{quizResult}', [QuizResultControllerAdmin::class, 'edit'])->name('admin.quiz_results.edit');
        Route::put('/update/{quizResult}', [QuizResultControllerAdmin::class, 'update'])->name('admin.quiz_results.update');
        Route::delete('/delete/{quizResult}', [QuizResultControllerAdmin::class, 'destroy'])->name('admin.quiz_results.destroy');
    });

    // Quản lý câu trả lời
    Route::prefix('admin/answers')->group(function () {
        Route::get('/', [AnswerControllerAdmin::class, 'index'])->name('admin.answers.index');
        Route::get('/create', [AnswerControllerAdmin::class, 'create'])->name('admin.answers.create');
        Route::post('/store', [AnswerControllerAdmin::class, 'store'])->name('admin.answers.store');
        Route::get('/edit/{answer}', [AnswerControllerAdmin::class, 'edit'])->name('admin.answers.edit');
        Route::put('/update/{answer}', [AnswerControllerAdmin::class, 'update'])->name('admin.answers.update');
        Route::delete('/delete/{answer}', [AnswerControllerAdmin::class, 'destroy'])->name('admin.answers.destroy');
        Route::get('/get-questions/{quizId}', [AnswerControllerAdmin::class, 'getQuestionsByQuiz']);
    });
    Route::get('/payments', [PaymentController::class, 'adminPaymentHistory'])->name('admin.payment.history');
    Route::post('/enrollments/{enrollment}/update-status', [PaymentController::class, 'updateEnrollmentStatus'])->name('admin.enrollment.update_status');
});


// Instructor
Route::middleware(['check.role:instructor'])->group(function () {
    Route::get('/instructor/home', [HomeControllerInstructor::class, 'index'])->name('instructor.dashboard');

    // Quản lý khóa học
    Route::prefix('instructor')->group(function () {
        Route::get('/home', [HomeControllerInstructor::class, 'index'])->name('instructor.dashboard');
        Route::get('/courses', [CourseControllerTeacher::class, 'index'])->name('instructor.courses.index');
        Route::get('/courses/create', [CourseControllerTeacher::class, 'create'])->name('instructor.courses.create');
        Route::post('/courses', [CourseControllerTeacher::class, 'store'])->name('instructor.courses.store');
        Route::get('/courses/edit/{course}', [CourseControllerTeacher::class, 'edit'])->name('instructor.courses.edit');
        Route::get('/courses/{slug}', [CourseControllerTeacher::class, 'show'])->name('courses.show');
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
    // Hồ sơ
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::get('/payment-history', [PaymentController::class, 'userPaymentHistory'])->name('user.payment.history');
    // Danh mục
    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

    // Khóa học
    Route::get('/course', [CourseController::class, 'index'])->name('course');
    Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course.show');
    Route::get('/lesson', [LessonController::class, 'index'])->name('lessons');
    Route::get('/lesson/{id}', [LessonController::class, 'show'])->name('lessons.show');
    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::post('/support', [SupportController::class, 'submit'])->name('support');

    Route::get('/lessons/{lessonId}/quizzes', [CourseController::class, 'getQuizzesByLesson']);
    
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    
    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::get('/simulation', [SimulationController::class, 'index'])->name('simulation');
    
});



Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/course/{slug}/payment', [PaymentController::class, 'showPaymentForm'])->name('course.payment');
    Route::post('/course/{slug}/payment', [PaymentController::class, 'processPayment'])->name('course.payment.process');
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/failure', [PaymentController::class, 'paymentFailure'])->name('payment.failure');
    Route::get('/payment-history', [PaymentController::class, 'userPaymentHistory'])->name('user.payment.history');
    Route::post('/payment-history/{payment}/cancel', [PaymentController::class, 'cancelPayment'])->name('user.payment.cancel');
    Route::post('/payment-history/{course}/buy-again', [PaymentController::class, 'buyAgain'])->name('user.payment.buy_again');
    Route::get('/payment/{slug}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/user/payment/{slug}', [PaymentController::class, 'processPayment'])->name('course.payment.process');
});

// VNPay callback
Route::get('/vnpay/callback', [PaymentController::class, 'vnpayCallback'])->name('vnpay.callback');

// 404
Route::fallback(function () {
    return view('errors.404');
});

