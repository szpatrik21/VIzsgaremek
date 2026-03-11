<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentApiController;
use App\Http\Controllers\Api\AutoApiController;
use App\Http\Controllers\Api\CommentApiController2;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminStatsController;
use App\Http\Controllers\AdminCarController;

// --- PING ---
Route::get('/ping', fn () => response()->json(['ok' => true]));

// --- AUTH ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/upload-profile-image', [UserController::class, 'uploadProfileImage']);
});

// --- AUTÓK (PUBLIC) ---
Route::get('/autok', [AutoApiController::class, 'index']);
Route::get('/autok/{id}', [AutoApiController::class, 'show']);
Route::get('/featured-cars', [AutoApiController::class, 'featured']);

// --- AUTÓK (WRITE) ---
Route::post('/autok', [AutoApiController::class, 'store']);

// --- AJÁNLATKÉRÉS ---
Route::post('/offers/{auto}', [OfferController::class, 'storeApi']);

// --- KOMMENTEK ---
Route::get('/autok/{auto}/comments', [CommentApiController::class, 'index']);
Route::middleware('auth:api')->post('/autok/{auto}/comments', [CommentApiController::class, 'store']);

// --- ADMIN COMMENTS ---
Route::get('/admin-comments', [CommentApiController2::class, 'index']);
Route::delete('/admin-comments/{id}', [CommentApiController2::class, 'destroy']);

// --- ADMIN AUTH ---
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// --- ADMIN API ---
Route::post('/admin/cars', [AdminCarController::class, 'store']);

// --- ADMIN STATS ---
Route::get('/admin/stats', [AdminStatsController::class, 'stats']);

Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::get('/admin/cars', [AdminCarController::class, 'apiIndex']);
Route::patch('/admin/cars/{auto}', [AdminCarController::class, 'apiUpdate']);
Route::delete('/admin/cars/{auto}', [AdminCarController::class, 'apiDestroy']);

Route::get('/admin/autok', [AdminCarController::class, 'apiIndex']);
Route::post('/admin/autok', [AdminCarController::class, 'store']);
Route::put('/admin/autok/{auto}', [AdminCarController::class, 'apiUpdate']);
Route::delete('/admin/autok/{auto}', [AdminCarController::class, 'apiDestroy']);

Route::get('/featured-cars', [AdminCarController::class, 'featuredCars']);





Route::get('/featured-cars', [AdminCarController::class, 'featuredCars']);

Route::get('/admin/autok', [AdminCarController::class, 'apiIndex']);
Route::post('/admin/autok', [AdminCarController::class, 'store']);
Route::put('/admin/autok/{auto}', [AdminCarController::class, 'apiUpdate']);
Route::delete('/admin/autok/{auto}', [AdminCarController::class, 'apiDestroy']);


Route::get('/autok', [AdminCarController::class, 'apiIndex']);
Route::get('/featured-cars', [AdminCarController::class, 'featuredCars']);

Route::post('/admin/autok', [AdminCarController::class, 'store']);
Route::put('/admin/autok/{auto}', [AdminCarController::class, 'apiUpdate']);
Route::delete('/admin/autok/{auto}', [AdminCarController::class, 'apiDestroy']);


Route::middleware('auth:sanctum')->get('/admin/stats', [AdminController::class, 'stats']);



Route::get('/admin/stats', [AdminController::class, 'stats']);

use App\Http\Controllers\Api\Admin\AdminUserController;


Route::get('/admin/users', [AdminUserController::class, 'index']);

use App\Http\Controllers\Api\Admin\AdminDashboardController;

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index']);