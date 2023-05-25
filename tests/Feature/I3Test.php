<?php

namespace Tests\Feature;

use App\Models\Tweet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class I3Test extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_endpoint_get_users_top_returns_asserted_json_structure(): void
    {
        $response = $this->get('/api/users/top');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'is_verified',
                    'tweets_count'
                ]
            ]
        ]);
    }

    public function test_endpoint_get_users_top_returns_3_users_with_most_tweets(): void
    {
        $topUserIds = Tweet::selectRaw('user_id, count(*) as count')
            ->groupBy('user_id')
            ->orderBy('count', 'desc')
            ->take(3)
            ->pluck('user_id')
            ->toArray();

        $response = $this->get('/api/users/top');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => array_map(function ($id) {
                return ['id' => $id];
            }, $topUserIds)
        ]);
    }
}
