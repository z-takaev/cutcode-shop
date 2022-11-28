<?php

namespace Tests\Unit\Auth\DTOs;

use App\Http\Requests\RegistrationFormRequest;
use Domain\Auth\DTOs\NewUserDTO;
use Tests\TestCase;

class NewUserDTOTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function it_instance_created_from_form_request(): void
    {
        $dto = NewUserDTO::fromRequest(new RegistrationFormRequest([
            'name' => 'test',
            'email' => 'testing@gmail.com',
            'password' => 1234567890
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }
}
