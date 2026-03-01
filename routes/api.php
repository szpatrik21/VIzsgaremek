<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentApiController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| AUTH (JWT)
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/upload-profile-image', [UserController::class, 'uploadProfileImage']);
});

/*
|--------------------------------------------------------------------------
| COMMENTS (autóhoz kötve)
|--------------------------------------------------------------------------
| GET  /api/autok/{auto}/comments   -> publikus (mindenki látja)
| POST /api/autok/{auto}/comments   -> védett (JWT kell)
*/
Route::get('/autok/{auto}/comments', [CommentApiController::class, 'index']);
Route::middleware('auth:api')->post('/autok/{auto}/comments', [CommentApiController::class, 'store']);