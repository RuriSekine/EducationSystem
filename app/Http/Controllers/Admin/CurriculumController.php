<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurriculumRequest;
use App\Models\Curriculum;
use App\Models\Grade;
use Illuminate\Support\Facades\Redirect;
use Exception;

class CurriculumController extends Controller
{
    /**
     * 動画追加フォームを表示
     */
    public function create()
    {
        $grades = Grade::all();
        return view('admin.curriculum_create', compact('grades'));
    }

    /**
     * 動画を保存 (DBトランザクション対応)
     */
    public function store(CurriculumRequest $request)
    {
        try {
            Curriculum::storeCurriculum($request->validated());
            return Redirect::route('admin.curriculum.create')->with('success', '動画を追加しました');
        } catch (Exception $e) {
            return Redirect::back()->withErrors(['error' => '動画の保存に失敗しました: ' . $e->getMessage()]);
        }
    }
}
