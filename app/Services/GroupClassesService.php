<?php

namespace App\Services;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GroupClassesService implements ScheduleServiceInterface
{
    private const API_URL = 'http://fitness1c.phys.su:8080/fitness1c_chat/hs/api/v3/classes/';
    private const CACHE_TTL = 3600;
    private const CACHE_FILE = 'group_schedule.json';

    private string $apiKey;
    private string $userToken;
    private string $basicAuth;

    public function __construct()
    {
        $this->apiKey = config('services.fitness.api_key');
        $this->userToken = config('services.fitness.user_token');
        $this->basicAuth = config('services.fitness.basic_auth');
    }

    public function getSchedule(array $params): array
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $cacheFile = $this->getCacheFileName($params);

        if (Storage::disk('public')->exists($cacheFile)) {
            $cachedData = json_decode(Storage::disk('public')->get($cacheFile), true);

            if ($this->isCacheValid($cachedData)) {
                return $cachedData['data'];
            }
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'apikey' => $this->apiKey,
            'usertoken' => $this->userToken,
            'Authorization' => "Basic {$this->basicAuth}"
        ])->timeout(600)->get(self::API_URL, $params);

        if (!$response->successful()) {
            Log::error('Failed to fetch schedule data', [
                'status' => $response->status(),
                'body' => $response->body(),
                'params' => $params,
            ]);
            throw new ApiException('Failed to fetch schedule data', $response->status());
        }

        $data = $response->json('data', []);
        $this->cacheScheduleData($data, $cacheFile);

        return $data;
    }

    private function cacheScheduleData(array $data, string $cacheFile): void
    {
        $cachedData = [
            'timestamp' => time(),
            'data' => $data,
        ];
        Storage::disk('public')->put($cacheFile, json_encode($cachedData));
    }

    private function getCacheFileName(array $params): string
    {
        $date = $params['start_date'] ?? 'unknown';
        return "group_schedule_{$date}.json";
    }


    private function isCacheValid(array $cachedData): bool
    {
        // Проверяем, существует ли ключ "timestamp" и актуален ли кэш (например, по времени)
        if (!isset($cachedData['timestamp'])) {
            return false; // Если ключ отсутствует, считаем кэш недействительным
        }
        return (time() - $cachedData['timestamp']) < self::CACHE_TTL;
    }
    
}
