<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\CompanyController;
use App\Http\Controllers\SuperAdmin\FeatureController;
use App\Http\Controllers\Frontend\TrialRequestController;
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
        });
});
