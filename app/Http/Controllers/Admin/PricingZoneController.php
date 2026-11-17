<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingZone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PricingZoneController extends Controller
{
    public function index(): View
    {
        $zones = PricingZone::orderBy('name')->get();

        return view('admin.pricing-zones.index', compact('zones'));
    }

    public function create(): View
    {
        return view('admin.pricing-zones.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:pricing_zones,code', 'alpha_dash'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        PricingZone::create([
            ...$data,
            'base_fee' => config('pricing.base_fee'),
            'rate_per_kg' => config('pricing.rate_per_km'),
        ]);

        return redirect()->route('admin.pricing-zones.index')->with('status', 'Pricing zone added.');
    }

    public function edit(PricingZone $pricingZone): View
    {
        return view('admin.pricing-zones.edit', compact('pricingZone'));
    }

    public function update(Request $request, PricingZone $pricingZone): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:pricing_zones,code,' . $pricingZone->id],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $pricingZone->update($data);

        return redirect()->route('admin.pricing-zones.index')->with('status', 'Pricing zone updated.');
    }

    public function destroy(PricingZone $pricingZone): RedirectResponse
    {
        $pricingZone->delete();

        return back()->with('status', 'Pricing zone deleted.');
    }
}
