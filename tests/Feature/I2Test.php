<?php

namespace Tests\Feature;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class I2Test extends TestCase
{
    public function test_endpoint_post_tweets_id_like_own_tweet_likes_remain(): void
    {
        $tweet = $this->createAndLikeOwnTweet();

        $this->assertEquals(0, $tweet->fresh()->likes->count());
    }

    public function test_endpoint_post_tweets_id_like_own_tweet_returns_error(): void
    {
        $response = $this->postJson('/api/tweets/' . $this->createAndLikeOwnTweet()->id . '/like');

        $response->assertStatus(409);
        $response->assertJsonStructure([
            'message'
        ]);
    }

    private function createAndLikeOwnTweet()
    {
        Model::unguard();

        $user = Sanctum::actingAs(User::factory()->create());
        $tweet = $user->tweets()->create(Tweet::factory()->make()->toArray());

        $this->postJson('/api/tweets/' . $tweet->id . '/like');
        return $tweet;
    }
}
