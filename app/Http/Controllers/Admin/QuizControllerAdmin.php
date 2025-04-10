<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Quiz;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Answer;

class QuizControllerAdmin extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $lessons = Lesson::all();
        $quizzes = Quiz::paginate(10);
        return view('admin.quizzes.index', compact('quizzes', 'courses', 'lessons'));
    }

    public function create()
    {
        $courses = Course::all();
        $lessons = Lesson::all();
        return view('admin.quizzes.create', compact('courses', 'lessons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'questions' => 'required|array',
            'questions.*.question_text' => 'required|string',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*.answer_text' => 'required|string',
            'questions.*.answers.*.is_correct' => 'required|boolean',
        ]);

        DB::transaction(function () use ($validated) {
            // Tạo Quiz
            $quiz = Quiz::create([
                'course_id' => $validated['course_id'],
                'lesson_id' => $validated['lesson_id'],
                'title' => $validated['title'],
            ]);

            // Tạo Questions và Answers
            foreach ($validated['questions'] as $questionData) {
                $question = Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionData['question_text'],
                ]);

                foreach ($questionData['answers'] as $answerData) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer_text' => $answerData['answer_text'],
                        'is_correct' => $answerData['is_correct'],
                    ]);
                }
            }
        });

        return redirect()->route('admin.quizzes.index')->with('success', 'Đã tạo thành công!');
    }

    public function edit($id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        $courses = \App\Models\Course::all(); // Giả sử bạn có model Course
        $lessons = \App\Models\Lesson::where('course_id', $quiz->course_id)->get(); // Load lessons theo course_id

        return view('admin.quizzes.edit', compact('quiz', 'courses', 'lessons'));
    }

    // Xử lý cập nhật
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'questions' => 'required|array',
            'questions.*.question_text' => 'required|string',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*.answer_text' => 'required|string',
            'questions.*.answers.*.is_correct' => 'required|boolean',
        ]);

        DB::transaction(function () use ($validated, $id) {
            // Cập nhật Quiz
            $quiz = Quiz::findOrFail($id);
            $quiz->update([
                'course_id' => $validated['course_id'],
                'lesson_id' => $validated['lesson_id'],
                'title' => $validated['title'],
            ]);

            // Lấy danh sách ID của questions và answers hiện tại để so sánh
            $existingQuestionIds = $quiz->questions->pluck('id')->toArray();
            $existingAnswerIds = $quiz->questions->flatMap->answers->pluck('id')->toArray();

            $submittedQuestionIds = [];
            $submittedAnswerIds = [];

            // Cập nhật hoặc tạo mới Questions và Answers
            foreach ($validated['questions'] as $qIndex => $questionData) {
                if (isset($questionData['id'])) {
                    // Cập nhật question hiện có
                    $question = Question::find($questionData['id']);
                    if ($question) {
                        $question->update(['question_text' => $questionData['question_text']]);
                        $submittedQuestionIds[] = $question->id;
                    }
                } else {
                    // Tạo mới question
                    $question = Question::create([
                        'quiz_id' => $quiz->id,
                        'question_text' => $questionData['question_text'],
                    ]);
                    $submittedQuestionIds[] = $question->id;
                }

                foreach ($questionData['answers'] as $aIndex => $answerData) {
                    if (isset($answerData['id'])) {
                        // Cập nhật answer hiện có
                        $answer = Answer::find($answerData['id']);
                        if ($answer) {
                            $answer->update([
                                'answer_text' => $answerData['answer_text'],
                                'is_correct' => $answerData['is_correct'],
                            ]);
                            $submittedAnswerIds[] = $answer->id;
                        }
                    } else {
                        // Tạo mới answer
                        $answer = Answer::create([
                            'question_id' => $question->id,
                            'answer_text' => $answerData['answer_text'],
                            'is_correct' => $answerData['is_correct'],
                        ]);
                        $submittedAnswerIds[] = $answer->id;
                    }
                }
            }

            // Xóa các questions không còn trong form
            $questionsToDelete = array_diff($existingQuestionIds, $submittedQuestionIds);
            Question::whereIn('id', $questionsToDelete)->delete();

            // Xóa các answers không còn trong form
            $answersToDelete = array_diff($existingAnswerIds, $submittedAnswerIds);
            Answer::whereIn('id', $answersToDelete)->delete();
        });

        return redirect()->route('admin.quizzes.index')->with('success', 'Đã cập nhật thành công!');
    }

    public function getLessons($courseId)
    {
        $lessons = Lesson::where('course_id', $courseId)->get();
        return response()->json($lessons);
    }


    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
}
