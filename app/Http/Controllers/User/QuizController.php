<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\QuizResult;
use App\Models\UserAnswer;
use App\Models\CourseProgress;
use App\Notifications\AllQuizzesCompletedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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

            // Tính điểm số (thang điểm 10)
            $finalScore = ($score / $total) * 10;
            $quizResult->update(['score' => $finalScore]);

            // Xác định xem quiz có đạt yêu cầu (score >= 7)
            $passingScore = 7; // Có thể cấu hình trong .env hoặc config
            $quizPassed = $finalScore >= $passingScore;

            // Nếu quiz được vượt qua, cập nhật tiến độ khóa học
            if ($quizPassed) {
                $courseId = $quiz->lesson->course_id;
                $lessonId = $quiz->lesson->id;

                $progress = CourseProgress::firstOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'course_id' => $courseId,
                    ],
                    [
                        'completed_lessons' => [],
                    ]
                );

                $completedLessons = $progress->completed_lessons ?? [];
                if (!in_array($lessonId, $completedLessons)) {
                    $completedLessons[] = $lessonId;
                    $progress->completed_lessons = $completedLessons;
                    $progress->save();
                }

                // Kiểm tra xem học viên đã hoàn thành tất cả bài quiz trong khóa học chưa
                $user = Auth::user();
                if ($courseId && $user->hasCompletedAllQuizzesInCourse($courseId)) {
                    $course = \App\Models\Course::findOrFail($courseId);
                    Log::info('Triggering AllQuizzesCompletedNotification for user ' . $user->id . ' and course ' . $course->id);
                    $user->notify(new AllQuizzesCompletedNotification($course));
                }

                return redirect()->route('course.show', ['slug' => $quiz->lesson->course->slug])
                    ->with('success', 'Chúc mừng! Bạn đã vượt qua bài kiểm tra. Tiến độ khóa học đã được cập nhật.');
            }

            // Nếu không vượt qua, trả về view kết quả
            return view('user.quizzes.result', [
                'quiz' => $quiz,
                'score' => $score,
                'total' => $total,
                'details' => $details,
                'backUrl' => route('course.show', ['slug' => $quiz->lesson->course->slug]),
                'passed' => $quizPassed,
            ]);
        });
    }
}
