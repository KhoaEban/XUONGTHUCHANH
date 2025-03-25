<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class khoa extends Model
{
    use HasFactory;

    public function congnghes()
    {
        return $this->hasMany(CongNghe::class, 'KhoaID');
    }

}
