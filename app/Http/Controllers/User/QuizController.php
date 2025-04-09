<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;

class QuizController extends Controller
{
    public function show($id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        return view('user.quizzes.show', compact('quiz'));
    }

    public function doQuiz($quizId)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($quizId);

        return view('user.quizzes.do', compact('quiz'));
    }
}
