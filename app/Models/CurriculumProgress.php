<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumProgress extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);//多対1
    }

    public function curriculum()
    {
        return $this->belongsTo(User::class);//多対1
    }
}
