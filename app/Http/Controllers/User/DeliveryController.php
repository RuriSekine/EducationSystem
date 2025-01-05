<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryTime;
use App\Models\CurriculumProgress;
use App\Models\User;
use App\Models\Grade;
use App\Models\Curriculum;
use Carbon\Carbon; // (公開日時設定)日付操作のためのCarbonライブラリ
use Illuminate\Support\Facades\Auth; //ログインしているユーザーの認証機能を使用するために追加

class DeliveryController extends Controller
{
    private function getYoutubeEmbedUrl($url) //YoutubeのURLを埋め込み用に変換するための処理
    {
        $videoId = explode("v=", $url)[1];
        return "https://www.youtube.com/embed/". $videoId;
    }

    public function index($id)
    {
        $curriculum = Curriculum::with('grade')->findOrFail($id); //学年に応じた動画・タイトル・詳細を取得する処理

        $embedUrl = $this->getYoutubeEmbedUrl($curriculum->video_url); // 既存: YouTube埋め込みURLの生成

        $deliveryTime = DeliveryTime::where('curriculums_id', $curriculum->id)->first(); // カリキュラムIDに基づいて、DeliveryTimeテーブルから対応するレコードを取得

        $isWithinDeliveryPeriod = false; // 配信期間内かどうかを示すフラグを初期化（デフォルトはfalse）
        //falseにしておくことで不適切なタイミングでコンテンツが表示されることを防ぐセーフガードとして機能

        // DeliveryTimeレコードが存在する場合のみ以下の処理を行う
        if ($deliveryTime) {
            $now = Carbon::now();// 現在の日時を取得
            $isWithinDeliveryPeriod = $now->between(
                // 現在の日時が配信開始日と終了日の間にあるかをチェック
                Carbon::parse($deliveryTime->delivery_from),// 配信開始日をCarbonオブジェクトに変換
                Carbon::parse($deliveryTime->delivery_to) // 配信終了日をCarbonオブジェクトに変換
            );
        }

        $user = Auth::user(); //ログインユーザーの情報を取得

        // 追加: ユーザーの受講状況を取得
        $curriculumProgress = CurriculumProgress::where('users_id', $user->id)
                                                    ->where('curriculums_id', $curriculum->id)
                                                    ->first();

        $isClearFlag = false; //ユーザーの受講状況（該当の授業のclear_flg）をチェック
        if ($curriculumProgress && $curriculumProgress->clear_flg) {
            $isClearFlag = true;

            $this->checkAndUpdateGrade($user, $curriculum->grade_id); // 全ての授業が完了しているかチェック
        }
        return view('user.delivery', compact('curriculum', 'embedUrl','isWithinDeliveryPeriod','isClearFlag'));
    }

    private function checkAndUpdateGrade($user, $currentGradeId)
    {
        $nextGradeId = $currentGradeId;

        while ($nextGradeId < 12){ //最大学年（高校3年生）までチェック
        //現在の学年のすべての授業を取得
        $curriculums = Curriculum::where('grade_id', $currentGradeId)->get();

        // 全ての授業が完了しているかチェック
        $allCompleted = $curriculums->every(function ($curriculum) use ($user){
            return CurriculumProgress::where('users_id', $user->id)
                                    ->where('curriculums_id', $curriculum->id)
                                    ->where('clear_flg', true)
                                    ->exists();
        });

        // 全ての授業が完了していない場合はループを抜ける。
        if ($allCompleted) {
            break;
        }
        $nextGradeId++;
    }

    // 学年が更新される場合のみ保存
    if ($nextGradeId != $user->grade_id && $nextGradeId <= 12) {
        $user->grade_id = $nextGradeId;
        $user->save();
        }
    }

        public function completeCurriculum(Request $request, $id)
        {
            try{
            $user = Auth::user(); // ログインしているユーザーの情報を取得
            $progress = CurriculumProgress::updateOrCreate(
                ['users_id' => $user->id, 'curriculums_id' => $id],
                ['clear_flg' => true]
            );

            $curriculum = Curriculum::findOrFail($id); // 指定されたIDのカリキュラムを取得
            $this->checkAndUpdateGrade($user, $curriculum->grade_id); // ユーザーの学年を更新するメソッドを呼び出し
            return redirect()->back()->with('success', '受講が完了しました');
            } catch (\Exception $e) {
                \Log::error('Curriculum completion error: ' . $e->getMessage());
                return redirect()->back()->with('error', '処理中にエラーが発生しました');
            }
        }
}
