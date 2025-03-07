<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grade;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'title',
        'description',
        'video_url',
        'thumbnail',
        'alway_delivery_flg',
        'grade_id',
    ];

    // 学年とのリレーション（多対1）
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    // 進捗とのリレーション（1対多）
    public function progress()
    {
        return $this->hasMany(CurriculumProgress::class, 'curriculums_id');
    }
}
