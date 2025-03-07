<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
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
        $gradeNames = ['小学校1年生','小学校2年生','小学校3年生','小学校4年生','小学校5年生','小学校6年生','中学校1年生','中学校2年生','中学校3年生','高校1年生','高校2年生','高校3年生'];

        foreach ($gradeNames as $gradeName) {
            DB::table('grades')->insert([
                    'name' => $gradeName,
            ]);
        }
    }
}
