<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\RefreshDatabaseOnce;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabaseOnce;

    public function test_redirects_to_login_if_unauthorized()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_redirect_to_forbidden_if_authorized_noname()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(403);
    }

    public function test_no_redirect_if_authorized_user()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }

    public function test_no_redirect_if_authorized_admin()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }
}
