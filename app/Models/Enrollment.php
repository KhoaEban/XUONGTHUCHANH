<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    public $timestamps = false;


    protected $fillable = [
        'user_id',
        'course_id',
        'payment_id',
        'status',
        'enrolled_at',
        'slug'
    ];

    // Relationship with User
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }


    public function isActive()
    {
        return $this->status === 'active';
    }


    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function getFormattedEnrollmentDate()
    {
        // Chuyển đổi enrolled_at thành Carbon nếu nó không phải là một đối tượng Carbon
        return $this->enrolled_at ? \Carbon\Carbon::parse($this->enrolled_at)->format('d/m/Y H:i') : null;
    }

    protected $dates = [
        'enrolled_at',
    ];
}
