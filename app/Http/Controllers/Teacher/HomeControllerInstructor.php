<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class HomeControllerInstructor extends Controller
{
    public function index()
    {
        // Lấy ID của giảng viên đang đăng nhập
        $instructorId = Auth::id();

        // Lấy danh sách các khóa học do giảng viên này tạo, kèm theo số bài học và học viên
        $courses = Course::where('instructor_id', $instructorId)
            ->withCount('lessons') // Đếm số bài học
            ->withCount('enrollments') // Đếm số học viên tham gia
            ->orderBy('created_at', 'desc')
            ->paginate(6); // 6 khóa học mỗi trang

        // Truyền danh sách khóa học vào view
        return view('instructor.home', compact('courses'));
    }
    
}
