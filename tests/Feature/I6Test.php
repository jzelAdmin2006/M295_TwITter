<?php

namespace Tests\Feature;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class I6Test extends TestCase
{
    use RefreshDatabase;

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

    public function test_endpoint_get_users_id_returns_positive_is_valid_if_likes_more_than_10000()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $user = User::factory()->create();
        $likingUsers = User::factory()->count(10000)->create();

        $tweet = Tweet::factory()->create(['user_id' => $user->id]);

        $likingUsersIds = $likingUsers->pluck('id')->toArray();
        $tweet->likes()->attach($likingUsersIds);

        $response = $this->getJson('/api/users/' . $user->id);
        $response->assertJsonPath('data.is_verified', true);
    }

    public function test_endpoint_get_users_id_returns_negative_is_valid_if_likes_less_than_10000()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $user = User::factory()->create();
        $likingUsers = User::factory()->count(9999)->create();

        $tweet = Tweet::factory()->create(['user_id' => $user->id]);

        $likingUsersIds = $likingUsers->pluck('id')->toArray();
        $tweet->likes()->attach($likingUsersIds);

        $response = $this->getJson('/api/users/' . $user->id);
        $response->assertJsonPath('data.is_verified', false);
    }
}
