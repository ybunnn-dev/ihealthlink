<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Shared middleware group for authenticated and verified users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
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
    
});
