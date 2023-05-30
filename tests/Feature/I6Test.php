<?php

namespace Tests\Feature;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class I6Test extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_endpoint_post_tweets_id_like_only_works_once_for_each_user(): void
    {
        Model::unguard();

        $user = Sanctum::actingAs(User::factory()->create());
        $tweet = $user->tweets()->create(Tweet::factory()->make()->toArray());

        Sanctum::actingAs(User::factory()->create());
        $this->postJson('/api/tweets/' . $tweet->id . '/like');
        $this->postJson('/api/tweets/' . $tweet->id . '/like');

        $this->assertEquals(1, $tweet->fresh()->likes->count());
    }

    public function test_endpoint_get_user_id_returns_asserted_data_with_liked_tweets()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Model::unguard();

        Tweet::factory()->count(10)->create([
            'user_id' => User::factory()->create()->id,
        ]);
        $user = Sanctum::actingAs(User::factory()->create());
        $user->likes()->attach([2, 3, 5, 8]);

        $response = $this->get('/api/users/' . $user->id);

        $this->assertEquals([2, 3, 5, 8], $response->json('data.liked_tweets'));
    }

    public function test_endpoint_get_users_id_returns_positive_is_valid_if_likes_more_than_10000()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $user = User::factory()->create();

        $tweet = Tweet::factory()->create(['user_id' => $user->id]);

        $tweet->likes()->attach(User::factory()->count(10000)->create()->pluck('id')->toArray());

        $response = $this->getJson('/api/users/' . $user->id);
        $response->assertJsonPath('data.is_verified', true);
    }

    public function test_endpoint_get_users_id_returns_negative_is_valid_if_likes_less_than_10000()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $user = User::factory()->create();

        $tweet = Tweet::factory()->create(['user_id' => $user->id]);

        $tweet->likes()->attach(User::factory()->count(9999)->create()->pluck('id')->toArray());

        $response = $this->getJson('/api/users/' . $user->id);
        $response->assertJsonPath('data.is_verified', false);
    }
}
