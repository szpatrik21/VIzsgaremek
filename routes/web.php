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


// HOME

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/main', [HomeController::class, 'index'])->name('main');

// Regisztráció bejelentkezés

Route::view('/register', 'auth.register')->name('register');
Route::view('/login', 'auth.login')->name('login');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');



Route::get('/autok', [AutoController::class, 'index'])->name('autok.index');
Route::get('/autok/{auto}', [AutoController::class, 'show'])->name('autok.show');

// CART / comment, profil

Route::get('/cart', fn() => view('cart'))->name('cart');
Route::get('/comments', fn() => view('comments'))->name('comments');
Route::view('/profile', 'profile')->name('profile');

Route::middleware('auth:api')->post(
    '/upload-profile-image',
    [UserController::class, 'uploadProfileImage']
)->name('profile.upload-image');

// Ajánlatkérés)

Route::get('/autok/{auto}/offer', [OfferController::class, 'create'])->name('offer.create');
Route::post('/autok/{auto}/offer', [OfferController::class, 'store'])->name('offer.store');

// ADMIN regisztráció bejelentkezés

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

Route::get('/admin/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.post');

Route::middleware('admin')->group(function () {

    Route::get('/admin/dashboard', function () {
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
    })->name('admin.dashboard');

    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Autó feltöltés form + mentés
    Route::get('/admin/carcreate', [AdminCarController::class, 'create'])->name('admin.carcreate');
    Route::post('/admin/carcreate', [AdminCarController::class, 'store'])->name('admin.carcreate.store');

    // Admin autó lista + update + delete
    Route::get('/admin/cars', [AdminCarController::class, 'adminIndex'])->name('admin.cars');
    Route::patch('/admin/cars/{auto}', [AdminCarController::class, 'adminUpdate'])->name('admin.cars.update');
    Route::delete('/admin/cars/{auto}', [AdminCarController::class, 'adminDestroy'])->name('admin.cars.destroy');
});


Route::view('/createcars', 'createcars')->name('createcars');


Route::get('/autok/{auto}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/autok/{auto}/comments', [CommentController::class, 'store'])->name('comments.store');




Route::get('/autok/{auto}/comments', [CommentApiController::class, 'index']);
Route::post('/autok/{auto}/comments', [CommentApiController::class, 'store'])->middleware('auth:api');


Route::get('/autok/{auto}', [AutoController::class, 'show'])->name('autok.show');

Route::get('/admin/cars', [AdminCarController::class, 'adminIndex'])->name('admin.cars');
Route::patch('/admin/cars/{auto}', [AdminCarController::class, 'adminUpdate'])->name('admin.cars.update');
Route::delete('/admin/cars/{auto}', [AdminCarController::class, 'adminDestroy'])->name('admin.cars.destroy');

Route::get('/kapcsolat', function () {
    return view('contact');
})->name('contact');


Route::get('/gyik', function () {
    return view('gyik');
})->name('gyik');



Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/comments', function () {
        $comments = \App\Models\Comment::with(['user','auto'])
            ->latest()
            ->paginate(10);

        return view('admin.comment', compact('comments'));
    })->name('comments.index');

    Route::delete('/comments/{comment}', [CommentAdminController::class, 'destroy'])
        ->name('comments.destroy');
});





Route::prefix('admin')->name('admin.')->group(function () {

Route::get('/users', function () {
    $users = \App\Models\User::latest()->paginate(10);
    return view('admin.users', compact('users'));
})->name('users.index');

    Route::delete('/users/{user}', [UserAdminController::class, 'destroy'])
        ->name('users.destroy');
});




Route::delete('/admin/users/{user}', [UserAdminController::class, 'destroy'])
    ->name('admin.users.destroy');

    Route::delete('/admin/comments/{comment}', [CommentAdminController::class, 'destroy'])
    ->name('admin.comments.destroy');