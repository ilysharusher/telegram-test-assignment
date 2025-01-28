<?php

namespace App\Http\Controllers;

use DefStudio\Telegraph\Handlers\WebhookHandler;

class TelegramController extends WebhookHandler
{
    public function start(): void
    {
        userService()->addUserIfNotExists($this->message->from());

        $first_name = $this->message->from()?->firstName();

        $this->chat->html(
            'Hello, ' . "<b>$first_name</b>" . '! Welcome to the bot!'
        )->send();
    }
}
