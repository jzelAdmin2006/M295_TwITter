<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class H1Test extends TestCase
{
    public function test_endpoint_post_tweets_returns_creates_tweet_in_database(): void
    {
        $user = Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/tweets', [
            'text' => 'This is a tweet',
        ]);

        $this->assertDatabaseHas('tweets', [
            'text' => 'This is a tweet',
            'user_id' => $user->id,
        ]);
    }
}
