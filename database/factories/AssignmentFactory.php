<?php

namespace Database\Factories;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition(): array
    {
        return [
            'lesson_id' => $this->faker->uuid,
            'task_id' => $this->faker->uuid,
            'assignment_xp' => $this->faker->numberBetween(1, 100)
        ];
    }
}
