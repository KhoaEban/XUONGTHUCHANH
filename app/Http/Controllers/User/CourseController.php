<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\Review;
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


        // Lấy bài học đầu tiên và bình luận của nó
        $firstLesson = $course->lessons->first();
        $comments = $firstLesson ? $firstLesson->comments()->with('user')->orderBy('created_at', 'desc')->get() : collect([]);

        // Chuyển đổi comments thành định dạng JSON phù hợp
        $comments = $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'content' => $comment->content,
                'created_at' => $comment->created_at->toDateTimeString(),
                'user' => [
                    'name' => $comment->user->name,
                    'is_teacher' => $comment->user->isTeacher(),
                ],
            ];
        })->toArray();

        return view('user.course.show', compact('course', 'comments', 'reviews'));

    }
}
