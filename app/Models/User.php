<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    //
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Thêm role vào fillable để có thể cập nhật
    ];

    public function hasRole($role)
    {
        // Implement your role checking logic here
        return $this->role === $role;
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin'; // Kiểm tra nếu role là admin
    }
    public function isTeacher()
    {
        return $this->role === 'instructor';
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function courseReviews() {
        return $this->hasMany(CourseReview::class);
    }
}
