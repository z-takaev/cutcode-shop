<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
