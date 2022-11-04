<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
