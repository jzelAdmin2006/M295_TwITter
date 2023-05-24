<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class F3Test extends TestCase
{
    public function test_endpoint_post_login_returns_token_as_plain_text_with_valid_credentials(): void
    {
        $user = User::factory()->state([
            'password' => bcrypt('password')
        ])->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $this->assertIsString($response['token']);
    }
}
