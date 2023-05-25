<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            return ['token' => $request->user()->createToken('auth_token')->plainTextToken];
        } else {
            return response()->json([
                'errors' => ['general' => 'E-Mail oder Passwort falsch.']
            ], 422);
        }
    }
}
