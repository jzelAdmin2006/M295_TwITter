<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        $user = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
        return UserResource::make($user);
    }
}
