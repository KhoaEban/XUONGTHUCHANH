<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Quiz;
use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\QuizResult;
use Illuminate\Support\Facades\Auth;


class QuizController extends Controller
{
    public function show($id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        return view('user.quizzes.show', compact('quiz'));
    }
    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        $answers = $request->input('answers', []);

        $score = 0;
        $total = $quiz->questions->count();
        $details = [];

        foreach ($quiz->questions as $question) {
            $userAnswerId = $answers[$question->id] ?? null;
            $correctAnswer = $question->answers->where('is_correct', 1)->first();

            $isCorrect = ($userAnswerId == optional($correctAnswer)->id);

            if ($isCorrect) $score++;

            $details[] = [
                'question' => $question->question_text,
                'your_answer' => optional(\App\Models\Answer::find($userAnswerId))->answer_text,
                'correct_answer' => optional($correctAnswer)->answer_text,
                'is_correct' => $isCorrect,
            ];
        }

        \App\Models\QuizResult::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total_questions' => $total,
        ]);

        return view('user.quizzes.result', [
            'quiz' => $quiz,
            'score' => $score,
            'total' => $total,
            'details' => $details
        ]);
    }



}