<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\PurokController;
use App\Http\Controllers\MidwifeController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicineInventoryController;

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

    /** Municipal Health Office Module **/

    // MHO-specific dashboard
    Route::get('/mho/dashboard', function () {
        return view('mho.dashboard');
    })->name('mho.dashboard');

    //Route for health programs
    Route::get('/mho/health-programs', function () {
        return view('mho.health-program-list');
    })->name('mho.health-programs');

    //Route for specific health programs
    Route::get('/mho/health-programs/spec', function () {
        return view('mho.spec-health-program');
    })->name('mho.spec-hprog');

    //Route for barangays
    Route::get('/mho/barangays', [BarangayController::class, 'listView'])->name('mho.barangays');

    //Route for adding barangays
    Route::post('/add-brgy', [BarangayController::class, 'store'])->name('barangays.store');

    //fitler, search, and sort functions for the barangay module
    Route::get('/mho/barangays/search', [BarangayController::class, 'search'])->name('mho.barangays.search');

    //Corrected route to go to a specific barangay
    Route::get('/mho/barangays/{barangay}/{name}', [BarangayController::class, 'show'])
        ->name('mho.barangays.show')
        ->where(['barangay' => '[0-9]+', 'name' => '[a-zA-Z0-9-]+']);

    Route::post('/add-purok', [PurokController::class, 'addPurok'])->name('puroks.add');

    Route::get('/mho/barangays/{barangay}/search', [PurokController::class, 'search'])->name('puroks.search');

    Route::get('/mho/midwives', [MidwifeController::class, 'index'])->name('mho.midwives');

    // add midwife
    Route::post('/mho/add-midwife', [MidwifeController::class, 'store']);

    //Route for specific midwife
    Route::get('/mho/midwives/spec', function () {
        return view('mho.spec-midwife');
    })->name('mho.midwife-spec');

    Route::get('/mho/midwife/{name}/{m_id}', [MidwifeController::class, 'show'])
        ->name('mho.midwife.show');

    //route for mho reports
    Route::get('/mho/reports', function () {
        return view('mho.reports');
    })->name('mho.reports');

    Route::get('/mho/logs', function () {
        return view('mho.logs');
    })->name('mho.logs');

    Route::get('/mho/faq', function () {
        return view('mho.faq');
    })->name('mho.faq');

    /** Barangay Health Center Modules **/

    // Midwife-specific dashboard
    Route::get('/midwife/dashboard', function () {
        return view('midwife.dashboard');
    })->name('midwife.dashboard');

    // Midwife-specific dashboard
    Route::get('/midwife/households', function () {
        return view('midwife.household-list');
    })->name('midwife.households');

    Route::get('/midwife/households/num', function () {
        return view('midwife.spec-household');
    })->name('midwife.spechouse');

    Route::get('/midwife/residents', function () {
        return view('midwife.resident-list');
    })->name('midwife.residents');

    Route::get('/midwife/families', function () {
        return view('midwife.families');
    })->name('midwife.families');


    Route::get('/midwife/families/spec', function () {
        return view('midwife.spec-family');
    })->name('midwife.cur-fam');

    Route::get('/midwife/residents/spec-res', function () {
        return view('midwife.spec-resident');
    })->name('midwife.spec-resident');

    Route::get('/midwife/schedules', function () {
        return view('midwife.schedules');
    })->name('midwife.sched');

    Route::get('/midwife/reports', function () {
        return view('midwife.reports');
    })->name('midwife.reports');

    Route::get('/midwife/health-program', function () {
        return view('midwife.health-program');
    })->name('midwife.health-program');

    Route::get('/midwife/health-program-profile', function () {
        return view('midwife.health-program-profile');
    })->name('midwife.health-program-profile');

    // Midwife-specific dashboard 
    // Show list
    Route::get('/midwife/medicines', [MedicineController::class, 'index'])
        ->name('midwife.medicines');

    // Store new medicine
    Route::post('/midwife/medicines', [MedicineController::class, 'store'])
        ->name('medicines.store');

    // Midwife-specific dashboard 
    //inside view 
    Route::get('/midwife/medicines/{id}', [MedicineController::class, 'show'])->name('midwife.medicines.show');

    // Store new medicine batch
    Route::post('/midwife/medicines/{id}/inventory', [MedicineInventoryController::class, 'store'])
    ->name('midwife.medicines.inventory.store');

    Route::get('/midwife/bhws', function () {
        return view('midwife.BHWs');
    })->name('midwife.bhws');

    Route::get('/midwife/bhw-profile', function () {
        return view('midwife.BHWs-profile');
    })->name('midwife.BHWs-profile');

    // Midwife-specific dashboard
    Route::get('/midwife/logs', function () {
        return view('midwife.log-list');
    })->name('midwife.logs');

    // Midwife-specific dashboard
    Route::get('/midwife/faqs', function () {
        return view('midwife.faqs');
    })->name('midwife.faqs');

    Route::get('/midwife/health-programs/spec', function () {
        return view('midwife.enrolled-resident');
    })->name('midwife.enrolled-resident');
});
