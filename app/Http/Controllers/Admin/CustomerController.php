<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = User::withCount('shipments')->latest()->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function impersonate(User $user): RedirectResponse
    {
        Auth::guard('web')->login($user);

        return redirect()->route('customer.dashboard');
    }
}
