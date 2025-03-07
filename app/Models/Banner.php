<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    // Mass Assignment（一括割り当て）で代入を許可するカラムを指定
   // この場合、imageカラムのみが一括代入可能
   protected $fillable = ['image'];


   // image_urlという名前のアクセサを定義
    // $banner->image_url としてアクセスすると、このメソッドが呼び出される
   public function getImageUrlAttribute()

   // asset()ヘルパー関数を使用して、画像のフルURLを生成
    // 'storage/'はpublic/storageディレクトリを指し、そこから$this->image_pathで指定されたパスを結合
   {
        return asset('storage/' . $this->image);
   }
}
