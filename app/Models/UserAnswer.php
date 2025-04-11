<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_result_id',
        'question_id',
        'answer_id',
        'is_correct',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'is_correct' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quizResult()
    {
        return $this->belongsTo(QuizResult::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
