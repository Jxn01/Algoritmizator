<?php

namespace Database\Factories;

use App\Models\BlockedUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlockedUserFactory extends Factory
{
    protected $model = BlockedUser::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'blocked_user_id' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->dateTimeThisYear()
        ];
    }
}
