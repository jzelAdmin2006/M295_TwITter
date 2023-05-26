<?php

namespace Tests\Feature;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class I6Test extends TestCase
{
    public function test_endpoint_post_tweets_id_like_only_works_once_for_each_user(): void
    {
        Model::unguard();

        $user = Sanctum::actingAs(User::factory()->create());
        $tweet = $user->tweets()->create(Tweet::factory()->make()->toArray());

        Sanctum::actingAs(User::factory()->create());
        $this->postJson('/api/tweets/' . $tweet->id . '/like');
        $this->postJson('/api/tweets/' . $tweet->id . '/like');


        $this->assertEquals(1, $tweet->fresh()->likes);
    }

    public function test_endpoint_get_user_id_returns_asserted_data_format_with_liked_tweets()
    {
        Model::unguard();

        Tweet::factory()->count(10)->create();
        $user = Sanctum::actingAs(User::factory()->create());
        $user->likedTweets()->attach([1, 2, 3, 5, 8]);

        $response = $this->get('/api/users/' . $user->id);

        $this->assertEquals([1, 2, 3, 5, 8], $response->json()['data']['liked_tweets']);
    }
}
