<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        return UserResource::make(User::findOrFail($id));
    }

    public function tweets($id)
    {
        return TweetResource::collection(User::findOrFail($id)->tweets()->with('user')->latest()->take(10)->get());
    }
}
