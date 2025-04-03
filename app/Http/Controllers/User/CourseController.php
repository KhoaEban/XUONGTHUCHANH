<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $course = Course::with('lessons', 'instructor')->where('slug', $slug)->firstOrFail();

        if (!$course->isPaidByUser(Auth::id())) {
            return redirect()->route('course.payment', ['slug' => $slug]);
        }

        return view('user.course.show', compact('course'));
    }
}
