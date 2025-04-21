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
        $errors = [];

        if (!$request->filled('course_id') || !Course::find($request->course_id)) {
            $errors['course_id'] = 'Khóa học không hợp lệ.';
        }

        if (!$request->filled('lesson_id') || !Lesson::where('course_id', $request->course_id)->find($request->lesson_id)) {
            $errors['lesson_id'] = 'Bài học không hợp lệ hoặc không thuộc khóa học đã chọn.';
        }

        if (!$request->filled('title')) {
            $errors['title'] = 'Tiêu đề không được để trống.';
        }

        if (!isset($request->questions) || !is_array($request->questions) || empty($request->questions)) {
            $errors['questions'] = 'Quiz phải có ít nhất một câu hỏi.';
        } else {
            foreach ($request->questions as $index => $qData) {
                if (empty($qData['question_text'])) {
                    $errors["questions.$index.question_text"] = 'Nội dung câu hỏi không được để trống.';
                }

                if (!isset($qData['answers']) || !is_array($qData['answers']) || empty($qData['answers'])) {
                    $errors["questions.$index.answers"] = 'Câu hỏi phải có ít nhất một câu trả lời.';
                } else {
                    $correctAnswers = 0;
                    foreach ($qData['answers'] as $aIndex => $aData) {
                        if (empty($aData['answer_text'])) {
                            $errors["questions.$index.answers.$aIndex.answer_text"] = 'Câu trả lời không được để trống.';
                        }
                        if ($aData['is_correct'] ?? false) {
                            $correctAnswers++;
                        }
                    }
                    if ($correctAnswers == 0) {
                        $errors["questions.$index.correct"] = 'Phải có ít nhất một câu trả lời đúng.';
                    }
                }
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        DB::transaction(function () use ($request) {
            // Tạo Quiz
            $quiz = Quiz::create([
                'course_id' => $request->course_id,
                'lesson_id' => $request->lesson_id,
                'title' => $request->title,
            ]);

            // Tạo Questions và Answers
            foreach ($request->questions as $questionData) {
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
        $errors = [];

        $quiz = Quiz::findOrFail($id);

        if (!$request->filled('course_id') || !Course::find($request->course_id)) {
            $errors['course_id'] = 'Khóa học không hợp lệ.';
        }

        if (!$request->filled('lesson_id') || !Lesson::where('course_id', $request->course_id)->find($request->lesson_id)) {
            $errors['lesson_id'] = 'Bài học không hợp lệ hoặc không thuộc khóa học đã chọn.';
        }

        if (!$request->filled('title')) {
            $errors['title'] = 'Tiêu đề không được để trống.';
        }

        if (!isset($request->questions) || !is_array($request->questions) || empty($request->questions)) {
            $errors['questions'] = 'Quiz phải có ít nhất một câu hỏi.';
        } else {
            foreach ($request->questions as $index => $qData) {
                if (empty($qData['question_text'])) {
                    $errors["questions.$index.question_text"] = 'Nội dung câu hỏi không được để trống.';
                }

                if (!isset($qData['answers']) || !is_array($qData['answers']) || empty($qData['answers'])) {
                    $errors["questions.$index.answers"] = 'Câu hỏi phải có ít nhất một câu trả lời.';
                } else {
                    $correctAnswers = 0;
                    foreach ($qData['answers'] as $aIndex => $aData) {
                        if (empty($aData['answer_text'])) {
                            $errors["questions.$index.answers.$aIndex.answer_text"] = 'Câu trả lời không được để trống.';
                        }
                        if ($aData['is_correct'] ?? false) {
                            $correctAnswers++;
                        }
                    }
                    if ($correctAnswers == 0) {
                        $errors["questions.$index.correct"] = 'Phải có ít nhất một câu trả lời đúng.';
                    }
                }
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        DB::transaction(function () use ($request, $quiz) {
            // Cập nhật Quiz
            $quiz->update([
                'course_id' => $request->course_id,
                'lesson_id' => $request->lesson_id,
                'title' => $request->title,
            ]);

            // Xóa các câu hỏi và câu trả lời cũ
            foreach ($quiz->questions as $question) {
                $question->answers()->delete();
                $question->delete();
            }

            // Tạo lại Questions và Answers
            foreach ($request->questions as $questionData) {
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
