<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Import the model
use App\Models\Lesson;
use App\Models\Course;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('course')->orderBy('order_number')->get();
        $courses = Course::all();
        return view('instructor.lesson.index', compact('lessons', 'courses'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('instructor.lesson.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'content' => 'nullable|string',
            'order_number' => 'required|integer|min:1',
        ]);

        Lesson::create($request->all());
        return redirect()->route('instructor.lesson.index')->with('success', 'Lesson created successfully.');
    }

    public function edit(Lesson $lesson)
    {
        $courses = Course::all(); // Fetch all courses
        return view('instructor.lesson.edit', compact('lesson', 'courses'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'content' => 'nullable|string',
            'order_number' => 'required|integer|min:1',
        ]);

        $lesson->update($request->all());
        return redirect()->route('instructor.lesson.index')->with('success', 'Lesson updated successfully.');
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
