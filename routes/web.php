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
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\AdminCommentsController;
use App\Http\Controllers\Admin\AdminRevenueController;
use App\Http\Controllers\Admin\ReviewControllerAdmin;

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
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\CertificateController;

// Instructor
use App\Http\Controllers\Teacher\HomeControllerInstructor;
use App\Http\Controllers\Teacher\CourseControllerTeacher;
use App\Http\Controllers\Teacher\LessonController;
use App\Http\Controllers\Teacher\QuizControllerInstructor;
use App\Http\Controllers\Teacher\ProgressController;

// Gemini Chat
use App\Http\Controllers\GeminiChatController;

// Gemini Chat
Route::get('/chat', [GeminiChatController::class, 'index'])->name('chat.index');
Route::post('/chat/send', [GeminiChatController::class, 'send'])->name('chat.send');
Route::get('/chat/history', [GeminiChatController::class, 'history'])->name('chat.history'); // Route để lấy lịch sử chat

// Trang chủ
Route::get('/', [HomeController::class, 'index']);

// Đăng nhập, đăng ký
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::middleware(['check.role:admin'])->group(function () {
    // Trang chủ Admin
    Route::get('/admin/dashboard', [Dashboard::class, 'index'])->name('admin.dashboard');


    // Quản lý người dùng
    Route::prefix('admin/user')->prefix('admin')->group(function () {
        Route::get('/', [AuthController::class, 'index'])->name('admin.user.index');
        Route::get('/{id}/edit', [AuthController::class, 'edit'])->name('admin.user.edit');
        Route::put('/{id}', [AuthController::class, 'update'])->name('admin.user.update');
        Route::delete('/delete/{id}', [AuthController::class, 'deleteUser'])->name('admin.user.delete'); // Sửa 'update' thành 'deleteUser'
    });

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
    Route::prefix('admin/comments')->group(function () {
        Route::get('/', [AdminCommentsController::class, 'index'])->name('admin.comments.index');
        Route::put('/{id}/status', [AdminCommentsController::class, 'updateStatus'])->name('admin.comments.updateStatus');
        Route::delete('/{id}', [AdminCommentsController::class, 'destroy'])->name('admin.comments.destroy');
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

    // Quản lý quizz
    Route::prefix('admin/quizzes')->group(function () {
        Route::get('/', [QuizControllerAdmin::class, 'index'])->name('admin.quizzes.index');
        Route::get('/create', [QuizControllerAdmin::class, 'create'])->name('admin.quizzes.create');
        Route::post('/store', [QuizControllerAdmin::class, 'store'])->name('admin.quizzes.store');
        Route::get('/edit/{quiz}', [QuizControllerAdmin::class, 'edit'])->name('admin.quizzes.edit');
        Route::put('/update/{quiz}', [QuizControllerAdmin::class, 'update'])->name('admin.quizzes.update');
        Route::delete('/delete/{quiz}', [QuizControllerAdmin::class, 'destroy'])->name('admin.quizzes.destroy');
        Route::get('/get-lessons/{courseId}', [QuizControllerAdmin::class, 'getLessons']);
        Route::get('/{quiz_id}/questions/create', [QuestionControllerAdmin::class, 'create'])->name('admin.questions.create');
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

    // Quản lý thanh toán
    Route::prefix('admin/orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::put('/{payment}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    });

    // thống kê doanh thu
    Route::prefix('admin/revenue')->group(function () {
        Route::get('/', [AdminRevenueController::class, 'index'])->name('revenue.index'); // Trang tổng quan doanh thu
        Route::get('/report', [AdminRevenueController::class, 'report'])->name('revenue.report'); // Báo cáo doanh thu
        Route::get('/user/{userId}', [AdminRevenueController::class, 'userRevenue'])->name('revenue.user'); // Doanh thu theo người dùng
        Route::get('/course/{courseId}', [AdminRevenueController::class, 'courseRevenue'])->name('revenue.course'); // Doanh thu theo khóa học
    });

    // Quản lý kết quả bài tập
    Route::prefix('admin/quiz-results')->group(function () {
        Route::get('/quiz_results', [QuizResultControllerAdmin::class, 'index'])->name('quiz_results.index');
        Route::get('/quiz_results/completed', [QuizResultControllerAdmin::class, 'completed'])->name('quiz_results.completed');
        Route::get('/create', [QuizResultControllerAdmin::class, 'create'])->name('admin.quiz_results.create');
        Route::post('/store', [QuizResultControllerAdmin::class, 'store'])->name('admin.quiz_results.store');
        Route::get('/edit/{quizResult}', [QuizResultControllerAdmin::class, 'edit'])->name('admin.quiz_results.edit');
        Route::put('/update/{quizResult}', [QuizResultControllerAdmin::class, 'update'])->name('admin.quiz_results.update');
        Route::delete('/delete/{quizResult}', [QuizResultControllerAdmin::class, 'destroy'])->name('admin.quiz_results.destroy');
    });

    // Quản lý bình luận
    Route::prefix('admin/comments')->group(function () {
        Route::get('/', [AdminCommentsController::class, 'index'])->name('admin.comments.index');
        Route::put('/{id}/status', [AdminCommentsController::class, 'updateStatus'])->name('admin.comments.updateStatus');
        Route::delete('/{id}', [AdminCommentsController::class, 'destroy'])->name('admin.comments.destroy');
    });

    // Quản lí đánh giá
    Route::prefix('admin/reviews')->group(function () {
        Route::get('/', [ReviewControllerAdmin::class, 'index'])->name('admin.reviews.index');
        Route::patch('/{review}/toggle-visibility', [ReviewControllerAdmin::class, 'toggleVisibility'])->name('reviews.toggle_visibility');
        Route::delete('/{review}', [ReviewControllerAdmin::class, 'destroy'])->name('reviews.destroy');
    });

    Route::post('/admin/enrollments/store', [EnrollmentController::class, 'store'])->name('admin.enrollments.store');
    Route::put('/admin/enrollments/{payment}/updateStatus', [EnrollmentController::class, 'updateStatus'])->name('admin.enrollments.updateStatus');

    Route::get('/payments', [PaymentController::class, 'adminPaymentHistory'])->name('admin.payment.history');
    Route::post('/enrollments/{enrollment}/update-status', [PaymentController::class, 'updateEnrollmentStatus'])->name('admin.enrollment.update_status');
});

// Instructor
Route::middleware(['check.role:instructor'])->group(function () {
    Route::prefix('instructor')->group(function () {
        // Trang chủ giảng viên
        Route::get('/home', [HomeControllerInstructor::class, 'index'])->name('instructor.dashboard');

        // Quản lý khóa học
        Route::get('/courses', [CourseControllerTeacher::class, 'index'])->name('instructor.courses.index');
        Route::get('/courses/create', [CourseControllerTeacher::class, 'create'])->name('instructor.courses.create');
        Route::post('/courses', [CourseControllerTeacher::class, 'store'])->name('instructor.courses.store');
        Route::get('/courses/edit/{course}', [CourseControllerTeacher::class, 'edit'])->name('instructor.courses.edit');
        Route::get('/courses/{slug}', [CourseControllerTeacher::class, 'show'])->name('instructor.courses.show'); // Đổi tên route để tránh xung đột
        Route::put('/courses/{course}', [CourseControllerTeacher::class, 'update'])->name('instructor.courses.update');
        Route::delete('/courses/{course}', [CourseControllerTeacher::class, 'destroy'])->name('instructor.courses.destroy');
        // Trong nhóm prefix('instructor')
        Route::get('/courses/{courseId}/lessons', [HomeControllerInstructor::class, 'manageLessons'])->name('instructor.courses.lessons');
        Route::post('/courses/{courseId}/lessons', [HomeControllerInstructor::class, 'storeLesson'])->name('instructor.courses.lessons.store');

        // Quản lý bài học
        Route::get('/lessons', [LessonController::class, 'index'])->name('instructor.lesson.index');
        Route::get('/lessons/create', [LessonController::class, 'create'])->name('instructor.lesson.create');
        Route::post('/lessons', [LessonController::class, 'store'])->name('instructor.lesson.store');
        Route::get('/lessons/edit/{lesson}', [LessonController::class, 'edit'])->name('instructor.lesson.edit');
        Route::put('/lessons/{lesson}', [LessonController::class, 'update'])->name('instructor.lesson.update');
        Route::delete('/lessons/{lesson}', [LessonController::class, 'destroy'])->name('instructor.lesson.destroy');

        // Quản lý bài tập
        Route::get('/quizzes', [QuizControllerInstructor::class, 'index'])->name('instructor.quizzes.index');
        Route::get('/quizzes/create', [QuizControllerInstructor::class, 'create'])->name('instructor.quizzes.create');
        Route::post('/quizzes', [QuizControllerInstructor::class, 'store'])->name('instructor.quizzes.store');
        Route::get('/quizzes/{id}/edit', [QuizControllerInstructor::class, 'edit'])->name('instructor.quizzes.edit');
        Route::put('/quizzes/{id}', [QuizControllerInstructor::class, 'update'])->name('instructor.quizzes.update');
        Route::delete('/quizzes/{id}', [QuizControllerInstructor::class, 'destroy'])->name('instructor.quizzes.destroy');
        Route::get('/quizzes/get-lessons/{courseId}', [QuizControllerInstructor::class, 'getLessons'])->name('instructor.quizzes.getLessons');

        // Quản lý tiến độ của học viên
        Route::get('/progress', [ProgressController::class, 'index'])->name('instructor.progress.index');
        Route::get('/progress/{userId}/{quizId}', [ProgressController::class, 'detail'])->name('instructor.progress.detail');
        Route::get('/student/quiz/{id}', [ProgressController::class, 'show'])->name('student.quiz.show');
        Route::post('/student/quiz/{id}/submit', [ProgressController::class, 'submit'])->name('student.quiz.submit');
        Route::get('/student/quiz/{id}/result', [ProgressController::class, 'result'])->name('student.quiz.result');
        Route::post('/progress/{userId}/{quizId}/notify', [ProgressController::class, 'notify'])->name('instructor.progress.notify');
    });
    Route::get('/instructor/courses/{courseId}/progress', [LessonController::class, 'trackProgress'])->name('instructor.courses.progress');
    Route::get('/instructor/courses/{courseId}/lessons/{lessonId}/comments', [LessonController::class, 'manageComments'])->name('instructor.courses.comments');
    Route::post('/instructor/courses/{courseId}/lessons/{lessonId}/comments/reply', [LessonController::class, 'replyComment'])->name('instructor.courses.comments.reply');
    Route::patch('/instructor/courses/{courseId}/lessons/{lessonId}/comments/{commentId}', [LessonController::class, 'updateComment'])->name('instructor.courses.comments.update');
    Route::delete('/instructor/courses/{courseId}/lessons/{lessonId}/comments/{commentId}', [LessonController::class, 'deleteComment'])->name('instructor.courses.comments.delete');
});

// User
Route::prefix('user')->group(function () {
    // Hồ sơ
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::get('/profile/course/show', [ProfileController::class, 'showProfile'])->name('user.profile.course.show');
    Route::get('/profile/course/{id}', [CourseController::class, 'showCourseProfile'])->name('profile.course.detail');
    Route::get('/profile/course/{id}', [ProfileController::class, 'showCourseProgress'])->name('profile.progress.detail');

    // Thay đổi mật khẩu
    Route::get('/change-password', [ProfileController::class, 'editPassword'])->name('user.change.password');
    Route::post('/change-password', [ProfileController::class, 'updatePassword'])->name('user.change.password.update');

    Route::get('/payment-history', [PaymentController::class, 'userPaymentHistory'])->name('user.payment.history');

    // Danh mục
    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

    // Khóa học
    Route::get('/course', [CourseController::class, 'index'])->name('course');
    Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course.show');
    Route::get('/courses/search', [CourseController::class, 'search'])->name('courses.search');
    
    // Bài học
    Route::get('/lesson', [LessonController::class, 'index'])->name('lessons');
    Route::get('/course/lesson/{slug}', [LessonController::class, 'show'])->name('course.lessons.show');

    // Quizzes
    Route::get('/lessons/{lessonId}/quizzes', [CourseController::class, 'getQuizzesByLesson']);
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('quiz/{id}/submit', [QuizController::class, 'submit'])->name('user.quizzes.submit');

    // Thanh toán
    Route::get('/courses/{slug}/lessons', [LessonController::class, 'getLessons'])->name('courses.lessons');
    Route::get('/lesson', [LessonController::class, 'index'])->name('lessons');
    Route::get('/lesson/{id}', [LessonController::class, 'getLesson'])->name('lessons.show');

    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::post('/support', [SupportController::class, 'submit'])->name('support');

    Route::get('/lessons/{lessonId}/quizzes', [CourseController::class, 'getQuizzesByLesson']);
    Route::get('/lessons/{lesson_id}', [CourseController::class, 'getLesson'])
        ->name('lesson.get');

    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quiz/{quizId}/do', [QuizController::class, 'doQuiz'])->name('user.quiz.do');
    Route::post('/quiz/{quizId}/submit', [QuizController::class, 'submitQuiz'])->name('user.quiz.submit');

    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::get('/simulation', [SimulationController::class, 'index'])->name('simulation');

    Route::get('/course/{slug}/payment', [PaymentController::class, 'showPaymentForm'])->name('course.payment');
    Route::post('/course/{slug}/payment', [PaymentController::class, 'processPayment'])->name('course.payment.process');
    // Thanh tiến độ bài học
    Route::get('/courses/{course}/progress', [CourseController::class, 'getCourseProgress'])->name('user.courses.progress');
    Route::post('/courses/{course}/lessons/{lesson}/complete', [CourseController::class, 'markLessonAsComplete'])->name('user.courses.lessons.complete');

    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/failure', [PaymentController::class, 'paymentFailure'])->name('payment.failure');
    Route::get('/payment-history', [PaymentController::class, 'userPaymentHistory'])->name('user.payment.history');
    Route::post('/payment-history/{payment}/cancel', [PaymentController::class, 'cancelPayment'])->name('user.payment.cancel');
    Route::post('/payment-history/{course}/buy-again', [PaymentController::class, 'buyAgain'])->name('user.payment.buy_again');
    Route::get('/payment/{slug}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment/{slug}/enroll-free', [PaymentController::class, 'enrollFreeCourse'])->name('course.enroll.free');
    Route::post('/user/payment/{slug}', [PaymentController::class, 'processPayment'])->name('course.payment.process');

    // các route khác
    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::get('/simulation', [SimulationController::class, 'index'])->name('simulation');
    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::post('/support', [SupportController::class, 'submit'])->name('support');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    //like
    Route::post('/comments/{id}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::post('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::patch('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/comments/{lesson_id}', [CommentController::class, 'getComments'])->name('comments.get');
    Route::post('/ratings', [ReviewController::class, 'store'])->name('ratings.store');

    //Download chứng chỉ
    Route::get('/certificate/{course_id}', [CertificateController::class, 'show'])->name('certificate.show');
    Route::get('/certificate/{course_id}/download', [CertificateController::class, 'download'])->name('certificate.download');
});

// VNPay callback
Route::get('/vnpay/callback', [PaymentController::class, 'vnpayCallback'])->name('vnpay.callback');

// Thống báo
Route::get('/notifications', [HomeController::class, 'notifications'])->name('user.notifications');
Route::post('/notifications/{notificationId}/mark-as-read', [HomeController::class, 'markAsRead'])->name('user.notifications.mark-as-read');
Route::post('/notifications/mark-all-as-read', [HomeController::class, 'markAllAsRead'])->name('user.notifications.mark-all-as-read');

// 404
Route::fallback(function () {
    return view('errors.404');
});
