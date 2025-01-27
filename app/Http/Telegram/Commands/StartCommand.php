<?php

namespace App\Http\Telegram\Commands;

use App\Models\User;
use DefStudio\Telegraph\Handlers\WebhookHandler;

class StartCommand extends WebhookHandler
{
    public function start(): void
    {
        User::query()->firstOrCreate([
            'chat_id' => $this->message->from()?->id(),
            'username' => $this->message->from()?->username(),
            'first_name' => $this->message->from()?->firstName(),
            'last_name' => $this->message->from()?->lastName(),
        ]);

        $first_name = $this->message->from()?->firstName();

        $this->chat->html(
            'Hello, ' . "<b>$first_name</b>" . '! Welcome to the bot!'
        )->send();
    }
}
