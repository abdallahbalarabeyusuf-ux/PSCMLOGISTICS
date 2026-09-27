<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiderPortalController extends Controller
{
    public function dashboard(): View
    {
        $rider = auth('rider')->user();

        $shipments = $rider->shipments()
            ->whereIn('status', ['picked_up', 'in_transit', 'out_for_delivery'])
            ->latest()
            ->get();

        $stats = [
            'active' => $shipments->count(),
            'delivered' => $rider->shipments()->where('status', 'delivered')->count(),
            'total' => $rider->shipments()->count(),
            'delivered_this_week' => $rider->shipments()->where('status', 'delivered')->where('updated_at', '>=', now()->subDays(7))->count(),
        ];

        return view('rider.dashboard', compact('rider', 'shipments', 'stats'));
    }

    public function updateLocation(Request $request): JsonResponse
    {
        $data = $request->validate([
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $rider = auth('rider')->user();

        $rider->update([
            'current_lat' => $data['lat'],
            'current_lng' => $data['lng'],
            'location_updated_at' => now(),
        ]);

        return response()->json(['ok' => true]);
    }
}
