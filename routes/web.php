<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

// ==============================================
// HOME
// ==============================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/main', [HomeController::class, 'index'])->name('main');
