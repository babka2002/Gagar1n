<?php

namespace App\Services;

use App\DTOs\TrainerDTO;
use App\Exceptions\ApiException;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TrainerService
{
    private const API_URL = 'http://fitness1c.phys.su:8080/fitness1c_chat/hs/api/v3';
    private const CACHE_TTL = 3600;

    private string $apiKey;
    private string $userToken;
    private string $basicAuth;

    public function __construct()
    {
        $this->apiKey = config('services.fitness.api_key');
        $this->userToken = config('services.fitness.user_token');
        $this->basicAuth = config('services.fitness.basic_auth');
    }

    public function getTrainers(string $clubId): array
    {
        return Cache::remember("trainers:{$clubId}", self::CACHE_TTL, function () use ($clubId) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'apikey' => $this->apiKey,
                'usertoken' => $this->userToken,
                'Authorization' => "Basic {$this->basicAuth}"
            ])->get(self::API_URL . "/trainers", [
                'club_id' => $clubId
            ]);

            if (!$response->successful()) {
                throw new ApiException('Failed to fetch trainers data', $response->status());
            }
            $data = $response->json('data', []);
            $trainers = array_map(fn($item) => TrainerDTO::fromArray($item), $data);
            // dd($trainers);
            foreach ($trainers as $trainer) {
                $trainer->localPhotoPath = $this->downloadImage($trainer);
            }

            return $trainers;
        });
    }

    private function downloadImage(TrainerDTO $trainer): string
    {
        $url = $trainer->photo;
        if (empty($url)) {
            return Storage::url('trainers/default-image.jpg');
        }

        $imageName = basename($url);
        $path = 'trainers/' . $imageName;

        // Если файл уже существует - возвращаем его
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        try {
            // Скачиваем файл с теми же credentials
            $response = Http::withHeaders([
                'apikey' => $this->apiKey,
                'usertoken' => $this->userToken,
                'Authorization' => "Basic {$this->basicAuth}"
            ])->get($url);

            if ($response->successful()) {
                // Сохраняем файл
                Storage::disk('public')->put($path, $response->body());
                return Storage::disk('public')->url($path);
            }
            // dd('im here > ',$response);
        } catch (\Exception $e) {
            Log::error("Failed to download trainer photo: {$e->getMessage()}", [
                'trainer_id' => $trainer->id,
                'url' => $url
            ]);
        }

        return Storage::url('trainers/default-image.jpg');
    }
}
