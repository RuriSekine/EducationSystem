<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\CurriculumProgress;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CurriculumController extends Controller
{

    /**
     * 授業一覧画面を表示
     */
    public function index()
    {
        $curriculums = Curriculum::all();
        return view('user.delivery', compact('curriculums'));
    }

    // 授業詳細画面の表示
    public function show($id)
    {
        $user = Auth::user();
        $curriculum = Curriculum::findOrFail($id);

        // 進捗情報を取得、なければ新規作成
        $progress = CurriculumProgress::firstOrCreate(
            ['curriculums_id' => $curriculum->id, 'users_id' => $user->id],
            ['clear_flg' => false]
        );

        // 受講済みフラグを設定
        $isCompleted = $progress->clear_flg;

        return view('user.curriculum.show', compact('curriculum', 'progress', 'isCompleted'));
    }

    // 動画視聴完了処理
    public function complete(Request $request, $id)
    {
        $user = Auth::user();
        $curriculum = Curriculum::findOrFail($id);

        $progress = CurriculumProgress::where('curriculums_id', $curriculum->id)
                                      ->where('users_id', $user->id)
                                      ->first();

        if ($progress) {
            $progress->clear_flg = true; // 受講済みに更新
            $progress->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
?>