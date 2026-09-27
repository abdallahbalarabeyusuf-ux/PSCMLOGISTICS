<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\RiderApplication;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_shipments' => Shipment::count(),
            'pending' => Shipment::where('status', 'pending')->count(),
            'in_transit' => Shipment::whereIn('status', ['picked_up', 'in_transit', 'out_for_delivery'])->count(),
            'delivered' => Shipment::where('status', 'delivered')->count(),
            'revenue' => Shipment::where('payment_status', 'paid')->sum('amount'),
            'active_riders' => \App\Models\Rider::where('status', 'active')->count(),
            'new_rider_applications' => RiderApplication::where('status', 'pending')->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        $recentShipments = Shipment::with('rider')->latest()->take(8)->get();

        $statusBreakdown = Shipment::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $shipmentsPerDay = Shipment::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(13))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentShipments', 'statusBreakdown', 'shipmentsPerDay'));
    }
}
