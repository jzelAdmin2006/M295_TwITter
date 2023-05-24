<?php

namespace Tests\Feature;

use Tests\TestCase;

class F1Test extends TestCase
{
    public function test_endpoint_post_login_does_not_return_404(): void
    {
        $response = $this->post('/api/login', []);

        $this->assertNotEquals(404, $response->getStatusCode());
    }

    public function test_endpoint_post_login_returns_422_without_valid_credentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => '',
            'password' => ''
        ]);

        $response->assertStatus(422);
    }
}
