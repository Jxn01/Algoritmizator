<?php

namespace Tests\Unit\Model;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AnswerTest
 *
 * This class contains unit tests for the Answer model.
 */
class AnswerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an answer can be created with valid data.
     *
     * This test verifies that an answer can be successfully created and saved in the database
     * with valid data.
     */
    public function test_answer_can_be_created_with_valid_data(): void
    {
        $question = Question::factory()->create();
        $answer = Answer::factory()->create(['question_id' => $question->id]);

        $this->assertDatabaseHas('answers', [
            'question_id' => $answer->question_id,
            'answer' => $answer->answer,
            'is_correct' => $answer->is_correct,
        ]);
    }

    /**
     * Test that an answer belongs to a question.
     *
     * This test verifies that an answer is correctly associated with a question.
     */
    public function test_answer_belongs_to_a_question(): void
    {
        $question = Question::factory()->create();
        $answer = Answer::factory()->create(['question_id' => $question->id]);

        $this->assertEquals($question->id, $answer->question->id);
    }

    /**
     * Test that an answer cannot be created without a question.
     *
     * This test verifies that a QueryException is thrown when attempting to create an answer
     * without associating it with a question.
     */
    public function test_answer_cannot_be_created_without_question(): void
    {
        $this->expectException(QueryException::class);

        Answer::factory()->create(['question_id' => null]);
    }

    /**
     * Test that an answer cannot be created without answer text.
     *
     * This test verifies that a QueryException is thrown when attempting to create an answer
     * without providing answer text.
     */
    public function test_answer_cannot_be_created_without_answer_text(): void
    {
        $this->expectException(QueryException::class);

        Answer::factory()->create(['answer' => null]);
    }

    /**
     * Test that the is_correct flag of an answer can be true.
     *
     * This test verifies that the is_correct flag can be set to true for an answer.
     */
    public function test_answer_is_correct_flag_can_be_true(): void
    {
        $answer = Answer::factory()->create(['is_correct' => true]);

        $this->assertTrue($answer->is_correct);
    }

    /**
     * Test that the is_correct flag of an answer can be false.
     *
     * This test verifies that the is_correct flag can be set to false for an answer.
     */
    public function test_answer_is_correct_flag_can_be_false(): void
    {
        $answer = Answer::factory()->create(['is_correct' => false]);

        $this->assertFalse($answer->is_correct);
    }
}
