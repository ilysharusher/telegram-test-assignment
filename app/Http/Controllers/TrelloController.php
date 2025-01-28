<?php

namespace App\Http\Controllers;

use App\Services\Trello\TrelloWebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrelloController extends Controller
{
    public function __construct(
        protected TrelloWebhookService $trelloWebhookService
    ) {
    }

    public function handle(Request $request): JsonResponse
    {
        $data = $request->all();

        $this->trelloWebhookService->handleCardMovement($data);

        return response()->json(['status' => 'success']);
    }
}
