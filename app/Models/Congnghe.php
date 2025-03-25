<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Congnghe extends Model
{
    use HasFactory;
    /**
     * Get the congnghes for the bomon.
     */
    public function nganhhocs(){
        return $this->hasMany(NganhHoc::class, 'CongNgheID');
    }

    public function khoa(){
        return $this->belongsTo(Khoa::class, 'KhoaID');
    }
}
