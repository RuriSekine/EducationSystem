<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Curriculum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeliveryTime>
 */
class DeliveryTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $curriculumIds = Curriculum::pluck('id')->toArray();  // カリキュラムidを選択し、そのカリキュラムのIDをcurriculum_idに設定
        $deliveryFrom = $this->faker->dateTimeBetween('now', '+1 month');  // 配信開始日時をランダムに生成

        $deliveryTo = (clone $deliveryFrom);
        $deliveryTo->modify('+' . rand(1, 5) . ' hours'); // 配信終了日時を配信開始日時から1～5時間後に設定
            
            return [
                'curriculums_id' => $this->faker->randomElement($curriculumIds),  // 選択したカリキュラムのIDを設定
                'delivery_from' => $deliveryFrom,  // 配信開始日時を設定
                'delivery_to' => $deliveryTo,  // 配信終了日時をランダムに生成
                'created_at' => now(),
                'updated_at' => now(),
            ];
    }
}
