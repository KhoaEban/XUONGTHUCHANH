<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\CourseProgress;
use App\Models\Review;

class CourseController extends Controller
{
    /**
     * Hiển thị danh sách các khóa học nổi bật.
     */
    public function index()
    {
        $courses = Course::orderBy('views', 'desc')->take(5)->get();
        return view('user.course.index', compact('courses'));
    }

    /**
     * Hiển thị chi tiết khóa học.
     */
    public function show($slug)
    {
        $course = Course::with(['lessons', 'instructor'])->where('slug', $slug)->firstOrFail();
        $course->increment('views');

        // Kiểm tra quyền truy cập
        if (!$course->isPaidByUser(Auth::id())) {
            return redirect()->route('course.payment', ['slug' => $slug]);
        }

        // Lấy đánh giá
        $reviews = Review::where('course_id', $course->id)
            ->where('visible', 1)
            ->with('user')
            ->latest()
            ->get();

        // Lấy bình luận của bài học đầu tiên
        $firstLesson = $course->lessons->first();
        $comments = $firstLesson
            ? $firstLesson->comments()
                ->with(['user', 'replies.user', 'replies.likes'])
                ->orderBy('created_at', 'desc')
                ->get()
            : collect([]);

        $userId = Auth::id();

        // Lấy danh sách bài học đã hoàn thành
        $progress = CourseProgress::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();
        $completedLessons = $progress ? $progress->completed_lessons : [];

        // Tính toán tiến độ
        $totalLessonsCount = $course->lessons()->count();
        $completedLessonsCount = count($completedLessons);
        $progressPercentage = $totalLessonsCount > 0 ? ($completedLessonsCount / $totalLessonsCount) * 100 : 0;

        // Lấy thông tin đánh giá
        $averageRating = Review::where('course_id', $course->id)
            ->where('visible', 1)
            ->avg('rating') ?? 0;

        $ratingCount = Review::where('course_id', $course->id)
            ->where('visible', 1)
            ->count();

        $ratingSummary = Review::where('course_id', $course->id)
            ->where('visible', 1)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating');

        // Gán trạng thái thích cho bình luận và phản hồi
        foreach ($comments as $comment) {
            $comment->liked_by_user = $comment->likes()->where('user_id', $userId)->exists();
            foreach ($comment->replies as $reply) {
                $reply->liked_by_user = $reply->likes->contains('user_id', $userId);
                $reply->likes_count = $reply->likes->count();
            }
        }

        return view('user.course.show', compact(
            'course',
            'comments',
            'reviews',
            'completedLessons',
            'progressPercentage',
            'totalLessonsCount',
            'completedLessonsCount',
            'averageRating',
            'ratingCount',
            'ratingSummary'
        ));
    }

    /**
     * Đánh dấu bài học hoàn thành.
     */
    public function markLessonAsComplete(Request $request, $courseId, $lessonId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Bạn cần đăng nhập để thực hiện hành động này.'], 401);
        }

        try {
            $course = Course::findOrFail($courseId);
            $lesson = Lesson::where('id', $lessonId)->where('course_id', $courseId)->firstOrFail();

            // Kiểm tra quyền truy cập khóa học
            if (!$course->isPaidByUser($user->id)) {
                return response()->json(['message' => 'Bạn chưa mua khóa học này.'], 403);
            }

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
            Log::error('Error marking lesson as complete: ' . $e->getMessage());
            return response()->json(['message' => 'Đã có lỗi xảy ra khi đánh dấu bài học là hoàn thành.'], 500);
        }
    }

    /**
     * Lấy tiến độ khóa học.
     */
    public function getCourseProgress(Request $request, $courseId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Bạn cần đăng nhập.'], 401);
        }

        try {
            $course = Course::findOrFail($courseId);

            // Kiểm tra quyền truy cập
            if (!$course->isPaidByUser($user->id)) {
                return response()->json(['message' => 'Bạn chưa mua khóa học này.'], 403);
            }

            $progress = CourseProgress::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->first();

            $completedLessons = $progress ? $progress->completed_lessons : [];
            $completedLessonsCount = count($completedLessons);
            $totalLessons = $course->lessons()->count();
            $progressPercentage = $totalLessons > 0 ? ($completedLessonsCount / $totalLessons) * 100 : 0;

            return response()->json([
                'progressPercentage' => round($progressPercentage, 2),
                'completedLessonsCount' => $completedLessonsCount,
                'totalLessonsCount' => $totalLessons,
                'completedLessons' => $completedLessons,
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting course progress: ' . $e->getMessage());
            return response()->json(['message' => 'Đã có lỗi xảy ra khi lấy tiến độ khóa học.'], 500);
        }
    }

    /**
     * Lấy thông tin chi tiết bài học.
     */
    public function getLesson($lesson_id)
    {
        try {
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

            $commentsHtml = view('user.course.partials.comments', compact('comments', 'lesson'))->render();

            return response()->json([
                'title' => $lesson->title,
                'video_url' => $lesson->video_url,
                'content' => nl2br(e($lesson->content)),
                'resources' => 'Danh sách tài liệu sẽ cập nhật sau.',
                'instructor_info' => 'Giảng viên: ' . ($course->instructor->name ?? 'Đang cập nhật'),
                'comments' => $commentsHtml,
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting lesson: ' . $e->getMessage());
            return response()->json(['message' => 'Đã có lỗi xảy ra khi lấy thông tin bài học.'], 500);
        }
    }

    /**
     * Hiển thị/tải chứng chỉ khóa học.
     */
    public function showCertificate($courseId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem chứng chỉ.');
        }

        try {
            $course = Course::findOrFail($courseId);

            // Kiểm tra quyền truy cập
            if (!$course->isPaidByUser($user->id)) {
                return redirect()->route('course.show', $course->slug)
                    ->with('error', 'Bạn chưa mua khóa học này.');
            }

            // Kiểm tra hoàn thành khóa học
            $progress = CourseProgress::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->first();

            if (!$progress || count($progress->completed_lessons) < $course->lessons()->count()) {
                return redirect()->route('course.show', $course->slug)
                    ->with('error', 'Bạn chưa hoàn thành tất cả bài học để nhận chứng chỉ.');
            }

            // Tạo PDF chứng chỉ
            $pdf = Pdf::loadView('user.certificate.show', compact('course', 'user'));
            return $pdf->download('certificate_' . $course->slug . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error generating certificate: ' . $e->getMessage());
            return redirect()->route('course.show', $course->slug)
                ->with('error', 'Đã có lỗi xảy ra khi tạo chứng chỉ.');
        }
    }
}