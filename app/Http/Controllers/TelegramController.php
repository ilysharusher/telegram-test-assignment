<?php

namespace App\Http\Controllers;

use App\Services\Telegram\Traits\ReportTrait;
use App\Services\Telegram\TrelloLinkService;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Keyboard;

class TelegramController extends WebhookHandler
{
    use ReportTrait;

    public function start(): void
    {
        $user = userService()->addUserIfNotExists($this->message->chat(), $this->message->from());

        $first_name = $this->message->from()?->firstName();

        $this->chat->html(
            'Hello, ' . "<b>$first_name</b>" . '! Welcome to the bot!'
        )->send();

        if (!$user->trello_id) {
            $this->chat->html(
                'You can connect your Trello account by clicking the button below.'
            )
                ->keyboard(
                    Keyboard::make()->button('Connect Trello')->action('connectTrello')
                )
                ->send();
        }
    }

    public function connectTrello(TrelloLinkService $trelloLinkService): void
    {
        $user = userService()->getUserByChatId($this->chat->chat_id);

        $trelloAuthUrl = $trelloLinkService->generateAuthUrl($user);

        $this->chat->html(
            'Please authorize your Trello account by clicking button below.'
        )
            ->keyboard(
                Keyboard::make()->button('Click here!')->url($trelloAuthUrl)
            )
            ->send();
    }

    public function report(): void
    {
        $chat_id = $this->chat->chat_id;

        if (!$chat_id) {
            sendMessage('Please, send /start command again.');
        }

        $report = $this->generateGroupReport($chat_id);

        $this->chat->html($report)->send();
    }
}
