<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function enrollment()
    {
        return $this->hasOne(Enrollment::class, 'payment_id');
    }

    // Nếu bạn vẫn muốn có danh sách các enrollments liên quan đến user và course
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id', 'course_id')->where('user_id', $this->user_id);
    }

    // Nếu bạn vẫn muốn có latest Enrollment
    public function latestEnrollment() {
        return $this->enrollments()->latest()->first();
    }
}
