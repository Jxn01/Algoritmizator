<?php

namespace Tests\Unit\Model;

use App\Models\AttemptQuestion;
use App\Models\Question;
use App\Models\TaskAttempt;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttemptQuestionTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_attempt_question_belongs_to_task_attempt_and_question(): void
    {
        $taskAttempt = TaskAttempt::factory()->create();
        $question = Question::factory()->create();
        $attemptQuestion = AttemptQuestion::factory()->create(['task_attempt_id' => $taskAttempt->id, 'question_id' => $question->id]);

        $this->assertEquals($taskAttempt->id, $attemptQuestion->taskAttempt->id);
        $this->assertEquals($question->id, $attemptQuestion->question->id);
    }

    public function test_attempt_question_cannot_be_created_without_task_attempt_or_question(): void
    {
        $this->expectException(QueryException::class);

        AttemptQuestion::factory()->create(['task_attempt_id' => null]);
        AttemptQuestion::factory()->create(['question_id' => null]);
    }
}
