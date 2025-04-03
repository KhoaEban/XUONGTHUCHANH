<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'video_url',
        'content',
        'order_number',
        'slug'
    ];

    // Quan hệ với Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Quan hệ với Instructor thông qua Course (giả sử instructor_id nằm trong bảng courses)
    public function instructor()
    {
        return $this->course->belongsTo(User::class, 'instructor_id'); // Liên kết đến bảng users qua trường instructor_id trong bảng courses
    }

    // Mỗi quan hệ quizzes với bài kiểm tra
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }


    // Slug
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });

        static::updating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }
}
