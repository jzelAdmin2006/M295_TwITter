<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class E4Test extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_endpoint_get_users_id_returns_asserted_data_format()
    {
        $response = $this->getJson('/api/users/1');
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'created_at',
                'is_verified',
            ]
        ]);
    }

    public function test_endpoint_get_tweets_id_returns_asserted_data_format()
    {
        $response = $this->getJson('/api/tweets');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'is_verified',
                    ]
                ]
            ]
        ]);
    }
}
