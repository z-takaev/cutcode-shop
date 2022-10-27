<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::get('/sign-in', 'signIn')->name('auth.sign-in');
    Route::get('/sign-up', 'signUp')->name('auth.sign-up');
    Route::get('/forgot-password', 'forgotPassword')->name('auth.forgot-password');
    Route::get('/password-reset', 'passwordReset')->name('password.reset');

    Route::post('/authenticate', 'authenticate')->name('auth.authenticate');
    Route::post('/registration', 'registration')->name('auth.registration');
    Route::post('/password-recovery', 'passwordRecovery')->name('auth.password-recovery');
    Route::post('/password-update', 'passwordUpdate')->name('auth.password-update');
    Route::delete('/logout', 'logout')->name('auth.logout');
});
