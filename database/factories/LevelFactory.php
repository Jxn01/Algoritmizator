<?php

namespace Database\Factories;

use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Level>
 */
class LevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomLevel = $this->faker->numberBetween(50, 100);

        return [
            'level' => $randomLevel,
            'xp_start' => $randomLevel * 10 - 99,
            'xp_end' => $randomLevel * 10,
        ];
    }
}
