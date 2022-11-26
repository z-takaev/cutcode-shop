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

    private function testingCredentials(): array
    {
        return [
            'email' => 'testing@cutcode.ru'
        ];
    }

    /**
     * @test
     * @return void
     */
    public function it_page_success(): void
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
    public function it_handle_success(): void
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
    public function it_handle_fail(): void
    {
        $this->assertDatabaseMissing('users', $this->testingCredentials());

        $this->post(
            action([
                ForgotPasswordController::class,
                'handle'
            ]),
            $this->testingCredentials()
        )
            ->assertInvalid(['email']);

        Notification::assertNothingSent();
    }
}
