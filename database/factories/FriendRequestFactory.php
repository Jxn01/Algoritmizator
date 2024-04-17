<?php

namespace Database\Factories;

use App\Models\FriendRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class FriendRequestFactory extends Factory
{
    protected $model = FriendRequest::class;

    public function definition(): array
    {
        return [
            'sender_id' => 1,
            'receiver_id' => 2,
            'status' => 0,
            'date' => now()
        ];
    }
}
