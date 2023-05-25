<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTweetRequest;
use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index()
    {
        return TweetResource::collection(
            Tweet::with([
                'user' => function ($query) {
                    $query->withCount('tweets');
                },
                'user.tweets'
            ])->latest()->take(100)->get()
        );
    }

    public function show(Tweet $tweet)
    {
        return TweetResource::make($tweet);
    }

    public function store(StoreTweetRequest $request)
    {
        $tweet = new Tweet();
        $tweet->text = $request->text;
        $tweet->user_id = $request->user()->id;
        $tweet->save();
        return TweetResource::make($tweet);
    }

    public function like(Request $request, Tweet $tweet)
    {
        if ($request->user()->id === $tweet->user_id) {
            return response()->json([
                'message' => 'You cannot like your own tweet.'
            ], 409);
        } else {
            $tweet->likes++;
            $tweet->save();
            return TweetResource::make($tweet);
        }
    }
}
