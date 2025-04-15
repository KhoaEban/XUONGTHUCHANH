<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    //
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isTeacher()
    {
        return $this->role === 'instructor';
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function hasCompletedAllQuizzesInCourse($courseId)
    {
        // Lấy danh sách tất cả bài học có quiz của khóa học
        $lessonQuizzes = \App\Models\Lesson::where('course_id', $courseId)
            ->whereHas('quizzes')
            ->pluck('id');

        if ($lessonQuizzes->isEmpty()) {
            return false;
        }

        $totalQuizzes = \App\Models\Quiz::whereIn('lesson_id', $lessonQuizzes)->count();

        $completedQuizzes = $this->quizResults()
            ->whereIn('quiz_id', function ($query) use ($lessonQuizzes) {
                $query->select('id')
                    ->from('quizzes')
                    ->whereIn('lesson_id', $lessonQuizzes);
            })
            ->count();

        return $totalQuizzes > 0 && $completedQuizzes >= $totalQuizzes;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
