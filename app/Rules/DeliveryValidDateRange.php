<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DeliveryValidDateRange implements Rule
{
    /**
     * バリデーションロジック
     * 
     * @param string $attribute フィールド名（例: delivery_from_date.0）
     * @param mixed $value 入力値
     * @return bool バリデーションの合否
     */
    public function passes($attribute, $value)
    {
        // フィールドのインデックスを取得（例: delivery_from_date.0 から 0 を抽出）
        preg_match('/\d+/', $attribute, $matches);
        $index = $matches[0] ?? null;

        // 該当の開始・終了日時を取得
        $fromDate = request()->input("delivery_from_date.$index");
        $fromTime = request()->input("delivery_from_time.$index");
        $toDate = request()->input("delivery_to_date.$index");
        $toTime = request()->input("delivery_to_time.$index");

        // どれかが未入力ならバリデーションスルー（他のルールでチェック）
        if (!$fromDate || !$fromTime || !$toDate || !$toTime) {
            return true;
        }

        // 日時を結合して比較（形式: YYYYMMDDHHMM）
        $startDatetime = $fromDate . $fromTime;
        $endDatetime = $toDate . $toTime;

        // 開始日時が終了日時より未来、または同じ場合はNG
        return $startDatetime < $endDatetime;
    }

    /**
     * バリデーションエラーメッセージ
     * 
     * @return string
     */
    public function message()
    {
        return __('delivery.errors.invalid_date_range');
    }
}
