<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name',
    ];


    public function users()
    {
        return $this->hasMany(User::class);//1対多
    }

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class);//1対多
    }

    public function classesClearChecks()
    {
        return $this->hasMany(ClassesClearCheck::class);//1対多
    }
}
