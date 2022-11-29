<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class AuthRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::controller(SignInController::class)->group(function () {
                Route::get('/login', 'page')->name('login')->middleware('guest');
                Route::post('/login', 'handle')->name('login.handle');
                Route::delete('/logout', 'logout')->name('logout');
            });

            Route::controller(SignUpController::class)->group(function () {
                Route::get('/registration', 'page')->name('registration')->middleware('guest');
                Route::post('/registration', 'handle')->name('registration.handle');
            });

            Route::controller(ForgotPasswordController::class)->group(function () {
                Route::get('/forgot-password', 'page')->name('forgot-password')->middleware('guest');
                Route::post('/forgot-password', 'handle')->name('forgot-password.handle');
            });

            Route::controller(ResetPasswordController::class)->group(function () {
                Route::get('/password-reset', 'page')->name('password-reset')->middleware('guest');
                Route::post('/password-reset', 'handle')->name('password.reset');
            });

            Route::controller(SocialiteController::class)->group(function () {
                Route::get('/auth/{driver}/redirect', 'redirect')->name('socialite.redirect');
                Route::get('/auth/{driver}/callback', 'callback')->name('socialite.callback');
            });
        });
    }
}
