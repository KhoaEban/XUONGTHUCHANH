<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Import the model
use App\Models\Lesson;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\QuizResult;
use App\Models\Enrollment;
use App\Models\Comment;

class LessonController extends Controller
{
    public function index()
    {
        $instructorId = Auth::id(); // Lấy ID của giảng viên đang đăng nhập

        // Lọc các khóa học thuộc giảng viên hiện tại
        $courses = Course::where('instructor_id', $instructorId)->get();

        // Chỉ lấy bài học của các khóa học do giảng viên tạo
        $lessons = Lesson::whereHas('course', function ($query) use ($instructorId) {
            $query->where('instructor_id', $instructorId);
        })->with('course')->orderBy('order_number')->get();

        return view('instructor.lesson.index', compact('lessons', 'courses'));
    }

    public function create()
    {
        $instructorId = Auth::id();
        $courses = Course::where('instructor_id', $instructorId)->get();

        return view('instructor.lesson.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $errors = [];

        if (!$request->filled('course_id') || !Course::find($request->course_id)) {
            $errors['course_id'] = 'Khóa học không hợp lệ.';
        }

        if (!$request->filled('title')) {
            $errors['title'] = 'Tiêu đề không được để trống.';
        }

        if ($request->filled('video_url') && !filter_var($request->video_url, FILTER_VALIDATE_URL)) {
            $errors['video_url'] = 'Đường dẫn video không hợp lệ.';
        }

        if (!$request->filled('order_number') || !is_numeric($request->order_number) || $request->order_number < 1) {
            $errors['order_number'] = 'Thứ tự bài học phải là số nguyên dương.';
        } elseif (Lesson::where('course_id', $request->course_id)->where('order_number', $request->order_number)->exists()) {
            $errors['order_number'] = 'Thứ tự này đã tồn tại trong khóa học.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        Lesson::create($request->all());
        return redirect()->route('instructor.lesson.index')->with('success', 'Bài học đã được tạo thành công!');
    }

    public function edit(Lesson $lesson)
    {
        $instructorId = Auth::id();

        $courses = Course::where('instructor_id', $instructorId)->get();
        return view('instructor.lesson.edit', compact('lesson', 'courses'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $errors = [];

        if (!$request->filled('title')) {
            $errors['title'] = 'Tiêu đề không được để trống.';
        }

        if ($request->filled('video_url') && !filter_var($request->video_url, FILTER_VALIDATE_URL)) {
            $errors['video_url'] = 'Đường dẫn video không hợp lệ.';
        }

        if (!$request->filled('order_number') || !is_numeric($request->order_number) || $request->order_number < 1) {
            $errors['order_number'] = 'Thứ tự bài học phải là số nguyên dương.';
        } elseif (Lesson::where('course_id', $request->course_id)->where('order_number', $request->order_number)->exists()) {
            $errors['order_number'] = 'Thứ tự sắp xếp đã tồn tại trong khóa học.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        $lesson->update($request->all());
        return redirect()->route('instructor.lesson.index')->with('success', 'Bài học đã được cập nhật thành công!');
    }

    public function trackProgress($courseId)
    {
        // Đảm bảo khóa học thuộc về giảng viên đang đăng nhập
        $course = Course::where('id', $courseId)
            ->where('instructor_id', Auth::id())
            ->with('lessons')
            ->firstOrFail();

        // Lấy danh sách học viên tham gia khóa học
        $enrollments = Enrollment::where('course_id', $courseId)
            ->with('user')
            ->get();

        // Tính toán tiến độ và kết quả bài kiểm tra cho từng học viên
        $progressData = [];
        foreach ($enrollments as $enrollment) {
            $user = $enrollment->user;

            // Lấy tiến độ học tập từ bảng course_progress
            $progress = CourseProgress::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->first();

            $completedLessons = $progress ? $progress->completed_lessons : [];
            $totalLessons = $course->lessons->count();
            $progressPercentage = $totalLessons > 0 ? (count($completedLessons) / $totalLessons) * 100 : 0;

            // Lấy kết quả bài kiểm tra từ bảng quiz_results
            $quizResults = QuizResult::where('user_id', $user->id)
                ->whereIn('quiz_id', $course->lessons->flatMap->quizzes->pluck('id'))
                ->get();

            $progressData[] = [
                'user' => $user,
                'progress_percentage' => $progressPercentage,
                'completed_lessons' => count($completedLessons),
                'total_lessons' => $totalLessons,
                'quiz_results' => $quizResults,
            ];
        }

        return view('instructor.courses.progress', compact('course', 'progressData'));
    }

    public function manageComments($courseId, $lessonId)
    {
        // Đảm bảo khóa học và bài học thuộc về giảng viên
        $course = Course::where('id', $courseId)
            ->where('instructor_id', Auth::id())
            ->firstOrFail();

        $lesson = Lesson::where('id', $lessonId)
            ->where('course_id', $courseId)
            ->with(['comments.user', 'comments.replies.user'])
            ->firstOrFail();

        return view('instructor.courses.comments', compact('course', 'lesson'));
    }

    public function replyComment(Request $request, $courseId, $lessonId)
    {
        $course = Course::where('id', $courseId)
            ->where('instructor_id', Auth::id())
            ->firstOrFail();

        $lesson = Lesson::where('id', $lessonId)
            ->where('course_id', $courseId)
            ->firstOrFail();

        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'content' => 'required|string',
        ]);

        $comment = Comment::findOrFail($request->comment_id);

        // Kiểm tra nếu giảng viên đang cố trả lời chính bình luận của mình
        if ($comment->user_id == Auth::id()) {
            return redirect()->back()->withErrors(['error' => 'Bạn không thể trả lời chính bình luận của mình!']);
        }

        Comment::create([
            'user_id' => Auth::id(),
            'lesson_id' => $lessonId,
            'parent_id' => $comment->id, // Gán đúng parent_id để hiển thị đúng cấu trúc trả lời
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Đã trả lời bình luận!');
    }


    public function updateComment(Request $request, $courseId, $lessonId, $commentId)
    {
        $course = Course::where('id', $courseId)
            ->where('instructor_id', Auth::id())
            ->firstOrFail();

        $lesson = Lesson::where('id', $lessonId)
            ->where('course_id', $courseId)
            ->firstOrFail();

        $comment = Comment::where('id', $commentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Đã cập nhật câu trả lời!');
    }

    public function deleteComment($courseId, $lessonId, $commentId)
    {
        $course = Course::where('id', $courseId)
            ->where('instructor_id', Auth::id())
            ->firstOrFail();

        $lesson = Lesson::where('id', $lessonId)
            ->where('course_id', $courseId)
            ->firstOrFail();

        $comment = Comment::where('id', $commentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $comment->delete();

        return redirect()->back()->with('success', 'Đã xóa câu trả lời!');
    }

    public function destroy(Lesson $lesson)
    {
        if (!$lesson) {
            return redirect()->route('instructor.lesson.index')->with('error', 'Bài học không tồn tại.');
        }

        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $lesson->instructor_id) {
            return redirect()->route('instructor.lesson.index')->with('error', 'Bạn không có quyền xóa bài học này.');
        }

        $lesson->delete();
        return redirect()->route('instructor.lesson.index')->with('success', 'Bài học đã được xóa thành công.');
    }
}
