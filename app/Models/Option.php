<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'text', 'is_correct'];

    // Quan hệ với bảng questions (Câu hỏi)
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
