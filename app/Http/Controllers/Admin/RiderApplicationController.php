<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rider;
use App\Models\RiderApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RiderApplicationController extends Controller
{
    public function index(): View
    {
        $applications = RiderApplication::latest()->paginate(15);

        return view('admin.rider-applications.index', compact('applications'));
    }

    public function approve(RiderApplication $riderApplication): RedirectResponse
    {
        $riderApplication->update(['status' => 'approved']);

        $temporaryPassword = Str::password(10);

        $rider = Rider::firstOrCreate(
            ['email' => $riderApplication->email],
            [
                'name' => $riderApplication->full_name,
                'phone' => $riderApplication->phone,
                'vehicle_type' => $riderApplication->vehicle_type,
                'plate_number' => $riderApplication->plate_number,
                'status' => 'active',
                'password' => $temporaryPassword,
            ]
        );

        if ($rider->wasRecentlyCreated) {
            return back()->with('status', "Application approved and rider account created. Rider portal login: {$rider->email} / temporary password: {$temporaryPassword}");
        }

        return back()->with('status', 'Application approved and rider account created.');
    }

    public function reject(RiderApplication $riderApplication): RedirectResponse
    {
        $riderApplication->update(['status' => 'rejected']);

        return back()->with('status', 'Application rejected.');
    }
}
