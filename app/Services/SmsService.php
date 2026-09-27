<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function send(string $phone, string $message): bool
    {
        $apiKey = config('termii.api_key');

        if (empty($apiKey)) {
            Log::info("[SMS not sent - TERMII_API_KEY missing] To: {$phone} | Message: {$message}");

            return false;
        }

        $response = Http::post(config('termii.base_url') . '/sms/send', [
            'api_key' => $apiKey,
            'to' => $phone,
            'from' => config('termii.sender_id'),
            'sms' => $message,
            'type' => 'plain',
            'channel' => 'generic',
        ]);

        return $response->successful();
    }
}
