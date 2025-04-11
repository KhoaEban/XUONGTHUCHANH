<?php

use Illuminate\Support\Facades\Route;
// Admin
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\CourseControllerAdmin;
use App\Http\Controllers\Admin\CategoryControllerAdmin;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\Admin\LessonControllerAdmin;
use App\Http\Controllers\Admin\QuizControllerAdmin;
use App\Http\Controllers\Admin\QuestionControllerAdmin;
use App\Http\Controllers\Admin\QuizResultControllerAdmin;
use App\Http\Controllers\Admin\AnswerControllerAdmin;
use App\Http\Controllers\Admin\AdminRevenueController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\EnrollmentController;
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes

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

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');


// Đăng nhập, đăng ký
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::middleware(['check.role:student'])->group(function () {
//     Route::get('/user/home', [HomeController::class, 'index'])->name('home');
// });





<<<<<<< Updated upstream
=======
// Gemini Chat
Route::get('/chat', [GeminiChatController::class, 'index'])->name('chat.index');
Route::post('/chat/send', [GeminiChatController::class, 'send'])->name('chat.send');
Route::get('/chat/history', [GeminiChatController::class, 'history'])->name('chat.history'); // Route để lấy lịch sử chat
>>>>>>> Stashed changes

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
<<<<<<< Updated upstream
=======


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

    // thống kê doanh thu
// Routes for Revenue management (Admin)
    Route::get('/admin/revenue', [RevenueController::class, 'index'])->name('admin.revenue.index');
    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::get('revenue', [AdminRevenueController::class, 'index'])->name('revenue.index'); // Trang tổng quan doanh thu
    Route::get('revenue/report', [AdminRevenueController::class, 'report'])->name('revenue.report'); // Báo cáo doanh thu
    Route::get('revenue/user/{userId}', [AdminRevenueController::class, 'userRevenue'])->name('revenue.user'); // Doanh thu theo người dùng
    Route::get('revenue/course/{courseId}', [AdminRevenueController::class, 'courseRevenue'])->name('revenue.course'); // Doanh thu theo khóa học
    
>>>>>>> Stashed changes
});
Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
Route::put('/admin/orders/{payment}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
Route::put('/admin/enrollments/{payment}/update-status', [EnrollmentController::class, 'updateStatus'])->name('admin.enrollments.updateStatus'); // Thêm route này
<<<<<<< Updated upstream


=======
>>>>>>> Stashed changes


// Instructor
Route::middleware(['check.role:instructor'])->group(function () {
    Route::get('/instructor/home', [HomeControllerInstructor::class, 'index'])->name('instructor.home');
    // Quản lý khóa học của giảng viên
    Route::prefix('instructor')->group(function () {
        Route::get('/courses', [CourseControllerTeacher::class, 'index'])->name('instructor.courses.index');
        Route::get('/courses/create', [CourseControllerTeacher::class, 'create'])->name('instructor.courses.create');
        Route::post('/courses', [CourseControllerTeacher::class, 'store'])->name('instructor.courses.store');
        Route::get('/courses/edit/{course}', [CourseControllerTeacher::class, 'edit'])->name('instructor.courses.edit');
        Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
        Route::put('/courses/{course}', [CourseControllerTeacher::class, 'update'])->name('instructor.courses.update');
        Route::delete('/courses/{course}', [CourseControllerTeacher::class, 'destroy'])->name('instructor.courses.destroy');
    });
});


// User
Route::prefix('user')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('user.home');


    // Danh mục
    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

    Route::get('/course', [CourseController::class, 'index'])->name('course');
<<<<<<< Updated upstream
=======
    Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course.show');
    Route::get('/courses/incomplete', [HomeController::class, 'getIncompleteCourses'])->name('courses.incomplete');
   

    // Bài học
    Route::get('/lesson', [LessonController::class, 'index'])->name('lessons');
    Route::get('/course/lesson/{slug}', [LessonController::class, 'show'])->name('course.lessons.show');

    // Quizzes
    Route::get('/lessons/{lessonId}/quizzes', [CourseController::class, 'getQuizzesByLesson']);
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');

    // Thanh toán
    Route::get('/courses/{slug}/lessons', [LessonController::class, 'getLessons'])->name('courses.lessons');
    Route::get('/lesson', [LessonController::class, 'index'])->name('lessons');
    Route::get('/lesson/{id}', [LessonController::class, 'getLesson'])->name('lessons.show');

>>>>>>> Stashed changes
    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::post('/support', [SupportController::class, 'submit'])->name('support');

    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::get('/simulation', [SimulationController::class, 'index'])->name('simulation');
<<<<<<< Updated upstream
=======

    
    
    Route::get('/courses/{course}/progress', [CourseController::class, 'getCourseProgress'])->name('user.courses.progress');
    Route::post('/courses/{course}/lessons/{lesson}/complete', [CourseController::class, 'markLessonAsComplete'])->name('user.courses.lessons.complete');
>>>>>>> Stashed changes
});

// 404
Route::fallback(function () {
    return view('errors.404');
});
