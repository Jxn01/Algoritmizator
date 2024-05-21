<?php

namespace Database\Factories;

use App\Models\FriendRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FriendRequest>
 */
class FriendRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sender_id' => 1,
            'receiver_id' => 2,
        ];
    }
}
