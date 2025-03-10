<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'title', 'description', 'video_url', 'thumbnail', 'alway_delivery_flg', 'grade_id',
    ];

    // 学年とのリレーションシップ
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    // 進捗とのリレーションシップ
    public function progresses()
    {
        return $this->hasMany(CurriculumProgress::class, 'curriculums_id');
    }

    /**
     * カリキュラムを学年ごとにグループ化して取得
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getCurriculumsGroupedByGrade()
    {
        return self::with('grade')->get()->groupBy('grade.name');
    }

    /**
     * ユーザーの進捗情報を取得
     *
     * @param int $userId
     * @return \Illuminate\Support\Collection
     */
    public static function getUserProgress(int $userId)
    {
        return CurriculumProgress::where('users_id', $userId)->pluck('clear_flg', 'curriculums_id');
    }
    
    /**
     * カリキュラム（動画）の保存 (DBトランザクション対応)
     *
     * @param array $data
     * @return Curriculum
     * @throws \Exception
     */
    public static function storeCurriculum(array $data): Curriculum
    {
        return DB::transaction(function () use ($data) {
            // サムネイル画像の保存
            $thumbnailPath = $data['thumbnail']->store('thumbnails', 'public');
            $thumbnailUrl = Storage::url($thumbnailPath);

            // カリキュラムの保存
            return self::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'video_url' => $data['video_url'],
                'thumbnail' => $thumbnailUrl,
                'alway_delivery_flg' => $data['alway_delivery_flg'] ?? 1, // 常時配信フラグ（デフォルト1）
                'grade_id' => $data['grade_id'],
            ]);
        });
    }
}
