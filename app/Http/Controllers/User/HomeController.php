<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $courses = Course::all();

        $user = Auth::user();

        $purchasedCourses = [];
        if ($user) {
            $purchasedCourses = $user->enrollments->pluck('course_id')->toArray();
        }

        return view('user.home', compact('categories', 'courses', 'purchasedCourses'));
        $categories = Category::all(); // Lấy tất cả danh mục
        // $categories->load('courses'); // Load tất cả khóa học của mỗi danh mục
        $courses = Course::all();
        return view('user.home', compact('categories', 'courses'));
    }
}
