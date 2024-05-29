<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Answer;
use App\Models\Assignment;
use App\Models\Attempt;
use App\Models\AttemptAnswer;
use App\Models\AttemptQuestion;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Sublesson;
use App\Models\Task;
use App\Models\TaskAttempt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * Class LessonsControllerTest
 *
 * This class contains unit tests for the LessonsController.
 */
class LessonsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that lessons are retrieved correctly.
     *
     * This test verifies that a user can retrieve lessons.
     */
    public function test_lessons_are_retrieved_correctly(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $lessons = Lesson::factory()->count(3)->create();

        $response = $this->getJson('/api/lessons');

        $response->assertStatus(200);
        $response->assertJsonCount(7); // 4 are created by default
    }

    /**
     * Test that an assignment and its tasks are retrieved correctly.
     *
     * This test verifies that a user can retrieve an assignment and its tasks.
     */
    public function test_assignment_and_tasks_are_retrieved_correctly(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $sublesson = Sublesson::factory()->create();
        $assignment = Assignment::factory()->create(['sublesson_id' => $sublesson->id]);
        $task = Task::factory()->create(['assignment_id' => $assignment->id]);
        $question = Question::factory()->create(['task_id' => $task->id]);
        $answer = Answer::factory()->create(['question_id' => $question->id]);

        $response = $this->getJson('/api/task/'.$sublesson->id);

        $response->assertStatus(200);
        $response->assertJsonPath('assignment.id', $assignment->id);
    }

    /**
     * Test that an assignment submission is successful.
     *
     * This test verifies that a user can submit an assignment successfully.
     */
    public function test_assignment_submission_is_successful(): void
    {
        $user = User::factory()->create();
        Auth::login($user);
        $this->actingAs($user);

        $lesson = Lesson::factory()->create();
        $sublesson = Sublesson::factory()->create(['lesson_id' => $lesson->id]);
        $assignment = Assignment::factory()->create(['sublesson_id' => $sublesson->id]);
        $task = Task::factory()->create(['assignment_id' => $assignment->id, 'type' => 'result']);
        $question = Question::factory()->create(['task_id' => $task->id]);
        $answer1 = Answer::factory()->create(['question_id' => $question->id, 'is_correct' => true]);
        $attemptData = [
            'assignment_id' => $assignment->id,
            'tasks' => [
                [
                    'id' => $task->id,
                    'questions' => [
                        [
                            'id' => $question->id,
                            'answer' => $answer1->answer,
                        ],
                    ],
                ],
            ],
            'time' => 300,
        ];

        $response = $this->postJson('/api/task/submit', $attemptData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('attempts', [
            'user_id' => $user->id,
            'assignment_id' => $assignment->id,
        ]);
    }

    /**
     * Test that an attempt is retrieved correctly.
     *
     * This test verifies that a user can retrieve an attempt with all related data.
     */
    public function test_attempt_is_retrieved_correctly(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $lesson = Lesson::factory()->create();
        $sublesson = Sublesson::factory()->create(['lesson_id' => $lesson->id]);
        $assignment = Assignment::factory()->create(['sublesson_id' => $sublesson->id]);
        $task = Task::factory()->create(['assignment_id' => $assignment->id, 'type' => 'result']);
        $question = Question::factory()->create(['task_id' => $task->id]);
        $answer = Answer::factory()->create(['question_id' => $question->id, 'is_correct' => true]);

        $attempt = Attempt::factory()->create(['user_id' => $user->id]);
        $taskAttempt = TaskAttempt::factory()->create(['attempt_id' => $attempt->id, 'task_id' => $task->id]);
        $attemptQuestion = AttemptQuestion::factory()->create(['task_attempt_id' => $taskAttempt->id, 'question_id' => $question->id]);
        $attemptAnswer = AttemptAnswer::factory()->create(['attempt_question_id' => $attemptQuestion->id, 'answer_id' => $answer->id, 'custom_answer' => $answer->answer]);

        $response = $this->getJson('/api/task/attempt/'.$attempt->id);

        $response->assertStatus(200);
        $response->assertJsonPath('id', $attempt->id);
    }
}
