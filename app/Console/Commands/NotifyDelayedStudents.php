<?php

namespace App\Console\Commands;

use App\Models\QuizResult;
use App\Notifications\QuizDelayNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class NotifyDelayedStudents extends Command
{
    protected $signature = 'notify:delayed-students';
    protected $description = 'Notify students who have delayed completing their quizzes';

    public function handle()
    {
        $delayThreshold = 24; // Ngưỡng trì hoãn: 24 giờ

        // Tìm các bài làm chưa hoàn thành và đã quá thời gian trì hoãn
        $delayedResults = QuizResult::where('score', 0) // Chưa hoàn thành
            ->whereNotNull('taken_at')
            ->where('taken_at', '<', Carbon::now()->subHours($delayThreshold))
            ->with('user', 'quiz')
            ->get();

        foreach ($delayedResults as $result) {
            $user = $result->user;
            $quiz = $result->quiz;

            // Gửi thông báo cho học viên
            $user->notify(new QuizDelayNotification($quiz));
            $this->info("Sent notification to user {$user->id} for quiz {$quiz->id}");
        }

        $this->info('Finished checking delayed students.');
    }
}
