<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'slug'
    ];

    // Định nghĩa khóa chính bằng slug để tự động tìm kiếm theo slug thay vì id
    public function getRouteKeyName()
    {
        return 'slug';
    }

  // In App\Models\Course.php
public function instructor()
{
    return $this->belongsTo(User::class, 'instructor_id'); // Assuming you have an 'instructor_id' foreign key in your 'courses' table
}

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
<<<<<<< Updated upstream
=======

    public function isPaidByUser($userId)
    {
        
        return Payment::where('user_id', $userId)
            ->where('course_id', $this->id)
            ->where('status', 'completed')
            ->exists();
    }
<<<<<<< Updated upstream
    
>>>>>>> Stashed changes
=======
    public function enrollments()
{
    return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id');
}
public function progress()
{
    return $this->hasMany(CourseProgress::class);
}
>>>>>>> Stashed changes
}
