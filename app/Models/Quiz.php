<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'slug'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }


    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quiz_results()
    {
        return $this->hasMany(Result::class);
    }


    public function lessons()
    {
        return $this->course->lessons;
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
