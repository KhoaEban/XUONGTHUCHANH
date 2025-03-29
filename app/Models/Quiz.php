<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'lesson_id', 'title', 'slug'];

    public function question()
    {
        return $this->hasMany(Question::class);
    }


    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // public function quiz_results()
    // {
    //     return $this->hasMany(Result::class);
    // }


    public function lessons()
    {
        return $this->course->lessons;
    }

    // Quan hệ với bảng questions (Câu hỏi)
    public function questions()
    {
        return $this->hasMany(Question::class);
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
