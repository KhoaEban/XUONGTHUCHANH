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

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
