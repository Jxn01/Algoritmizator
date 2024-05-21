<?php

namespace Tests\Unit\Model;

use App\Models\HourlyAlgorithm;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HourlyAlgorithmTest extends TestCase
{
    use RefreshDatabase;

    public function test_hourly_algorithm_can_be_created_with_valid_data(): void
    {
        $hourlyAlgorithm = HourlyAlgorithm::factory()->create();

        $this->assertDatabaseHas('hourly_algorithms', [
            'title' => $hourlyAlgorithm->title,
            'markdown' => $hourlyAlgorithm->markdown,
        ]);
    }

    public function test_hourly_algorithm_cannot_be_created_without_title(): void
    {
        $this->expectException(QueryException::class);

        HourlyAlgorithm::factory()->create(['title' => null]);
    }

    public function test_hourly_algorithm_cannot_be_created_without_markdown(): void
    {
        $this->expectException(QueryException::class);

        HourlyAlgorithm::factory()->create(['markdown' => null]);
    }
}
