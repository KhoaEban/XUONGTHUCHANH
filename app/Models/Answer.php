<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['question_id', 'answer_text', 'selected_answer', 'is_correct'];

    public function quizResult()
    {
        return $this->belongsTo(QuizResult::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
