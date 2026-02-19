<?php

use App\Http\Controllers\AutoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;

Route::get('/main', [HomeController::class, 'index'])->name('main');


// ==============================================
// PUBLIC ROUTES
// ==============================================

// Főoldal
Route::get('/', function () {
    return view('welcome');
});

// Regisztrációs oldal
Route::view('/register', 'auth.register')->name('register');

// Bejelentkezési oldal
Route::view('/login', 'auth.login')->name('login');

// Regisztráció POST
Route::post('/register', [AuthController::class, 'register']);

// Bejelentkezés POST
Route::post('/login', [AuthController::class, 'login']);

// Fő oldal / dashboard
//Route::get('/main', function () {
 //   return view('main_page');
//})->name('main');


// ==============================================
// AUTÓ OLDALAK (STATIC PAGES)
// ==============================================

Route::get('/alfa_romeo', fn() => view('cars.alfaromeo'))->name('alfaromeo');
Route::get('/aston_martin_db11', fn() => view('cars.astonmartin'))->name('astonmartin');
Route::get('/audi_r8_v10_performance', fn() => view('cars.audir8'))->name('audir8');
Route::get('/bentley_continental', fn() => view('cars.bentleycontinental'))->name('bentleycontinental');
Route::get('/bmw_m8_competition', fn() => view('cars.bmwm8'))->name('bmwm8');
Route::get('/bugatti_chiron', fn() => view('cars.bugattichiron'))->name('bugattichiron');
Route::get('/ferrari_laferrari', fn() => view('cars.ferrarilaferrari'))->name('ferrarilaferrari');
Route::get('/jaguar_f_type_r', fn() => view('cars.jaguarf'))->name('jaguarf');
Route::get('/koenigsegg_jesko', fn() => view('cars.koenigsegg'))->name('koenigsegg');
Route::get('/lamborghini_aventador', fn() => view('cars.lamborghini'))->name('lamborghini');
Route::get('/lexus_lc_500', fn() => view('cars.lexus'))->name('lexus');
Route::get('/lotus_evija', fn() => view('cars.lotus'))->name('lotus');
Route::get('/maserati_mc20', fn() => view('cars.maserati'))->name('maserati');
Route::get('/maybach_s680', fn() => view('cars.maybach'))->name('maybach');
Route::get('/mclaren_7205', fn() => view('cars.mclaren'))->name('mclaren');
Route::get('/mercedes_benz_amg_gt_black_series', fn() => view('cars.mercedesbenz'))->name('mercedesbenz');
Route::get('/pagani_huayra', fn() => view('cars.pagani'))->name('pagani');
Route::get('/porsche_911_turbo_s', fn() => view('cars.porsche911'))->name('porsche911');
Route::get('/rolls_royce_phantom', fn() => view('cars.rollsroyce'))->name('rollsroyce');
Route::get('/tesla_model_s_paid', fn() => view('cars.teslamodel'))->name('teslamodel');


// ==============================================
// NAVBAR OLDALAK
// ==============================================

Route::get('/cars', fn() => view('cars_list'))->name('cars');
Route::get('/cart', fn() => view('cart'))->name('cart');

// Autó dinamikus részletei
Route::get('/cars/{id}', [AutoController::class, 'show'])->name('car.details');


// ==============================================
// COMMENTS (AUTH REQUIRED)
// ==============================================

Route::get('/comments', function () {
    return view('comments'); // resources/views/comments.blade.php
})->name('comments');


// ==============================================
// ADMIN ROUTES
// ==============================================

// Admin login & regisztráció
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

Route::get('/admin/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.post');

// Admin protected
Route::middleware('admin')->group(function () {

    Route::get('/admin/dashboard', function () {

        $usersCount      = \App\Models\User::count();
        $carsCount       = \App\Models\Auto::count();
        $availableCars   = \App\Models\Auto::where('raktaron', '>', 0)->count();
        $adminsCount     = \App\Models\Admin::count();

        return view('admin.dashboard', compact(
            'usersCount',
            'carsCount',
            'availableCars',
            'adminsCount'
        ));
    })->name('admin.dashboard');

    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

//Profil oldal
Route::view('/profile', 'profile')->name('profile');

// Bejelentkezési oldal
Route::view('/admin/carcreate', 'admin.carcreate')->name('carcreate');

// Bejelentkezési oldal
Route::view('/createcars', 'createcars')->name('createcars');


Route::get('/', [HomeController::class, 'index'])->name('home');


use App\Http\Controllers\UserController;

Route::middleware('auth:api')
    ->post('/upload-profile-image', [UserController::class, 'uploadProfileImage']);


use App\Http\Controllers\OfferController;

Route::get('/cars/{auto}/offer', [OfferController::class, 'create'])->name('offer.create');
Route::post('/cars/{auto}/offer', [OfferController::class, 'store'])->name('offer.store');
