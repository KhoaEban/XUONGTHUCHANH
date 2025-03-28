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
        $instructor_id = $request->input('instructor_id');

        // Lấy danh sách giảng viên để hiển thị trong bộ lọc
        $instructors = User::where('role', 'instructor')->get();

        // Nếu là admin, hiển thị tất cả khóa học, nếu là giảng viên chỉ hiển thị khóa học của họ
        $query = Course::with('instructor', 'category');

        if (Auth::user()->role !== 'admin') {
            $query->where('instructor_id', Auth::user()->id);
        }

        // Lọc theo giảng viên nếu admin chọn
        if ($instructor_id) {
            $query->where('instructor_id', $instructor_id);
        }

        $courses = $query->paginate(10);
        $categories = Category::all();
        return view('admin.courses.index', compact('courses', 'instructors'));
    }


    public function show($id)
    {
        $course = Course::with('instructor', 'category', 'lessons')->findOrFail($id);

        // Kiểm tra nếu không phải admin và không phải người tạo khóa học thì từ chối truy cập
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $course->instructor_id) {
            abort(403, 'Bạn không có quyền truy cập khóa học này.');
        }

        return view('admin.courses.show', compact('course'));
    }



    public function create()
    {
        $categories = Category::all();
        return view('admin.courses.create', compact('categories'));
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

        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã được tạo!');
    }

    public function edit($id)
    {
        $course = Course::all()->findOrFail($id);
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

        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã được cập nhật!');
    }

    public function destroy($id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã bị xóa!');
    }
}
