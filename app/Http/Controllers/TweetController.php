<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index()
    {
        return TweetResource::collection(Tweet::with(['user', 'user.tweets'])->latest()->take(100)->get());
    }

    public function show($id)
    {
        return TweetResource::make(Tweet::findOrFail($id));
    }

    public function like(Request $request, $id)
    {
        $tweet = Tweet::findOrFail($id);
        $tweet->likes++;
        $tweet->save();
        return TweetResource::make($tweet);
    }
}
