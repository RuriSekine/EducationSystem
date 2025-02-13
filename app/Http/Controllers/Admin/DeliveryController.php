<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryTime;
use App\Models\Curriculum;
use App\Http\Requests\DeliveryRequest;
use Illuminate\Support\Facades\Log;

class DeliveryController extends Controller
{
    /**
     * 配信日時設定画面の表示
     *
     * @param int $id 授業ID
     * @return \Illuminate\Contracts\View\View
     */
    public function showDeliveryEdit($id)
    {
        try {
            // 授業情報と配信日時データの取得
            $curriculum = Curriculum::findOrFail($id);
            $deliveryTimes = DeliveryTime::getDeliveryDataByCurriculumId($id);

            // 取得したデータをビューに渡す
            return view('admin.delivery', [
                'curriculum' => $curriculum,
                'deliveryTimes' => $deliveryTimes,
            ]);
        } catch (\Exception $e) {
            // 取得エラー時のログ記録とエラーメッセージ表示
            Log::error('配信日時設定画面の読み込みエラー: ' . $e->getMessage());
            return back()->withErrors(['error' => '配信日時データの取得に失敗しました']);
        }
    }

    /**
     * 配信日時の更新処理
     *
     * @param DeliveryRequest $request バリデーション済みリクエストデータ
     * @param int $id 授業ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDelivery(DeliveryRequest $request, $id)
    {
        try {
            // 配信日時データの保存
            DeliveryTime::storeDeliveryTimes($id, $request->all());

            // 成功メッセージと共に授業一覧にリダイレクト
            return redirect()->route('admin.curriculum.list')->with('success', '配信日時が更新されました');
        } catch (\Exception $e) {
            // 更新エラー時のログ記録とエラーメッセージ表示
            Log::error('配信日時の更新エラー: ' . $e->getMessage());
            return back()->withErrors(['error' => '登録に失敗しました: ' . $e->getMessage()]);
        }
    }
}
