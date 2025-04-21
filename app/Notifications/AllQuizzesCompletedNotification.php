<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AllQuizzesCompletedNotification extends Notification
{
    use Queueable;

    protected $course;

    public function __construct($course)
    {
        $this->course = $course;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Chúc mừng! Bạn đã hoàn thành tất cả bài quiz trong khóa học')
            ->line('Bạn đã hoàn thành tất cả bài quiz trong khóa học "' . $this->course->title . '".')
            ->action('Xem khóa học', route('course.show', $this->course->slug))
            ->line('Cảm ơn bạn đã tham gia học tập!');
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'message' => 'Bạn đã hoàn thành tất cả bài quiz trong khóa học "' . $this->course->title . '".',
            'course_id' => $this->course->id,
            'url' => route('course.show', $this->course->slug),
        ]);
    }
}
