<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentApiController;
use App\Http\Controllers\UserController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/upload-profile-image', [UserController::class, 'uploadProfileImage']);
});


Route::get('/autok/{auto}/comments', [CommentApiController::class, 'index']);
Route::middleware('auth:api')->post('/autok/{auto}/comments', [CommentApiController::class, 'store']);