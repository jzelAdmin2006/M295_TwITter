<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class F2Test extends TestCase
{
    public function test_endpoint_post_login_returns_token_with_valid_credentials(): void
    {
        $user = User::factory()->state([
            'password' => bcrypt('password')
        ])->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertJsonStructure(['token']);
    }
}
