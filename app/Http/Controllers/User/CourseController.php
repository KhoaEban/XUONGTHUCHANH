<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\CourseProgress;
use App\Models\Review;
use App\Models\Quiz;

class CourseController extends Controller
{
    public function index()
    {
        // Lấy các khóa học được xem nhiều nhất
        $courses = Course::orderBy('views', 'desc')->take(5)->get();
        return view('user.course.index', compact('courses'));
    }

    public function show($slug)
    {
        $course = Course::with(['lessons', 'instructor'])->where('slug', $slug)->firstOrFail();
        $course->increment('views');

        if (!$course->isPaidByUser(Auth::id())) {
            return redirect()->route('course.payment', ['slug' => $slug]);
        }

        $reviews = Review::where('course_id', $course->id)
            ->where('visible', 1) // chỉ lấy review được hiển thị
            ->with('user')
            ->latest()
            ->get();

        $firstLesson = $course->lessons->first();
        $comments = $firstLesson
            ? $firstLesson->comments()
                ->with(['user', 'replies.user', 'replies.likes']) // Không cần nạp quan hệ likes cho comment chính
                ->orderBy('created_at', 'desc')
                ->get()
            : collect([]);

        $userId = Auth::id();

        $completedLessons = [];
        $progress = CourseProgress::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();

        if ($progress) {
            $completedLessons = $progress->completed_lessons ?? [];
        }

        $averageRating = Review::where('course_id', $course->id)
            ->where('visible', 1)
            ->avg('rating');

        $ratingCount = Review::where('course_id', $course->id)
            ->where('visible', 1)
            ->count();

        $ratingSummary = Review::where('course_id', $course->id)
            ->where('visible', 1)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating');

        // Tính toán phần trăm tiến độ
        $totalLessonsCount = $course->lessons()->count();
        $completedLessonsCount = count($completedLessons);
        $progressPercentage = $totalLessonsCount > 0 ? ($completedLessonsCount / $totalLessonsCount) * 100 : 0;

        foreach ($comments as $comment) {
            // Gán trạng thái like cho comment chính
            $comment->liked_by_user = $comment->likes()->where('user_id', $userId)->exists();
            // $comment->likes_count đã có sẵn trong cơ sở dữ liệu, không cần tính lại

            foreach ($comment->replies as $reply) {
                // Gán trạng thái like cho từng reply
                $reply->liked_by_user = $reply->likes->contains('user_id', $userId);
                $reply->likes_count = $reply->likes->count();
            }
        }

        return view('user.course.show', compact('course', 'comments', 'reviews', 'completedLessons', 'progressPercentage', 'totalLessonsCount', 'completedLessonsCount', 'averageRating', 'ratingCount', 'ratingSummary'));
    }

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
            Log::error('Error marking lesson as complete: ' . $e->getMessage());
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

    public function getLesson($lesson_id)
    {
        $lesson = Lesson::where('id', $lesson_id)
            ->with(['course', 'course.instructor', 'comments', 'comments.user', 'comments.replies.user', 'comments.replies.likes'])
            ->firstOrFail();

        $course = $lesson->course;

        // Kiểm tra quyền truy cập
        if (!$course->isPaidByUser(Auth::id())) {
            return response()->json(['error' => 'Bạn chưa mua khóa học này.'], 403);
        }

        // Chuẩn bị dữ liệu bình luận
        $comments = $lesson->comments()
            ->with(['user', 'replies.user', 'replies.likes'])
            ->orderBy('created_at', 'desc')
            ->get();

        $userId = Auth::id();

        foreach ($comments as $comment) {
            $comment->liked_by_user = $comment->likes()->where('user_id', $userId)->exists();
            foreach ($comment->replies as $reply) {
                $reply->liked_by_user = $reply->likes->contains('user_id', $userId);
                $reply->likes_count = $reply->likes->count();
            }
        }

        // Chuẩn bị HTML cho tab "Đánh giá"
        $commentsHtml = view('user.course.partials.comments', compact('comments', 'lesson'))->render();

        return response()->json([
            'title' => $lesson->title,
            'video_url' => $lesson->video_url,
            'content' => nl2br(e($lesson->content)),
            'resources' => 'Danh sách tài liệu sẽ cập nhật sau.', // Thay bằng dữ liệu thực nếu có
            'instructor_info' => 'Giảng viên: ' . ($course->instructor->name ?? 'Đang cập nhật'),
            'comments' => $commentsHtml,
        ]);
    }
}
