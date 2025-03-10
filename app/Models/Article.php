<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'article_contents', 'posted_date'];

    /**
     * お知らせの保存・更新処理 (DBトランザクション対応)
     * 
     * @param array $data 保存するデータ
     * @param int|null $id 更新する場合のID (新規の場合はnull)
     * @return Article 保存した記事のモデルインスタンス
     * @throws \Exception
     */
    public static function saveOrUpdate(array $data, $id = null): Article
    {
        return DB::transaction(function () use ($data, $id) {
            $article = $id ? self::findOrFail($id) : new self();

            $article->fill([
                'title' => $data['title'],
                'article_contents' => $data['article_contents'],
                'posted_date' => $data['posted_date'] ?? now(),
            ]);

            $article->save();

            return $article;
        });
    }
}
