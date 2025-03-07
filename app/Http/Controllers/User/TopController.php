<?php

namespace App\Http\Controllers\User; //名前空間をApp\Http\Controllersから変更

use App\Http\Controllers\Controller;
use App\Models\Article; //articleモデルをインポート
use Illuminate\Http\Request;
use App\Models\Banner; //bannerモデルをインポート

class TopController extends Controller
{
    public function index ()
    {
        $banners = Banner::all(); // すべてのバナー画像を取得
        $articles = Article::orderBy('posted_date', 'desc')->take(5)->get();
         //orderBy('created_at', 'desc') - 記事を作成日時（created_at）の降順（最新のものから）で並べ替え。5件のみ取得。
     return view('user.top', compact('banners','articles'));
    }
}