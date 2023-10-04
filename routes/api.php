<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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

Route::middleware('auth:custom')->group(function () {


});
Route::get('posts', [PostController::class, 'index']);
Route::post('posts', [PostController::class, 'store']);


Route::get('posts/{post}/comments', [CommentController::class, 'index']);
Route::post('posts/{post}/comments', [CommentController::class, 'store']);
Route::post('posts/{post}/like', [LikeController::class, 'likePost']);
Route::delete('posts/{user_id}/{post}/like', [LikeController::class, 'dislikePost']);
Route::post('comments/{comment}/like', [LikeController::class,'likeComment']);



Route::delete('comments/{user_id}/{comment}/like', [LikeController::class, 'dislikeComment']);


