<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    // 一覧表示メソッドを追加
    public function index()
    {
        $articles = Article::latest()->paginate(10); // お知らせ一覧を取得
        return view('user.top', compact('articles')); // 一覧表示用ビュー
    }

    // 詳細表示メソッド
    public function show($id)
    {
        $article = Article::findOrFail($id); // 変数名を単数形に修正
        return view('user.article', compact('article')); // 単数形でビューに渡す
    }
}
?>