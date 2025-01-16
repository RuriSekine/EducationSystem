<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index (){
        return view('admin.banner_edit');
    }

    public function store(Request $request)
    {
        // リクエストのバリデーション
        $request->validate([
         'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // 画像ファイルがアップロードされているか確認
        if ($request -> hasFile('image')) {
            // アップロードされたファイルを取得
            $file = $request -> file('image');
            // ファイルを指定のパスに保存し、そのパスを取得※今回はバナー画像はimages/bannerに保存する。
            $path = $file -> store('images/banner', 'public');

            // 新しいBannerモデルのインスタンスを作成し、データベースに保存
            Banner::create([
                'image' => $path,
            ]);

            return redirect()->route('admin.show.banner.edit')
            ->with('success', 'バナー画像が登録されました');

            return back()->with('error', '画像のアップロードに失敗しました');
        }
    }
}