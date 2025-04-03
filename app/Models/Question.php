<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'question_text', 'slug', 'correct_answer'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($question) {
            $question->slug = Str::slug($question->question_text);
        });

        static::updating(function ($question) {
            $question->slug = Str::slug($question->question_text);
        });
    }

    // Quan hệ với bảng options (Lựa chọn)
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    // Quan hệ với bảng quiz (Bài kiểm tra)
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
