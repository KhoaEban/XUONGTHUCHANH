<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\UserAnswer;



class QuizControllerInstructor extends Controller
{
    public function show($id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        return view('student.quiz', compact('quiz'));
    }

    public function submit(Request $request, $id)
    {
        $user = Auth::user();
        $quiz = Quiz::with('questions.answers')->findOrFail($id);

        DB::transaction(function () use ($request, $user, $quiz) {
            // Tạo hoặc cập nhật bản ghi trong quiz_results
            $quizResult = QuizResult::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'quiz_id' => $quiz->id,
                ],
                [
                    'total_questions' => $quiz->questions->count(),
                    'taken_at' => now(),
                    'score' => 0, // Ban đầu đặt score là 0 (in_progress)
                    'slug' => Str::slug($quiz->title . '-' . $user->id . '-' . time()),
                ]
            );

            $totalQuestions = $quiz->questions->count();
            $correctAnswers = 0;

            // Lưu từng câu trả lời vào user_answers
            foreach ($quiz->questions as $question) {
                $submittedAnswerId = $request->input("answers.{$question->id}");
                $correctAnswer = $question->answers->where('is_correct', 1)->first();

                $isCorrect = $submittedAnswerId && $correctAnswer && $submittedAnswerId == $correctAnswer->id;

                UserAnswer::create([
                    'user_id' => $user->id,
                    'quiz_result_id' => $quizResult->id,
                    'question_id' => $question->id,
                    'answer_id' => $submittedAnswerId,
                    'is_correct' => $isCorrect,
                    'submitted_at' => now(),
                ]);

                if ($isCorrect) $correctAnswers++;
            }

            // Cập nhật điểm số (score > 0 nghĩa là completed)
            $score = ($correctAnswers / $totalQuestions) * 10; // Thang điểm 10
            $quizResult->update([
                'score' => $score,
            ]);
        });

        return redirect()->route('student.quiz.result', $quiz->id)->with('success', 'Đã nộp bài thành công!');
    }

    public function result($id)
    {
        $quiz = Quiz::findOrFail($id);
        $result = QuizResult::where('user_id', Auth::id())->where('quiz_id', $id)->firstOrFail();
        $answers = UserAnswer::where('quiz_result_id', $result->id)->with('question', 'answer')->get();

        return view('student.quiz-result', compact('quiz', 'result', 'answers'));
    }
}
