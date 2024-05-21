<?php

namespace Tests\Unit\Model;

use App\Models\Attempt;
use App\Models\Task;
use App\Models\TaskAttempt;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskAttemptTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_attempt_can_be_created_with_valid_data(): void
    {
        $attempt = Attempt::factory()->create();
        $task = Task::factory()->create();
        $taskAttempt = TaskAttempt::factory()->create([
            'attempt_id' => $attempt->id,
            'task_id' => $task->id,
        ]);

        $this->assertDatabaseHas('task_attempts', [
            'attempt_id' => $attempt->id,
            'task_id' => $task->id,
        ]);
    }

    public function test_task_attempt_belongs_to_attempt_and_task(): void
    {
        $attempt = Attempt::factory()->create();
        $task = Task::factory()->create();
        $taskAttempt = TaskAttempt::factory()->create(['attempt_id' => $attempt->id, 'task_id' => $task->id]);

        $this->assertEquals($attempt->id, $taskAttempt->attempt->id);
        $this->assertEquals($task->id, $taskAttempt->task->id);
    }

    public function test_task_attempt_cannot_be_created_without_attempt_or_task(): void
    {
        $this->expectException(QueryException::class);

        TaskAttempt::factory()->create(['attempt_id' => null]);
        TaskAttempt::factory()->create(['task_id' => null]);
    }
}
