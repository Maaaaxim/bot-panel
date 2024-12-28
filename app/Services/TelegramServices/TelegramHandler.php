<?php

namespace App\Services\TelegramServices;

use App\Models\Bot;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

/**
 * Class TelegramHandler
 *
 * this handler realizing the strategy design pattern
 * determines the bot type and launches the corresponding strategy
 */
class TelegramHandler
{
    protected array $strategies;

    public function __construct(
        ApprovalService $approvalService,
        DefaultService  $defaultService,
        RequestService  $requestService,
        Request2Service $request2Service,
        CaloriesService $caloriesService,
    )
    {
        $this->strategies = [
            'Approval' => $approvalService,
            'Default' => $defaultService,
            'Request' => $requestService,
            'Request2' => $request2Service,
            'Calories' => $caloriesService,
        ];
    }

    public function handle($botName, $request): void
    {
        $bot = Bot::with('type')->where('name', $botName)->firstOrFail();

        $botTypeName = $bot->type->name ?? 'unknown';

//        Log::info('Telegram request data: ' . print_r($request->all(), true));

        $telegram = new Api($bot->token);

        $update = new Update($request->all());

        if (!$bot->active) {
            return;
        }

        if (array_key_exists($botTypeName, $this->strategies)) {
            $this->strategies[$botTypeName]->handle($bot, $telegram, $update);
        } else {
            Log::error('Unknown bot type: ' . $botTypeName);
        }
    }
}

