<?php

namespace Database\Factories;

use App\Models\AttemptQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AttemptQuestion>
 */
class AttemptQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_attempt_id' => 1,
            'question_id' => 1,
        ];
    }
}
