<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MakeTrelloWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trello-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Trello webhook';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $callbackURL = config('services.trello.webhook_url');
        $idModel = config('services.trello.id_model');
        $apiKey = config('services.trello.key');
        $apiToken = config('services.trello.token');

        if (!$callbackURL || !$idModel || !$apiKey || !$apiToken) {
            $this->error(
                'Please make sure that all Trello parameters (key, token, callback_url, id_model) are set in the .env file.'
            );

            return self::FAILURE;
        }

        $payload = [
            'key' => $apiKey,
            'token' => $apiToken,
            'callbackURL' => $callbackURL,
            'idModel' => $idModel,
        ];

        $this->info('Sending a request to create a Webhook in Trello...');

        try {
            $response = Http::post('https://api.trello.com/1/webhooks/', $payload);

            if ($response->successful()) {
                $this->info('Webhook has been successfully created!');
                $this->info('ID Webhook: ' . $response->json('id'));

                return self::SUCCESS;
            }

            $this->error('Failed to create Webhook. Error:');
            $this->error($response->json('message', 'Unknown Error.'));

            return self::FAILURE;
        } catch (\Exception $e) {
            $this->error('An error occurred while creating a Webhook: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
