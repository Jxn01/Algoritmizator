<?php

namespace Tests\Unit\Model;

use App\Models\Assignment;
use App\Models\Attempt;
use App\Models\SuccessfulAttempt;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class SuccessfulAttemptTest
 *
 * This class contains unit tests for the SuccessfulAttempt model.
 */
class SuccessfulAttemptTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a successful attempt can be created with valid data.
     *
     * This test verifies that a successful attempt can be successfully created and saved in the database
     * with valid data.
     */
    public function test_successful_attempt_can_be_created_with_valid_data(): void
    {
        $user = User::factory()->create();
        $assignment = Assignment::factory()->create();
        $attempt = Attempt::factory()->create(['user_id' => $user->id, 'assignment_id' => $assignment->id]);

        $successfulAttempt = SuccessfulAttempt::factory()->create([
            'user_id' => $user->id,
            'assignment_id' => $assignment->id,
            'attempt_id' => $attempt->id,
        ]);

        $this->assertDatabaseHas('successful_attempts', [
            'user_id' => $user->id,
            'assignment_id' => $assignment->id,
            'attempt_id' => $attempt->id,
        ]);
    }

    /**
     * Test that a successful attempt belongs to a user, assignment, and attempt.
     *
     * This test verifies that the successful attempt is correctly associated with a user, assignment,
     * and attempt.
     */
    public function test_successful_attempt_belongs_to_user_assignment_and_attempt(): void
    {
        $user = User::factory()->create();
        $assignment = Assignment::factory()->create();
        $attempt = Attempt::factory()->create(['user_id' => $user->id, 'assignment_id' => $assignment->id]);

        $successfulAttempt = SuccessfulAttempt::factory()->create([
            'user_id' => $user->id,
            'assignment_id' => $assignment->id,
            'attempt_id' => $attempt->id,
        ]);

        $this->assertEquals($user->id, $successfulAttempt->user->id);
        $this->assertEquals($assignment->id, $successfulAttempt->assignment->id);
        $this->assertEquals($attempt->id, $successfulAttempt->attempt->id);
    }

    /**
     * Test that a successful attempt cannot be created without a user, assignment, or attempt.
     *
     * This test verifies that an attempt to create a successful attempt without associating it with a user,
     * assignment, or attempt will throw a QueryException.
     */
    public function test_successful_attempt_cannot_be_created_without_user_assignment_or_attempt(): void
    {
        $this->expectException(QueryException::class);

        SuccessfulAttempt::factory()->create(['user_id' => null]);
        SuccessfulAttempt::factory()->create(['assignment_id' => null]);
        SuccessfulAttempt::factory()->create(['attempt_id' => null]);
    }
}
