<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    use HasFactory;

    protected $table = 'course_progresses'; // Explicitly define the table name

    protected $fillable = [
        'user_id',
        'course_id',
        'completed_lessons',
    ];

    protected $casts = [
        'completed_lessons' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getProgressPercentage()
    {
        $totalLessons = $this->course->lessons()->count();
        $completedLessons = count($this->completed_lessons ?? []);

        return $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 2) : 0;
    }
}
