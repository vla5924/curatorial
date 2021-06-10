<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    public function test_redirects_to_login_if_unauthorized()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_no_redirect_if_authorized()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }
}
