<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Grade;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curriculum>
 */
class CurriculumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
            $gradeIds = Grade::pluck('id')->toArray();  // ランダムに学年を選択し、その学年のIDをgrade_idに設定
            
            return [
                'title' => '授業' . $this->faker->randomNumber(1),// ランダムな授業タイトルを生成
                'thumbnail' => 'storage/images/curriculums/curriculum.jpg',  
                // ランダムな画像URLを生成
                'description' => $this->faker->realText(100), // 日本語説明
                'video_url' => $this->faker->url(),  // ランダムな動画URLを生成
                'alway_delivery_flg' => $this->faker->boolean(),  // ランダムな配送フラグを生成
                'grade_id' => $this->faker->randomElement($gradeIds),  // 選択した学年のIDを設定
                'created_at' => now(),
                'updated_at' => now(),
            ];
    }
}
