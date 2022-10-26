<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::get('/sign-in', 'signIn')->name('auth.sign-in');
    Route::get('/sign-up', 'signUp')->name('auth.sign-up');
    Route::get('/forgot-password', 'forgotPassword')->name('auth.forgot-password');
    Route::get('/password-recovery', 'passwordRecovery')->name('auth.password-recovery');
});
