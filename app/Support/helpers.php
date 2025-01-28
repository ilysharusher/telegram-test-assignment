<?php

use App\Services\Telegram\SendMessageService;
use App\Services\Telegram\UserService;

if (!function_exists('userService')) {
    /**
     * Get an instance of the UserService.
     *
     * @return UserService An instance of the UserService class.
     */
    function userService(): UserService
    {
        return app(UserService::class);
    }
}

if (!function_exists('sendMessage')) {
    /**
     * Send a message to a Telegram chat.
     *
     * @param string $message The message to send.
     * @return SendMessageService An instance of the SendMessageService class.
     */
    function sendMessage(string $message): SendMessageService
    {
        return app(SendMessageService::class)->execute($message);
    }
}
