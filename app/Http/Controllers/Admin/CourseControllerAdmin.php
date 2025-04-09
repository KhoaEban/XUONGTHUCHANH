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


        return view('admin.courses.show', compact('course' , 'lessons'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Cập nhật validation để trường 'price' không bắt buộc khi là khóa học miễn phí
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_free' => 'nullable|boolean',
            'price' => 'nullable|numeric|required_if:is_free,0',  // 'price' chỉ bắt buộc khi khóa học có giá
        ]);


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
            'price' => $request->has('is_free') ? 0 : $request->price,  // Nếu là khóa học miễn phí thì giá là 0
            'category_id' => $request->category_id,
            'thumbnail' => $thumbnailPath,
            'slug' => $slug,
            'is_free' => $request->has('is_free') ? true : false,  // Lưu thông tin khóa học miễn phí
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã được tạo!');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = Category::all();
        return view('admin.courses.edit', compact('course', 'categories'));
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
        $course = Course::findOrFail($id);


        // Kiểm tra nếu người dùng không phải là admin hoặc không phải giảng viên sở hữu khóa học
        if (Auth::user()->role !== 'admin' && Auth::id() !== $course->instructor_id) {
            abort(403, 'Bạn không có quyền chỉnh sửa khóa học này.');
        }

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

        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã được cập nhật!');
    }

    public function destroy($id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã bị xóa!');
    }
}
