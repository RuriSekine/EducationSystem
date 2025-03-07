<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum;
use Illuminate\Support\Facades\Storage;
use App\Models\Grade;

class CurriculumController extends Controller
{
    // 動画追加フォームを表示
    public function create()
    {
        $grades = Grade::all();
        return view('admin.curriculum_create', compact('grades'));
    }

    // 動画を保存
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // サムネイル画像のバリデーション
            'grade_id' => 'required|exists:grades,id',
        ]);

        // サムネイル画像の保存
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $thumbnailUrl = Storage::url($thumbnailPath);
        } else {
            return back()->with('error', 'サムネイル画像のアップロードに失敗しました');
        }

        // 授業データを保存
        Curriculum::create([
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $request->video_url,
            'thumbnail' => $thumbnailUrl,
            'alway_delivery_flg' => 1, // 常時配信
            'grade_id' => $request->grade_id, // 学年指定
        ]);

        return redirect()->route('admin.curriculum.create')->with('success', '動画を追加しました');
    }
}
