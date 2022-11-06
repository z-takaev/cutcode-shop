<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SignUpController;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SignUpControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_sign_up_page_success(): void
    {
        $response = $this->get(
            action([
                SignUpController::class,
                'page'
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
    public function it_sign_up_page_redirect_authorized_user(): void
    {
        $user = UserFactory::new()->create();

        $this->actingAs($user);

        $this->assertAuthenticatedAs($user);

        $response = $this->get(
            action([
                SignUpController::class,
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
            action([
                SignUpController::class,
                'page'
            ]),
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
    public function it_registration_invalid_form_data(): void
    {
        $response = $this->post(
            action([
                SignUpController::class,
                'page'
            ]),
            []
        );

        $response
            ->assertInvalid(['name', 'email', 'password']);
    }

    /**
     * @test
     * @return void
     */
    public function it_registration_password_confirmation_fail(): void
    {
        $user = [
            'name' => 'testing',
            'email' => 'testing@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '987654321',
        ];

        $response = $this->post(
            action([
                SignUpController::class,
                'page'
            ]),
            $user
        );

        $response
            ->assertInvalid(['password']);
    }
}
