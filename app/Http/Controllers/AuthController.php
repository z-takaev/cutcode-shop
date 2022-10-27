<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateFormRequest;
use App\Http\Requests\PasswordRecoveryFormRequest;
use App\Http\Requests\PasswordResetFormRequest;
use App\Http\Requests\RegistrationFormRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

    public function passwordRecovery(PasswordRecoveryFormRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function passwordReset(Request $request)
    {
        return view('auth.password-reset', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    }

    public function passwordUpdate(PasswordResetFormRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('auth.sign-in')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function authenticate(AuthenticateFormRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.'
            ])
            ->onlyInput('email');
    }

    public function registration(RegistrationFormRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        event(new Registered($user));

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
