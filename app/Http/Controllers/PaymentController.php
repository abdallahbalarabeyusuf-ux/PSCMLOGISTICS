<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Shipment;
use App\Services\PaystackService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function pay(Shipment $shipment, PaystackService $paystack): RedirectResponse
    {
        if ($shipment->payment_status === 'paid') {
            return redirect()->route('shipments.show', $shipment)->with('status', 'This shipment has already been paid for.');
        }

        if (! $paystack->isConfigured()) {
            return back()->withErrors(['payment' => 'Online payment is not yet configured. Please choose pay on delivery, or contact support.']);
        }

        $reference = 'PSCM-PAY-' . strtoupper(Str::random(10));

        Payment::create([
            'shipment_id' => $shipment->id,
            'reference' => $reference,
            'amount' => $shipment->amount,
            'status' => 'pending',
        ]);

        $response = $paystack->initialize(
            email: $shipment->user?->email ?? 'guest@pscmlogistics.com',
            amountNaira: (float) $shipment->amount,
            reference: $reference,
            callbackUrl: route('payments.callback'),
        );

        if (! ($response['status'] ?? false)) {
            return back()->withErrors(['payment' => 'Unable to initialize payment. Please try again.']);
        }

        return redirect()->away($response['data']['authorization_url']);
    }

    public function callback(Request $request, PaystackService $paystack): RedirectResponse
    {
        $reference = $request->query('reference');

        $payment = Payment::where('reference', $reference)->firstOrFail();
        $shipment = $payment->shipment;

        $result = $paystack->verify($reference);
        $status = $result['data']['status'] ?? 'failed';

        if ($status === 'success') {
            $payment->update([
                'status' => 'success',
                'channel' => $result['data']['channel'] ?? null,
                'paid_at' => now(),
            ]);
            $shipment->update(['payment_status' => 'paid']);

            return redirect()->route('shipments.show', $shipment)->with('status', 'Payment successful. Thank you!');
        }

        $payment->update(['status' => 'failed']);

        return redirect()->route('shipments.show', $shipment)->withErrors(['payment' => 'Payment was not successful.']);
    }

    public function webhook(Request $request): \Illuminate\Http\JsonResponse
    {
        $signature = $request->header('x-paystack-signature');
        $payload = $request->getContent();

        if (! $signature || ! hash_equals($signature, hash_hmac('sha512', $payload, config('paystack.secret_key') ?? ''))) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        $event = json_decode($payload, true);
        if (($event['event'] ?? '') === 'charge.success') {
            $data = $event['data'] ?? [];
            $reference = $data['reference'] ?? null;

            if ($reference) {
                $payment = Payment::where('reference', $reference)->first();
                if ($payment) {
                    $payment->update([
                        'status' => 'success',
                        'channel' => $data['channel'] ?? null,
                        'paid_at' => now(),
                    ]);
                    $payment->shipment?->update(['payment_status' => 'paid']);
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
