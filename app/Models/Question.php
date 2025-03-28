<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'content', 'correct_answer'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
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
