<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assignment_id' => 1,
            'type' => $this->faker->randomElement(['result', 'quiz', 'checkbox', 'true_false']),
            'title' => $this->faker->sentence,
            'markdown' => $this->faker->sentence,
        ];
    }
}
