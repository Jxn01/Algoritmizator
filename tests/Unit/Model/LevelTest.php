<?php

namespace Tests\Unit\Model;

use App\Models\Level;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LevelTest extends TestCase
{
    use RefreshDatabase;

    public function test_levelCanBeCreatedWithValidData(): void
    {
        $level = Level::factory()->create();

        $this->assertDatabaseHas('levels', [
            'level' => $level->level,
            'xp_start' => $level->xp_start,
            'xp_end' => $level->xp_end,
        ]);
    }

    public function test_findLevelByXpReturnsCorrectLevel(): void
    {
        $this->assertEquals(1, Level::findLevelByXp(50));
        $this->assertEquals(2, Level::findLevelByXp(150));
    }

    public function test_findLevelByXpReturnsNullWhenXpIsOutOfRange(): void
    {
        $this->assertNull(Level::findLevelByXp(4000000000));
    }
}
