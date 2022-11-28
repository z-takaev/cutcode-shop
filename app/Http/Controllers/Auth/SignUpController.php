<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Support\Facades\Auth;

class SignUpController extends Controller
{
    public function page()
    {
        return view('auth.sign-up');
    }

    public function handle(RegistrationFormRequest $request, RegisterNewUserContract $action)
    {
//        $dto = new NewUserDTO(
//            $request->get('name'),
//            $request->get('email'),
//            $request->get('password')
//        );

        $user = $action(NewUserDTO::fromRequest($request));

        Auth::login($user);

        return redirect()->intended(route('home'));
    }
}
