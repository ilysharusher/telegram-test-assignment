<?php

namespace App\Http\Telegram\Commands;

use DefStudio\Telegraph\Handlers\WebhookHandler;

class StartCommand extends WebhookHandler
{
    public function start(): void
    {
        $first_name = $this->message->from()?->firstName();

        $this->chat->html(
            'Hello, ' . "<b>$first_name</b>" . '! Welcome to the bot!'
        )->send();
    }
}
