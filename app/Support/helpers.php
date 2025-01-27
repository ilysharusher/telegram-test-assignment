<?php

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
