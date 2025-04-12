<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Notifications\InstructorReminderNotification;
use Illuminate\Support\Facades\Auth;
use App\Models\QuizResult;

class ProgressController extends Controller
{
    public function index()
    {
        $progresses = QuizResult::with('user', 'quiz')->get();
        return view('instructor.student_management.progress', compact('progresses'));
    }

    public function detail($userId, $quizId)
    {
        $progress = QuizResult::where('user_id', $userId)->where('quiz_id', $quizId)
            ->with('user', 'quiz', 'userAnswers')->firstOrFail();
        return view('instructor.student_management.progress-detail', compact('progress'));
    }

    public function notify($userId, $quizId)
    {
        $progress = QuizResult::where('user_id', $userId)->where('quiz_id', $quizId)
            ->with('user', 'quiz')->firstOrFail();

        // Kiểm tra trạng thái, chỉ gửi thông báo nếu chưa hoàn thành (score = 0)
        if ($progress->score == 0) { // Thay $progress->status !== 'completed' bằng $progress->score == 0
            $instructorName = Auth::user()->name;
            $progress->user->notify(new InstructorReminderNotification($progress->quiz, $instructorName));
            return redirect()->back()->with('success', 'Đã gửi thông báo nhắc nhở cho học viên.');
        }

        return redirect()->back()->with('error', 'Học viên đã hoàn thành bài quiz, không cần nhắc nhở.');
    }
}
