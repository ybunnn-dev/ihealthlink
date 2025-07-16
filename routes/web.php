<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

// Shared middleware group for authenticated and verified users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

   Route::get('/dashboard', function () {
        $user = Auth::user();
        return match ($user->role_id) {
            1 => redirect()->intended('/mho/dashboard'),
            2 => redirect()->intended('/midwife/dashboard'),
        };
    })->name('dashboard');

    // MHO-specific dashboard
    Route::get('/mho/dashboard', function () {
        return view('mho.dashboard');
    })->name('mho.dashboard');

    // Midwife-specific dashboard
    Route::get('/midwife/dashboard', function () {
        return view('midwife.dashboard');
    })->name('midwife.dashboard');
    
        // Midwife-specific dashboard
    Route::get('/midwife/households', function () {
        return view('midwife.household-list');
    })->name('midwife.households');

    // Midwife-specific dashboard
    Route::get('/midwife/medicines', function () {
        return view('midwife.medicine-list');
    })->name('midwife.medicines');

    // Midwife-specific dashboard
    Route::get('/midwife/medicines-view', function () {
        return view('midwife.spec-medicine');
    })->name('midwife.medicines-view');

    // Midwife-specific dashboard
    Route::get('/midwife/logs', function () {
        return view('midwife.log-list');
    })->name('midwife.logs');

    // Midwife-specific dashboard
    Route::get('/midwife/faqs', function () {
        return view('midwife.faqs');
    })->name('midwife.faqs');
    
});
