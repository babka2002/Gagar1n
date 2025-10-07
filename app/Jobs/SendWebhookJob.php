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

            // Отправляем только на ваш сервер
            $response = Http::timeout(60)
                ->retry(3, 100)
                ->post('http://147.45.143.215:777/api/leads', $webhookData);

            Log::info('Webhook sent to custom server successfully', [
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
