<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index()
    {
        return Tweet::with('user')->latest()->take(100)->get();
    }
}
