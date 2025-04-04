<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $lesson = Lesson::all();
        return view('user.lesson.index', compact('lesson'));
    }

    public function show($id)
    {
        $lesson = Lesson::with('comments.user')->findOrFail($id);
        $lesson = Lesson::with('course.instructor')->findOrFail($id);
        $course = $lesson->course;

        $relatedCourses = Course::where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->take(3)
            ->get();

        return view('lesson.show', compact('lesson', 'course', 'relatedCourses'));
    }

    public function getLessons($slug)
    {
        $lessons = Lesson::where('course_id', $slug)->orderBy('order_number')->get();
        return response()->json($lessons);
    }
}
