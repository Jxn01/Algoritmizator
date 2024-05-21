<?php

namespace Tests\Unit\Console\Commands;

use App\Console\Commands\SetPeopleOffline;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SetPeopleOfflineCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_set_people_offline_command_sets_users_offline(): void
    {
        $user1 = User::factory()->create(['last_online' => now()->subMinutes(40), 'is_online' => true]);
        $user2 = User::factory()->create(['last_online' => now()->subMinutes(10), 'is_online' => true]);

        Artisan::call(SetPeopleOffline::class);

        $this->assertEquals(0, $user1->fresh()->is_online);
        $this->assertEquals(1, $user2->fresh()->is_online);
    }

    public function test_set_people_offline_command_does_not_affect_users_online_within_last_20_minutes(): void
    {
        $user = User::factory()->create(['last_online' => now()->subMinutes(10), 'is_online' => true]);

        Artisan::call(SetPeopleOffline::class);

        $this->assertEquals(1, $user->fresh()->is_online);
    }
}
