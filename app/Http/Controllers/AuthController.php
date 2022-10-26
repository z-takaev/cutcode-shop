<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function signIn()
    {
        return view('auth.sign-in');
    }

    public function signUp()
    {
        return view('auth.sign-up');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function passwordRecovery()
    {
        return view('auth.password-recovery');
    }
}
