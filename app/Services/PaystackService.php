<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaystackService
{
    public function isConfigured(): bool
    {
        return ! empty(config('paystack.secret_key'));
    }

    public function initialize(string $email, float $amountNaira, string $reference, string $callbackUrl): array
    {
        $response = Http::withToken(config('paystack.secret_key'))
            ->post(config('paystack.payment_url') . '/transaction/initialize', [
                'email' => $email,
                'amount' => (int) round($amountNaira * 100),
                'reference' => $reference,
                'callback_url' => $callbackUrl,
            ]);

        return $response->json() ?? [];
    }

    public function verify(string $reference): array
    {
        $response = Http::withToken(config('paystack.secret_key'))
            ->get(config('paystack.payment_url') . "/transaction/verify/{$reference}");

        return $response->json() ?? [];
    }
}
