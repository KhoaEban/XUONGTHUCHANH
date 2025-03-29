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

    // Mối quan hệ với khóa học
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Lấy giảng viên từ khóa học
    public function instructor()
    {
        return $this->course->instructor();
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
