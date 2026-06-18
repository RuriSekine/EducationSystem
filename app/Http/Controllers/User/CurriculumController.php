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
        $curriculums = Curriculum::with('deliveryTimes')->get(); 
        // curriculumsテーブルおよびdelivery_timesテーブルのデータを取得

        return view('user.curriculum_list', compact('grades', 'curriculums'));
    }
}
