<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $shipments = $user->shipments()->latest()->paginate(10);

        $stats = [
            'total' => $user->shipments()->count(),
            'in_transit' => $user->shipments()->whereIn('status', ['picked_up', 'in_transit', 'out_for_delivery'])->count(),
            'delivered' => $user->shipments()->where('status', 'delivered')->count(),
            'pending' => $user->shipments()->where('status', 'pending')->count(),
        ];

        return view('customer.dashboard', compact('shipments', 'stats'));
    }

    public function show(Shipment $shipment): View
    {
        abort_unless($shipment->user_id === auth()->id(), 403);

        $shipment->load('trackingUpdates', 'rider', 'payment');

        return view('customer.shipment-show', compact('shipment'));
    }
}
