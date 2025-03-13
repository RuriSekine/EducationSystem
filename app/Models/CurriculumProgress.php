<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumProgress extends Model
{
    use HasFactory;

    // テーブル名を明示的に指定
    protected $table = 'curriculum_progress';

    protected $fillable = [
        'curriculums_id', 'users_id', 'clear_flg',
    ];

    // リレーションシップ：カリキュラムと進捗
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculums_id');
    }

    // リレーションシップ：ユーザーと進捗
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * 進捗を完了としてマーク
     *
     * @param int $curriculumId
     * @param int $userId
     * @return bool
     */
    public static function completeCurriculum(int $curriculumId, int $userId): bool
    {
        return self::updateOrCreate(
            ['curriculums_id' => $curriculumId, 'users_id' => $userId],
            ['clear_flg' => true]
        );
    }

    /**
     * 進捗が完了しているか判定
     *
     * @param int $curriculumId
     * @param int $userId
     * @return bool
     */
    public static function isCompleted(int $curriculumId, int $userId): bool
    {
        return self::where('curriculums_id', $curriculumId)
                    ->where('users_id', $userId)
                    ->where('clear_flg', true)
                    ->exists();
    }
}
