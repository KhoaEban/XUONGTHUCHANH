<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserSubject;
use App\Models\Subject;
use App\Models\UserSubjectCourse;
use App\Models\SubjectCourse;
use App\Models\SubjectUser;
use App\Models\SubjectUserCourse;

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