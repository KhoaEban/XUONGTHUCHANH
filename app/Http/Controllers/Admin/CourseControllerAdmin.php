<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// use auth
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;

class CourseControllerAdmin extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Course::with('category')
            ->orderBy(
                $request->get('sort_by', 'created_at'),
                $request->get('sort_order', 'desc')
            );

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo khoảng giá
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Lọc theo từ khóa tìm kiếm
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Lấy danh sách khóa học sau khi áp dụng bộ lọc
        $courses = $query->paginate(10);

        return view('admin.course.index', compact('courses', 'categories'));
    }


    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedCourses = $request->input('selected_courses', []);

        if ($action === 'delete' && !empty($selectedCourses)) {
            Course::whereIn('id', $selectedCourses)->delete();
            return redirect()->route('admin.course.index')
                ->with('success', 'Đã xóa các khóa học đã chọn!');
        }

        return redirect()->route('admin.course.index')
            ->with('error', 'Không có hành động nào được thực hiện.');
    }

    public function create()
    {
        $categories = Category::with('child_categories')->get(); // Nạp sẵn danh mục con
        return view('admin.course.create', compact('categories'));
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

        return redirect()->route('admin.course.index')->with('success', 'Khóa học đã được tạo!');
    }



    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = Category::all();
        return view('admin.course.edit', compact('course', 'categories'));
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
    public function viewInstructorCourses($id)
    {
        // Lấy giảng viên với role là 'instructor' và load luôn khóa học
        $instructor = User::where('role', 'instructor')->where('id', $id)->firstOrFail();

        // Lấy danh sách khóa học của giảng viên đó
        $courses = $instructor->courses;

        return view('admin.instructor_courses', compact('instructor', 'courses'));
    }
}
