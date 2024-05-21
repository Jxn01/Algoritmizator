<?php

namespace Database\Factories;

use App\Models\Sublesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sublesson>
 */
class SublessonFactory extends Factory
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
            'lesson_id' => 1,
            'markdown' => $this->faker->paragraph,
            'has_quiz' => $this->faker->boolean,
        ];
    }
}
