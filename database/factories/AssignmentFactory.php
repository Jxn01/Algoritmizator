<?php

namespace Database\Factories;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sublesson_id' => 1,
            'title' => $this->faker->sentence,
            'markdown' => $this->faker->paragraph,
            'assignment_xp' => $this->faker->numberBetween(1, 100),
        ];
    }
}
