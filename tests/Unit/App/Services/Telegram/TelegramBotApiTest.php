<?php

namespace Tests\Unit\App\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;
use Tests\TestCase;

class TelegramBotApiTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function it_send_message_success(): void
    {
        Http::fake([
            TelegramBotApi::HOST . '*' => Http::response(['ok' => true])
        ]);

        $response = TelegramBotApi::sendMessage('', 1, 'Testing');

        $this->assertTrue($response);
    }
}
