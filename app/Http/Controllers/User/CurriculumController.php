<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Curriculum;
use App\Models\DeliveryTime;
use Carbon\Carbon;

class CurriculumController extends Controller
{
    public function showCurriculumList()
    {
        $grades = Grade::all(); // gradesテーブル取得

        //gradesテーブルのデータを取得
        return view('user.curriculum_list', compact('grades'));

    }

    //リクエストを受け取り
    public function getCurriculums(Request $request)
    {
        // 選択された年月を取得
        $year = $request->year;
        $month = $request->month;

        // 選択した月の開始日・終了日
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();

        $query = Curriculum::with([
            'deliveryTimes' => function ($query) use ($startOfMonth, $endOfMonth) {
            $query->where('delivery_from', '<=', $endOfMonth)
            ->where('delivery_to', '>=', $startOfMonth);
            }
        ]);

        //カリキュラムテーブル検索と同時に関連のdeliveryTimesテーブルも一緒に
        $query->where('grade_id', $request->grade_id);
        $query->where(function ($query) use ($startOfMonth, $endOfMonth) {

        // 常時公開
        $query->where('alway_delivery_flg', 1)

            // 選択した月に配信期間が存在する
            ->orWhereHas('deliveryTimes', function ($query) use ($startOfMonth, $endOfMonth) {
            $query->where('delivery_from', '<=', $endOfMonth)
                  ->where('delivery_to', '>=', $startOfMonth);
            });
        });
        return response()->json($query->get());
    }
}
