<?php

namespace Database\Factories;

use App\Models\SuccessfulAttempt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SuccessfulAttempt>
 */
class SuccessfulAttemptFactory extends Factory
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
            'attempt_id' => 1,
        ];
    }
}
