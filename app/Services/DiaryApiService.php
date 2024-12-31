<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class DiaryApiService
{
    private Client $client;
    private string $apiUrl;
    private mixed $host;
    private string $diaryApiKey;

    public function __construct()
    {
        $this->diaryApiKey = config('services.diary_api.key');
        $this->apiUrl      = config('services.diary_api.url');
        $this->client      = new Client();
        $this->host        = config('services.diary_api.host');
    }

    /**
     * Унифицированный метод для формирования заголовков запроса.
     *
     * @param int|null    $caloriesId
     * @param string|null $locale
     * @return array
     */
    private function getHeaders($caloriesId = null, $locale = null): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
            'Host'         => $this->host,
            'X-Api-Key'    => $this->diaryApiKey,
        ];

        if (!empty($caloriesId)) {
            $headers['X-Calories-Id'] = $caloriesId;
        }

        if (!empty($locale)) {
            $headers['X-Locale'] = $locale;
        }

        return $headers;
    }

    /**
     * Отправляем текст на сервис (пример).
     */
    public function sendText(string $text, $calories_id, $locale)
    {
        try {
            $response = $this->client->post($this->apiUrl . '/caloriesEndPoint', [
                'headers' => $this->getHeaders($calories_id, $locale),
                'json'    => [
                    'text' => $text,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error("Error sending text to diary service: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Получаем наиболее релевантный продукт
     */
    public function getTheMostRelevantProduct(string $text, $calories_id, $locale)
    {
        try {
            $response = $this->client->post($this->apiUrl . '/caloriesEndPoint/getTheMostRelevantProduct', [
                'headers' => $this->getHeaders($calories_id, $locale),
                'json'    => [
                    'text' => $text,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error("Error getting relevant product from diary service: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Сохранение продукта
     */
    public function saveProduct(array $data, $calories_id, $locale)
    {
        try {
            $payload = array_merge($data);

            $response = $this->client->post($this->apiUrl . '/caloriesEndPoint/saveProduct', [
                'headers' => $this->getHeaders($calories_id, $locale),
                'json'    => $payload,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error("Error saving product to diary service: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Сохранение употреблённого продукта (приём пищи)
     */
    public function saveFoodConsumption(array $data, $calories_id, $locale)
    {
        try {
            $payload = array_merge($data);

            $response = $this->client->post($this->apiUrl . '/caloriesEndPoint/saveFoodConsumption', [
                'headers' => $this->getHeaders($calories_id, $locale),
                'json'    => $payload,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error("Error saving food consumption to diary service: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Показать статистику пользователя
     */
    public function showUserStats($date, $partOfDay = false, $calories_id, $locale)
    {
        try {
            $url = $this->apiUrl . '/caloriesEndPoint/showUserStats/' . $date;
            if ($partOfDay) {
                $url .= '/' . $partOfDay;
            }

            $response = $this->client->get($url, [
                'headers' => $this->getHeaders($calories_id, $locale),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error("Error retrieving user stats from diary service: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Удаление отдельного приёма пищи
     */
    public function deleteMeal($mealId, $calories_id, $locale)
    {
        try {
            $response = $this->client->delete($this->apiUrl . '/caloriesEndPoint/deleteMeal/' . $mealId, [
                'headers' => $this->getHeaders($calories_id, $locale),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error("Error deleting meal in diary service: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Проверка телеграм-кода
     */
    public function checkTelegramCode(string $code, int $telegram_id, string $locale = 'en')
    {
        try {
            $response = $this->client->post($this->apiUrl . '/caloriesEndPoint/checkTelegramCode', [
                'headers' => $this->getHeaders($telegram_id, $locale),
                'json'    => [
                    'code'        => $code,
                    'telegram_id' => $telegram_id
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error("Error verifying telegram code: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}
