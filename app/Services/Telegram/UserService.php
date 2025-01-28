<?php

namespace App\Services\Telegram;

use DefStudio\Telegraph\DTO\Chat;
use DefStudio\Telegraph\DTO\User;
use App\Models\User as UserModel;

class UserService
{
    public function addUserIfNotExists(Chat $chat, User $user): UserModel
    {
        return UserModel::query()->updateOrCreate(
            [
                'username' => $user->username(),
            ], [
                'chat_id' => $chat->id(),
                'first_name' => $user->firstName(),
                'last_name' => $user->lastName(),
            ]
        );
    }

    public function getUserByChatId(string $chat_id): UserModel
    {
        return UserModel::query()->where('chat_id', $chat_id)->first();
    }
}
