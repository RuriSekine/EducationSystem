<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassesClearCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'grade_id',
        'clear_flg'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);//多対1
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);//多対1
    }
}
