<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Support\SessionRegenerator;

class SignInController extends Controller
{
    public function page()
    {
        return view('auth.sign-in');
    }

    public function handle(AuthenticateFormRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            SessionRegenerator::run();

            return redirect()->intended(route('home'));
        }

        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.'
            ])
            ->onlyInput('email');
    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {
        SessionRegenerator::run(fn() => Auth::logout());

        return redirect()->route('home');
    }
}
