<?php

namespace Tests\Unit\Model;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_question_can_be_created_with_valid_data(): void
    {
        $task = Task::factory()->create();
        $question = Question::factory()->create(['task_id' => $task->id]);

        $this->assertDatabaseHas('questions', [
            'task_id' => $task->id,
            'markdown' => $question->markdown,
        ]);
    }

    public function test_question_belongs_to_task(): void
    {
        $task = Task::factory()->create();
        $question = Question::factory()->create(['task_id' => $task->id]);

        $this->assertEquals($task->id, $question->task->id);
    }

    public function test_question_has_many_answers(): void
    {
        $question = Question::factory()->create();
        $answer = Answer::factory()->create(['question_id' => $question->id]);

        $this->assertTrue($question->answers->contains($answer));
    }

    public function test_question_cannot_be_created_without_task(): void
    {
        $this->expectException(QueryException::class);

        Question::factory()->create(['task_id' => null]);
    }
}
