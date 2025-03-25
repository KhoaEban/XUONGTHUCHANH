<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Course;
use App\Models\Category;

class CourseControllerAdmin extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $courses = Course::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.course.index', compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = Category::with('child_categories')->get(); // Nạp sẵn danh mục con
        return view('admin.course.create' , compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $course = new Course();
        $course->instructor_id = auth()->id();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->category_id = $request->category_id;
        $course->slug = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            $imagePath = $request->file('thumbnail')->store('thumbnails', 'public');
            $course->thumbnail = $imagePath;
        }

        $course->save();
        return redirect()->route('admin.course.index')->with('success', 'Khóa học đã được tạo!');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.course.edit', compact('course'));
    }


    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->category_id = $request->category_id;
        $course->slug = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            $imagePath = $request->file('thumbnail')->store('thumbnails', 'public');
            $course->thumbnail = $imagePath;
        }

        $course->save();
        return redirect()->route('admin.course.index')->with('success', 'Khóa học đã được cập nhật!');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.course.index')->with('success', 'Khóa học đã bị xóa!');
    }
}
