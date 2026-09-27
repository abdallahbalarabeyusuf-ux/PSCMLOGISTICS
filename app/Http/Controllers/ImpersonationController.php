<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function stop(): RedirectResponse
    {
        abort_unless(Auth::guard('admin')->check(), 403);

        Auth::guard('web')->logout();
        Auth::guard('rider')->logout();

        return redirect()->route('admin.dashboard')->with('status', 'Returned to admin panel.');
    }
}
