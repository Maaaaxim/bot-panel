<?php

namespace App\Services\TelegramServices\CaloriesHandlers\CallbackQueryHandlers\EditingProcessCallbackQuery;

class EditingSaveCallbackQueryHandler extends EditingBaseCallbackQueryHandler
{
    protected function process($bot, $telegram, $callbackQuery)
    {
        $this->saveEditing(
            $telegram,
            $this->chatId,
            $this->userId,
            $this->userProducts,
            $this->productId,
            $this->messageId,
            $callbackQuery->getId()
        );
    }
}
