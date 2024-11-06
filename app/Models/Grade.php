<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;



    public function user()
    {
        return $this->belongsTo(User::class);//1対1,1対多
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);//1対多
    }
}
