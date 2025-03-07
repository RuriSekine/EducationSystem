<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.article_list', compact('articles'));
    }

    public function edit($id = null) // 新規作成と編集を統一
    {
        $article = $id ? Article::findOrFail($id) : new Article(); // IDがあれば編集、なければ新規
        return view('admin.article_edit', compact('article')); // 変数名を修正
    }

    public function store(Request $request, $id = null)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'article_contents' => 'required|string',
            'posted_date' => 'nullable|date',
        ]);

        $article = $id ? Article::findOrFail($id) : new Article();

        $article->title = $request->input('title');
        $article->article_contents = $request->input('article_contents');
        $article->posted_date = $request->input('posted_date') ?? now(); // 投稿日時が設定されていない場合は現在日時

        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'お知らせを保存しました');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'article_contents' => 'required|string',
            'posted_date' => 'nullable|date',
        ]);

        $article = Article::findOrFail($id); // IDがあれば、該当のレコードを取得

        $article->title = $request->input('title');
        $article->article_contents = $request->input('article_contents');
        $article->posted_date = $request->input('posted_date') ?? now(); // 投稿日時が設定されていない場合は現在日時

        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'お知らせを更新しました');
    }


    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'お知らせを削除しました。');
    }
}
