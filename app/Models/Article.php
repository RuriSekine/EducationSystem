<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    
protected $casts = [
    'posted_date' => 'datetime',
    // 'posted_date' フィールドを DateTime オブジェクトとして扱うよう指定する。
];
<<<<<<< HEAD
}
=======
}
>>>>>>> main
