<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Http\Requests\CurriculumRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CurriculumController extends Controller
{
    /**
     * 授業一覧画面を表示
     */
    public function showCurriculumList(Request $request)
    {
        $gradeName = $request->query('grade', 'all');

        // 指定された学年の授業を取得（デフォルトはすべて）
        $curriculums = $gradeName === 'all'
            ? Curriculum::with(['grade', 'deliveryTimes'])->get()
            : Curriculum::with(['grade', 'deliveryTimes'])->whereHas('grade', function ($query) use ($gradeName) {
                $query->where('name', $gradeName);
            })->get();

        // 全学年情報を取得
        $grades = Curriculum::getGrades();

        return view('admin.culliculum_list', compact('curriculums', 'grades'));
    }

    /**
     * 授業新規登録画面を表示
     */
    public function showCurriculumCreate()
    {
        $grades = Curriculum::getGrades(); // 学年情報を取得
        return view('admin.culliculum_create', compact('grades'));
    }

    /**
     * 授業新規登録処理
     */
    public function CurriculumRegist(CurriculumRequest $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated(); // バリデーション済みデータを取得
            Curriculum::CurriculumRegist($validated); // 授業登録処理

            DB::commit();

            return redirect()->route('admin.curriculum.list')->with('success', '授業を登録しました！');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('授業登録エラー: ' . $e->getMessage());

            return redirect()->route('admin.curriculum.create')->with('error', '授業の登録に失敗しました。再試行してください。');
        }
    }

    /**
     * 授業編集画面を表示
     */
    public function showCurriculumEdit($id)
    {
        $curriculum = Curriculum::with(['grade', 'deliveryTimes'])->findOrFail($id);
        $grades = Curriculum::getGrades();

        return view('admin.culliculum_edit', compact('curriculum', 'grades'));
    }

    /**
     * 授業情報の更新処理
     */
    public function CurriculumUpdate(CurriculumRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated(); // バリデーション済みデータを取得
            Curriculum::CurriculumUpdate($validated, $id); // 更新処理

            DB::commit();

            return redirect()->route('admin.curriculum.list')->with('success', '授業を更新しました！');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('授業更新エラー: ' . $e->getMessage());

            return redirect()->route('admin.curriculum.edit', ['id' => $id])->with('error', '授業の更新に失敗しました。再試行してください。');
        }
    }
}
