<?php

namespace App\Services\Telegram;

use DefStudio\Telegraph\DTO\User;
use App\Models\User as UserModel;

class UserService
{
    public function addUserIfNotExists(User $user): void
    {
        UserModel::query()->firstOrCreate([
            'chat_id' => $user->id(),
            'username' => $user->username(),
            'first_name' => $user->firstName(),
            'last_name' => $user->lastName(),
        ]);
    }
}
