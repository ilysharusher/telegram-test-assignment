<?php

namespace App\Services\Telegram\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Http;

trait ReportTrait
{
    public function generateGroupReport(int $chatId): string
    {
        $users = User::query()->where('chat_id', $chatId)->get();
        $report = [];

        foreach ($users as $user) {
            if ($user->trello_id) {
                $tasksCount = $this->getTrelloTasksCount($user->trello_id);
                $report[] = "<b>{$user->username}</b>: {$tasksCount} task(s) in progress.";
            } else {
                $report[] = "<b>{$user->username}</b>: Trello account not connected.";
            }
        }

        return implode("\n", $report);
    }

    private function getTrelloTasksCount(string $trelloToken): int
    {
        $response = Http::get('https://api.trello.com/1/members/me/boards', [
            'key' => config('services.trello.key'),
            'token' => $trelloToken,
        ]);

        $boards = $response->json();

        $tasksCount = 0;

        foreach ($boards as $board) {
            $listResponse = Http::get("https://api.trello.com/1/boards/{$board['id']}/lists", [
                'key' => config('services.trello.key'),
                'token' => $trelloToken,
            ]);

            $lists = $listResponse->json();

            foreach ($lists as $list) {
                if (stripos($list['name'], 'In Progress') !== false) {
                    $cardsResponse = Http::get("https://api.trello.com/1/lists/{$list['id']}/cards", [
                        'key' => config('services.trello.key'),
                        'token' => $trelloToken,
                    ]);

                    $tasksCount += count($cardsResponse->json());
                }
            }
        }

        return $tasksCount;
    }
}
