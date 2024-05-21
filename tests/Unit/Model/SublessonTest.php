<?php

namespace Tests\Unit\Model;

use App\Models\Lesson;
use App\Models\Sublesson;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SublessonTest extends TestCase
{
    use RefreshDatabase;

    public function test_sublesson_can_be_created_with_valid_data(): void
    {
        $sublesson = Sublesson::factory()->create();

        $this->assertDatabaseHas('sublessons', [
            'title' => $sublesson->title,
            'markdown' => $sublesson->markdown,
            'has_quiz' => $sublesson->has_quiz,
        ]);
    }

    public function test_sublesson_belongs_to_lesson(): void
    {
        $lesson = Lesson::factory()->create();
        $sublesson = Sublesson::factory()->create(['lesson_id' => $lesson->id]);

        $this->assertEquals($lesson->id, $sublesson->lesson->id);
    }

    public function test_sublesson_cannot_be_created_without_lesson(): void
    {
        $this->expectException(QueryException::class);

        Sublesson::factory()->create(['lesson_id' => null]);
    }

    public function test_sublesson_cannot_be_created_without_title(): void
    {
        $this->expectException(QueryException::class);

        Sublesson::factory()->create(['title' => null]);
    }

    public function test_sublesson_cannot_be_created_without_markdown(): void
    {
        $this->expectException(QueryException::class);

        Sublesson::factory()->create(['markdown' => null]);
    }

    public function test_sublesson_has_quiz_is_boolean(): void
    {
        $sublessonWithQuiz = Sublesson::factory()->create(['has_quiz' => true]);
        $sublessonWithoutQuiz = Sublesson::factory()->create(['has_quiz' => false]);

        $this->assertTrue(is_bool($sublessonWithQuiz->has_quiz));
        $this->assertTrue(is_bool($sublessonWithoutQuiz->has_quiz));
    }
}
