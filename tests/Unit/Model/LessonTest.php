<?php

namespace Tests\Unit\Model;

use App\Models\Lesson;
use App\Models\Sublesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class LessonTest
 *
 * This class contains unit tests for the Lesson model.
 */
class LessonTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a lesson can be created with valid data.
     *
     * This test verifies that a lesson can be successfully created and saved in the database
     * with valid data.
     */
    public function test_lesson_can_be_created_with_valid_data(): void
    {
        $lesson = Lesson::factory()->create();

        $this->assertDatabaseHas('lessons', [
            'title' => $lesson->title,
        ]);
    }

    /**
     * Test that finding a lesson by title returns the correct lesson.
     *
     * This test verifies that the method findLessonByTitle returns the correct lesson
     * when a lesson with the specified title exists.
     */
    public function test_find_lesson_by_title_returns_correct_lesson(): void
    {
        $lesson = Lesson::factory()->create(['title' => 'Test Lesson']);

        $foundLesson = Lesson::findLessonByTitle('Test Lesson');

        $this->assertEquals($lesson->id, $foundLesson->id);
    }

    /**
     * Test that finding a lesson by title returns null when the title does not exist.
     *
     * This test verifies that the method findLessonByTitle returns null
     * when no lesson with the specified title exists.
     */
    public function test_find_lesson_by_title_returns_null_when_title_does_not_exist(): void
    {
        $lesson = Lesson::factory()->create(['title' => 'Test Lesson']);

        $foundLesson = Lesson::findLessonByTitle('Nonexistent Lesson');

        $this->assertNull($foundLesson);
    }

    /**
     * Test that sublessons can be added to a lesson.
     *
     * This test verifies that sublessons can be successfully added to a lesson
     * and the relationship is correctly established.
     */
    public function test_sublessons_can_be_added_to_lesson(): void
    {
        $lesson = Lesson::factory()->create();
        $sublesson1 = Sublesson::factory()->create(['lesson_id' => $lesson->id]);
        $sublesson2 = Sublesson::factory()->create(['lesson_id' => $lesson->id]);

        $this->assertCount(2, $lesson->refresh()->sublessons);
    }
}
