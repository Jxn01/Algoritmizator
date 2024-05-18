<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'answer_id' => $this->faker->randomDigitNotNull,
            'description' => $this->faker->text,
        ];
    }
}
