<?php

namespace App\Services\Telegram;

use DefStudio\Telegraph\Facades\Telegraph;

class SendMessageService
{
    public function execute(string $message): static
    {
        $chatId = config('services.telegram.chat_id');

        Telegraph::chat($chatId)->html($message)->send();

        return $this;
    }
}
