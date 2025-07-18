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

    // Midwife-specific dashboard
    Route::get('/midwife/dashboard', function () {
        return view('midwife.dashboard');
    })->name('midwife.dashboard');
    
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
    
});
