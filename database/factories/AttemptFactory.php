<?php

namespace Database\Factories;

use App\Models\Attempt;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttemptFactory extends Factory
{
    protected $model = Attempt::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'assignment_id' => $this->faker->numberBetween(1, 10),
            'total_score' => $this->faker->numberBetween(0, 100),
            'max_score' => $this->faker->numberBetween(0, 100),
            'time' => $this->faker->numberBetween(0, 100),
            'pass' => $this->faker->boolean,
        ];
    }
}
