<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;

class AnswerControllerAdmin extends Controller
{
    // Hiển thị danh sách câu trả lời
    public function index()
    {
        $answers = Answer::with('question')->orderBy('id', 'desc')->get();
        return view('admin.answers.index', compact('answers'));
    }

    // Form tạo mới
    public function create()
    {
        $quizzes = Quiz::all();
        return view('admin.answers.create', compact('quizzes'));
    }

    // Lưu câu trả lời mới
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        $slug = $this->uniqueSlug($request->answer_text);

        Answer::create([
            'question_id' => $request->question_id,
            'answer_text' => $request->answer_text,
            'is_correct' => $request->is_correct,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.answers.index')->with('success', 'Câu trả lời đã được thêm thành công.');
    }

    // Form chỉnh sửa
    public function edit(Answer $answer)
    {
        $quizzes = Quiz::all();
        $questions = Question::where('quiz_id', optional($answer->question)->quiz_id)->get();
        return view('admin.answers.edit', compact('answer', 'quizzes', 'questions'));
    }

    // Cập nhật câu trả lời
    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'answer_text' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        $slug = $this->uniqueSlug($request->answer_text, $answer->id);

        $answer->update([
            'answer_text' => $request->answer_text,
            'slug' => $slug,
            'is_correct' => $request->is_correct,
        ]);

        return redirect()->route('admin.answers.index')->with('success', 'Câu trả lời đã được cập nhật.');
    }

    // Xóa câu trả lời
    public function destroy(Answer $answer)
    {
        if ($answer) {
            $answer->delete();
            return redirect()->route('admin.answers.index')->with('success', 'Câu trả lời đã bị xóa.');
        }
        return redirect()->route('admin.answers.index')->with('error', 'Không tìm thấy câu trả lời.');
    }

    // Lấy danh sách câu hỏi theo quiz_id (AJAX)
    public function getQuestionsByQuiz($quizId)
    {
        $questions = Question::where('quiz_id', $quizId)->get();
        return response()->json($questions);
    }

    // Hàm tạo slug không trùng lặp
    private function uniqueSlug($text, $ignoreId = null)
    {
        $slug = Str::slug($text);
        $query = Answer::where('slug', 'LIKE', "$slug%");

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $count = $query->count();
        return $count ? $slug . '-' . ($count + 1) : $slug;
    }
}
