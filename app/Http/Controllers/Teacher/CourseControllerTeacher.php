<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseControllerTeacher extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())->get();
        return view('instructor.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('instructor.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->instructor_id = Auth::id(); // Sửa teacher_id thành instructor_id

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
            $course->image = $imagePath;
        }

        $course->save();
        return redirect()->route('instructor.courses.index')->with('success', 'Khóa học đã được tạo thành công!');
    }

    public function edit($id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        return view('instructor.courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
            $course->image = $imagePath;
        }

        $course->save();
        return redirect()->route('instructor.courses.index')->with('success', 'Khóa học đã được cập nhật!');
    }

    public function destroy($id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        $course->delete();
        return redirect()->route('instructor.courses.index')->with('success', 'Khóa học đã bị xóa!');
    }
}
