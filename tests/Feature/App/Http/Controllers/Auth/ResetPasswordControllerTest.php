<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBroker;
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
    public function it_password_reset_page_redirect_authorized_user(): void
    {
        $user = UserFactory::new()->create();

        $this->actingAs($user);

        $this->assertAuthenticatedAs($user);

        $response = $this->get(
            action([
                ResetPasswordController::class,
                'page'
            ])
        );

        $response
            ->assertRedirect(route('home'));
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

    /**
     * @test
     * @return void
     */
    public function it_password_reset_invalid_form_data(): void
    {
        $response = $this->post(
            action([
                ResetPasswordController::class,
                'handle'
            ]),
            [
                'email' => '',
                'password' => '',
                'token' => ''
            ]
        );

        $response
            ->assertInvalid(['email', 'password', 'token']);
    }

    /**
     * @test
     * @return void
     */
    public function it_password_reset_invalid_token(): void
    {
        $user = UserFactory::new()->create();
        $newPassword = '123456789';

        $response = $this->post(
            action([
                ResetPasswordController::class,
                'handle'
            ]),
            [
                'email' => $user->email,
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
                'token' => str()->random(10)
            ]
        );

        $response
            ->assertInvalid(['email' => __(PasswordBroker::INVALID_TOKEN)]);
    }
}
