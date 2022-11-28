<?php

namespace Tests\Unit\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function it_success_user_created(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'testing@gmail.com'
        ]);

        $action = app(RegisterNewUserContract::class);

        $action(NewUserDTO::make('test', 'testing@gmail.com', '1234567890'));

        $this->assertDatabaseHas('users', [
            'email' => 'testing@gmail.com'
        ]);
    }
}
