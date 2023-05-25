<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class I1Test extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_tweet_factory_creates_between_0_and_50_tweets_per_user(): void
    {
        $tweetsCounts = $this->getTweetsCounts();

        $this->assertGreaterThanOrEqual(0, $tweetsCounts->min());
        $this->assertLessThanOrEqual(50, $tweetsCounts->max());
    }

    public function test_tweet_factory_creates_random_number_of_tweets_per_user(): void
    {
        $tweetsCounts = $this->getTweetsCounts();

        $this->assertTrue($tweetsCounts->unique()->count() > 1);
    }

    private function getTweetsCounts()
    {
        $tweetsCounts = User::with('tweets')->get()->map(function ($user) {
            return $user->tweets->count();
        });
        return $tweetsCounts;
    }
}
