<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

    //Route for health programs
    Route::get('/mho/health-programs', function(){
        return view('mho.health-program-list');
    })->name('mho.health-programs');

    //Route for specific health programs
    Route::get('/mho/health-programs/spec', function(){
        return view('mho.spec-health-program');
    })->name('mho.spec-hprog');

    //Route for barangays
    Route::get('/mho/barangays', function(){
        return view('mho.barangay-list');
    })->name('mho.barangays');

    //Route for midwives list
    Route::get('/mho/midwives', function(){
        return view('mho.midwives');
    })->name('mho.midwives');

    //Route for specific midwife
    Route::get('/mho/midwives/spec', function(){
        return view('mho.spec-midwife');
    })->name('mho.midwife-spec');

    // Midwife-specific dashboard
    Route::get('/midwife/dashboard', function () {
        return view('midwife.dashboard');
    })->name('midwife.dashboard');
    
    //route for mho reports
    Route::get('/mho/reports', function(){
        return view('mho.reports');
    })->name('mho.reports');

        // Midwife-specific dashboard
    Route::get('/midwife/households', function () {
        return view('midwife.household-list');
    })->name('midwife.households');

    Route::get('/midwife/households/num', function(){
        return view('midwife.spec-household');
    })->name('midwife.spechouse');

     Route::get('/midwife/residents', function(){
        return view('midwife.resident-list');
    })->name('midwife.residents');

    Route::get('/midwife/residents/spec-res', function(){
        return view('midwife.spec-resident');
    })->name('midwife.spec-resident');

    Route::get('/midwife/schedules', function(){
        return view('midwife.schedules');
    })->name('midwife.sched');
    
    Route::get('/midwife/reports', function(){
        return view('midwife.reports');
    })->name('midwife.reports');
});
