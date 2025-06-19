<?php

namespace Tests\Feature\StarWars;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatisticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_statistics_can_be_fetched()
    {
        $response = $this->get('/api/statistics');

        $response->assertStatus(200);
    }
}
