<?php

namespace App\Http\Controllers;

use App\Models\PricingZone;
use App\Models\Shipment;
use App\Services\PricingService;
use App\Services\SmsService;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ShipmentController extends Controller
{
    public function create(): View
    {
        $zones = PricingZone::orderBy('base_fee')->get();

        return view('pages.request-pickup', compact('zones'));
    }

    public function store(Request $request, PricingService $pricingService, SmsService $smsService): RedirectResponse
    {
        $data = $request->validate([
            'sender_name' => ['required', 'string', 'max:255'],
            'sender_phone' => ['required', 'string', 'max:20'],
            'pickup_address' => ['required', 'string', 'max:500'],
            'receiver_name' => ['required', 'string', 'max:255'],
            'receiver_phone' => ['required', 'string', 'max:20'],
            'delivery_address' => ['required', 'string', 'max:500'],
            'package_type' => ['required', 'string', 'max:100'],
            'weight_kg' => ['required', 'numeric', 'min:0.1', 'max:1000'],
            'description' => ['nullable', 'string', 'max:1000'],
            'destination_zone' => ['required', 'string', 'exists:pricing_zones,code'],
            'payment_method' => ['required', 'in:pay_on_delivery,online'],
        ]);

        $amount = $pricingService->calculate($data['destination_zone'], (float) $data['weight_kg']);

        $shipment = Shipment::create([
            ...$data,
            'user_id' => auth()->id(),
            'amount' => $amount,
        ]);

        $shipment->trackingUpdates()->create([
            'status' => 'pending',
            'location' => $shipment->pickup_address,
            'note' => 'Pickup request received. Awaiting rider assignment.',
        ]);

        $this->generateQrCode($shipment);

        $smsService->send(
            $shipment->sender_phone,
            "PSCM: Your pickup request has been booked. Waybill: {$shipment->waybill_number}. Track it at " . route('shipments.show', $shipment)
        );

        return redirect()->route('shipments.confirmation', $shipment);
    }

    public function confirmation(Shipment $shipment): View
    {
        return view('pages.request-pickup-confirmation', compact('shipment'));
    }

    public function trackForm(): View
    {
        return view('pages.track-shipment');
    }

    public function track(Request $request): RedirectResponse
    {
        $request->validate([
            'waybill_number' => ['required', 'string'],
        ]);

        $shipment = Shipment::where('waybill_number', trim($request->waybill_number))->first();

        if (! $shipment) {
            return back()->withErrors(['waybill_number' => 'No shipment found with that waybill number.']);
        }

        return redirect()->route('shipments.show', $shipment);
    }

    public function show(Shipment $shipment): View
    {
        $shipment->load('trackingUpdates', 'rider');

        return view('pages.track-shipment-result', compact('shipment'));
    }

    public function qr(Shipment $shipment)
    {
        $result = (new Builder(
            data: route('shipments.show', $shipment),
            size: 300,
            margin: 10,
        ))->build();

        return response($result->getString(), 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    public function invoice(Shipment $shipment)
    {
        $pdf = app('dompdf.wrapper')->loadView('pdf.invoice', compact('shipment'));

        return $pdf->download("invoice-{$shipment->waybill_number}.pdf");
    }

    public function riderLocation(Shipment $shipment)
    {
        $activeStatuses = ['picked_up', 'in_transit', 'out_for_delivery'];

        if (! $shipment->rider || ! in_array($shipment->status, $activeStatuses, true) || ! $shipment->rider->current_lat) {
            return response()->json(['available' => false], 404);
        }

        return response()->json([
            'available' => true,
            'lat' => (float) $shipment->rider->current_lat,
            'lng' => (float) $shipment->rider->current_lng,
            'rider_name' => $shipment->rider->name,
            'updated_at' => $shipment->rider->location_updated_at?->diffForHumans(),
        ]);
    }

    private function generateQrCode(Shipment $shipment): void
    {
        // QR codes are generated and streamed dynamically in qr()
        $shipment->update(['qr_code_path' => route('shipments.qr', $shipment)]);
    }
}
