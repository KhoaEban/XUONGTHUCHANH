<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\QuizResult;
use App\Models\UserAnswer;
use App\Notifications\AllQuizzesCompletedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

        return DB::transaction(function () use ($request, $quiz, $answers) {
            // Tạo bản ghi trong quiz_results
            $quizResult = QuizResult::create([
                'user_id' => Auth::id(),
                'quiz_id' => $quiz->id,
                'total_questions' => $quiz->questions->count(),
                'taken_at' => now(),
                'score' => 0, // Ban đầu đặt score là 0 (in_progress)
                'slug' => Str::slug($quiz->title . '-' . Auth::id() . '-' . time()),
            ]);

            $score = 0;
            $total = $quiz->questions->count();
            $details = [];

            // Lưu chi tiết câu trả lời vào user_answers
            foreach ($quiz->questions as $question) {
                $userAnswerId = $answers[$question->id] ?? null;
                $correctAnswer = $question->answers->where('is_correct', 1)->first();

                $isCorrect = ($userAnswerId == optional($correctAnswer)->id);

                if ($isCorrect) $score++;

                UserAnswer::create([
                    'user_id' => Auth::id(),
                    'quiz_result_id' => $quizResult->id,
                    'question_id' => $question->id,
                    'answer_id' => $userAnswerId,
                    'is_correct' => $isCorrect,
                    'submitted_at' => now(),
                ]);

                $details[] = [
                    'question' => $question->question_text,
                    'your_answer' => optional(Answer::find($userAnswerId))->answer_text,
                    'correct_answer' => optional($correctAnswer)->answer_text,
                    'is_correct' => $isCorrect,
                ];
            }

            // Cập nhật điểm số (score > 0 nghĩa là completed)
            $quizResult->update([
                'score' => ($score / $total) * 10, // Thang điểm 10
            ]);

            // Lấy course_id từ quiz
            $courseId = $quiz->lesson->course_id;

            // Kiểm tra xem học viên đã hoàn thành tất cả bài quiz trong khóa học chưa
            $user = Auth::user();
            if ($courseId && $user->hasCompletedAllQuizzesInCourse($courseId)) {
                $course = \App\Models\Course::findOrFail($courseId);
                $user->notify(new AllQuizzesCompletedNotification($course));
            }

            return view('user.quizzes.result', [
                'quiz' => $quiz,
                'score' => $score,
                'total' => $total,
                'details' => $details,
            ]);
        });
    }
}
