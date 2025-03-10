<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.article_list', compact('articles'));
    }

    public function edit($id = null)
    {
        $article = $id ? Article::findOrFail($id) : new Article();
        return view('admin.article_edit', compact('article'));
    }

    public function store(ArticleRequest $request, $id = null)
    {
        Article::saveOrUpdate($request->validated(), $id);

        return redirect()->route('admin.articles.index')->with('success', 'お知らせを保存しました');
    }

    public function update(ArticleRequest $request, $id)
    {
        Article::saveOrUpdate($request->validated(), $id);

        return redirect()->route('admin.articles.index')->with('success', 'お知らせを更新しました');
    }

    public function destroy($id)
    {
        Article::findOrFail($id)->delete();

        return redirect()->route('admin.articles.index')->with('success', 'お知らせを削除しました。');
    }
}
