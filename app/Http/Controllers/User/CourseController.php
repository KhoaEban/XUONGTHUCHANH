<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Category;
use App\Models\Lesson;

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

        $firstLesson = $course->lessons->first();
        $comments = $firstLesson
            ? $firstLesson->comments()
            ->with(['user', 'replies.user', 'replies.likes']) // Không cần nạp quan hệ likes cho comment chính
            ->orderBy('created_at', 'desc')
            ->get()
            : collect([]);

        $userId = Auth::id();

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

        return view('user.course.show', compact('course', 'comments'));
    }
}
