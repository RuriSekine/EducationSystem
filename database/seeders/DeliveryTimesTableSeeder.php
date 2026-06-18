<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryTime;
use App\Models\Curriculum;

class DeliveryTimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $curriculums = Curriculum::all();

        foreach ($curriculums as $curriculum) {
            DeliveryTime::factory()->count(2)->create([
                'curriculums_id' => $curriculum->id,
            ]);
        }
    }
}
