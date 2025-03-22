<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseControllerAdmin extends Controller
{
    public function index()
    {
        if (Auth::user()->role != 'admin') {
            return redirect()->route('home');
        }

        $courses = Course::paginate(5);

        return view('admin.course.index' , compact('courses'));
    }

    public function create()
    {
        if (Auth::user()->role != 'admin') {
            return redirect()->route('home');
        }
        return view('admin.course.create');
    }

    public function store(Request $request)
    {
        // Xu ly luu khoa hoc
    }
}