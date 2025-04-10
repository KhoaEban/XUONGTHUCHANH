<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizResult;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class QuizResultControllerAdmin extends Controller
{
    public function index()
    {
        $results = QuizResult::with(['quiz', 'user'])->get();

        foreach ($results as $result) {
            if ($result->total_questions > 0) {
                $result->percent = round(($result->score / $result->total_questions) * 100);
            } else {
                $result->percent = 0;
            }

            $result->is_completed = $result->percent === 100; // Kiểm tra hoàn thành 100%
        }

        return view('admin.quiz_results.index', compact('results'));
    }
    public function completed()
    {
        $results = QuizResult::with(['quiz', 'user'])->get()->filter(function ($result) {
            return $result->total_questions > 0 && ($result->score / $result->total_questions) == 1;
        });

        foreach ($results as $result) {
            $result->percent = round(($result->score / $result->total_questions) * 100);
            $result->is_completed = true;
        }

        return view('admin.quiz_results.completed', compact('results'));
    }


    public function create()
    {
        $quizzes = Quiz::all();
        $users = User::all();
        return view('admin.quiz_results.create', compact('quizzes', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'user_id' => 'required|exists:users,id',
            'score' => 'required|integer|min:0|max:100',
        ]);

        QuizResult::create($request->all());

        return redirect()->route('quiz_results.index')->with('success', 'Quiz result created successfully.');
    }

    public function edit(QuizResult $quizResult)
    {
        $quizzes = Quiz::all();
        $users = User::all();
        return view('admin.quiz_results.edit', compact('quizResult', 'quizzes', 'users'));
    }

    public function update(Request $request, QuizResult $quizResult)
    {
        $request->validate([
            'score' => 'required|integer|min:0|max:100',
        ]);

        $quizResult->update($request->all());

        return redirect()->route('quiz_results.index')->with('success', 'Quiz result updated successfully.');
    }

    public function destroy(QuizResult $quizResult)
    {
        $quizResult->delete();
        return redirect()->route('quiz_results.index')->with('success', 'Quiz result deleted successfully.');
    }
}
