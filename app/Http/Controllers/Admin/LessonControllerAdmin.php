<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Import model
use App\Models\Lesson;
use App\Models\Course;
use App\Models\User;

class LessonControllerAdmin extends Controller
{
    public function index(Request $request)
    {
        $query = Lesson::with(['course.instructor']); // Eager load course và instructor

        // Nếu không phải admin, chỉ lấy bài học của giảng viên hiện tại
        if (Auth::user()->role !== 'admin') {
            $query->where('instructor_id', Auth::id());
        }

        // Lọc theo khóa học
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
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

        // Lấy danh sách bài học
        $lessons = $query->paginate(10);

        // Lấy danh sách khóa học & giảng viên
        $courses = Course::all();
        $instructors = User::where('role', 'instructor')->get();

        return view('admin.lessons.index', compact('lessons', 'courses', 'instructors'));
    }

    public function show($id)
    {
        // Eager load mối quan hệ course và instructor
        $lesson = Lesson::with(['course.instructor'])->findOrFail($id);

        // Kiểm tra quyền truy cập
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $lesson->instructor_id) {
            abort(403, 'Bạn không có quyền truy cập bài học này.');
        }

        return view('admin.lessons.show', compact('lesson'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.lessons.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|integer|exists:courses,id',
            'order_number' => 'required|integer',
            'video_url' => 'nullable|url',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/lessons'), $imageName);
            $thumbnailPath = 'uploads/lessons/' . $imageName;
        } else {
            $thumbnailPath = null;
        }

        // Tạo bài học mới
        Lesson::create([
            'instructor_id' => Auth::id(),
            'title' => $request->title,
            'course_id' => $request->course_id,
            'order_number' => $request->order_number,
            'video_url' => $request->video_url,
            'content' => $request->content,
            'thumbnail' => $thumbnailPath
        ]);

        // slug tạo tự động
        $lesson = Lesson::latest()->first();
        $lesson->slug = Str::slug($lesson->title);
        $lesson->save();

        return redirect()->route('admin.lessons.index')->with('success', 'Bài học đã được tạo!');
    }

    public function edit($id)
    {
        $lesson = Lesson::findOrFail($id);
        $courses = Course::all();
        return view('admin.lessons.edit', compact('lesson', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|integer|exists:courses,id',
            'order_number' => 'required|integer',
            'video_url' => 'nullable|url',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $lesson = Lesson::findOrFail($id);

        // Kiểm tra quyền truy cập
        if (Auth::user()->role !== 'admin' && Auth::id() !== $lesson->instructor_id) {
            abort(403, 'Bạn không có quyền chỉnh sửa bài học này.');
        }

        // Cập nhật thông tin bài học
        $lesson->title = $request->title;
        $lesson->course_id = $request->course_id;
        $lesson->order_number = $request->order_number;
        $lesson->video_url = $request->video_url;
        $lesson->content = $request->content;

        // Xử lý cập nhật ảnh nếu có
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/lessons'), $imageName);

            // Xóa ảnh cũ nếu có
            if ($lesson->thumbnail && file_exists(public_path($lesson->thumbnail))) {
                unlink(public_path($lesson->thumbnail));
            }

            // Lưu ảnh mới
            $lesson->thumbnail = 'uploads/lessons/' . $imageName;
        }
        // Cập nhật slug tạo tự động
        $lesson->slug = Str::slug($lesson->title);

        $lesson->save();

        return redirect()->route('admin.lessons.index')->with('success', 'Bài học đã được cập nhật!');
    }

    public function destroy($id)
    {
        $lesson = Lesson::where('instructor_id', Auth::id())->findOrFail($id);
        $lesson->delete();
        return redirect()->route('admin.lessons.index')->with('success', 'Bài học đã bị xóa!');
    }
}
