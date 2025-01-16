<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grades')->insert([
            ['id' => 1, 'name' => '小学校1年生'],
            ['id' => 2, 'name' => '小学校2年生'],
            ['id' => 3, 'name' => '小学校3年生'],
            ['id' => 4, 'name' => '小学校4年生'],
            ['id' => 5, 'name' => '小学校5年生'],
            ['id' => 6, 'name' => '小学校6年生'],
            ['id' => 7, 'name' => '中学校1年生'],
            ['id' => 8, 'name' => '中学校2年生'],
            ['id' => 9, 'name' => '中学校3年生'],
            ['id' => 10, 'name' => '高校1年生'],
            ['id' => 11, 'name' => '高校2年生'],
            ['id' => 12, 'name' => '高校3年生'],
        ]);
    }
}

