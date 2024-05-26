<?php

namespace Tests\Unit\Model;

use App\Models\AttemptQuestion;
use App\Models\Question;
use App\Models\TaskAttempt;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AttemptQuestionTest
 *
 * This class contains unit tests for the AttemptQuestion model.
 */
class AttemptQuestionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an attempt question can be created with valid data.
     *
     * This test verifies that an attempt question can be successfully created and saved in the database
     * with valid data.
     */
    public function test_attempt_question_can_be_created_with_valid_data(): void
    {
        $taskAttempt = TaskAttempt::factory()->create();
        $question = Question::factory()->create();
        $attemptQuestion = AttemptQuestion::factory()->create([
            'task_attempt_id' => $taskAttempt->id,
            'question_id' => $question->id,
        ]);

        $this->assertDatabaseHas('attempt_questions', [
            'task_attempt_id' => $taskAttempt->id,
            'question_id' => $question->id,
        ]);
    }

    /**
     * Test that an attempt question belongs to a task attempt and a question.
     *
     * This test verifies the relationships between the AttemptQuestion model, the TaskAttempt model,
     * and the Question model.
     */
    public function test_attempt_question_belongs_to_task_attempt_and_question(): void
    {
        $taskAttempt = TaskAttempt::factory()->create();
        $question = Question::factory()->create();
        $attemptQuestion = AttemptQuestion::factory()->create(['task_attempt_id' => $taskAttempt->id, 'question_id' => $question->id]);

        $this->assertEquals($taskAttempt->id, $attemptQuestion->taskAttempt->id);
        $this->assertEquals($question->id, $attemptQuestion->question->id);
    }

    /**
     * Test that an attempt question cannot be created without a task attempt or a question.
     *
     * This test verifies that a QueryException is thrown when attempting to create an attempt question
     * without associating it with a task attempt or a question.
     */
    public function test_attempt_question_cannot_be_created_without_task_attempt_or_question(): void
    {
        $this->expectException(QueryException::class);

        AttemptQuestion::factory()->create(['task_attempt_id' => null]);
        AttemptQuestion::factory()->create(['question_id' => null]);
    }
}
