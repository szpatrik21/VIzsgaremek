<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\AdminCarController;
use App\Http\Controllers\CommentAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\CommentController;

// HOME
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/main', [HomeController::class, 'index'])->name('main');

// Regisztráció / bejelentkezés
Route::view('/register', 'auth.register')->name('register');
Route::view('/login', 'auth.login')->name('login');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Autók
Route::get('/autok', [AutoController::class, 'index'])->name('autok.index');
Route::get('/autok/{auto}', [AutoController::class, 'show'])->name('autok.show');

// Cart / comment / profil
Route::get('/cart', fn() => view('cart'))->name('cart');
Route::get('/comments', fn() => view('comments'))->name('comments');
Route::view('/profile', 'profile')->name('profile');

Route::middleware('auth:api')->post(
    '/upload-profile-image',
    [UserController::class, 'uploadProfileImage']
)->name('profile.upload-image');

// Ajánlatkérés
Route::get('/autok/{auto}/offer', [OfferController::class, 'create'])->name('offer.create');
Route::post('/autok/{auto}/offer', [OfferController::class, 'store'])->name('offer.store');

// ADMIN webes login/register oldalak
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

Route::get('/admin/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.post');

// Webes komment route-ok
Route::get('/autok/{auto}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/autok/{auto}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::view('/createcars', 'createcars')->name('createcars');

Route::get('/kapcsolat', function () {
    return view('contact');
})->name('contact');

Route::get('/gyik', function () {
    return view('gyik');
})->name('gyik');

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        $usersCount    = \App\Models\User::count();
        $carsCount     = \App\Models\Auto::count();
        $availableCars = \App\Models\Auto::where('raktaron', '>', 0)->count();
        $adminsCount   = \App\Models\Admin::count();

        return view('admin.dashboard', compact(
            'usersCount',
            'carsCount',
            'availableCars',
            'adminsCount'
        ));
    })->name('dashboard');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/carcreate', [AdminCarController::class, 'create'])->name('carcreate');
    Route::post('/carcreate', [AdminCarController::class, 'store'])->name('carcreate.store');

    Route::get('/cars', [AdminCarController::class, 'adminIndex'])->name('cars');
    Route::patch('/cars/{auto}', [AdminCarController::class, 'adminUpdate'])->name('cars.update');
    Route::delete('/cars/{auto}', [AdminCarController::class, 'adminDestroy'])->name('cars.destroy');

    Route::get('/comments', function () {
        $comments = \App\Models\Comment::with(['user','auto'])
            ->latest()
            ->paginate(10);

        return view('admin.comment', compact('comments'));
    })->name('comments.index');

    Route::delete('/comments/{comment}', [CommentAdminController::class, 'destroy'])
        ->name('comments.destroy');

    Route::get('/users', function () {
        $users = \App\Models\User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    })->name('users.index');

    Route::delete('/users/{user}', [UserAdminController::class, 'destroy'])
        ->name('users.destroy');
});