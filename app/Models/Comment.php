<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Comment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
        'lesson_id',
        'parent_id',
        'status',
        'comments_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    // Quan hệ trả lời bình luận
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Quan hệ bình luận gốc
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }

    public function unlike()
    {
        // Giảm số lên thích xuong 1
        $this->decrement('likes_count');
    }
}
