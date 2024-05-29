<?php

namespace Tests\Unit\Model;

use App\Models\Assignment;
use App\Models\Attempt;
use App\Models\Sublesson;
use App\Models\SuccessfulAttempt;
use App\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AssignmentTest
 *
 * This class contains unit tests for the Assignment model.
 */
class AssignmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an assignment can be created with valid data.
     *
     * This test verifies that an assignment can be successfully created and saved in the database
     * with valid data.
     */
    public function test_assignment_can_be_created_with_valid_data(): void
    {
        $sublesson = Sublesson::factory()->create();
        $assignment = Assignment::factory()->create(['sublesson_id' => $sublesson->id]);

        $this->assertDatabaseHas('assignments', [
            'sublesson_id' => $sublesson->id,
            'title' => $assignment->title,
            'markdown' => $assignment->markdown,
            'assignment_xp' => $assignment->assignment_xp,
        ]);
    }

    /**
     * Test that an assignment belongs to a sublesson.
     *
     * This test verifies that an assignment is correctly associated with a sublesson.
     */
    public function test_assignment_belongs_to_sublesson(): void
    {
        $sublesson = Sublesson::factory()->create();
        $assignment = Assignment::factory()->create(['sublesson_id' => $sublesson->id]);

        $this->assertEquals($sublesson->id, $assignment->sublesson->id);
    }

    /**
     * Test that an assignment has many tasks.
     *
     * This test verifies that an assignment can have multiple tasks associated with it.
     */
    public function test_assignment_has_many_tasks(): void
    {
        $assignment = Assignment::factory()->create();
        $task = Task::factory()->create(['assignment_id' => $assignment->id]);

        $this->assertTrue($assignment->tasks->contains($task));
    }

    /**
     * Test that an assignment has many attempts.
     *
     * This test verifies that an assignment can have multiple attempts associated with it.
     */
    public function test_assignment_has_many_attempts(): void
    {
        $assignment = Assignment::factory()->create();
        $attempt = Attempt::factory()->create(['assignment_id' => $assignment->id]);

        $this->assertTrue($assignment->attempts->contains($attempt));
    }

    /**
     * Test that an assignment has many successful attempts.
     *
     * This test verifies that an assignment can have multiple successful attempts associated with it.
     */
    public function test_assignment_has_many_successful_attempts(): void
    {
        $assignment = Assignment::factory()->create();
        $successfulAttempt = SuccessfulAttempt::factory()->create(['assignment_id' => $assignment->id]);

        $this->assertTrue($assignment->successfulAttempts->contains($successfulAttempt));
    }

    /**
     * Test that an assignment cannot be created without a sublesson.
     *
     * This test verifies that a QueryException is thrown when attempting to create an assignment
     * without associating it with a sublesson.
     */
    public function test_assignment_cannot_be_created_without_sublesson(): void
    {
        $this->expectException(QueryException::class);

        Assignment::factory()->create(['sublesson_id' => null]);
    }
}
