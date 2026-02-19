<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentApiController;
use App\Http\Controllers\UserController;

Route::middleware('auth:api')->post('/upload-profile-image', [UserController::class, 'uploadProfileImage']);



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('/comments', [CommentApiController::class, 'index']);
Route::middleware('auth:api')->post('/comments', [CommentApiController::class, 'store']);

use App\Http\Controllers\OfferApiController;

Route::middleware('auth:api')->post('/cars/{auto}/offer', [OfferApiController::class, 'store']);



