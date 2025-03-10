<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\CurriculumProgress;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;

class ProgressController extends Controller
{
    /**
     * 授業進捗画面を表示
     */
    public function index() // カリキュラムIDを受け取る
    {
        $user = Auth::user();
        $currentGrade = Grade::find($user->grade_id);
        $grades = Grade::orderBy('id')->get();
        $progresses = CurriculumProgress::where('users_id', $user->id)->pluck('clear_flg', 'curriculums_id');
        $curriculums = Curriculum::with('grade')->get();
        
        // 各カリキュラムに対して進捗と有効/無効を計算
        $curriculumsWithProgress = $curriculums->map(function ($curriculum) use ($progresses, $user) {
            $isCompleted = $progresses[$curriculum->id] ?? false;
            $isDisabled = $curriculum->grade_id > $user->grade_id; // 現在の学年以上のカリキュラムは非活性
    
            return [
                'curriculum' => $curriculum,
                'isCompleted' => $isCompleted,
                'isDisabled' => $isDisabled,
            ];
        });
    
        // 学年ごとに3列ごとに分割
        $gradeChunks = $grades->take(12)->chunk(3);
    
        return view('user.curriculum_progress', compact(
            'user', 
            'currentGrade', 
            'gradeChunks', 
            'curriculumsWithProgress', 
            'progresses'
        ));
    }   
}
?>