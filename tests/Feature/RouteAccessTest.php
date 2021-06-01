<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RouteAccessTest extends TestCase
{
    protected $user;
    protected $userId = 1;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make(['id' => $this->userId++]);
    }

    public function test_can_visit_practice_index_if_can_view_practices()
    {
        $this->user->givePermissionTo('view practices');
        $response = $this->actingAs($this->user)->get(route('practice.index'));

        $response->assertStatus(200);
    }
}
