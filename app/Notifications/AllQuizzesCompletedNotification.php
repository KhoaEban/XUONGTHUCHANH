<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

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
            ->subject('Chúc mừng bạn đã hoàn thành tất cả bài quiz trong khóa học!')
            ->greeting('Xin chào ' . $notifiable->name . ',')
            ->line("Chúc mừng bạn đã hoàn thành tất cả các bài quiz trong khóa học: **{$this->course->title}**!")
            ->line('Cảm ơn bạn đã nỗ lực học tập. Tiếp tục phát huy nhé!')
            ->action('Xem hồ sơ', route('user.profile'))
            ->line('Trân trọng,');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Bạn đã hoàn thành tất cả bài quiz trong khóa học: {$this->course->title}!",
            'action_url' => route('user.profile'),
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Bạn đã hoàn thành tất cả bài quiz trong khóa học: {$this->course->title}!",
        ];
    }
}
