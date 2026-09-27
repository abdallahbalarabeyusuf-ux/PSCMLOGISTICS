<?php

namespace App\Http\Controllers;

use App\Models\RiderApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiderApplicationController extends Controller
{
    public function create(): View
    {
        return view('pages.become-a-rider');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'vehicle_type' => ['required', 'string', 'max:100'],
            'plate_number' => ['nullable', 'string', 'max:50'],
            'license_number' => ['nullable', 'string', 'max:50'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        RiderApplication::create($data);

        return back()->with('status', 'Your rider application has been submitted. We will contact you soon.');
    }
}
