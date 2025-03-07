<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\CurriculumProgress;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    /**
     * 授業詳細画面を表示
     */
    public function show($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $user = Auth::user();

        // 受講済みかどうかを取得
        $isCompleted = CurriculumProgress::where('curriculums_id', $id)
                            ->where('users_id', $user->id)
                            ->where('clear_flg', true)
                            ->exists();

        return view('user.delivery', compact('curriculum', 'isCompleted'));
    }

    /**
     * 授業を受講済みにする処理
     */
    public function complete(Request $request, $id)
    {
        $user = Auth::user();

        // 受講状況を更新または作成
        CurriculumProgress::updateOrCreate(
            ['curriculums_id' => $id, 'users_id' => $user->id],
            ['clear_flg' => true]
        );

        return redirect()->route('user.show.curriculum', $id)
                         ->with('success', '受講が完了しました。');
    }
}