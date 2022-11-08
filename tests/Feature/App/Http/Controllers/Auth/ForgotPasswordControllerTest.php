<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Database\Factories\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_forgot_password_page_success(): void
    {
        $response = $this->get(
            action([
                ForgotPasswordController::class,
                'page'
            ])
        );

        $response
            ->assertOk()
            ->assertViewIs('auth.forgot-password')
            ->assertSee('Восстановление пароля');
    }

    /**
     * @test
     * @return void
     */
    public function it_forgot_password_page_redirect_authorized_user(): void
    {
        $user = UserFactory::new()->create();

        $this->actingAs($user);

        $this->assertAuthenticatedAs($user);

        $response = $this->get(
            action([
                ForgotPasswordController::class,
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
    public function it_forgot_password_success(): void
    {
        Notification::fake();

        $user = UserFactory::new()->create([
            'email' => 'testing@gmail.com'
        ]);

        $response = $this->post(
            action([
                ForgotPasswordController::class,
                'handle'
            ]),
            ['email' => $user->email]
        );

        Notification::assertSentTo($user, ResetPassword::class);

        $response
            ->assertValid()
            ->assertSessionHas('status', __(Password::RESET_LINK_SENT));
    }

    /**
     * @test
     * @return void
     */
    public function it_forgot_password_invalid_email(): void
    {
        $response = $this->post(
            action([
                ForgotPasswordController::class,
                'handle'
            ]),
            ['email' => 'testing@gmail.com']
        );

        $response
            ->assertInvalid(['email' => "We can't find a user with that email address."]);
    }
}
