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
            $response = Http::timeout(60)
                ->retry(3, 100)
                ->post('http://147.45.187.4:3000/webhook', [
                    'callerphone' => $this->data['phone'] ?? null,
                    'fio' => $this->data['full_name'] ?? null,
                    'subject' => $this->data['full_name'] ?? null,
                    'source' => 'gagar1n.ru',
                    'medium' => 'gagar1n.ru',
                    'leadtype' => 'request'
                ]);

            Log::info('Webhook sent successfully', [
                'status' => $response->status(),
                'response' => $response->json(),
                'data' => $this->data
            ]);

        } catch (\Exception $e) {
            Log::error('Webhook failed', [
                'error' => $e->getMessage(),
                'data' => $this->data
            ]);

            throw $e;
        }
    }
}
