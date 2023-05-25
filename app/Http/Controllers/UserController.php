<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\TweetResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        return UserResource::make($user);
    }

    public function tweets(User $user)
    {
        return TweetResource::collection($user->tweets()->with('user')->latest()->take(10)->get());
    }

    public function me(Request $request)
    {
        return UserResource::make($request->user());
    }

    public function updateMe(UpdateUserRequest $request)
    {
        $user = $request->user();

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return UserResource::make($user);
    }
}
