<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'title',
        'description',
        'price',
        'category_id',
        'thumbnail',
        'slug',
        'is_free',
        'views',
    ];


    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    
    // Định nghĩa khóa chính bằng slug để tự động tìm kiếm theo slug thay vì id
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function isPaidByUser($userId)
    {
        return Payment::where('user_id', $userId)
            ->where('course_id', $this->id)
            ->where('status', 'completed')
            ->exists();
    }
}
