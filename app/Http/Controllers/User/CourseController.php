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
        $course = Course::all();
        return view('user.course.index', compact('course'));
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
