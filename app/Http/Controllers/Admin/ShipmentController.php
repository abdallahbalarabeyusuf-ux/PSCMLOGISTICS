<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rider;
use App\Models\Shipment;
use App\Services\SmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShipmentController extends Controller
{
    public function index(Request $request): View
    {
        $shipments = Shipment::with('rider')
            ->when($request->search, function ($query, $search) {
                $query->where('waybill_number', 'like', "%{$search}%")
                    ->orWhere('sender_name', 'like', "%{$search}%")
                    ->orWhere('receiver_name', 'like', "%{$search}%");
            })
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.shipments.index', compact('shipments'));
    }

    public function show(Shipment $shipment): View
    {
        $shipment->load('trackingUpdates', 'rider', 'payment', 'user');
        $riders = Rider::where('status', 'active')->orderBy('name')->get();

        return view('admin.shipments.show', compact('shipment', 'riders'));
    }

    public function update(Request $request, Shipment $shipment): RedirectResponse
    {
        $data = $request->validate([
            'rider_id' => ['nullable', 'exists:riders,id'],
            'payment_status' => ['required', 'in:unpaid,paid'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        $shipment->update($data);

        return back()->with('status', 'Shipment updated successfully.');
    }

    public function destroy(Shipment $shipment): RedirectResponse
    {
        $shipment->delete();

        return redirect()->route('admin.shipments.index')->with('status', 'Shipment deleted.');
    }

    public function updateStatus(Request $request, Shipment $shipment, SmsService $smsService): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,picked_up,in_transit,out_for_delivery,delivered,cancelled'],
            'location' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $shipment->update(['status' => $data['status']]);

        $shipment->trackingUpdates()->create([
            'status' => $data['status'],
            'location' => $data['location'] ?? null,
            'note' => $data['note'] ?? null,
        ]);

        $smsService->send(
            $shipment->receiver_phone,
            "PSCM: Your shipment {$shipment->waybill_number} status is now: {$shipment->statusLabel()}."
        );

        return back()->with('status', 'Shipment status updated and customer notified.');
    }
}
