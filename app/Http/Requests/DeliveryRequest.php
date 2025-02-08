<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DeliveryValidDateFormat;
use App\Rules\DeliveryValidDateRange;

class DeliveryRequest extends FormRequest
{
    /**
     * 認可の確認
     * 常に true を返して認可をスキップ
     */
    public function authorize()
    {
        return true;
    }

    /**
     * バリデーションルールの定義
     * 各フィールドの基本的な形式チェックとカスタムルールの適用
     */
    public function rules()
    {
        return [
            // 開始日: 日付フォーマット (YYYYMMDD)
            'delivery_from_date.*' => ['nullable', new DeliveryValidDateFormat],

            // 開始時間: 24時間形式 (HHMM)
            'delivery_from_time.*' => ['nullable', 'regex:/^(0[0-9]|1[0-9]|2[0-3])[0-5][0-9]$/'],

            // 終了日: 日付フォーマット (YYYYMMDD)
            'delivery_to_date.*' => ['nullable', new DeliveryValidDateFormat],

            // 終了時間: 24時間形式 (HHMM)
            'delivery_to_time.*' => ['nullable', 'regex:/^(0[0-9]|1[0-9]|2[0-3])[0-5][0-9]$/'],

            // 開始日時と終了日時の整合性チェック
            'delivery_from_date' => [new DeliveryValidDateRange],
        ];
    }

    /**
     * 追加バリデーションロジック
     * フィールド間の相関チェックをここで実施
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->all();

            foreach ($data['delivery_from_date'] as $index => $fromDate) {
                $fromTime = $data['delivery_from_time'][$index] ?? null;
                $toDate = $data['delivery_to_date'][$index] ?? null;
                $toTime = $data['delivery_to_time'][$index] ?? null;

                // 部分的な入力チェック: どれか1つでも入力があれば他の3つも必須
                $filledFields = array_filter([$fromDate, $fromTime, $toDate, $toTime]);
                if (count($filledFields) > 0 && count($filledFields) < 4) {
                    if (!$fromTime || !$toTime) {
                        $validator->errors()->add("delivery_from_time.$index", __('delivery.errors.required_with_time'));
                    }
                    if (!$fromDate || !$toDate) {
                        $validator->errors()->add("delivery_from_date.$index", __('delivery.errors.required_with_date'));
                    }
                }

                // 開始日時が終了日時より未来または同一日時でないかチェック
                if ($fromDate && $fromTime && $toDate && $toTime) {
                    $startDatetime = $fromDate . $fromTime;
                    $endDatetime = $toDate . $toTime;

                    if ($startDatetime >= $endDatetime) {
                        $validator->errors()->add("delivery_from_date.$index", __('delivery.errors.invalid_date_range'));
                    }
                }
            }
        });
    }

    /**
     * カスタムエラーメッセージの定義
     * バリデーション失敗時のメッセージをカスタマイズ
     */
    public function messages()
    {
        return [
            // 日付形式エラー
            'delivery_from_date.*.delivery_valid_date_format' => __('delivery.errors.invalid_date_format'),
            'delivery_to_date.*.delivery_valid_date_format' => __('delivery.errors.invalid_date_format'),

            // 時間形式エラー
            'delivery_from_time.*.regex' => __('delivery.errors.invalid_time_format'),
            'delivery_to_time.*.regex' => __('delivery.errors.invalid_time_format'),

            // 開始日時と終了日時の順序エラー
            'delivery_from_date.*.invalid_date_range' => __('delivery.errors.invalid_date_range'),
        ];
    }
}
