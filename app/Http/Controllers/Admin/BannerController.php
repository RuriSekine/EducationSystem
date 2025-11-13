<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{
    public function showBannerEdit() {
        
        $banners = Banner::all();//bannersテーブルから全取得
        
        return view('admin.banner_edit',['banners' => $banners]);
    }


    //登録ボタンを押したとき
    public function showBannerUpdate(Request $request) { 
        //すべてが成功したときに
        DB::transaction(function () use ($request) {
            $storedFiles = []; // 保存済みファイルを追跡

            try {
                //バリデーションのルール
                $request->validate([
                    'new_images.*' => 'required|file|mimes:jpeg,png,jpg,gif|max:10485760|min:1048576',
                    'images.*' => 'file|mimes:jpeg,png,jpg,gif|max:10485760|min:1048576',
                ], [
                    'new_images.*.required' => 'ファイルを選択してください。',
                    'new_images.*.mimes'    => '所定の形式ではありません',
                    'new_images.*.max'      => 'ファイルが大きすぎます',
                    'new_images.*.min'      => 'ファイルが小さすぎます',
                    'images.*.mimes'        => '所定の形式ではありません',
                    'images.*.max'          => 'ファイルが大きすぎます',
                    'images.*.min'          => 'ファイルが小さすぎます',
                ]);

                //バリデーションをクリアしたら新規追加処理
                if ($request->hasFile('new_images')) {
                    foreach ($request->file('new_images') as $file) {
                        //ファイル名取得
                        $originalName = $file->getClientOriginalName();
                        //保存用パスを指定
                        $path = 'storage/images/banner/' . $originalName;
                        //実際に保存
                        $file->storeAs('images/banner', $originalName, 'public');
                        // 保存済みファイルリストに追加
                        $storedFiles[] = $path;
                        //DBに保存
                        Banner::create(['image' => $path]);
                    }
                }
                //バリデーションをクリアしたら更新
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        //ファイル名取得
                        $originalName = $file->getClientOriginalName();
                        //保存用パスを指定
                        $path = 'storage/images/banner/' . $originalName;
                        //実際に保存
                        $file->storeAs('images/banner', $originalName, 'public');
                        //既存IDの取得
                        $banner = Banner::find($id);
                        if ($banner) {
                            //元画像取得
                            $oldImage = $banner->image;
                            //バナー画像を更新
                            $banner::update(['image' => $path]);
                            //更新できたら元画像を削除
                            if ($oldImage && Storage::disk('public')->exists('banner/' . basename($oldImage))) {Storage::disk('public')->delete('banner/' . basename($oldImage));
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    // エラー発生時に新規画像保存済みファイルを削除
                    foreach ($storedFiles as $filePath) {
                        if (Storage::disk('public')->exists('banner/' . basename($filePath))) {
                        Storage::disk('public')->delete('banner/' . basename($filePath));
                        }
                    } 
                throw $e; //トランザクションのロールバック
            }
        });
    }
}