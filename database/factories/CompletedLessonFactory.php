<?php

namespace Database\Factories;

use App\Models\CompletedLesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompletedLessonFactory extends Factory
{
    protected $model = CompletedLesson::class;

    public function definition(): array
    {
        return [
            'user_id' => 1,
            'lesson_id' => 1,
            'date' => $this->faker->dateTimeThisYear()
        ];
    }
}
