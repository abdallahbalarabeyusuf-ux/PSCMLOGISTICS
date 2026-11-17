<?php

namespace App\Http\Controllers;

use App\Models\PricingZone;
use App\Services\PricingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PricingController extends Controller
{
    public function index(): View
    {
        $zones = PricingZone::orderBy('name')->get();

        return view('pages.pricing', compact('zones'));
    }

    public function calculate(Request $request, PricingService $pricingService): JsonResponse
    {
        $data = $request->validate([
            'distance_km' => ['required', 'numeric', 'min:0.1', 'max:10000'],
        ]);

        $amount = $pricingService->calculate((float) $data['distance_km']);

        return response()->json([
            'amount' => number_format($amount, 2),
        ]);
    }
}
