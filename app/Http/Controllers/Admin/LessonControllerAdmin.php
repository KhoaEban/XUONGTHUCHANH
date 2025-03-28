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
        $course_id = $request->input('course_id'); // Lấy giá trị lọc khóa học

        // Lấy danh sách giảng viên
        $instructors = User::where('role', 'instructor')->get();

        // Lấy danh sách khóa học
        $courses = Course::all();

        // Lấy danh sách bài học với điều kiện lọc
        $lessons = Lesson::with(['course.instructor'])
            ->when($course_id, function ($query) use ($course_id) {
                return $query->where('course_id', $course_id);
            })
            ->when($instructor_id, function ($query) use ($instructor_id) {
                return $query->where('instructor_id', $instructor_id);
            })
            ->orderBy('order_number')
            ->get();

        return view('admin.lessons.index', compact('lessons', 'courses', 'instructors'));
    }


    public function show($id)
    {
        $lesson = Lesson::with(['course', 'instructor'])->findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $lesson->instructor_id) {
            abort(403, 'Bạn không có quyền truy cập bài học này.');
        }

        return view('admin.lessons.show', compact('lesson'));
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
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $lesson->instructor_id) {
            return redirect()->route('admin.lessons.index')->with('error', 'Bạn không có quyền xóa bài học này.');
        }

        $lesson->delete();
        return redirect()->route('admin.lessons.index')->with('success', 'Bài học đã được xóa thành công.');
    }
}
