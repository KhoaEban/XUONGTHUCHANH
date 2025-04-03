<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    public $timestamps = false; // Disable timestamp management

    protected $fillable = [
        'user_id',
        'course_id',
        'status',       // Add status field
        'enrolled_at',  // Add enrolled_at field
        'slug',         // Add slug field
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Check if enrollment is active
    public function isActive()
    {
        return $this->status === 'active';
    }

    // Check if enrollment is completed
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    // Get formatted enrollment date
    public function getFormattedEnrollmentDate()
    {
        return $this->enrolled_at ? $this->enrolled_at->format('d/m/Y H:i') : null;
    }
}
