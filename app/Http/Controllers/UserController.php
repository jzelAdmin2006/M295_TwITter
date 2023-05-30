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

    public function deleteMe(Request $request)
    {
        $request->user()->delete();
        return response()->json([
            'message' => 'User deleted'
        ]);
    }

    public function topUsers()
    {
        $users = User::withCount('tweets')
            ->with('tweets')
            ->orderBy('tweets_count', 'desc')
            ->limit(3)
            ->get();

        return UserResource::collection($users);
    }

    public function newUsers()
    {
        $users = User::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return UserResource::collection($users);
    }
}
