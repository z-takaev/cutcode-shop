<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_sign_in_page_success(): void
    {
        $response = $this->get(
            action([
                AuthController::class,
                'signIn'
            ])
        );

        $response
            ->assertOk()
            ->assertViewIs('auth.sign-in')
            ->assertSee('Вход в аккаунт');
    }

    /**
     * @test
     * @return void
     */
    public function it_sign_up_page_success(): void
    {
        $response = $this->get(
            action([
                AuthController::class,
                'signUp'
            ])
        );

        $response
            ->assertOk()
            ->assertViewIs('auth.sign-up')
            ->assertSee('Регистрация аккаунта');
    }

    /**
     * @test
     * @return void
     */
    public function it_forgot_password_page_success(): void
    {
        $response = $this->get(
            action([
                AuthController::class,
                'forgotPassword'
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
    public function it_password_reset_page_success(): void
    {
        $response = $this->get(
            action([
                AuthController::class,
                'passwordReset'
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
    public function it_registration_success(): void
    {
        Event::fake();

        $password = '123456789';

        $user = [
            'name' => 'testing',
            'email' => 'testing@gmail.com',
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $this->assertDatabaseMissing(
            'users',
            ['email' => $user['email']]
        );

        $response = $this->post(
            action([AuthController::class, 'registration']),
            $user
        );

        $this->assertDatabaseHas(
            'users',
            ['email' => $user['email']]
        );

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailVerificationNotification::class);

        $event = new Registered($user);
        $listener = new SendEmailVerificationNotification();

        $listener->handle($event);

        $createdUser = User::where('email', $user['email'])
            ->first();

        $this->assertAuthenticatedAs($createdUser);

        $response
            ->assertValid()
            ->assertRedirect(route('home'));
    }

    /**
     * @test
     * @return void
     */
    public function it_authenticate_success(): void
    {
        $password = '123456789';

        $user = User::factory()->create([
            'email' => 'testing@gmail.com',
            'password' => bcrypt($password)
        ]);

        $response = $this->post(
            action([
                AuthController::class,
                'authenticate'
            ]),
            [
                'email' => $user['email'],
                'password' => $password
            ]
        );

        $this->assertAuthenticatedAs($user);

        $response
            ->assertValid()
            ->assertRedirect(route('home'));
    }

    /**
     * @test
     * @return void
     */
    public function it_logout_success(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->delete(
                action([
                    AuthController::class,
                    'logout'
                ])
            );

        $this->assertGuest();
    }
}
