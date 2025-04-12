<?php

namespace App\Notifications;

use App\Models\Quiz;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InstructorReminderNotification extends Notification
{
    use Queueable;

    protected $quiz;
    protected $instructorName;

    public function __construct(Quiz $quiz, $instructorName)
    {
        $this->quiz = $quiz;
        $this->instructorName = $instructorName;
    }

    public function via($notifiable)
    {
        return ['database']; // Lưu thông báo vào database để hiển thị trên navbar
    }

    public function toDatabase($notifiable)
    {
        return [
            'quiz_id' => $this->quiz->id,
            'quiz_title' => $this->quiz->title,
            'instructor_name' => $this->instructorName,
            'message' => "Giảng viên {$this->instructorName} nhắc bạn hoàn thành bài quiz: {$this->quiz->title}",
            'action_url' => route('quizzes.show', $this->quiz->id),
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'quiz_id' => $this->quiz->id,
            'quiz_title' => $this->quiz->title,
            'instructor_name' => $this->instructorName,
            'message' => "Giảng viên {$this->instructorName} nhắc bạn hoàn thành bài quiz: {$this->quiz->title}",
        ];
    }
}
