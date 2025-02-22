<?php

namespace App\Services\TelegramServices;

use App\Models\Bot;
use Illuminate\Support\Facades\Log;
use Illuminate\Pipeline\Pipeline;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class TelegramHandler
{
    protected array $strategies;

    public function __construct(
        ApprovalService $approvalService,
        DefaultService  $defaultService,
        RequestService  $requestService,
        Request2Service $request2Service,
        CaloriesService $caloriesService,
    ) {
        $this->strategies = [
            'Approval' => $approvalService,
            'Default'  => $defaultService,
            'Request'  => $requestService,
            'Request2' => $request2Service,
            'Calories' => $caloriesService,
        ];
    }

    public function handle($botName, $request): void
    {
        $bot = Bot::with('type')->where('name', $botName)->firstOrFail();
        $botTypeName = $bot->type->name ?? 'unknown';

        if (!$bot->active) {
            return;
        }

        $telegram = new Api($bot->token);
        $update   = new Update($request->all());

        if (!array_key_exists($botTypeName, $this->strategies)) {
            Log::error('Unknown bot type: ' . $botTypeName);
            return;
        }
        $strategy = $this->strategies[$botTypeName];

        $passable = $this->runMiddlewares($botTypeName, $bot, $telegram, $update, $strategy);

        if (!$passable){
            return;
        }

        if (isset($passable['botUser'])){
            $botUser = $passable['botUser'] ?: null;
        } else {
            $botUser = null;
        }

        $strategy->handle($bot, $telegram, $update, $botUser);
    }

    protected function runMiddlewares($botTypeName, $bot, $telegram, $update, $strategy)
    {
        $middlewares = [
            'Calories' => [
                \App\Services\TelegramServices\Middleware\CheckUserAuthAndLocale::class,
            ],
        ];

        $passable = [
            'botTypeName'       => $botTypeName,
            'bot'               => $bot,
            'telegram'          => $telegram,
            'update'            => $update,
            'excludedCommands'  => method_exists($strategy, 'getExcludedCommands')
                ? $strategy->getExcludedCommands()
                : [],
        ];

        if (!isset($middlewares[$botTypeName])) {
            return $passable;
        }

        $passable = app(Pipeline::class)
            ->send($passable)
            ->through($middlewares[$botTypeName])
            ->then(function ($passable) {
                return $passable;
            });

        return $passable;
    }
}
