<?php

namespace Database\Factories;

use App\Models\AttemptAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AttemptAnswer>
 */
class AttemptAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attempt_question_id' => 1,
            'answer_id' => 1,
            'custom_answer' => $this->faker->sentence,
        ];
    }
}
