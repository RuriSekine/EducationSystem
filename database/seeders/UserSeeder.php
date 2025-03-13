<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 一人目のユーザーを手動で作成
        User::create([
            'name' => '山田 太郎',
            'name_kana' => 'ヤマダ タロウ',
            'email' => 'taro.yamada@example.com',
            'password' => bcrypt('password123'), // 必ず暗号化して保存
            'profile_image' => 'profile1.jpg', // デフォルトのプロフィール画像を設定（画像があれば）
            'grade_id' => 1, // 例: 小学1年生
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 二人目のユーザーを手動で作成
        User::create([
            'name' => '鈴木 花子',
            'name_kana' => 'スズキ ハナコ',
            'email' => 'hanako.suzuki@example.com',
            'password' => bcrypt('password456'),
            'profile_image' => 'profile2.jpg',
            'grade_id' => 2, // 例: 小学2年生
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 三人目以降も同様に設定
        User::create([
            'name' => '田中 一郎',
            'name_kana' => 'タナカ イチロウ',
            'email' => 'ichiro.tanaka@example.com',
            'password' => bcrypt('password789'),
            'profile_image' => 'profile3.jpg',
            'grade_id' => 3, // 例: 小学3年生
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'さくらみこ',
            'name_kana' => 'サクラミコ',
            'email' => 'micochi@example.com',
            'password' => bcrypt('micochi123'), // 必ず暗号化して保存
            'profile_image' => 'profile1.jpg', // デフォルトのプロフィール画像を設定（画像があれば）
            'grade_id' => 12, // 例: 小学1年生
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
