<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SignUpController;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class SignUpControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = [
            'name' => 'testing',
            'email' => 'testing@gmail.com',
            'password' => '1234567890',
            'password_confirmation' => '1234567890',
        ];
    }

    private function request(): TestResponse
    {
        return $this->post(
            action([
                SignUpController::class,
                'handle'
            ]),
            $this->request
        );
    }

    private function findUser()
    {
        return User::query()
            ->where('email', $this->request['email'])
            ->first();
    }

    /**
     * @test
     * @return void
     */
    public function it_page_success(): void
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
    public function it_validation_success(): void
    {
        $this->request()
            ->assertValid();
    }

    /**
     * @test
     * @return void
     */
    public function it_should_fail_validation_on_password_confirm(): void
    {
        $this->request['password_confirmation'] = '0987654321';

        $this->request()
            ->assertInvalid(['password']);
    }

    /**
     * @test
     * @return void
     */
    public function it_user_created_success(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => $this->request['email']
        ]);

        $this->request();

        $this->assertDatabaseHas('users', [
            'email' => $this->request['email']
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function it_should_fail_validation_on_unique_email(): void
    {
        UserFactory::new()
            ->create([
                'email' => $this->request['email']
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $this->request['email']
        ]);

        $this->request()
            ->assertInvalid('email');
    }

    /**
     * @test
     * @return void
     */
    public function it_registered_event_and_listeners_dispatched(): void
    {
        Event::fake();

        $this->request();

        Event::assertDispatched(Registered::class);

        Event::assertListening(Registered::class, SendEmailVerificationNotification::class);
    }

    /**
     * @test
     * @return void
     */
    public function it_user_authenticated_after_and_redirected(): void
    {
        $this->request()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($this->findUser());
    }
}
