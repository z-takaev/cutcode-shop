<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SignInController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignInControllerTest extends TestCase
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
                SignInController::class,
                'page'
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
    public function it_sign_in_page_redirect_authorized_user(): void
    {
        $user = UserFactory::new()->create();

        $this->actingAs($user);

        $this->assertAuthenticatedAs($user);

        $response = $this->get(
            action([
                SignInController::class,
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
    public function it_login_success(): void
    {
        $password = '123456789';

        $user = UserFactory::new()->create([
            'email' => 'testing@gmail.com',
            'password' => bcrypt($password)
        ]);

        $response = $this->post(
            action([
                SignInController::class,
                'handle'
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
    public function it_login_invalid_password(): void
    {
        $user = UserFactory::new()->create([
            'email' => 'testing@gmail.com',
            'password' => bcrypt('123456789')
        ]);

        $response = $this->post(
            action([
                SignInController::class,
                'handle'
            ]),
            [
                'email' => $user['email'],
                'password' => '987654321'
            ]
        );

        $this->assertGuest();

        $response
            ->assertInvalid(['email' => 'The provided credentials do not match our records.']);
    }

    /**
     * @test
     * @return void
     */
    public function it_logout_success(): void
    {
        $user = UserFactory::new()->create();

        $this->actingAs($user)
            ->delete(
                action([
                    SignInController::class,
                    'logout'
                ])
            );

        $this->assertGuest();
    }

}
