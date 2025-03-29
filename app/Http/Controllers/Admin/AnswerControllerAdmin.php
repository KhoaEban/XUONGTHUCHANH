<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\QuizResult;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerControllerAdmin extends Controller
{
    public function index()
    {
        $answers = Answer::with(['quizResult', 'question'])->get();
        return view('admin.answers.index', compact('answers'));
    }

    public function create()
    {
        $quizResults = QuizResult::all();
        $questions = Question::all();
        return view('admin.answers.create', compact('quizResults', 'questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'quiz_result_id' => 'required|exists:quiz_results,id',
            'question_id' => 'required|exists:questions,id',
            'selected_answer' => 'required|string',
        ]);

        $correctAnswer = Question::find($request->question_id)->correct_answer;
        $isCorrect = $correctAnswer == $request->selected_answer;

        Answer::create([
            'quiz_result_id' => $request->quiz_result_id,
            'question_id' => $request->question_id,
            'selected_answer' => $request->selected_answer,
            'is_correct' => $isCorrect,
        ]);

        return redirect()->route('admin.answers.index')->with('success', 'Answer created successfully.');
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();
        return redirect()->route('admin.answers.index')->with('success', 'Answer deleted successfully.');
    }
}
