<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class I4Test extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_endpoint_get_users_new_returns_asserted_json_structure(): void
    {
        $response = $this->get('/api/users/new');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'created_at',
                ]
            ]
        ]);
    }

    public function test_endpoint_get_users_new_returns_3_newest_users(): void
    {
        $newestUserIds = User::latest()
            ->take(3)
            ->pluck('id')
            ->toArray();

        $response = $this->get('/api/users/new');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => array_map(function ($id) {
                return ['id' => $id];
            }, $newestUserIds)
        ]);
    }
}
