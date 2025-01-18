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
        // URLが有効かどうかをチェック
        if (!filter_var($url, FILTER_VALIDATE_URL)){
            return null; //無効なURLの場合はnullを返す。
        }

        // URLのホストがYouTubeかどうかをチェック
        $host = parse_url($url, PHP_URL_HOST);
        if (!in_array($host, ['www.youtube.com', 'youtube.com', 'youtu.be'])) { //https://の後の確認
            return null; //YouTubeのURLでない場合はnullを返す
        }

        //動画IDを抽出
        $videoId = null;
        if ($host === 'youtu.be') {
            $videoId = trim(parse_url($url, PHP_URL_PATH), '/');
        } else {
            parse_str(parse_url($url, PHP_URL_QUERY), $params); //parse_str()でクエリ文字列をパースし、パラメータを連想配列$paramsに格納
            $videoId = $params['v'] ?? null; //'v'パラメータの値（動画ID）を取得
        }

        // 動画IDを抽出したが見つからない、または11文字でない場合はnullを返す→※YouTubeの動画IDは常に11文字である
        if (!$videoId || strlen($videoId) !== 11){
            return null;
        }

        return "https://www.youtube.com/embed/". $videoId;
    }

    public function index($id)//Youtubeのリンク判別の処理を追加済み
    {
        $curriculum = Curriculum::with('grade')->findOrFail($id); //学年に応じた動画・タイトル・詳細を取得する処理
        $embedUrl = $this->getYoutubeEmbedUrl($curriculum->video_url); // 既存: YouTube埋め込みURLの生成
        $deliveryTime = DeliveryTime::where('curriculums_id', $curriculum->id)->first(); // カリキュラムIDに基づいて、DeliveryTimeテーブルから対応するレコードを取得

        $isWithinDeliveryPeriod = $this->checkDeliveryPeriod($deliveryTime);

        $user = Auth::user();
        $curriculumProgress = $this->getCurriculumProgress($user->id, $curriculum->id);
        $isClearFlag = $this->isClear($curriculumProgress);

        if ($isClearFlag){
            $this->checkAndUpdateGrade($user, $curriculum->grade_id);
        }

        return view('user.delivery', compact('curriculum', 'embedUrl','isWithinDeliveryPeriod', 'isClearFlag'));
    }


        private function getCurriculumProgress($userId, $curriculumId)
        {
            return CurriculumProgress::where('users_id', $userId)
                                        ->where('curriculums_id', $curriculumId)
                                        ->first();
        }

        private function isClear($curriculumProgress)
        {
            return $curriculumProgress && $curriculumProgress->clear_flg;
        }

        private function checkDeliveryPeriod($deliveryTime)
        {
            if (!$deliveryTime) {
                return false;
            }
        

        $now = Carbon::now();
        return $now->between(
            Carbon::parse($deliveryTime->delivery_from),
            Carbon::parse($deliveryTime->delivery_to)
        );
    }

    private function checkAndUpdateGrade($user, $currentGradeId)
    {
        $nextGradeId = $this->determineNextGrade($user, $currentGradeId);

        if ($nextGradeId != $user->grade_id && $nextGradeId <= 12){
            $user->updateGrade($nextGradeId);
        }
    }

    // 次の学年を決定するメソッド
    private function determineNextGrade($user, $currentGradeId){
        $nextGradeId = $currentGradeId;
        while ($nextGradeId < 12 && $this->isGradeCompleted($user, $nextGradeId))
        {
            $nextGradeId++;
        }
        return $nextGradeId;
    }

    //特定の学年のカリキュラムが全て完了しているかチェックするメソッド
    private function isGradeCompleted($user, $gradeId)
    {
        $curriculums = Curriculum::where('grade_id', $gradeId)->get();

        // 全ての授業が完了しているかチェック
        return $curriculums->every(function ($curriculum) use ($user){
            return CurriculumProgress::where('users_id', $user->id)
                                    ->where('curriculums_id', $curriculum->id)
                                    ->where('clear_flg', true)
                                    ->exists();
        });
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
