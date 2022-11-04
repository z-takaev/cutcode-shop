<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_password_reset_page_success(): void
    {
        $response = $this->get(
            action([
                ResetPasswordController::class,
                'page'
            ])
        );

        $response
            ->assertOk()
            ->assertViewIs('auth.password-reset')
            ->assertSee('Сброс пароля');
    }

    /**
     * @test
     * @return void
     */
    public function it_password_reset_success(): void
    {
        Event::fake();

        $user = UserFactory::new()->create();

        $newPassword = '123456789';

        $this->assertDatabaseHas('users', ['email' => $user->email]);

        $response = $this->post(
            action([
                ResetPasswordController::class,
                'handle'
            ]),
            [
                'email' => $user->email,
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
                'token' => app('auth.password.broker')->createToken($user)
            ]
        );

        Event::assertDispatched(PasswordReset::class);

        $updatedUser = User::where('email', $user->email)->first();

        $isValidPassword = Hash::check($newPassword, $updatedUser->password);

        $this->assertTrue($isValidPassword);

        $response
            ->assertValid()
            ->assertSessionHas('status', __(Password::PASSWORD_RESET));
    }
}
