<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RiderController extends Controller
{
    public function index(): View
    {
        $riders = Rider::withCount('shipments')->latest()->paginate(15);

        return view('admin.riders.index', compact('riders'));
    }

    public function locations(): JsonResponse
    {
        $riders = Rider::where('status', 'active')
            ->whereNotNull('current_lat')
            ->whereNotNull('current_lng')
            ->get()
            ->map(fn (Rider $rider) => [
                'id' => $rider->id,
                'name' => $rider->name,
                'vehicle_type' => $rider->vehicle_type,
                'lat' => (float) $rider->current_lat,
                'lng' => (float) $rider->current_lng,
                'updated_at' => $rider->location_updated_at?->diffForHumans(),
            ]);

        return response()->json($riders);
    }

    public function create(): View
    {
        return view('admin.riders.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:riders,email'],
            'phone' => ['required', 'string', 'max:20'],
            'vehicle_type' => ['required', 'string', 'max:100'],
            'plate_number' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        Rider::create($data);

        return redirect()->route('admin.riders.index')->with('status', 'Rider added successfully.');
    }

    public function edit(Rider $rider): View
    {
        return view('admin.riders.edit', compact('rider'));
    }

    public function update(Request $request, Rider $rider): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:riders,email,' . $rider->id],
            'phone' => ['required', 'string', 'max:20'],
            'vehicle_type' => ['required', 'string', 'max:100'],
            'plate_number' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $rider->update($data);

        return redirect()->route('admin.riders.index')->with('status', 'Rider updated successfully.');
    }

    public function destroy(Rider $rider): RedirectResponse
    {
        $rider->delete();

        return back()->with('status', 'Rider removed.');
    }

    public function impersonate(Rider $rider): RedirectResponse
    {
        Auth::guard('rider')->login($rider);

        return redirect()->route('rider.dashboard');
    }
}
