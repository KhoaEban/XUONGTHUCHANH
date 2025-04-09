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

    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    // Quan hệ bình luận gốc
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($comment) {
            $comment->replies()->delete(); // Xóa tất cả bình luận con khi xóa bình luận cha
        });
    }

    public function likes()
    {
        return $this->hasMany(CommentLike::class, 'comment_id');
    }


    public function unlike()
    {
        // Giảm số lên thích xuong 1
        $this->decrement('likes_count');
    }
}
