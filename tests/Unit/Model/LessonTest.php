<?php

namespace Tests\Unit\Model;

use App\Models\Lesson;
use App\Models\Sublesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use RefreshDatabase;

    public function test_lesson_can_be_created_with_valid_data(): void
    {
        $lesson = Lesson::factory()->create();

        $this->assertDatabaseHas('lessons', [
            'title' => $lesson->title,
        ]);
    }

    public function test_find_lesson_by_title_returns_correct_lesson(): void
    {
        $lesson = Lesson::factory()->create(['title' => 'Test Lesson']);

        $foundLesson = Lesson::findLessonByTitle('Test Lesson');

        $this->assertEquals($lesson->id, $foundLesson->id);
    }

    public function test_find_lesson_by_title_returns_null_when_title_does_not_exist(): void
    {
        $lesson = Lesson::factory()->create(['title' => 'Test Lesson']);

        $foundLesson = Lesson::findLessonByTitle('Nonexistent Lesson');

        $this->assertNull($foundLesson);
    }

    public function test_sublessons_can_be_added_to_lesson(): void
    {
        $lesson = Lesson::factory()->create();
        $sublesson1 = Sublesson::factory()->create(['lesson_id' => $lesson->id]);
        $sublesson2 = Sublesson::factory()->create(['lesson_id' => $lesson->id]);

        $this->assertCount(2, $lesson->refresh()->sublessons);
    }
}
