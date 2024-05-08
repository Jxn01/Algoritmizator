<?php

namespace Database\Factories;

use App\Models\AttemptAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttemptAnswerFactory extends Factory
{
    protected $model = AttemptAnswer::class;

    public function definition(): array
    {
        return [
            'attempt_id' => $this->faker->numberBetween(1, 10),
            'answer_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
