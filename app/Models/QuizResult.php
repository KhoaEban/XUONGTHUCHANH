<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_questions',
        'taken_at',
        'slug',
    ];

    protected $casts = [
        'taken_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'quiz_result_id');
    }

    // Xác định trạng thái dựa trên score
    public function getStatusAttribute()
    {
        return is_null($this->score) || $this->score == 0 ? 'in_progress' : 'completed';
    }
}
