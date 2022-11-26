<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
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

    private string $token;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::new()->create();
        $this->token = Password::createToken($this->user);
    }

    /**
     * @test
     * @return void
     */
    public function it_page_success(): void
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
    public function it_handle_success(): void
    {
        $password = '1234567890';
        $password_confirmation = '1234567890';

        Password::shouldReceive('reset')
            ->once()
            ->withSomeofArgs([
                'email' => $this->user->email,
                'password' => $password,
                'password_confirmation' => $password_confirmation,
                'token' => $this->token
            ])
            ->andReturn(Password::PASSWORD_RESET);

        $response = $this->post(action([ResetPasswordController::class, 'handle']), [
            'email' => $this->user->email,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
            'token' => $this->token
        ]);

        $response->assertRedirect(action([SignInController::class, 'page']));
    }
}
