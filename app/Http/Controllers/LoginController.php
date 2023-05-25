<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return response()->json(['errors' => ['general' => 'E-Mail oder Passwort falsch.']], 422);
    }
}
