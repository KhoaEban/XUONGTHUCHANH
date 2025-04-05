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
    public function index(Request $request)
    {
        $query = Course::where('instructor_id', Auth::id());

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

        // Áp dụng sắp xếp
        $query->orderBy(
            $request->get('sort_by', 'created_at'),
            $request->get('sort_order', 'desc')
        );

        // Lấy danh sách khóa học
        $courses = $query->paginate(10);

        // Lấy danh sách danh mục
        $categories = Category::all();

        return view('instructor.courses.index', compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('instructor.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|required_if:is_free,0',  // 'price' chỉ bắt buộc khi khóa học có giá
            'category_id' => 'required|integer|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_free' => 'nullable|boolean',
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
            'price' => $request->has('is_free') ? 0 : $request->price,
            'category_id' => $request->category_id,
            'thumbnail' => $thumbnailPath,
            'slug' => $slug,
            'is_free' => $request->has('is_free') ? true : false,
        ]);

        return redirect()->route('instructor.courses.index')->with('success', 'Khóa học đã được tạo!');
    }

    public function edit($id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        $categories = Category::all();
        return view('instructor.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048'
        ]);

        // Tìm khóa học của giảng viên hiện tại
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);

        // Cập nhật thông tin khóa học
        $course->title       = $request->title;
        $course->description = $request->description;
        $course->price       = $request->price;
        $course->category_id = $request->category_id;

        // Xử lý cập nhật slug nếu title thay đổi
        if ($course->title !== $request->title) {
            $slug = Str::slug($request->title, '-');
            $count = Course::where('slug', 'LIKE', $slug . '%')->where('id', '!=', $id)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
            $course->slug = $slug;
        }

        // Xử lý upload ảnh mới nếu có
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/courses'), $imageName);

            // Xóa ảnh cũ (nếu có)
            if ($course->thumbnail && file_exists(public_path($course->thumbnail))) {
                unlink(public_path($course->thumbnail));
            }

            // Lưu ảnh mới vào database
            $course->thumbnail = 'uploads/courses/' . $imageName;
        }

        // Lưu thay đổi vào database
        $course->save();

        return redirect()->route('instructor.courses.index')->with('success', 'Khóa học đã được cập nhật!');
    }

    public function destroy($id)
    {
        // Tìm khóa học của giảng viên hiện tại
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);

        // Xóa khóa học
        $course->delete();

        // Trả về thông báo thành công
        return redirect()->route('instructor.courses.index')->with('success', 'Khóa học đã bị xóa thành công!');
    }

    public function show($slug)
    {
        $course = Course::where('instructor_id', Auth::id())->where('slug', $slug)->firstOrFail();
        return view('instructor.courses.show', compact('course'));
    }
}
