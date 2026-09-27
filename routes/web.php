<?php

use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PricingZoneController as AdminPricingZoneController;
use App\Http\Controllers\Admin\RiderApplicationController as AdminRiderApplicationController;
use App\Http\Controllers\Admin\RiderController as AdminRiderController;
use App\Http\Controllers\Admin\ShipmentController as AdminShipmentController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\RiderAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiderApplicationController;
use App\Http\Controllers\RiderPortalController;
use App\Http\Controllers\ShipmentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public marketing pages
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');

Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::post('/pricing/calculate', [PricingController::class, 'calculate'])->name('pricing.calculate');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/become-a-rider', [RiderApplicationController::class, 'create'])->name('rider-application.create');
Route::post('/become-a-rider', [RiderApplicationController::class, 'store'])->name('rider-application.store');

/*
|--------------------------------------------------------------------------
| Shipments: track + request pickup (guest + authenticated)
|--------------------------------------------------------------------------
*/
Route::get('/track-shipment', [ShipmentController::class, 'trackForm'])->name('shipments.track');
Route::post('/track-shipment', [ShipmentController::class, 'track'])->name('shipments.track.submit');
Route::get('/track-shipment/{shipment:waybill_number}', [ShipmentController::class, 'show'])->name('shipments.show');

Route::get('/request-pickup', [ShipmentController::class, 'create'])->name('shipments.create');
Route::post('/request-pickup', [ShipmentController::class, 'store'])->name('shipments.store');
Route::get('/request-pickup/{shipment:waybill_number}/confirmation', [ShipmentController::class, 'confirmation'])->name('shipments.confirmation');
Route::get('/shipments/{shipment:waybill_number}/invoice', [ShipmentController::class, 'invoice'])->name('shipments.invoice');
Route::get('/shipments/{shipment:waybill_number}/qr', [ShipmentController::class, 'qr'])->name('shipments.qr');
Route::get('/track-shipment/{shipment:waybill_number}/location', [ShipmentController::class, 'riderLocation'])->name('shipments.location');

/*
|--------------------------------------------------------------------------
| Payments (Paystack)
|--------------------------------------------------------------------------
*/
Route::get('/payments/{shipment:waybill_number}/pay', [PaymentController::class, 'pay'])->name('payments.pay');
Route::get('/payments/callback', [PaymentController::class, 'callback'])->name('payments.callback');

/*
|--------------------------------------------------------------------------
| Customer authentication (Breeze) + dashboard
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('/dashboard/shipments/{shipment:waybill_number}', [CustomerDashboardController::class, 'show'])->name('customer.shipments.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::post('/stop-impersonating', [ImpersonationController::class, 'stop'])->name('impersonate.stop');

/*
|--------------------------------------------------------------------------
| Rider portal (live location sharing)
|--------------------------------------------------------------------------
*/
Route::prefix('rider')->name('rider.')->group(function () {
    Route::middleware('guest:rider')->group(function () {
        Route::get('/login', [RiderAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [RiderAuthController::class, 'login'])->name('login.submit');
    });

    Route::post('/logout', [RiderAuthController::class, 'logout'])->name('logout');

    Route::middleware('rider')->group(function () {
        Route::get('/dashboard', [RiderPortalController::class, 'dashboard'])->name('dashboard');
        Route::post('/location', [RiderPortalController::class, 'updateLocation'])->name('location');
    });
});

/*
|--------------------------------------------------------------------------
| Admin authentication
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('shipments', AdminShipmentController::class)->except(['create', 'store']);
        Route::post('/shipments/{shipment}/status', [AdminShipmentController::class, 'updateStatus'])->name('shipments.updateStatus');

        Route::get('/riders/locations', [AdminRiderController::class, 'locations'])->name('riders.locations');
        Route::post('/riders/{rider}/impersonate', [AdminRiderController::class, 'impersonate'])->name('riders.impersonate');
        Route::resource('riders', AdminRiderController::class)->except(['show']);

        Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::post('/customers/{user}/impersonate', [AdminCustomerController::class, 'impersonate'])->name('customers.impersonate');

        Route::get('/rider-applications', [AdminRiderApplicationController::class, 'index'])->name('rider-applications.index');
        Route::post('/rider-applications/{riderApplication}/approve', [AdminRiderApplicationController::class, 'approve'])->name('rider-applications.approve');
        Route::post('/rider-applications/{riderApplication}/reject', [AdminRiderApplicationController::class, 'reject'])->name('rider-applications.reject');

        Route::get('/contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');

        Route::resource('pricing-zones', AdminPricingZoneController::class)->except(['show']);
    });
});
