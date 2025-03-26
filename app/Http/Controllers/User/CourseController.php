<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('user.course.show', compact('course'));
    }
}
