<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:4200');

            return $frontendUrl.'/reset-password?token='.$token.'&email='.urlencode($user->email);
        });
    }
}