<?php

namespace Database\Seeders;

use App\Models\Cat;
use App\Models\CatsParent;
use Illuminate\Database\Seeder;

class CatsTableSeeder extends Seeder
{
    public function run(): void
    {
        $cats = Cat::factory()->count(20)->create();

        $mothers = $cats->where('gender', 'female')->where('age', '>', 1);
        $fathers = $cats->where('gender', 'male')->where('age', '>', 1);

        foreach ($mothers as $mother) {
            $kittenCount = rand(1, 3);
            $kittens = Cat::factory()->count($kittenCount)->create([
                'age' => rand(0, 1),
            ]);

            foreach ($kittens as $kitten) {
                $father = $fathers->random();

                CatsParent::create([
                    'kitten_id' => $kitten->id,
                    'mother_id' => $mother->id,
                    'father_id' => $father->id,
                ]);
            }
        }
    }
}
