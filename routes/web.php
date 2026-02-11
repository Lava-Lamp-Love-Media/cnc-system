<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]); // DISABLE REGISTRATION

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
