<?php

namespace Tests\Unit\Model;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class QuestionTest
 *
 * This class contains unit tests for the Question model.
 */
class QuestionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a question can be created with valid data.
     *
     * This test verifies that a question can be successfully created and saved in the database
     * with valid data.
     */
    public function test_question_can_be_created_with_valid_data(): void
    {
        $task = Task::factory()->create();
        $question = Question::factory()->create(['task_id' => $task->id]);

        $this->assertDatabaseHas('questions', [
            'task_id' => $task->id,
            'markdown' => $question->markdown,
        ]);
    }

    /**
     * Test that a question belongs to a task.
     *
     * This test verifies that the question is correctly associated with a task.
     */
    public function test_question_belongs_to_task(): void
    {
        $task = Task::factory()->create();
        $question = Question::factory()->create(['task_id' => $task->id]);

        $this->assertEquals($task->id, $question->task->id);
    }

    /**
     * Test that a question has many answers.
     *
     * This test verifies that a question can have multiple answers associated with it.
     */
    public function test_question_has_many_answers(): void
    {
        $question = Question::factory()->create();
        $answer = Answer::factory()->create(['question_id' => $question->id]);

        $this->assertTrue($question->answers->contains($answer));
    }

    /**
     * Test that a question cannot be created without a task.
     *
     * This test verifies that an attempt to create a question without associating it with a task
     * will throw a QueryException.
     */
    public function test_question_cannot_be_created_without_task(): void
    {
        $this->expectException(QueryException::class);

        Question::factory()->create(['task_id' => null]);
    }
}
