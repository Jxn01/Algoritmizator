<?php

namespace Tests\Unit\Model;

use App\Models\Assignment;
use App\Models\Question;
use App\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class TaskTest
 *
 * This class contains unit tests for the Task model.
 */
class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a task can be created with valid data.
     *
     * This test verifies that a task can be successfully created and saved in the database
     * with valid data.
     */
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

    /**
     * Test that a task belongs to an assignment.
     *
     * This test verifies that the task is correctly associated with an assignment.
     */
    public function test_task_belongs_to_assignment(): void
    {
        $assignment = Assignment::factory()->create();
        $task = Task::factory()->create(['assignment_id' => $assignment->id]);

        $this->assertEquals($assignment->id, $task->assignment->id);
    }

    /**
     * Test that a task has many questions.
     *
     * This test verifies that the task can have multiple questions associated with it.
     */
    public function test_task_has_many_questions(): void
    {
        $task = Task::factory()->create();
        $question = Question::factory()->create(['task_id' => $task->id]);

        $this->assertTrue($task->questions->contains($question));
    }

    /**
     * Test that a task cannot be created without an assignment.
     *
     * This test verifies that an attempt to create a task without associating it with an assignment
     * will throw a QueryException.
     */
    public function test_task_cannot_be_created_without_assignment(): void
    {
        $this->expectException(QueryException::class);

        Task::factory()->create(['assignment_id' => null]);
    }
}
