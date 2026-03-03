<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MakeWebhookService
{
    /**
     * Send a payload to the Make.com Webhook.
     *
     * @param string $eventType
     * @param array $data
     * @return bool
     */
    public function send(string $eventType, array $data): bool
    {
        $url = config('services.make.webhook_url') ?? env('MAKE_WEBHOOK_URL');

        if (!$url) {
            Log::warning('Make Webhook URL is not configured.');
            return false;
        }

        try {
            $response = Http::post($url, [
                'event_type' => $eventType,
                'data' => $data,
                'timestamp' => now()->toIso8601String(),
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('Make Webhook failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'event_type' => $eventType
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Make Webhook exception', [
                'message' => $e->getMessage(),
                'event_type' => $eventType
            ]);
            return false;
        }
    }
}
