<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;


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

    // app/Models/User.php
    public function hasCompletedAllQuizzesInCourse($courseId)
    {
        $course = Course::findOrFail($courseId);
        $quizIds = $course->lessons->flatMap->quizzes->pluck('id')->toArray();
        $passingScore = 7;

        Log::info('Quizzes in course ' . $courseId . ': ' . json_encode($quizIds));

        $completedQuizzes = QuizResult::where('user_id', $this->id)
            ->whereIn('quiz_id', $quizIds)
            ->where('score', '>=', $passingScore)
            ->pluck('quiz_id')
            ->toArray();

        Log::info('Completed quizzes for user ' . $this->id . ': ' . json_encode($completedQuizzes));

        return count($quizIds) > 0 && count(array_diff($quizIds, $completedQuizzes)) === 0;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
