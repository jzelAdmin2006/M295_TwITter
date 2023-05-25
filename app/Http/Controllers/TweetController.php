<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index()
    {
        return TweetResource::collection(Tweet::with(['user', 'user.tweets'])->latest()->take(100)->get());
    }
}
