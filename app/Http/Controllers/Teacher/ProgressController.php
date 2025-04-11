<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\QuizResult;

class ProgressController extends Controller
{
    public function index()
    {
        $progresses = QuizResult::with('user', 'quiz')->get();
        return view('instructor.student_management.progress', compact('progresses'));
    }

    public function detail($userId, $quizId)
    {
        $progress = QuizResult::where('user_id', $userId)->where('quiz_id', $quizId)
            ->with('user', 'quiz', 'userAnswers')->firstOrFail();
        return view('instructor.student_management.progress-detail', compact('progress'));
    }
}
