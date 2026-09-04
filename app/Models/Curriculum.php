<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;
    protected $table = 'curriculums';

    public function deliveryTimes()
    {
        return $this->hasMany(
            DeliveryTime::class,// 関連するモデルクラスを指定 
            'curriculums_id',// 外部キーを指定 
            'id'
        );
    }
}

