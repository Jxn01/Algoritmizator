<?php

namespace Database\Factories;

use App\Models\CompletedAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompletedAssignmentFactory extends Factory
{
    protected $model = CompletedAssignment::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->uuid,
            'assignment_id' => $this->faker->uuid,
            'date' => $this->faker->dateTimeThisYear(),
        ];
    }
}
