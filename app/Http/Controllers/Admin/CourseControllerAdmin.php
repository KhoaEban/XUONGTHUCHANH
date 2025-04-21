<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Import model
use App\Models\Course;
use App\Models\Category;
use App\Models\User;

class CourseControllerAdmin extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['category', 'instructor']);

        // Nếu không phải admin, chỉ lấy khóa học của giảng viên hiện tại
        if (Auth::user()->role !== 'admin') {
            $query->where('instructor_id', Auth::id());
        }

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

        // Lọc theo giảng viên (chỉ admin mới có quyền lọc)
        if ($request->filled('instructor_id') && Auth::user()->role === 'admin') {
            $query->where('instructor_id', $request->instructor_id);
        }

        // Áp dụng sắp xếp
        $query->orderBy(
            $request->get('sort_by', 'created_at'),
            $request->get('sort_order', 'desc')
        );

        // Lấy danh sách khóa học
        $courses = $query->paginate(10);

        // Lấy danh sách danh mục & giảng viên
        $categories = Category::all();
        $instructors = User::where('role', 'instructor')->get();

        return view('admin.courses.index', compact('courses', 'categories', 'instructors'));
    }

    public function show($id)
    {
        $course = Course::with([
            'instructor',
            'lessons', // Nạp danh sách bài học
            'category',
            'lessons.quizzes' // Nạp danh sách quiz của từng bài học
        ])->findOrFail($id);
        $lessons = $course->lessons;
        $lessons->load('quizzes'); // Nạp danh sách quiz của từng bài học
        // Kiểm tra quyền truy cập
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $course->instructor_id) {
            abort(403, 'Bạn không có quyền truy cập khóa học này.');
        }


        return view('admin.courses.show', compact('course', 'lessons'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.courses.create', compact('categories'));
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

        if (!$request->has('is_free') && !$request->filled('price')) {
            $errors['price'] = 'Giá bắt buộc nếu không phải khóa học miễn phí.';
        } elseif ($request->filled('price') && !is_numeric($request->price)) {
            $errors['price'] = 'Giá phải là số.';
        } elseif ($request->filled('price') && $request->price < 0) {
            $errors['price'] = 'Giá phải lớn hơn 0.';
        } elseif ($request->filled('price') && $request->price > 10000000) {
            $errors['price'] = 'Giá không được lớn hơn 10.000.000 VNĐ.';
        }

        if ($request->hasFile('thumbnail') && !$request->file('thumbnail')->isValid()) {
            $errors['thumbnail'] = 'Ảnh tải lên không hợp lệ.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Xử lý upload ảnh
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/courses'), $imageName);
            $thumbnailPath = 'uploads/courses/' . $imageName;
        }

        // Tạo slug từ title
        $slug = Str::slug($request->title, '-');
        if (Course::where('slug', 'LIKE', $slug . '%')->exists()) {
            $slug .= '-' . (Course::where('slug', 'LIKE', $slug . '%')->count() + 1);
        }

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

        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã được tạo thành công!');
    }


    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = Category::all();
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $errors = [];

        $course = Course::findOrFail($id);

        if (!$request->filled('title')) {
            $errors['title'] = 'Tiêu đề không được để trống.';
        }

        if (!$request->filled('category_id') || !Category::find($request->category_id)) {
            $errors['category_id'] = 'Danh mục không hợp lệ.';
        }

        if (!$request->has('is_free') && !$request->filled('price')) {
            $errors['price'] = 'Giá bắt buộc nếu không phải khóa học miễn phí.';
        } elseif ($request->filled('price') && !is_numeric($request->price)) {
            $errors['price'] = 'Giá phải là số.';
        } elseif ($request->filled('price') && $request->price < 0) {
            $errors['price'] = 'Giá phải lớn hơn 0.';
        } elseif ($request->filled('price') && $request->price > 10000000) {
            $errors['price'] = 'Giá không được lớn hơn 10.000.000 VNĐ.';
        }

        if ($request->hasFile('thumbnail') && !$request->file('thumbnail')->isValid()) {
            $errors['thumbnail'] = 'Ảnh tải lên không hợp lệ.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Xử lý cập nhật slug nếu title thay đổi
        if ($course->title !== $request->title) {
            $slug = Str::slug($request->title, '-');
            if (Course::where('slug', 'LIKE', $slug . '%')->where('id', '!=', $id)->exists()) {
                $slug .= '-' . (Course::where('slug', 'LIKE', $slug . '%')->count() + 1);
            }
            $course->slug = $slug;
        }

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/courses'), $imageName);

            // Xóa ảnh cũ nếu có
            if ($course->thumbnail && file_exists(public_path($course->thumbnail))) {
                unlink(public_path($course->thumbnail));
            }

            $course->thumbnail = 'uploads/courses/' . $imageName;
        }

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->has('is_free') ? 0 : $request->price,
            'category_id' => $request->category_id,
            'is_free' => $request->has('is_free'),
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã được cập nhật thành công!');
    }


    public function destroy($id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã bị xóa!');
    }
}
