<?php

namespace App\Services\TelegramServices\CaloriesHandlers\CallbackQueryHandlers;

use App\Utilities\Utilities;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\DiaryApiService;

class SaveCallbackQueryHandler implements CallbackQueryHandlerInterface
{
    public bool $blockAble = true;
    protected DiaryApiService $diaryApiService;

    public function __construct()
    {
        $this->diaryApiService = new DiaryApiService();
    }

    public function handle($bot, $telegram, $callbackQuery, $botUser)
    {
        $userId       = $callbackQuery->getFrom()->getId();
        $chatId       = $callbackQuery->getMessage()->getChat()->getId();
        $callbackData = $callbackQuery->getData();
        $locale       = $botUser->locale;
        $calories_id  = $botUser->calories_id;
        $parts        = explode('_', $callbackData);

        if (count($parts) > 1) {
            $partOfTheDay = $parts[1];
        }

        $data = Cache::get("user_products_{$userId}");
        if (!$data) {
            return;
        }

        $diaryUserId = 32;
        $total = [
            'calories'      => 0,
            'proteins'      => 0,
            'fats'          => 0,
            'carbohydrates' => 0,
        ];

        foreach ($data as $productData) {
            $product            = $productData['product'];
            $productTranslation = $productData['product_translation'];

            $total['calories']      += round($product['calories']      * $product['quantity_grams'] / 100);
            $total['proteins']      += round($product['proteins']      * $product['quantity_grams'] / 100);
            $total['fats']          += round($product['fats']          * $product['quantity_grams'] / 100);
            $total['carbohydrates'] += round($product['carbohydrates'] * $product['quantity_grams'] / 100);

            if (isset($product['edited']) && $product['edited'] == 1) {
                $this->saveProduct($product, $productTranslation, $diaryUserId, $partOfTheDay, $calories_id, $locale, $chatId);
            } else {
                $this->saveFoodConsumption($product, $diaryUserId, $partOfTheDay, $calories_id, $locale);
            }

            Cache::forget("product_click_count_{$userId}_{$productTranslation['id']}");
        }

        $productArray = [
            [ __('calories365-bot.calories'),      $total['calories']      ],
            [ __('calories365-bot.proteins'),      $total['proteins']      ],
            [ __('calories365-bot.fats'),          $total['fats']          ],
            [ __('calories365-bot.carbohydrates'), $total['carbohydrates'] ],
        ];

        $messageText = Utilities::generateTableType2(
                __('calories365-bot.data_saved_you_consumed'),
                $productArray
            ) . "\n\n";

        Cache::forget("user_products_{$userId}");
        Cache::forget("user_final_message_id_{$userId}");

        $telegram->sendMessage([
            'chat_id'    => $chatId,
            'text'       => $messageText,
            'parse_mode' => 'Markdown',
        ]);

        $this->deleteProductMessages($telegram, $chatId, $data, $callbackQuery);

        $telegram->answerCallbackQuery([
            'callback_query_id' => $callbackQuery->getId(),
        ]);
    }

    protected function saveProduct($product, $productTranslation, $diaryUserId, $partOfTheDay, $calories_id, $locale, $chat_id)
    {
        $postData = [
            'user_id'        => $diaryUserId,
            'name'           => $productTranslation['name'],
            'calories'       => $product['calories_per_100g']      ?? $product['calories'],
            'carbohydrates'  => $product['carbohydrates_per_100g'] ?? $product['carbohydrates'],
            'fats'           => $product['fats_per_100g']          ?? $product['fats'],
            'fibers'         => $product['fibers_per_100g']        ?? $product['fibers'] ?? 0,
            'proteins'       => $product['proteins_per_100g']      ?? $product['proteins'],
            'quantity'       => $product['quantity_grams'],
            'consumed_at'    => date('Y-m-d'),
            'part_of_day'    => $partOfTheDay,
            'verified'       => $product['verified'],
        ];

        $response = $this->diaryApiService->saveProduct($postData, $calories_id, $locale);

        if (isset($response['error'])) {
            Log::error('Error saving product: ' . $response['error']);
        } else {
            Log::info('Product saved successfully.');
        }
    }

    protected function saveFoodConsumption($product, $diaryUserId, $partOfTheDay, $calories_id, $locale)
    {
        $postData = [
            'user_id'      => $diaryUserId,
            'food_id'      => $product['id'],
            'quantity'     => $product['quantity_grams'],
            'consumed_at'  => date('Y-m-d'),
            'part_of_day'  => $partOfTheDay,
        ];

        $response = $this->diaryApiService->saveFoodConsumption($postData, $calories_id, $locale);

        if (isset($response['error'])) {
            Log::error('Error saving food consumption: ' . $response['error']);
        } else {
            Log::info('Food consumption saved successfully.');
        }
    }

    protected function deleteProductMessages($telegram, $chatId, $data, $callbackQuery)
    {
        foreach ($data as $productData) {
            if (isset($productData['message_id'])) {
                try {
                    $telegram->deleteMessage([
                        'chat_id'    => $chatId,
                        'message_id' => $productData['message_id'],
                    ]);
                } catch (\Exception $e) {
                    Log::error("Error deleting product message: " . $e->getMessage());
                }
            }
        }

        $finalMessageId = $callbackQuery->getMessage()->getMessageId();
        try {
            $telegram->deleteMessage([
                'chat_id'    => $chatId,
                'message_id' => $finalMessageId,
            ]);
        } catch (\Exception $e) {
            Log::error("Error deleting final action message: " . $e->getMessage());
        }
    }

    private function getPartOfTheDay(): string
    {
        $currentHour = (int) date('G');

        if ($currentHour >= 6 && $currentHour < 12) {
            $partOfDay = 'morning';
        } elseif ($currentHour >= 12 && $currentHour < 18) {
            $partOfDay = 'dinner';
        } else {
            $partOfDay = 'supper';
        }

        return $partOfDay;
    }
}
