<?php

namespace Database\Factories;

use App\Models\Sublesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class SublessonFactory extends Factory
{
    protected $model = Sublesson::class;

    public function definition(): array
    {
        return [
            'lesson_id' => 1,
            'title' => $this->faker->sentence,
            'markdown' => $this->faker->paragraph,
        ];
    }
}
