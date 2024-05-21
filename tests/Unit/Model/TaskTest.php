<?php

namespace Tests\Unit\Model;

use App\Models\Assignment;
use App\Models\Question;
use App\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_created_with_valid_data(): void
    {
        $assignment = Assignment::factory()->create();
        $task = Task::factory()->create(['assignment_id' => $assignment->id]);

        $this->assertDatabaseHas('tasks', [
            'assignment_id' => $assignment->id,
            'type' => $task->type,
            'title' => $task->title,
            'markdown' => $task->markdown,
        ]);
    }

    public function test_task_belongs_to_assignment(): void
    {
        $assignment = Assignment::factory()->create();
        $task = Task::factory()->create(['assignment_id' => $assignment->id]);

        $this->assertEquals($assignment->id, $task->assignment->id);
    }

    public function test_task_has_many_questions(): void
    {
        $task = Task::factory()->create();
        $question = Question::factory()->create(['task_id' => $task->id]);

        $this->assertTrue($task->questions->contains($question));
    }

    public function test_task_cannot_be_created_without_assignment(): void
    {
        $this->expectException(QueryException::class);

        Task::factory()->create(['assignment_id' => null]);
    }
}
