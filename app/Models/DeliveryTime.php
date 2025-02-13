<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeliveryTime extends Model
{
    use HasFactory;

    // 登録可能なカラム
    protected $fillable = [
        'curriculums_id',
        'delivery_from',
        'delivery_to',
    ];

    /**
     * カリキュラムとのリレーション
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculums_id');
    }

    /**
     * 指定カリキュラムIDの配信日時データを取得
     * 
     * @param int $curriculumId カリキュラムID
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getDeliveryDataByCurriculumId($curriculumId)
    {
        return self::where('curriculums_id', $curriculumId)->get();
    }

    /**
     * 指定カリキュラムIDの配信日時データを削除
     * 
     * @param int $curriculumId カリキュラムID
     */
    public static function deleteByCurriculumId($curriculumId)
    {
        self::where('curriculums_id', $curriculumId)->delete();
    }

    /**
     * 配信日時の保存（更新処理）
     * 
     * @param int $curriculumId カリキュラムID
     * @param array $data 配信日時データ
     * @throws \Exception
     */
    public static function storeDeliveryTimes($curriculumId, $data)
    {
        DB::beginTransaction();

        try {
            // 既存データの削除
            self::deleteByCurriculumId($curriculumId);

            $newRecords = [];

            // 新規データの準備
            foreach ($data['delivery_from_date'] as $index => $fromDate) {
                if (!empty($fromDate) && !empty($data['delivery_from_time'][$index])) {
                    $newRecords[] = [
                        'curriculums_id' => $curriculumId,
                        'delivery_from' => $fromDate . $data['delivery_from_time'][$index] . '00',
                        'delivery_to' => $data['delivery_to_date'][$index] . $data['delivery_to_time'][$index] . '00',
                    ];
                }
            }

            // データベースへ一括挿入
            if (!empty($newRecords)) {
                self::insert($newRecords);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
