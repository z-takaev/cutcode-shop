<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function it_home_page_success(): void
    {
        $response = $this->get(route('home'));

        $response
            ->assertOk()
            ->assertViewIs('home')
            ->assertSee('Главная страница');
    }
}
