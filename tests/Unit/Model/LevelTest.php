<?php

namespace Tests\Unit\Model;

use App\Models\Level;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class LevelTest
 *
 * This class contains unit tests for the Level model.
 */
class LevelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a level can be created with valid data.
     *
     * This test verifies that a level can be successfully created and saved in the database
     * with valid data.
     */
    public function test_levelCanBeCreatedWithValidData(): void
    {
        $level = Level::factory()->create();

        $this->assertDatabaseHas('levels', [
            'level' => $level->level,
            'xp_start' => $level->xp_start,
            'xp_end' => $level->xp_end,
        ]);
    }

    /**
     * Test that findLevelByXp returns the correct level.
     *
     * This test verifies that the method findLevelByXp returns the correct level
     * for given XP values within the defined ranges.
     */
    public function test_findLevelByXpReturnsCorrectLevel(): void
    {
        $this->assertEquals(1, Level::findLevelByXp(50));
        $this->assertEquals(2, Level::findLevelByXp(150));
    }

    /**
     * Test that findLevelByXp returns null when the XP value is out of range.
     *
     * This test verifies that the method findLevelByXp returns null
     * when the given XP value does not fall within any defined level ranges.
     */
    public function test_findLevelByXpReturnsNullWhenXpIsOutOfRange(): void
    {
        $this->assertNull(Level::findLevelByXp(4000000000));
    }
}
