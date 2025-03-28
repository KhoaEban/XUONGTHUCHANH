<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Import the model
use App\Models\Lesson;
use App\Models\Course;
use App\Models\User;

class LessonControllerAdmin extends Controller
{
    public function index(Request $request)
    {
        $instructor_id = $request->input('instructor_id');

        // Lấy danh sách giảng viên
        $instructors = User::where('role', 'instructor')->get();

        // Lấy danh sách bài học kèm khóa học và giảng viên
        $lessons = Lesson::with(['course', 'instructor'])
            ->orderBy('order_number')
            ->get();

        $courses = Course::all();

        return view('admin.lessons.index', compact('lessons', 'courses', 'instructors'));
    }


    public function show($id)
    {
        $lessons = Course::with('instructor', 'courses', 'lessons')->findOrFail($id);

        // Kiểm tra nếu không phải admin và không phải người tạo khóa học thì từ chối truy cập
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $lessons->instructor_id) {
            abort(403, 'Bạn không có quyền truy cập khóa học này.');
        }

        return view('admin.lessons.show', compact('lessons'));
    }


    public function create()
    {
        $courses = Course::all();
        return view('admin.lessons.create', compact('courses'));
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
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson created successfully.');
    }
    

    public function edit(Lesson $lesson)
    {
        $courses = Course::all(); // Fetch all courses
        return view('admin.lessons.edit', compact('lesson', 'courses'));
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
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson deleted successfully.');
    }
}
