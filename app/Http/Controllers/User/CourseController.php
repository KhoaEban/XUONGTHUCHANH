<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;


class CourseController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function index()
    {
        
        return view('user.course.index');
    }

}