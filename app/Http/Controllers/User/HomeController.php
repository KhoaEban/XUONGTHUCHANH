<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
<<<<<<< Updated upstream
use App\Models\Category;

=======
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Course;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\CourseProgress; // Correct use statement
use App\Models\Review;
>>>>>>> Stashed changes
class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Lấy tất cả danh mục

        return view('user.home', compact('categories'));
    }
    public function getIncompleteCourses()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem các khóa học chưa hoàn thành.');
        }

        $user = Auth::user();
        $incompleteCourses = $user->enrollments()
            ->with('course') // Eager load relationship
            ->get()
            ->filter(function ($enrollment) use ($user) {
                $course = $enrollment->course;
                $progress = CourseProgress::where('user_id', $user->id)
                    ->where('course_id', $course->id)
                    ->first();
                // Khóa học chưa hoàn thành nếu chưa có progress hoặc số bài hoàn thành ít hơn tổng số bài
                return !$progress || count($progress->completed_lessons) < $course->lessons()->count();
            });

        return view('user.course.incomplete', compact('incompleteCourses'));
    }
}
