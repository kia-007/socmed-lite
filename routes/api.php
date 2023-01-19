<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

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
    Route::post('/', [FollowController::class, 'index'])->middleware('jwt.verify');
    Route::post('/following', [FollowController::class, 'store'])->middleware('jwt.verify');
    Route::post('/unfollow', [FollowController::class, 'destroy'])->middleware('jwt.verify');
});

Route::prefix('post')->group(function () {
    Route::get('/', [PostController::class, 'index'])->middleware('jwt.verify');
    Route::post('/create', [PostController::class, 'store'])->middleware('jwt.verify');
    Route::post('/delete', [PostController::class, 'destroy'])->middleware('jwt.verify');
});

Route::prefix('like')->group(function () {
    Route::post('/create', [LikeController::class, 'store'])->middleware('jwt.verify');
    Route::post('/delete', [LikeController::class, 'destroy'])->middleware('jwt.verify');
});

Route::prefix('comment')->group(function () {
    Route::post('/create', [CommentController::class, 'store'])->middleware('jwt.verify');
    Route::post('/delete', [CommentController::class, 'destroy'])->middleware('jwt.verify');
});
