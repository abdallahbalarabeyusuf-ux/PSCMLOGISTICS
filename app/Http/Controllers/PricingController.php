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
        $zones = PricingZone::orderBy('base_fee')->get();

        return view('pages.pricing', compact('zones'));
    }

    public function calculate(Request $request, PricingService $pricingService): JsonResponse
    {
        $data = $request->validate([
            'destination_zone' => ['required', 'string', 'exists:pricing_zones,code'],
            'weight_kg' => ['required', 'numeric', 'min:0.1', 'max:1000'],
        ]);

        $amount = $pricingService->calculate($data['destination_zone'], (float) $data['weight_kg']);

        return response()->json([
            'amount' => number_format($amount, 2),
        ]);
    }
}
