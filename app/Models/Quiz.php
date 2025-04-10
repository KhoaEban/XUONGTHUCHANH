<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'lesson_id', 'title', 'slug'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    // Slug
    public static function boot()
    {
        parent::boot();

        static::creating(function ($quiz) {
            $quiz->slug = Str::slug($quiz->title);
        });

        static::updating(function ($quiz) {
            $quiz->slug = Str::slug($quiz->title);
        });
    }
}
