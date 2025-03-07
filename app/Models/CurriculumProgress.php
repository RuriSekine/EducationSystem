<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Curriculum;

class CurriculumProgress extends Model
{
    use HasFactory;

    protected $table = 'curriculum_progress';

    protected $fillable = ['curriculums_id', 'users_id', 'clear_flg'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');//多対1
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculums_id');//多対1
    }
}
