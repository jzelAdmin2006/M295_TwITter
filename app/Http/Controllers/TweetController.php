<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::latest()->take(100)->get();
        $tweets = $tweets->map(function ($tweet) {
            $tweet->user = [
                "id" => 1,
                "name" => "Franzi Musterfrau"
            ];
            return $tweet;
        });
        return TweetResource::collection($tweets);
    }
}
