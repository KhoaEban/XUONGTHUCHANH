<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Models
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Lesson;

class QuestionControllerAdmin extends Controller
{
    public function index()
    {
        $questions = Question::with('quiz')->get();
        $lessons = Lesson::all();
        $quizzes = Quiz::all();
        return view('admin.questions.index', compact('questions', 'lessons', 'quizzes'));
    }

    public function create()
    {
        $quizzes = Quiz::all();
        $lessons = Lesson::all();
        return view('admin.questions.create', compact('quizzes', 'lessons'));
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
        $lessons = Lesson::all();
        return view('admin.questions.edit', compact('question', 'quizzes', 'lessons'));
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

    public function getQuizzesByLesson($lessonId)
    {
        $quizzes = Quiz::where('lesson_id', $lessonId)->get();
        return response()->json($quizzes);
    }


    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully.');
    }
}
