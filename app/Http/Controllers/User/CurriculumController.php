<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Curriculum;
use App\Models\DeliveryTime;

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
        $query = Curriculum::with('deliveryTimes');
        //カリキュラムテーブル検索と同時に関連のdeliveryTimesテーブルも一緒に
        $query->where('grade_id', $request->grade_id);
        return response()->json($query->get());//実際に検索して結果を返す
    }
}
