<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show($id)
    {
        $quiz = Quiz::with('questions.options')->findOrFail($id);
        return view('quizzes.show', compact('quiz'));
    }
}
