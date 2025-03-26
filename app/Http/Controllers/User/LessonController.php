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
        $lesson = Lesson::with('course.instructor')->findOrFail($id);
        $course = $lesson->course;

        // Lấy các khóa học liên quan trong cùng danh mục nhưng không bao gồm khóa học hiện tại
        $relatedCourses = Course::where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->take(3)
            ->get();

        return view('lesson.show', compact('lesson', 'course', 'relatedCourses'));
    }
}
