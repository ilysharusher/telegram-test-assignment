<?php

namespace App\Services\Trello;

class TrelloWebhookService
{
    public function handleCardMovement($data): void
    {
        $action = $data['action'] ?? null;
        $cardName = $action['data']['card']['name'] ?? null;
        $listBefore = $action['data']['listBefore']['name'] ?? null;
        $listAfter = $action['data']['listAfter']['name'] ?? null;

        if (($listBefore === 'In Progress' && $listAfter === 'Done') || ($listBefore === 'Done' && $listAfter === 'In Progress')) {
            $message = "Card <b>$cardName</b> moved from <b>$listBefore</b> to <b>$listAfter</b>";

            sendMessage($message);
        }
    }
}
