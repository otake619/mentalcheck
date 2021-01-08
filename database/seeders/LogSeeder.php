<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('logs')->insert([
            'user_id' => 1,
            'mental_point' => $this->faker->numberBetween($min=1, $max=5),
            'medicine_check' => $this->faker->boolean,
            'comment' => $this->faker->Str::random(30),
            'created_at' => $this->faker->date('2020-12-d H:i:s'),
            'updated_at' => $this->faker->date('2020-12-d H:i:s'),
        ]);
    }
}
