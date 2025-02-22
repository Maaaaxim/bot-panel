<?php

namespace App\Services\TelegramServices\CaloriesHandlers\CallbackQueryHandlers\EditingProcessCallbackQuery;

class EditingCancelCallbackQueryHandler extends EditingBaseCallbackQueryHandler
{
    protected function process($bot, $telegram, $callbackQuery, $botUser)
    {
        $this->exitEditing(
            $telegram,
            $this->chatId,
            $this->userId,
            $this->userProducts,
            $this->productId,
            $this->messageId,
            $callbackQuery->getId()
        );

        $telegram->answerCallbackQuery([
            'callback_query_id' => $callbackQuery->getId(),
            'text'       => __('calories365-bot.editing_canceled'),
            'show_alert' => false,
        ]);
    }
}
