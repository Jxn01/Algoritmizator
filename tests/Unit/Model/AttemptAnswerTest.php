<?php

namespace Tests\Unit\Model;

use App\Models\Answer;
use App\Models\AttemptAnswer;
use App\Models\AttemptQuestion;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AttemptAnswerTest
 *
 * This class contains unit tests for the AttemptAnswer model.
 */
class AttemptAnswerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an attempt answer can be created with valid data.
     *
     * This test verifies that an attempt answer can be successfully created and saved in the database
     * with valid data.
     */
    public function test_attempt_answer_can_be_created_with_valid_data(): void
    {
        $attemptQuestion = AttemptQuestion::factory()->create();
        $answer = Answer::factory()->create();
        $attemptAnswer = AttemptAnswer::factory()->create([
            'attempt_question_id' => $attemptQuestion->id,
            'answer_id' => $answer->id,
            'custom_answer' => 'Custom Answer',
        ]);

        $this->assertDatabaseHas('attempt_answers', [
            'attempt_question_id' => $attemptQuestion->id,
            'answer_id' => $answer->id,
            'custom_answer' => 'Custom Answer',
        ]);
    }

    /**
     * Test that an attempt answer belongs to an attempt question and an answer.
     *
     * This test verifies the relationships between the AttemptAnswer model, the AttemptQuestion model,
     * and the Answer model.
     */
    public function test_attempt_answer_belongs_to_attempt_question_and_answer(): void
    {
        $attemptQuestion = AttemptQuestion::factory()->create();
        $answer = Answer::factory()->create();
        $attemptAnswer = AttemptAnswer::factory()->create(['attempt_question_id' => $attemptQuestion->id, 'answer_id' => $answer->id]);

        $this->assertEquals($attemptQuestion->id, $attemptAnswer->attemptQuestion->id);
        $this->assertEquals($answer->id, $attemptAnswer->answer->id);
    }

    /**
     * Test that an attempt answer cannot be created without an attempt question or answer.
     *
     * This test verifies that a QueryException is thrown when attempting to create an attempt answer
     * without associating it with an attempt question or an answer.
     */
    public function test_attempt_answer_cannot_be_created_without_attempt_question_or_answer(): void
    {
        $this->expectException(QueryException::class);

        AttemptAnswer::factory()->create(['attempt_question_id' => null]);
        AttemptAnswer::factory()->create(['answer_id' => null]);
    }
}
