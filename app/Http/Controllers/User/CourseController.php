<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
<<<<<<< Updated upstream


class CourseController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function index()
    {
        
        return view('user.course.index');
    }

=======
use App\Models\Category;
use App\Models\Lesson;
use App\Models\CourseProgress; // Import the CourseProgress model

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('user.course.index', compact('courses'));
    }

    public function show($slug)
    {
        $course = Course::with('lessons', 'instructor')->where('slug', $slug)->firstOrFail();

        if (!$course->isPaidByUser(Auth::id())) {
            return redirect()->route('course.payment', ['slug' => $slug]);
        }

        // Lấy danh sách các bài học đã hoàn thành của người dùng trong khóa học này
        $completedLessons = [];
        $progress = CourseProgress::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();

        if ($progress) {
            $completedLessons = $progress->completed_lessons ?? [];
        }

        // Tính toán phần trăm tiến độ
        $totalLessonsCount = $course->lessons()->count();
        $completedLessonsCount = count($completedLessons);
        $progressPercentage = $totalLessonsCount > 0 ? ($completedLessonsCount / $totalLessonsCount) * 100 : 0;

        return view('user.course.show', compact('course', 'completedLessons', 'progressPercentage', 'totalLessonsCount', 'completedLessonsCount'));
    }

    // API endpoint để đánh dấu bài học là hoàn thành (cho người dùng)
    public function markLessonAsComplete(Request $request, $courseId, $lessonId)
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['message' => 'Bạn cần đăng nhập để thực hiện hành động này.'], 401);
        }
    
        try {
            $course = Course::findOrFail($courseId);
            $lesson = Lesson::where('id', $lessonId)->where('course_id', $courseId)->firstOrFail();
    
            $progress = CourseProgress::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->first();
    
            if (!$progress) {
                $progress = CourseProgress::create([
                    'user_id' => $user->id,
                    'course_id' => $courseId,
                    'completed_lessons' => [$lessonId],
                ]);
            } else {
                if (!in_array($lessonId, $progress->completed_lessons)) {
                    $progress->completed_lessons = array_merge($progress->completed_lessons, [$lessonId]);
                    $progress->save();
                }
            }
    
            return response()->json(['message' => 'Bài học đã được đánh dấu là hoàn thành.']);
    
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error marking lesson as complete: ' . $e->getMessage());
            return response()->json(['message' => 'Đã có lỗi xảy ra khi đánh dấu bài học là hoàn thành.'], 500);
        }
    }
    // API endpoint để lấy tiến độ khóa học (cho người dùng)
    public function getCourseProgress(Request $request, $courseId)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Bạn cần đăng nhập.'], 401);
        }

        $course = Course::findOrFail($courseId);

        $progress = CourseProgress::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();

        $completedLessons = $progress ? count($progress->completed_lessons) : 0;
        $totalLessons = $course->lessons()->count();
        $progressPercentage = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

        return response()->json([
            'progressPercentage' => round($progressPercentage, 2),
            'completedLessonsCount' => $completedLessons,
            'totalLessonsCount' => $totalLessons,
        ]);
    }
>>>>>>> Stashed changes
}