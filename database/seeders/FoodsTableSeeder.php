<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Food;
use Faker\Factory as Faker;

class FoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            Food::create([
                'name' => $faker->word,
                'price' => $faker->numberBetween(10000, 50000),
                'description' => $faker->sentence,
            ]);
        }
    }
}
