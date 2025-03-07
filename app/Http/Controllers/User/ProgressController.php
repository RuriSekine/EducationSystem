<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\CurriculumProgress;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;

class ProgressController extends Controller
{
    public function index() // カリキュラムIDを受け取る
    {
        $user = Auth::user();
        
        // ユーザーの学年を取得
        $currentGrade = Grade::find($user->grade_id);

        // 全ての学年を取得（小1〜高3）
        $grades = Grade::orderBy('id')->get();

        // ユーザーの進捗情報を取得
        $progresses = CurriculumProgress::where('users_id', $user->id)->pluck('clear_flg', 'curriculums_id');

        // カリキュラムを学年ごとに取得し、進捗情報を追加
        $curriculums = Curriculum::with('grade')->get();
        $groupedCurriculums = $curriculums->groupBy('grade.name');

        return view('user.curriculum_progress', compact('user','currentGrade' ,'grades', 'groupedCurriculums', 'progresses'));
    }
}
?>