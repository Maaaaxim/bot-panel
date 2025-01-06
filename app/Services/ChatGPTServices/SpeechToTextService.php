<?php

namespace App\Services\ChatGPTServices;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;

class SpeechToTextService
{
    private Client $client;
    private string $apiKey;

    public function __construct()
    {
        $this->client = new Client();

        // Смотрим текущую локаль (можно использовать $botUser->locale или app()->getLocale() и т.д.)
        $locale = app()->getLocale();
        // Для теста явно установлено 'en'; можете убрать/изменить по необходимости.
        $locale = 'en';

        switch ($locale) {
            case 'ua':
                $this->apiKey = env('OPENAI_API_KEY_UK');
                break;
            case 'en':
                $this->apiKey = env('OPENAI_API_KEY_EN');
                break;
            default:
                $this->apiKey = env('OPENAI_API_KEY_RU');
        }
    }

    public function convertSpeechToText(string $filePath)
    {
        $multipartBody = new MultipartStream([
            [
                'name'     => 'file',
                'contents' => fopen($filePath, 'r'),
                'filename' => basename($filePath)
            ],
            [
                'name'     => 'model',
                'contents' => 'whisper-1'
            ]
        ]);

        $headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'multipart/form-data; boundary=' . $multipartBody->getBoundary()
        ];

        $request = new Request(
            'POST',
            'https://api.openai.com/v1/audio/transcriptions',
            $headers,
            $multipartBody
        );

        try {
            $response = $this->client->send($request);
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['text'])) {
                // Передаём распознанный текст на дальнейший анализ
                return $this->analyzeFoodIntake($data['text']);
            }
            return false;
        } catch (GuzzleException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function analyzeFoodIntake(string $text)
    {
        Log::info('prompt: ' . $text);

        // Вместо «сырого» текста — используем языковую фразу
        $prompt = __('calories365-bot.prompt_analyze_food_intake', [
            'text' => $text,
        ]);

        $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json'
            ],
            'json' => [
                'model'    => 'gpt-4o',
                'messages' => [
                    [
                        'role'    => 'user',
                        'content' => $prompt,
                    ]
                ]
            ]
        ]);

        try {
            $result = json_decode($response->getBody()->getContents(), true);

            // Если отсутствует нужная часть — выводим фразу из локали
            return $result['choices'][0]['message']['content']
                ?? __('calories365-bot.data_not_extracted');
        } catch (GuzzleException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * @throws GuzzleException
     */
    public function generateNewProductData(string $text)
    {
        // Выносим длинный промт в локаль
        $prompt = __('calories365-bot.prompt_generate_new_product_data', [
            'text' => $text,
        ]);

        $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json'
            ],
            'json' => [
                'model'    => 'gpt-4o',
                'messages' => [
                    [
                        'role'    => 'user',
                        'content' => $prompt
                    ]
                ]
            ]
        ]);

        try {
            $result = json_decode($response->getBody()->getContents(), true);

            return $result['choices'][0]['message']['content']
                ?? __('calories365-bot.data_not_extracted');
        } catch (GuzzleException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function chooseTheMostRelevantProduct(array $products)
    {
        try {
            $chosenProductName = '';

            for ($i = 0; $i < count($products); $i += 5) {
                $prompt = '';

                for ($j = $i; $j < $i + 5 && $j < count($products); $j++) {
                    $name    = $products[$j]['name'];
                    $details = $products[$j]['details'];

                    $productNames = array_map(function ($detail) {
                        return $detail['id'] . ' - ' . $detail['name'];
                    }, $details);

                    // Здесь можно собрать часть промта через локаль, например:
                    // prompt_choose_relevant_products_part
                    $prompt .= __('calories365-bot.prompt_choose_relevant_products_part', [
                            'name'         => $name,
                            'productNames' => implode(', ', $productNames),
                        ]) . ' ';
                }

                // Добавим «footer» — формат вывода
                $prompt .= __('calories365-bot.prompt_choose_relevant_products_footer');

                // Вызываем наш метод для отправки промта
                $chosenProductName .= $this->askGPTForRelevance($prompt);
            }

            // Можете здесь Log::info("Chosen products: ".$chosenProductName); если нужно
        } catch (\Exception $e) {
            Log::error("Error in choosing product: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
        return true;
    }

    private function askGPTForRelevance($prompt)
    {
        $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json'
            ],
            'json' => [
                'model'    => 'gpt-4o',
                'messages' => [
                    [
                        'role'    => 'user',
                        'content' => $prompt
                    ]
                ]
            ]
        ]);

        try {
            $result = json_decode($response->getBody()->getContents(), true);

            return $result['choices'][0]['message']['content']
                ?? __('calories365-bot.data_not_extracted');
        } catch (GuzzleException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
