<?php

namespace Tests\Unit\Model;

use App\Models\Lesson;
use App\Models\Sublesson;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class SublessonTest
 *
 * This class contains unit tests for the Sublesson model.
 */
class SublessonTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a sublesson can be created with valid data.
     *
     * This test verifies that a sublesson can be successfully created and saved in the database
     * with valid data.
     */
    public function test_sublesson_can_be_created_with_valid_data(): void
    {
        $sublesson = Sublesson::factory()->create();

        $this->assertDatabaseHas('sublessons', [
            'title' => $sublesson->title,
            'markdown' => $sublesson->markdown,
            'has_quiz' => $sublesson->has_quiz,
        ]);
    }

    /**
     * Test that a sublesson belongs to a lesson.
     *
     * This test verifies that the sublesson is correctly associated with a lesson.
     */
    public function test_sublesson_belongs_to_lesson(): void
    {
        $lesson = Lesson::factory()->create();
        $sublesson = Sublesson::factory()->create(['lesson_id' => $lesson->id]);

        $this->assertEquals($lesson->id, $sublesson->lesson->id);
    }

    /**
     * Test that a sublesson cannot be created without a lesson.
     *
     * This test verifies that an attempt to create a sublesson without associating it with a lesson
     * will throw a QueryException.
     */
    public function test_sublesson_cannot_be_created_without_lesson(): void
    {
        $this->expectException(QueryException::class);

        Sublesson::factory()->create(['lesson_id' => null]);
    }

    /**
     * Test that a sublesson cannot be created without a title.
     *
     * This test verifies that an attempt to create a sublesson without a title
     * will throw a QueryException.
     */
    public function test_sublesson_cannot_be_created_without_title(): void
    {
        $this->expectException(QueryException::class);

        Sublesson::factory()->create(['title' => null]);
    }

    /**
     * Test that a sublesson cannot be created without markdown content.
     *
     * This test verifies that an attempt to create a sublesson without markdown content
     * will throw a QueryException.
     */
    public function test_sublesson_cannot_be_created_without_markdown(): void
    {
        $this->expectException(QueryException::class);

        Sublesson::factory()->create(['markdown' => null]);
    }

    /**
     * Test that the has_quiz attribute of a sublesson is a boolean.
     *
     * This test verifies that the has_quiz attribute is stored as a boolean value.
     */
    public function test_sublesson_has_quiz_is_boolean(): void
    {
        $sublessonWithQuiz = Sublesson::factory()->create(['has_quiz' => true]);
        $sublessonWithoutQuiz = Sublesson::factory()->create(['has_quiz' => false]);

        $this->assertTrue(is_bool($sublessonWithQuiz->has_quiz));
        $this->assertTrue(is_bool($sublessonWithoutQuiz->has_quiz));
    }
}
