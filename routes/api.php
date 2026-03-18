<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentApiController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminStatsController;
use App\Http\Controllers\AdminCarController;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\Api\AutoApiController;
use App\Http\Controllers\Api\CommentApiController2;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\Admin\AdminCommentController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Admin\AdminDashboardController;

Route::get('/ping', fn () => response()->json(['ok' => true]));

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);

// AUTHENTICATED USER
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/upload-profile-image', [UserController::class, 'uploadProfileImage']);

    Route::post('/change-password', [ProfileController::class, 'changePassword']);
    Route::get('/my-comments', [ProfileController::class, 'myComments']);
    Route::delete('/my-comments/{comment}', [ProfileController::class, 'deleteMyComment']);

    Route::post('/autok/{auto}/comments', [CommentApiController::class, 'store']);
});

// AUTÓK
Route::get('/autok', [AutoApiController::class, 'index']);
Route::get('/autok/{id}', [AutoApiController::class, 'show']);
Route::post('/autok', [AutoApiController::class, 'store']);
Route::get('/featured-cars', [AutoApiController::class, 'featured']);

// AJÁNLATKÉRÉS
Route::post('/offers/{auto}', [OfferController::class, 'storeApi']);

// KOMMENTEK
Route::get('/autok/{auto}/comments', [CommentApiController::class, 'index']);

// ADMIN AUTH
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// ADMIN AUTÓK
Route::get('/admin/cars', [AdminCarController::class, 'apiIndex']);
Route::post('/admin/cars', [AdminCarController::class, 'store']);
Route::patch('/admin/cars/{auto}', [AdminCarController::class, 'apiUpdate']);
Route::delete('/admin/cars/{auto}', [AdminCarController::class, 'apiDestroy']);

// ADMIN STATS
Route::get('/admin/stats', [AdminStatsController::class, 'stats']);

// ADMIN USERS / DASHBOARD
Route::get('/admin/users', [AdminUserController::class, 'index']);
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index']);

// ADMIN COMMENTS
Route::get('/admin/comments', [AdminCommentController::class, 'index']);
Route::patch('/admin/comments/{id}/approve', [AdminCommentController::class, 'approve']);
Route::patch('/admin/comments/{id}/reject', [AdminCommentController::class, 'reject']);
Route::delete('/admin/comments/{id}', [AdminCommentController::class, 'destroy']);

// EGYÉB KOMMENT API, ha tényleg használod
Route::get('/cars/{id}/comments', [CommentController::class, 'indexByCar']);
Route::post('/comments', [CommentController::class, 'store']);

use App\Http\Controllers\AiController;

Route::post('/ai/chat', [AiController::class, 'chat']);
