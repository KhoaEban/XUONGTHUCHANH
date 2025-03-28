<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Quiz;
use App\Models\Course;

class QuizControllerAdmin extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $quizzes = Quiz::paginate(10);
        return view('admin.quizzes.index', compact('quizzes', 'courses'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.quizzes.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255|unique:quizzes,title',
        ]);

        $slug = Str::slug($request->title);
        $count = Quiz::where('slug', 'LIKE', "$slug%")->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        Quiz::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz created successfully.');
    }

    public function edit(Quiz $quiz)
    {
        $courses = Course::all();
        return view('admin.quizzes.edit', compact('quiz', 'courses'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:quizzes,title,' . $quiz->id,
        ]);

        $quiz->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title), // Cập nhật slug tự động
        ]);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
}
