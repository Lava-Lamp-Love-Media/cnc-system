<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\CompanyController;
use App\Http\Controllers\SuperAdmin\FeatureController;
use App\Http\Controllers\CompanyAdmin\VendorController;
use App\Http\Controllers\CompanyAdmin\MachineController;
use App\Http\Controllers\CompanyAdmin\CustomerController;
use App\Http\Controllers\CompanyAdmin\OperatorController;
use App\Http\Controllers\Frontend\TrialRequestController;
use App\Http\Controllers\CompanyAdmin\OperationController;
use App\Http\Controllers\CompanyAdmin\WarehouseController;
use App\Http\Controllers\CompanyAdmin\CompanyUserController;
use App\Http\Controllers\SuperAdmin\TrialRequestAdminController;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/', function () {
    // If user is logged in, redirect to dashboard
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('frontend.home');
})->name('landing');

Route::post('/trial-request', [TrialRequestController::class, 'store'])->name('trial.request.store');
Route::view('/trial-success', 'frontend.trial_success')->name('trial.success');
Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('super-admin')
        ->name('superadmin.')
        ->middleware('superadmin') // ✅ only once
        ->group(function () {
            Route::resource('features', FeatureController::class);
            Route::resource('plans', PlanController::class);
            Route::resource('companies', CompanyController::class);
            Route::post('companies/search-user', [CompanyController::class, 'searchUser'])->name('companies.search-user');
            Route::get('trial-requests', [TrialRequestAdminController::class, 'index'])->name('trial_requests.index');
            Route::post('trial-requests/{trialRequest}/approve', [TrialRequestAdminController::class, 'approve'])->name('trial_requests.approve');
            Route::post('trial-requests/{trialRequest}/reject', [TrialRequestAdminController::class, 'reject'])->name('trial_requests.reject');
        });

    Route::prefix('company')
        ->name('company.')
        ->middleware('companyadmin')
        ->group(function () {
            Route::resource('users', CompanyUserController::class);
            Route::resource('machines', MachineController::class);
            Route::resource('operators', OperatorController::class);
            Route::resource('operations', OperationController::class);
            Route::resource('warehouses', WarehouseController::class);
            Route::resource('customers', CustomerController::class);
            Route::get('customers/{customer}/print', [CustomerController::class, 'print'])->name('customers.print');
            Route::post('customers/{customer}/add-address', [CustomerController::class, 'addAddress'])->name('customers.add-address');
            Route::put('customers/{customer}/addresses/{address}', [CustomerController::class, 'updateAddress'])->name('customers.update-address');
            Route::delete('customers/{customer}/addresses/{address}', [CustomerController::class, 'deleteAddress'])->name('customers.delete-address');
            Route::post('customers/{customer}/upload-document', [CustomerController::class, 'uploadDocument'])->name('customers.upload-document');
            Route::delete('customers/{customer}/media/{media}', [CustomerController::class, 'deleteMedia'])->name('customers.delete-media');            // ✅ Vendors
            Route::resource('vendors', VendorController::class);
            Route::get('vendors/{vendor}/print', [VendorController::class, 'print'])->name('vendors.print');
            Route::post('vendors/{vendor}/add-address', [VendorController::class, 'addAddress'])->name('vendors.add-address');
            Route::put('vendors/{vendor}/addresses/{address}', [VendorController::class, 'updateAddress'])->name('vendors.update-address'); // ✅ ADD THIS
            Route::delete('vendors/{vendor}/addresses/{address}', [VendorController::class, 'deleteAddress'])->name('vendors.delete-address');
            Route::post('vendors/{vendor}/upload-document', [VendorController::class, 'uploadDocument'])->name('vendors.upload-document');
            Route::delete('vendors/{vendor}/media/{media}', [VendorController::class, 'deleteMedia'])->name('vendors.delete-media');
        });
});
