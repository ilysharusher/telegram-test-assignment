<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Telegram\TrelloLinkService;
use App\Services\Trello\TrelloWebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function handleCallback(Request $request): JsonResponse
    {
        $userId = $request->query('user_id');
        $trelloToken = $request->query('token');

        if ($userId && $trelloToken) {
            $user = User::query()->findOrFail($userId);
            $this->trelloLinkService->saveTrelloToken($user, $trelloToken);

            return response()->json(['message' => 'Trello account successfully linked!']);
        }

        return response()->json(['message' => 'Failed to link Trello account. Please replace # with & in the URL before token.']);
    }
}
