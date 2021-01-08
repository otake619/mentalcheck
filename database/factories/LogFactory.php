<?php

namespace Database\Factories;

use App\Models\Log;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Log::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'mental_point' => $this->faker->numberBetween($min=1, $max=5),
            'medicine_check' => $this->faker->boolean,
            'comment' => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            'created_at' => $this->faker->date('2020-12-d H:i:s'),
            'updated_at' => $this->faker->date('2020-12-d H:i:s'),
        ];
    }
}
