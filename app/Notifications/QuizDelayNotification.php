<?php

namespace App\Notifications;

use App\Models\Quiz;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class QuizDelayNotification extends Notification
{
    use Queueable;

    protected $quiz;

    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Thêm 'database' để lưu thông báo vào DB
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nhắc nhở hoàn thành bài Quiz: ' . $this->quiz->title)
            ->greeting('Xin chào ' . $notifiable->name . ',')
            ->line('Bạn đã bắt đầu làm bài quiz "' . $this->quiz->title . '" nhưng chưa hoàn thành.')
            ->line('Vui lòng hoàn thành bài quiz để không ảnh hưởng đến tiến độ học tập của bạn.')
            ->action('Làm bài ngay', route('quizzes.show', $this->quiz->id))
            ->line('Cảm ơn bạn đã chú ý!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'quiz_id' => $this->quiz->id,
            'quiz_title' => $this->quiz->title,
            'message' => 'Bạn đã trì hoãn hoàn thành bài quiz: ' . $this->quiz->title,
            'action_url' => route('quizzes.show', $this->quiz->id),
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'quiz_id' => $this->quiz->id,
            'quiz_title' => $this->quiz->title,
            'message' => 'Bạn đã trì hoãn hoàn thành bài quiz: ' . $this->quiz->title,
        ];
    }
}
