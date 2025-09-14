<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\BarangayController;
use App\Http\Controllers\Web\PurokController;
use App\Http\Controllers\Web\MidwifeController;
use App\Http\Controllers\Web\MedicineController;
use App\Http\Controllers\Web\MedicineInventoryController;
use App\Http\Controllers\Web\BHWController;
use App\Http\Controllers\Web\ScheduleController;
use App\Http\Controllers\Web\HealthProgramController;
use App\Http\Controllers\Web\HouseholdController;
use App\Http\Controllers\Web\FamilyController;
use App\Http\Controllers\Web\RedirectBarangayController;
use App\Http\Controllers\Web\MidwifeDashboardController;

Route::get('/', function () {
    return view('auth.login');
});


// Shared middleware group for authenticated and verified users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    Route::get('/redirect-dashboard', [RedirectBarangayController::class, 'redirect'])
     ->name('role.redirect');
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

    //edit barangay
    Route::put('/barangays/{barangay}', [BarangayController::class, 'update'])->name('barangays.update');

    //soft delete barangay
    Route::put('/barangays/{barangay}/deactivate', [BarangayController::class, 'deactivate'])->name('barangays.deactivate');

    //edit purok
    Route::put('mho/puroks/{id}', [PurokController::class, 'update'])->name('puroks.update');

    //removing a purok
    Route::put('/mho/puroks/remove/{id}', [PurokController::class, 'remove'])->name('mho.puroks.remove');

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
    Route::get('/mho/midwives/search', [MidwifeController::class, 'search'])->name('mho.midwives.search');

    Route::get('/mho/midwife/{name}/{m_id}', [MidwifeController::class, 'show'])
        ->name('mho.midwife.show');

    // edit midwife info
    Route::put('mho/midwife/{id}/update', [MidwifeController::class, 'update'])->name('midwives.update');

    //remove midwife
    Route::put('/mho/midwife/{user}/remove', [MidwifeController::class, 'remove']);

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
     Route::get('/midwife/{barangay}/dashboard', [MidwifeDashboardController::class, 'index'])
             ->name('midwife.dashboard');

    // Midwife-specific dashboard
    Route::get('/barangay/households', [HouseholdController::class, 'index'])->name('midwife.households');

    Route::post('/barangays/households/add', [HouseholdController::class, 'store']);

    Route::get('/barangays/households/{id}', [HouseholdController::class, 'show'])->name('midwife.spec-household');

    Route::get('/barangay/families', [FamilyController::class, 'index'])->name('midwife.families');

    Route::post('/barangays/families/add', [FamilyController::class, 'store']);
    /*Route::get('/midwife/households/num', function () {
        
    })->name('midwife.spechouse');*/
    Route::get('/barangay/households/get', [HouseholdController::class, 'getHouseholdsJson'])
                                                                                                ->name('households.json'); 
    Route::get('/midwife/residents', function () {
        return view('midwife.resident-list');
    })->name('midwife.residents');

    /*Route::get('/midwife/families', function () {
        
    })->name('midwife.families');*/


    Route::get('/midwife/family/{family}', [FamilyController::class, 'show'])
        ->name('midwife.cur-fam');

    Route::get('/midwife/residents/spec-res', function () {
        return view('midwife.spec-resident');
    })->name('midwife.spec-resident');

    Route::get('/barangay/schedules', [ScheduleController::class, 'index'])->name('midwife.sched');
    
    Route::put('/daily-activity/update', [ScheduleController::class, 'updateDailyActivity']);

    Route::get('/barangay/get-bhws', [BHWController::class, 'getBHWs'])->name('bhws.get');

    Route::post('/barangay/bhw/add', [BHWController::class, 'store']);


    Route::put('/barangay/bhw/{id}/edit', [BHWController::class, 'update']);

    Route::put('/barangay/bhw/{id}/remove', [BhwController::class, 'remove']);

    Route::get('/midwife/reports', function () {
        return view('midwife.reports');
    })->name('midwife.reports');

    Route::get('/midwife/health-program', function () {
        return view('midwife.health-program');
    })->name('midwife.health-program');
    Route::get('/midwife/bhws/{bhw}', [BHWController::class, 'show'])->name('midwife.bhws.show');

    Route::get('/barangay/fetch/health-programs', [HealthProgramController::class, 'provideData'])->name('health.programs');

    Route::put('/barangay/schedule/delete/{id}', [ScheduleController::class, 'softDelete']);


    Route::get('/midwife/health-program-profile', function () {
        return view('midwife.health-program-profile');
    })->name('midwife.health-program-profile');

    // Midwife-specific dashboard 
    // Show list
    Route::get('/midwife/medicines', [MedicineController::class, 'index'])
        ->name('midwife.medicines');

    // Store new medicine
    Route::post('/midwife/add-medicines', [MedicineController::class, 'store'])->name('medicines.store');

    //updating medicine info
    Route::put('midwife/update-med/{id}', [MedicineController::class, 'updateMedicine']);
    // Midwife-specific dashboard 

    //inside view 
    Route::get('/midwife/medicines/{id}', [MedicineController::class, 'show'])->name('midwife.medicines.show');


    //delete a medicine
    Route::put('/midwife/medicine/delete={id}', [MedicineController::class, 'delete']);

    // Store new medicine batch
    Route::post('/midwife/medicines/{id}/inventory', [MedicineInventoryController::class, 'store'])->name('midwife.medicines.inventory.store');

    //bhw routes
    Route::get('/midwife/bhws/', [BHWController::class, 'index'])->name('midwife.bhws');

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
