<?php

namespace App\Services\Telegram;

use App\Models\User;

class TrelloLinkService
{
    private string $trelloAuthUrl = 'https://trello.com/1/authorize';
    private string $trelloApiKey;
    private string $trelloCallbackUrl;

    public function __construct()
    {
        $this->trelloApiKey = config('services.trello.key');
        $this->trelloCallbackUrl = config('services.trello.callback_url');
    }

    public function generateAuthUrl(User $user): string
    {
        $query = http_build_query([
            'key' => $this->trelloApiKey,
            'name' => 'Telegram Bot Integration',
            'expiration' => '1hour',
            'response_type' => 'token',
            'scope' => 'read,write',
            'callback_method' => 'fragment',
            'return_url' => $this->trelloCallbackUrl . '?user_id=' . $user->id,
        ]);

        return $this->trelloAuthUrl . '?' . $query;
    }

    public function saveTrelloToken(User $user, string $trelloToken): void
    {
        $user->update(['trello_id' => $trelloToken]);
    }
}
