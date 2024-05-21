<?php

namespace Database\Factories;

use App\Models\Attempt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attempt>
 */
class AttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'assignment_id' => 1,
            'total_score' => $this->faker->randomNumber(2),
            'max_score' => $this->faker->randomNumber(2),
            'time' => $this->faker->time(),
            'passed' => $this->faker->boolean,
        ];
    }
}
