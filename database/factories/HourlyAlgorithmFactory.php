<?php

namespace Database\Factories;

use App\Models\HourlyAlgorithm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HourlyAlgorithm>
 */
class HourlyAlgorithmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'markdown' => $this->faker->paragraph,
        ];
    }
}
