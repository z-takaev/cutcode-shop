<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SignUpController;
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

}
