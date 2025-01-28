<?php

use App\Http\Controllers\TrelloController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
});

Route::post('/trello/webhook', [TrelloController::class, 'handle'])
    ->withoutMiddleware(VerifyCsrfToken::class);

Route::get('/trello/webhook/', static fn () => response()->json());
