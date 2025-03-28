<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Lấy tất cả danh mục
        // $categories->load('courses'); // Load tất cả khóa học của mỗi danh mục
        $courses = Course::all();
        return view('user.home', compact('categories', 'courses'));
    }
}
