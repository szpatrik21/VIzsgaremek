<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return 'http://localhost:4201/reset-password?token=' . $token . '&email=' . urlencode($user->email);
        });
    }
}