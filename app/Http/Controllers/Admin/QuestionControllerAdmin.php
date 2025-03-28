<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Question;
use App\Models\Quiz;

class QuestionControllerAdmin extends Controller
{
    public function index()
    {
        $questions = Question::with('quiz')->get();
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $quizzes = Quiz::all();
        return view('admin.questions.create', compact('quizzes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string|unique:questions,question_text',
            'correct_answer' => 'required|string',
        ]);

        $slug = Str::slug($request->question_text);
        $count = Question::where('slug', 'LIKE', "$slug%")->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        Question::create([
            'quiz_id' => $request->quiz_id,
            'question_text' => $request->question_text,
            'slug' => $slug,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully.');
    }

    public function edit(Question $question)
    {
        $quizzes = Quiz::all();
        return view('admin.questions.edit', compact('question', 'quizzes'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string|unique:questions,question_text,' . $question->id,
            'correct_answer' => 'required|string',
        ]);

        $slug = Str::slug($request->question_text);
        $count = Question::where('slug', 'LIKE', "$slug%")->where('id', '!=', $question->id)->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $question->update([
            'question_text' => $request->question_text,
            'slug' => $slug,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully.');
    }
}
