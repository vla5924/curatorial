<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\RefreshDatabaseOnce;
use Tests\TestCase;

class RouteAccessTest extends TestCase
{
    use RefreshDatabaseOnce;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_visit_practice_index_if_can_view_practices()
    {
        $this->user->givePermissionTo('view practices');
        $response = $this->actingAs($this->user)->get(route('practice.index'));

        $response->assertStatus(200);
    }

    public function test_cannot_visit_practice_index_if_cannot_view_practices()
    {
        $response = $this->actingAs($this->user)->get(route('practice.index'));

        $response->assertStatus(403);
    }
}
