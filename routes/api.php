<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/tweets'], function () {
    $controller = TweetController::class;
    Route::get('/', [$controller, 'index']);
    Route::get('/{tweet}', [$controller, 'show']);
    Route::post('/', [$controller, 'store'])->middleware('auth:sanctum');
    Route::post('/{tweet}/like', [$controller, 'like'])->middleware('auth:sanctum');
});

Route::group(['prefix' => '/users'], function () {
    $controller = UserController::class;
    Route::get('/top', [$controller, 'topUsers']);
    Route::get('/{user}', [$controller, 'show']);
    Route::get('/{user}/tweets', [$controller, 'tweets']);
});


Route::group(['prefix' => '/me'], function () {
    Route::get('/', [UserController::class, 'me'])->middleware('auth:sanctum');
    Route::put('/', [UserController::class, 'updateMe'])->middleware('auth:sanctum');
    Route::delete('/', [UserController::class, 'deleteMe'])->middleware('auth:sanctum');
});

Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/auth', [LoginController::class, 'checkAuth'])->middleware('auth:sanctum');
