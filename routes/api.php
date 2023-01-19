<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
});

Route::prefix('follow')->group(function () {
    Route::post('/', [FollowController::class, 'index']);
    Route::post('/following', [FollowController::class, 'store']);
    Route::post('/unfollow', [FollowController::class, 'destroy']);
});

Route::prefix('post')->group(function () {
    Route::get('/', [PostController::class, 'index']);
});
