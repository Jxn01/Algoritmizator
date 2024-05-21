<?php

namespace Tests\Unit\Model;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_answer_belongs_to_a_question(): void
    {
        $question = Question::factory()->create();
        $answer = Answer::factory()->create(['question_id' => $question->id]);

        $this->assertEquals($question->id, $answer->question->id);
    }

    public function test_answer_cannot_be_created_without_question(): void
    {
        $this->expectException(QueryException::class);

        Answer::factory()->create(['question_id' => null]);
    }

    public function test_answer_cannot_be_created_without_answer_text(): void
    {
        $this->expectException(QueryException::class);

        Answer::factory()->create(['answer' => null]);
    }

    public function test_answer_is_correct_flag_can_be_true(): void
    {
        $answer = Answer::factory()->create(['is_correct' => true]);

        $this->assertTrue($answer->is_correct);
    }

    public function test_answer_is_correct_flag_can_be_false(): void
    {
        $answer = Answer::factory()->create(['is_correct' => false]);

        $this->assertFalse($answer->is_correct);
    }
}
