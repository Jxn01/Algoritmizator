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

class AssignmentTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_assignment_belongs_to_sublesson(): void
    {
        $sublesson = Sublesson::factory()->create();
        $assignment = Assignment::factory()->create(['sublesson_id' => $sublesson->id]);

        $this->assertEquals($sublesson->id, $assignment->sublesson->id);
    }

    public function test_assignment_has_many_tasks(): void
    {
        $assignment = Assignment::factory()->create();
        $task = Task::factory()->create(['assignment_id' => $assignment->id]);

        $this->assertTrue($assignment->tasks->contains($task));
    }

    public function test_assignment_has_many_attempts(): void
    {
        $assignment = Assignment::factory()->create();
        $attempt = Attempt::factory()->create(['assignment_id' => $assignment->id]);

        $this->assertTrue($assignment->attempts->contains($attempt));
    }

    public function test_assignment_has_many_successful_attempts(): void
    {
        $assignment = Assignment::factory()->create();
        $successfulAttempt = SuccessfulAttempt::factory()->create(['assignment_id' => $assignment->id]);

        $this->assertTrue($assignment->successfulAttempts->contains($successfulAttempt));
    }

    public function test_assignment_cannot_be_created_without_sublesson(): void
    {
        $this->expectException(QueryException::class);

        Assignment::factory()->create(['sublesson_id' => null]);
    }
}
