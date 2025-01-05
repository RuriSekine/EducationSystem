<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller; // ここで親クラスをインポート
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show($id) // 記事の詳細を表示するためのメソッド
    {
        $article = Article::findOrFail($id); // 指定されたIDの記事をデータベースから取得
        return view('user.article', compact('article')); // 'article.show'ビューを返し、compact('article')で$articleをビューに渡す
    }
}