<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Import model
use App\Models\Course;
use App\Models\Category;
use App\Models\Lesson;

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
        $errors = [];

        if (!$request->filled('title')) {
            $errors['title'] = 'Tiêu đề không được để trống.';
        }

        if (!$request->filled('category_id') || !Category::find($request->category_id)) {
            $errors['category_id'] = 'Danh mục không hợp lệ.';
        }

        if (!$request->filled('price') && !$request->has('is_free')) {
            $errors['price'] = 'Giá bắt buộc nếu không phải khóa học miễn phí.';
        } elseif ($request->filled('price') && !is_numeric($request->price)) {
            $errors['price'] = 'Giá phải là số.';
        } elseif ($request->filled('price') && $request->price < 0) {
            $errors['price'] = 'Giá phải lớn hơn 0.';
        } elseif ($request->filled('price') && $request->price > 10000000) {
            $errors['price'] = 'Giá không được quá 10.000.000 VNĐ.';
        }

        if ($request->hasFile('thumbnail') && !$request->file('thumbnail')->isValid()) {
            $errors['thumbnail'] = 'Ảnh tải lên không hợp lệ.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Xử lý upload ảnh giữ nguyên như cũ
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/courses'), $imageName);
            $thumbnailPath = 'uploads/courses/' . $imageName;
        } else {
            $thumbnailPath = null;
        }

        // Xử lý slug
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

        return redirect()->route('instructor.courses.index')->with('success', 'Khóa học đã được tạo thành công!');
    }

    public function edit($id)
    {
        $course = Course::where('id', $id)->where('instructor_id', Auth::id())->firstOrFail();
        $categories = Category::all();
        return view('instructor.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $errors = [];

        $course = Course::where('id', $id)->where('instructor_id', Auth::id())->firstOrFail();

        if (!$request->filled('title')) {
            $errors['title'] = 'Tiêu đề không được để trống.';
        }

        if (!$request->filled('category_id') || !Category::find($request->category_id)) {
            $errors['category_id'] = 'Danh mục không hợp lệ.';
        }

        if (!$request->filled('price') && !$request->has('is_free')) {
            $errors['price'] = 'Giá bắt buộc nếu không phải khóa học miễn phí.';
        } elseif ($request->filled('price') && !is_numeric($request->price)) {
            $errors['price'] = 'Giá phải là số.';
        } elseif ($request->filled('price') && $request->price < 0) {
            $errors['price'] = 'Giá phải lớn hơn 0.';
        } elseif ($request->filled('price') && $request->price > 10000000) {
            $errors['price'] = 'Giá không được quá 10.000.000 VNĐ.';
        }

        if ($request->hasFile('thumbnail') && !$request->file('thumbnail')->isValid()) {
            $errors['thumbnail'] = 'Ảnh tải lên không hợp lệ.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Xử lý cập nhật ảnh giữ nguyên như cũ
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/courses'), $imageName);
            $thumbnailPath = 'uploads/courses/' . $imageName;
        } else {
            $thumbnailPath = $course->thumbnail; // Giữ nguyên ảnh cũ nếu không tải ảnh mới
        }

        // Cập nhật dữ liệu
        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->has('is_free') ? 0 : $request->price,
            'category_id' => $request->category_id,
            'thumbnail' => $thumbnailPath,
            'is_free' => $request->has('is_free'),
        ]);

        return redirect()->route('instructor.courses.index')->with('success', 'Khóa học đã được cập nhật thành công!');
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
