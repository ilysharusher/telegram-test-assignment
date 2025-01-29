<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Telegram\TrelloLinkService;
use App\Services\Trello\TrelloWebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrelloController extends Controller
{
    public function __construct(
        protected TrelloWebhookService $trelloWebhookService,
        protected TrelloLinkService $trelloLinkService
    ) {
    }

    public function handleWebhook(Request $request): JsonResponse
    {
        $data = $request->all();

        $this->trelloWebhookService->handleCardMovement($data);

        return response()->json();
    }

    public function handleCallback(Request $request): JsonResponse|Response
    {
        $userId = $request->query('user_id');
        $trelloToken = $request->query('token');

        if ($userId && !$trelloToken) {
            return response()->view('trello.extract-token', ['userId' => $userId]);
        }

        if ($userId && $trelloToken) {
            $user = User::query()->findOrFail($userId);
            $this->trelloLinkService->saveTrelloToken($user, $trelloToken);

            sendMessage("Your Trello account has been successfully linked!\n\nYou can now send /report command to get your group report.");

            return response()->json(['message' => 'Trello account successfully linked!']);
        }

        return response()->json(['message' => 'Failed to link Trello account.']);
    }
}
