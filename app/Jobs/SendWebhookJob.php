<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        try {
            // Формируем данные точно как в curl запросе
            $webhookData = [
                'leadtype' => $this->data['leadtype'] ?? 'request',
                'callerphone' => $this->data['callerphone'] ?? '',
                'requestDate' => $this->data['requestDate'] ?? now()->format('Y-m-d H:i:s'),
                'subject' => $this->data['subject'] ?? 'Заявка с сайта',
                'fio' => $this->data['fio'] ?? '',
                'source' => $this->data['source'] ?? '',
                'medium' => $this->data['medium'] ?? 'direct',
                'siteName' => $this->data['siteName'] ?? '',
                'city' => $this->data['city'] ?? 'Симферополь',
                'comment' => $this->data['comment'] ?? ''
            ];

            Log::info('Sending webhook data:', $webhookData);

            $response = Http::timeout(60)
                ->retry(3, 100)
                ->post('http://147.45.187.4:5557/api/leads', $webhookData);  // Обратите внимание на изменённый URL

            Log::info('Webhook sent successfully', [
                'status' => $response->status(),
                'response' => $response->json(),
                'sent_data' => $webhookData
            ]);

        } catch (\Exception $e) {
            Log::error('Webhook failed', [
                'error' => $e->getMessage(),
                'data' => $webhookData ?? null
            ]);

            throw $e;
        }
    }
}
