<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\BarangayController;
use App\Http\Controllers\Web\BarangayHealthProgramController;
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
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\BarangayReportsController;
use App\Http\Controllers\Web\ResidentController;
use App\Http\Controllers\Web\UserManualController;
use App\Http\Controllers\Web\MaternalController;
use App\Http\Controllers\Web\BarangayExportData;
use App\Http\Controllers\Web\ConsultationController;
use App\Http\Controllers\Web\MaternalExport;
use App\Http\Controllers\Web\ChildcareController;
use App\Http\Controllers\Web\BarangayLogs;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\Web\PhilpenController;
use App\Http\Controllers\Web\ReportsController;
use App\Http\Controllers\Web\ExportController;
use App\Http\Controllers\Web\FaqController;
use App\Http\Controllers\Web\MhoDashboardController;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('home');
    
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'throttle:auth-web',
    'admin.only',
    'active'
])->group(function(){
     // MHO-specific dashboard
     Route::put('/mho/health-programs/{healthProgram}', [HealthProgramController::class, 'update'])->name('health-programs.update');

    Route::get('/mho/dashboard', [MhoDashboardController::class, 'index'])->name('mho.dashboard');

    Route::get('/mho/health-programs', [HealthProgramController::class, 'index'])->name('mho.health-programs');

    Route::get('/mho/health-programs/{healthProgram}', [HealthProgramController::class, 'show'])->name('mho.spec-hprog');

      //Corrected route to go to a specific barangay
    Route::get('/mho/barangays/{barangay}/{name}', [BarangayController::class, 'show'])
        ->name('mho.barangays.show')
        ->where(['barangay' => '[0-9]+', 'name' => '[a-zA-Z0-9-]+']);

    Route::post('/barangay/health-programs/add', [HealthProgramController::class, 'store']);

    //Route for barangays
    Route::get('/mho/barangays', [BarangayController::class, 'index'])->name('mho.barangays');

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

    Route::post('/add-purok', [PurokController::class, 'addPurok'])->name('puroks.add');

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
    Route::get('/mho/reports', [ReportsController::class, 'index'])->name('mho.reports');


    Route::get('/mho/faq', [FaqController::class, 'index'])->name('mho.faq');

    Route::get('/mho/reports/community-report-pdf', [ExportController::class, 'downloadCommunityReport']);
    Route::get('/mho/reports/preview-community-report', [ExportController::class, 'previewCommunityReport']);
    Route::get('/mho/reports/export-excel', [ExportController::class, 'exportCommunityReportExcel']);

    Route::post('/mho/faq/create', [FaqController::class, 'store'])->name('faqs.store');

    Route::get('/faqs/{manual}', [FaqController::class, 'fetchFaq'])->name('faqs.show');
    Route::put('/faqs/{manual}', [FaqController::class, 'update'])->name('faqs.update');
    Route::put('/faqs/{manual}/deactivate', [FaqController::class, 'deactivate'])->name('faqs.deactivate');
    Route::patch('/faqs/{manual}/activate', [FaqController::class, 'activate'])->name('faqs.activate');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'throttle:auth-web',
    'midwife.only',
    'active'
])->group(function () {
     Route::get('/barangay/schedules', [ScheduleController::class, 'index'])->name('midwife.sched');
    
    Route::put('/daily-activity/update', [ScheduleController::class, 'updateDailyActivity']);

    Route::get('/barangay/get-bhws', [BHWController::class, 'getBHWs'])->name('bhws.get');

    Route::post('/barangay/bhw/add', [BHWController::class, 'store']);

    Route::put('/barangay/bhw/{id}/edit', [BHWController::class, 'update']);

    Route::put('/barangay/bhw/{id}/remove', [BhwController::class, 'remove']);

      //bhw routes
    Route::get('/barangay/bhws/', [BHWController::class, 'index'])->name('midwife.bhws');

    // Midwife-specific dashboard
    Route::get('/barangay/logs', [BarangayLogs::class, 'index'])->name('midwife.logs');
    
    Route::get('/midwife/bhws/{personnel}', [BHWController::class, 'show'])->name('midwife.bhws.show');

    Route::get('/barangay/philpen/count/', [PhilpenController::class, 'countIncomplete']);

    Route::post('/barangay/philpen/consultation/create', [PhilpenController::class, 'createNewScheds']);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'throttle:auth-web',
    'active',
])->group(function () {

    Route::get('/firebase-messaging-sw.js', function () {
        return response()->view('firebase-messaging-sw')
            ->header('Content-Type', 'application/javascript')
            ->header('Service-Worker-Allowed', '/');
    });

     Route::patch('/firebase/token', [FirebaseController::class, 'updateToken'])
        ->name('firebase.token');
        
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index']);
    Route::patch('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead']);
    Route::patch('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead']);
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'throttle:auth-web',
    'midwife.role4',
    'active',
])->group(function () {
    
    Route::put('/barangay/family/transfer', [FamilyController::class, 'transfer'])->name('family.transfer');

    Route::put('/barangay/household/update', [HouseholdController::class, 'update']);

    Route::post('/notifications/send', [App\Http\Controllers\NotificationController::class, 'send']);

     Route::get('barangay/{barangay}/dashboard', [DashboardController::class, 'index'])
             ->name('midwife.dashboard');

    Route::get('/barangay/households', [HouseholdController::class, 'index'])->name('midwife.households');

    Route::post('/barangays/households/add', [HouseholdController::class, 'store']);

    Route::get('/barangays/households/{household}', [HouseholdController::class, 'show'])->name('midwife.spec-household');

    Route::get('/barangay/families', [FamilyController::class, 'index'])->name('midwife.families');

    Route::post('/barangays/families/add', [FamilyController::class, 'store']);
    /*Route::get('/midwife/households/num', function () {
        
    })->name('midwife.spechouse');*/
    Route::get('/barangay/households/get', [HouseholdController::class, 'getHouseholdsJson'])
                                                                                                ->name('households.json'); 
    Route::get('philpen/get/{consultation}', [PhilpenController::class, 'getPhilpen'])->name('philpen.get');

    Route::get('/barangay/residents/load', [ResidentController::class, 'index'])->name('midwife.residents');
    
    Route::get('barangay/resident/families/find', [FamilyController::class, 'getAllFamilies']);

    Route::get('barangay/resident/families/get', [FamilyController::class, 'getFamilies']);
    
    Route::get('/barangay/family/{family}', [FamilyController::class, 'show'])
        ->name('midwife.cur-fam');

    Route::get('/barangay/residents/{resident}', [ResidentController::class, 'show'])->name('midwife.spec-resident');

    Route::post('/barangay/add-sched', [ScheduleController::class, 'store']);

    Route::put('/barangay/schedule/edit/{id}', [ScheduleController::class, 'edit']);

    Route::post('/barangay/resident/add', [ResidentController::class, 'addResident']);

    Route::get('/barangay/resident/enroll', [ResidentController::class, 'getResident']);
    
    Route::get('/barangay/maternity/resident/enroll', [ResidentController::class, 'getWRA']);

    Route::get('/barangay/get/mother', [ResidentController::class, 'getMother']);
    
    Route::get('/barangay/reports',[BarangayReportsController::class, 'index'])->name('midwife.reports');

    Route::get('/barangay/fetch/health-programs', [HealthProgramController::class, 'provideData'])->name('health.programs');

    Route::put('/barangay/schedule/delete/{id}', [ScheduleController::class, 'softDelete']);

   
   
    
    
    Route::get('/barangay/medicines', [MedicineController::class, 'index'])
        ->name('midwife.medicines');

    // Store new medicine
    Route::post('/midwife/add-medicines', [MedicineController::class, 'store'])->name('medicines.store');

    //updating medicine info
    Route::put('midwife/update-med/{id}', [MedicineController::class, 'updateMedicine']);
    // Midwife-specific dashboard 

    //inside view 
    Route::get('/barangay/medicines/{id}', [MedicineController::class, 'show'])->name('midwife.medicines.show');

    Route::get('/philpen/print/{consultation}', [BarangayExportData::class, 'printPhilpen']);

    //delete a medicine
    Route::put('/midwife/medicine/delete={id}', [MedicineController::class, 'delete']);

    // Store new medicine batch
    Route::post('/midwife/medicines/{id}/inventory', [MedicineInventoryController::class, 'store'])->name('midwife.medicines.inventory.store');


    Route::get('/barangay/user-manual', [UserManualController::class, 'index'])->name('midwife.faqs');
    // Midwife-specific dashboard
   
    Route::get('/barangay/health-programs/enrolled/resident/{enrolledResident}', [BarangayHealthProgramController::class, 'show'])
    ->name('midwife.enrolled-resident');


    Route::get('/barangay/health-programs/{healthProgram?}', [BarangayHealthProgramController::class, 'index'])
    ->name('midwife.health-program');


    Route::get('/barangay/reports/community-report-pdf', [BarangayExportData::class, 'downloadCommunityReport']);
    Route::get('/reports/preview-community-report', [BarangayExportData::class, 'previewCommunityReport']);
    Route::get('/barangay/reports/export-excel', [BarangayExportData::class, 'exportCommunityReportExcel']);


    Route::post('/barangay/health-program/{healthProgramId}/enroll/{residentId}',[BarangayHealthProgramController::class, 'enrollResident'])->name('barangay.health-program.enroll');
    
    Route::post('/barangay/health-program/maternity/enroll/',[MaternalController::class, 'enroll']);

    Route::get('/barangay/health-program/fetch', [BarangayHealthProgramController::class, 'getAllPrograms'])
    ->name('barangay.health-program.fetch');

    Route::get('/barangay/consultation/{id}', [ConsultationController::class, 'getConsultation']);

    Route::get('/barangay/get-medicines', [MedicineController::class, 'getMedicines']);

    Route::post('/barangay/consultation/store', [ConsultationController::class, 'store']);

    Route::post('/barangay/export-maternal', [MaternalExport::class, 'exportIndividual']);

    Route::post('/barangay/health-program/maternity/update-maternal-record', [MaternalController::class, 'updateMaternalRecord']);

    Route::post('/barangay/health-program/enroll/{residentId}', [BarangayHealthProgramController::class, 'enrollFamPlan']);

    Route::post('/barangay/health-program/fam-plan/update/{enrolledResident}', [BarangayHealthProgramController::class, 'updateFamPlan']);

    Route::post('/barangay/health-programs/philpen/create', [ConsultationController::class, 'createPhilpenData'])
    ->name('barangay.health-programs.philpen.create');

    Route::get('/barangay/get-puroks', [PurokController::class, 'getPuroks']);

    Route::post('/export/referral-pdf', [BarangayExportData::class, 'exportReferralPdf']);

    Route::post('/barangay/health-program/child-healthcare/enroll', [ChildcareController::class, 'enrollChild']);

    Route::post('/export/child-care-record', [BarangayExportData::class, 'printChildCarePdf'])->name('export.child.pdf');

    Route::post('/barangay/health-program/update-child-record', [ChildcareController::class, 'updateChildRecord']);

    Route::get('/barangay/logs/{log}', [BarangayLogs::class, 'show'])->name('logs.show');

    Route::put('/barangay/household-head/set', [HouseholdController::class, 'setHead']);

    Route::get('/barangay/residents/get/all' , [ResidentController::class, 'getAllResidents']);

    Route::put('/barangay/resident/transfer', [ResidentController::class, 'transfer']);

    Route::put('/barangay/family/update/{family}', [FamilyController::class, 'update']);

    Route::put('/barangay/families/set-status', [FamilyController::class, 'setStatus'])
    ->name('families.setStatus');

    Route::post('/barangay/consultation/create', [ConsultationController::class, 'createConsultation']);

    Route::post('/barangay/resident/update', [ResidentController::class, 'updateResident']);




});