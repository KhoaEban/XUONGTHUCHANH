<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;

class QuizControllerInstructor extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách quiz thuộc các khóa học của giảng viên
        $query = Quiz::whereHas('course', function ($q) {
            $q->where('instructor_id', Auth::id());
        })->with(['course', 'lesson']);

        // Lọc theo từ khóa tìm kiếm
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        // Lọc theo khóa học
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Lọc theo bài học
        if ($request->filled('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }

        // Sắp xếp
        $query->orderBy('created_at', 'desc');
        $quizzes = $query->paginate(10);

        // Lấy danh sách khóa học của giảng viên để lọc
        $courses = Course::where('instructor_id', Auth::id())->get();

        return view('instructor.quizzes.index', compact('quizzes', 'courses'));
    }

    public function create()
    {
        // Lấy danh sách khóa học của giảng viên
        $courses = Course::where('instructor_id', Auth::id())->get();
        return view('instructor.quizzes.create', compact('courses'));
    }

    public function store(Request $request)
    {
        // Tự kiểm tra lỗi trước khi lưu dữ liệu
        $errors = [];

        if (!$request->course_id || !Course::where('id', $request->course_id)->where('instructor_id', Auth::id())->exists()) {
            $errors['course_id'] = 'Khóa học không hợp lệ hoặc không thuộc giảng viên.';
        }

        if (!$request->lesson_id || !Lesson::where('id', $request->lesson_id)->where('course_id', $request->course_id)->exists()) {
            $errors['lesson_id'] = 'Bài học không hợp lệ hoặc không thuộc khóa học.';
        }

        if (empty($request->title)) {
            $errors['title'] = 'Tiêu đề không được để trống.';
        }

        if (!isset($request->questions) || !is_array($request->questions)) {
            $errors['questions'] = 'Quiz phải có ít nhất một câu hỏi.';
        } else {
            foreach ($request->questions as $index => $qData) {
                if (empty($qData['question_text'])) {
                    $errors["questions.$index.question_text"] = 'Nội dung câu hỏi không được để trống.';
                }

                if (!isset($qData['answers']) || !is_array($qData['answers'])) {
                    $errors["questions.$index.answers"] = 'Câu hỏi phải có ít nhất một câu trả lời.';
                } else {
                    $correctAnswers = 0;
                    foreach ($qData['answers'] as $aIndex => $aData) {
                        if (empty($aData['answer_text'])) {
                            $errors["questions.$index.answers.$aIndex.answer_text"] = 'Câu trả lời không được để trống.';
                        }
                        if (isset($aData['is_correct']) && $aData['is_correct'] == true) {
                            $correctAnswers++;
                        }
                    }
                    if ($correctAnswers == 0) {
                        $errors["questions.$index.correct"] = 'Phải có ít nhất một câu trả lời đúng.';
                    }
                }
            }
        }

        // Nếu có lỗi, trả về trang trước với thông báo lỗi
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Tiếp tục lưu dữ liệu nếu không có lỗi
        $quiz = Quiz::create([
            'course_id' => $request->course_id,
            'lesson_id' => $request->lesson_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
        ]);

        foreach ($request->questions as $qData) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $qData['question_text'],
            ]);

            foreach ($qData['answers'] as $aData) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $aData['answer_text'],
                    'is_correct' => $aData['is_correct'],
                ]);
            }
        }

        return redirect()->route('instructor.quizzes.index')->with('success', 'Quiz đã được tạo!');
    }


    public function edit($id)
    {
        // Lấy quiz và kiểm tra quyền truy cập
        $quiz = Quiz::where('id', $id)
            ->whereHas('course', function ($q) {
                $q->where('instructor_id', Auth::id());
            })
            ->with(['course', 'lesson', 'questions.answers'])
            ->firstOrFail();

        $courses = Course::where('instructor_id', Auth::id())->get();
        $lessons = Lesson::where('course_id', $quiz->course_id)->get();

        return view('instructor.quizzes.edit', compact('quiz', 'courses', 'lessons'));
    }

    public function update(Request $request, $id)
    {
        $errors = [];

        // Kiểm tra Quiz có thuộc giảng viên hay không
        $quiz = Quiz::where('id', $id)->whereHas('course', function ($q) {
            $q->where('instructor_id', Auth::id());
        })->firstOrFail();

        if (!$request->course_id || !Course::where('id', $request->course_id)->where('instructor_id', Auth::id())->exists()) {
            $errors['course_id'] = 'Khóa học không hợp lệ hoặc không thuộc giảng viên.';
        }

        if (!$request->lesson_id || !Lesson::where('id', $request->lesson_id)->where('course_id', $request->course_id)->exists()) {
            $errors['lesson_id'] = 'Bài học không hợp lệ hoặc không thuộc khóa học.';
        }

        if (empty($request->title)) {
            $errors['title'] = 'Tiêu đề không được để trống.';
        }

        if (!isset($request->questions) || !is_array($request->questions)) {
            $errors['questions'] = 'Quiz phải có ít nhất một câu hỏi.';
        } else {
            foreach ($request->questions as $index => $qData) {
                if (empty($qData['question_text'])) {
                    $errors["questions.$index.question_text"] = 'Nội dung câu hỏi không được để trống.';
                }

                if (!isset($qData['answers']) || !is_array($qData['answers'])) {
                    $errors["questions.$index.answers"] = 'Câu hỏi phải có ít nhất một câu trả lời.';
                } else {
                    $correctAnswers = 0;
                    foreach ($qData['answers'] as $aIndex => $aData) {
                        if (empty($aData['answer_text'])) {
                            $errors["questions.$index.answers.$aIndex.answer_text"] = 'Câu trả lời không được để trống.';
                        }
                        if (isset($aData['is_correct']) && $aData['is_correct'] == true) {
                            $correctAnswers++;
                        }
                    }
                    if ($correctAnswers == 0) {
                        $errors["questions.$index.correct"] = 'Phải có ít nhất một câu trả lời đúng.';
                    }
                }
            }
        }

        // Nếu có lỗi, trả về trang trước với thông báo lỗi
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Xóa câu hỏi và đáp án cũ
        foreach ($quiz->questions as $question) {
            $question->answers()->delete();
            $question->delete();
        }

        // Cập nhật Quiz và tạo mới câu hỏi, đáp án
        $quiz->update([
            'course_id' => $request->course_id,
            'lesson_id' => $request->lesson_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
        ]);

        foreach ($request->questions as $qData) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $qData['question_text'],
            ]);

            foreach ($qData['answers'] as $aData) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $aData['answer_text'],
                    'is_correct' => $aData['is_correct'],
                ]);
            }
        }

        return redirect()->route('instructor.quizzes.index')->with('success', 'Quiz đã được cập nhật!');
    }

    public function destroy($id)
    {
        // Lấy quiz và kiểm tra quyền truy cập
        $quiz = Quiz::where('id', $id)
            ->whereHas('course', function ($q) {
                $q->where('instructor_id', Auth::id());
            })
            ->firstOrFail();

        // Xóa câu hỏi và đáp án liên quan
        foreach ($quiz->questions as $question) {
            $question->answers()->delete();
            $question->delete();
        }

        $quiz->delete();

        return redirect()->route('instructor.quizzes.index')->with('success', 'Quiz đã được xóa!');
    }

    public function getLessons($courseId)
    {
        // Chỉ lấy bài học của khóa học thuộc giảng viên
        $course = Course::where('id', $courseId)
            ->where('instructor_id', Auth::id())
            ->firstOrFail();

        $lessons = Lesson::where('course_id', $courseId)->get();
        return response()->json($lessons);
    }
}
