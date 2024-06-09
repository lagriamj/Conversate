<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::prefix('users')->group(function () {
        Route::post('/{id}', [UserController::class, 'showPosts']);
        Route::get('/profile', [UserController::class, 'getUser']);
        Route::patch('/profile/{id}', [UserController::class, 'update']);
    });

    Route::prefix('posts')->group(function () {
        Route::post('/', [PostController::class, 'index']);
        Route::post('/store', [PostController::class, 'store']);
        Route::patch('/{id}', [PostController::class, 'update']);
        Route::delete('/{id}', [PostController::class, 'delete']);
        Route::get('/{id}', [PostController::class, 'get']);
        Route::post('/like/{id}', [PostController::class, 'like']);
        Route::delete('/unlike/{id}', [PostController::class, 'unlike']);
    });

    Route::prefix('comments')->group(function () {
        Route::post('/store/{id}', [CommentController::class, 'store']);
        Route::patch('/{id}', [CommentController::class, 'update']);
        Route::delete('/{id}', [CommentController::class, 'delete']);
        Route::post('/like/{id}', [CommentController::class, 'like']);
        Route::delete('/unlike/{id}', [CommentController::class, 'unlike']);
    });
});

Route::post('/login', [LoginController::class, 'login']);