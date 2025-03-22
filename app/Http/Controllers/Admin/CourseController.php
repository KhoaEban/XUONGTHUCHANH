<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('admin.course.index', compact('course'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:10000',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Upload image & video
        $imagePath = $request->file('image') ? $request->file('image')->store('courses', 'public') : null;
        $videoPath = $request->file('video') ? $request->file('video')->store('courses/videos', 'public') : null;

        Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'video' => $videoPath,
            'category_id' => $request->category_id,
            'teacher_id' => auth()->id(),
        ]);

        return redirect()->route('courses.index')->with('success', 'Khóa học đã được tạo thành công!');
    }

    public function edit(Course $course)
    {
        $categories = Category::all();
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:10000',
            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = $course->image;
        if ($request->hasFile('image')) {
            \Storage::delete('public/' . $course->image);
            $imagePath = $request->file('image')->store('courses', 'public');
        }

        $videoPath = $course->video;
        if ($request->hasFile('video')) {
            \Storage::delete('public/' . $course->video);
            $videoPath = $request->file('video')->store('courses/videos', 'public');
        }

        $course->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'video' => $videoPath,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('courses.index')->with('success', 'Khóa học đã được cập nhật!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Khóa học đã bị xóa!');
    }
}
