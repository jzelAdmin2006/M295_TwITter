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
        return UserResource::make(User::find($id));
    }

    public function tweets($id)
    {
        return TweetResource::collection(User::find($id)->tweets()->latest()->take(10)->get());
    }
}
