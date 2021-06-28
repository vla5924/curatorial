<?php

namespace Tests\Feature;

use Tests\RefreshDatabaseOnce;
use Tests\TestCase;

class PracticeTest extends TestCase
{
    use RefreshDatabaseOnce;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }
}
