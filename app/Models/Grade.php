<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['name'];

    /**
     * 全ての学年を取得（小1〜高3）
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllGrades()
    {
        return self::orderBy('id')->get();
    }
}
