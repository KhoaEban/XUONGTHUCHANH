<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Result;
use App\Models\ResultDetail;
use App\Models\UserCourse;
use App\Models\UserQuestion;
use App\Models\UserAnswer;
use App\Models\UserResult;
use App\Models\UserResultDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeControllerInstructor extends Controller
{
    public function index()
    {
        return view('instructor.home');
    }
}