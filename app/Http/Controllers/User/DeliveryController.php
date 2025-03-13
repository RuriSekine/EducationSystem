<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\CurriculumProgress;
use Illuminate\Support\Facades\Auth;
use Exception;

class DeliveryController extends Controller
{
    /**
     * 授業詳細画面を表示
     */
    public function show($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $user = Auth::user();

        // モデルのメソッドを利用して受講済みかを確認
        $isCompleted = CurriculumProgress::isCompleted($id, $user->id);

        // 動画URLの処理
        $videoUrl = $curriculum->video_url;
        if ($videoUrl) {
        // YouTube用の埋め込みURLに変換
        if (strpos($videoUrl, 'youtube.com/watch?v=') !== false) {
            $videoId = explode('v=', $videoUrl)[1];
            $videoUrl = "https://www.youtube.com/embed/" . $videoId;
        }
    
        // ニコニコ動画用の埋め込みURLに変換
        if (strpos($videoUrl, 'nicovideo.jp/watch/') !== false) {
            $videoId = basename(parse_url($videoUrl, PHP_URL_PATH));
            $videoUrl = "https://embed.nicovideo.jp/watch/" . $videoId;
        }
    }

        return view('user.delivery', compact('curriculum', 'isCompleted', 'videoUrl'));
    }

    /**
     * 授業を受講済みにする処理
     */
    public function complete(Request $request, $id)
    {
        $user = Auth::user();

        try {
            // トランザクション付きのメソッドを利用
            if (CurriculumProgress::completeCurriculum($id, $user->id)) {
                return redirect()->route('user.show.curriculum', $id)
                                 ->with('success', '受講が完了しました。');
            }
            return back()->with('error', '受講完了処理に失敗しました。');
        } catch (\Exception $e) {
            return back()->with('error', 'エラーが発生しました: ' . $e->getMessage());
        }
    }
}