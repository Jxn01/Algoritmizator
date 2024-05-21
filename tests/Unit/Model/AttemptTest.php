<?php

namespace Tests\Unit\Model;

use App\Models\Assignment;
use App\Models\Attempt;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttemptTest extends TestCase
{
    use RefreshDatabase;

    public function test_attempt_can_be_created_with_valid_data(): void
    {
        $user = User::factory()->create();
        $assignment = Assignment::factory()->create();
        $attempt = Attempt::factory()->create([
            'user_id' => $user->id,
            'assignment_id' => $assignment->id,
            'total_score' => 80,
            'max_score' => 100,
            'time' => '00:01:00',
            'passed' => true,
        ]);

        $this->assertDatabaseHas('attempts', [
            'user_id' => $user->id,
            'assignment_id' => $assignment->id,
            'total_score' => 80,
            'max_score' => 100,
            'time' => '00:01:00',
            'passed' => true,
        ]);
    }

    public function test_attempt_belongs_to_user_and_assignment(): void
    {
        $user = User::factory()->create();
        $assignment = Assignment::factory()->create();
        $attempt = Attempt::factory()->create(['user_id' => $user->id, 'assignment_id' => $assignment->id]);

        $this->assertEquals($user->id, $attempt->user->id);
        $this->assertEquals($assignment->id, $attempt->assignment->id);
    }

    public function test_attempt_cannot_be_created_without_user_or_assignment(): void
    {
        $this->expectException(QueryException::class);

        Attempt::factory()->create(['user_id' => null]);
        Attempt::factory()->create(['assignment_id' => null]);
    }
}
