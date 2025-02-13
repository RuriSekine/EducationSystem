<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grade;

class Curriculum extends Model
{
    use HasFactory;

    /** @var string テーブル名 */
    protected $table = 'curriculums';

    /** @var array 更新可能なカラム */
    protected $fillable = [
        'title',
        'thumbnail',
        'description',
        'video_url',
        'alway_delivery_flg',
        'grade_id',
    ];

    /**
     * 学年とのリレーション
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    /**
     * 配信日時とのリレーション（開始日時の昇順で取得）
     */
    public function deliveryTimes()
    {
        return $this->hasMany(DeliveryTime::class, 'curriculums_id')->orderBy('delivery_from', 'asc');
    }

    /**
     * すべての学年を取得
     */
    public static function getGrades()
    {
        return Grade::all();
    }

    /**
     * 授業の新規登録処理
     */
    public static function CurriculumRegist($data)
    {
        // サムネイル画像の保存処理
        $filePath = null;
        if (isset($data['thumbnail']) && $data['thumbnail']->isValid()) {
            $filePath = $data['thumbnail']->store('public/images/thumbnail');
        }

        // データベースに登録
        self::create([
            'title' => $data['title'],
            'thumbnail' => $filePath ? str_replace('public/', '', $filePath) : null,
            'description' => $data['description'],
            'video_url' => $data['video_url'],
            'alway_delivery_flg' => isset($data['always_delivery']) ? 1 : 0,
            'grade_id' => $data['grade_id'],
        ]);
    }

    /**
     * 指定された学年の授業を取得（すべての学年も可）
     */
    public static function getFilteredCurriculums($gradeName = null)
    {
        $query = self::with('grade');
        if ($gradeName && $gradeName !== 'all') {
            $query->whereHas('grade', function ($q) use ($gradeName) {
                $q->where('name', $gradeName);
            });
        }
        return $query->get();
    }

    /**
     * 指定したIDのカリキュラムを取得
     */
    public static function getCurriculumById($id)
    {
        return self::with(['grade', 'deliveryTimes'])->findOrFail($id);
    }

    /**
     * 授業情報の更新処理
     */
    public static function CurriculumUpdate($data, $id)
    {
        $curriculum = self::findOrFail($id);

        // サムネイル画像の更新処理
        if (isset($data['thumbnail']) && $data['thumbnail']->isValid()) {
            if ($curriculum->thumbnail && \Storage::exists('public/' . $curriculum->thumbnail)) {
                \Storage::delete('public/' . $curriculum->thumbnail);
            }

            $filePath = $data['thumbnail']->store('public/images/thumbnail');
            $data['thumbnail'] = str_replace('public/', '', $filePath);
        } else {
            $data['thumbnail'] = $curriculum->thumbnail;
        }

        // データ更新
        $curriculum->update([
            'title' => $data['title'],
            'thumbnail' => $data['thumbnail'],
            'description' => $data['description'],
            'video_url' => $data['video_url'],
            'alway_delivery_flg' => isset($data['always_delivery']) ? 1 : 0,
            'grade_id' => $data['grade_id'],
        ]);
    }

    /**
     * 指定したカリキュラムの配信日時一覧を取得（昇順）
     */
    public static function getDeliverySchedules($curriculumId)
    {
        return self::with(['deliveryTimes'])
            ->where('id', $curriculumId)
            ->firstOrFail()
            ->deliveryTimes;
    }
}
