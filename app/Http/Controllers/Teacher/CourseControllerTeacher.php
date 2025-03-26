<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Import model
use App\Models\Course;
use App\Models\Category;

class CourseControllerTeacher extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())->get();
        $categories = Category::all();
        return view('instructor.courses.index', compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('instructor.courses.create' , compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Xử lý upload ảnh
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/courses'), $imageName);
            $thumbnailPath = 'uploads/courses/' . $imageName;
        } else {
            $thumbnailPath = null;
        }

        // Tạo slug từ title
        $slug = Str::slug($request->title, '-');
        $count = Course::where('slug', 'LIKE', $slug . '%')->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        // Lưu vào database
        Course::create([
            'instructor_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'thumbnail' => $thumbnailPath,
            'slug' => $slug
        ]);

        return redirect()->route('instructor.courses.index')->with('success', 'Khóa học đã được tạo!');
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
            'thumbnail' => 'nullable|thumbnail|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;

        if ($request->hasFile('thumbnail')) {
            $imagePath = $request->file('thumbnail')->store('courses', 'public');
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
