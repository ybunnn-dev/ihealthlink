<?php
//api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Mobile\AuthController;
use App\Http\Controllers\Mobile\HomeController;
use App\Http\Controllers\Mobile\ScheduleController;
use App\Http\Controllers\Mobile\MedicineController;
use App\Http\Controllers\Mobile\HouseholdController;
use App\Http\Controllers\Mobile\FamilyController;
use App\Http\Controllers\Mobile\MedicineInventoryController;
use App\Http\Controllers\Mobile\ResidentController;
use App\Http\Controllers\Mobile\UserManualController;
use App\Http\Controllers\Mobile\ProfileController;
use App\Http\Controllers\Mobile\HealthProgramController;
use App\Http\Controllers\Mobile\PreloadController;
use App\Http\Controllers\Mobile\ConsultationController;
use App\Http\Controllers\Mobile\PhilpenController;
use App\Http\Controllers\Mobile\SyncController;
use App\Http\Controllers\FirebaseController;

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login'); ;

// Protected routes (require Sanctum token)
Route::middleware(['auth:sanctum',
'verified',
'throttle:auth-web',
'active',
'personnel.only'
]
)->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/mobile/logout', [AuthController::class, 'logout']);

    Route::get('/home', [HomeController::class, 'index']);

    Route::get('/schedules', [ScheduleController::class, 'index']);
   
    Route::get('/barangay/medicine/load', [MedicineController::class, 'index']);

    Route::get('/barangay/household/load', [HouseholdController::class, 'index']);

    Route::get('/barangay/family/load', [FamilyController::class, 'index']);

    Route::get('/barangay/resident/load', [ResidentController::class, 'index']);

    Route::post('/barangay/medicine/add', [MedicineController::class, 'store']);

    Route::post('/barangay/medicine/batch/add', [MedicineInventoryController::class, 'store']);

    Route::get('/barangay/family/show/{family}', [FamilyController::class, 'show']);

    Route::get('/barangay/resident/show/{resident}', [ResidentController::class, 'show']);

    Route::get('/barangay/user-manual', [UserManualController::class, 'index']);

    Route::put('/barangay/update-med/{id}', [MedicineController::class, 'updateMedicine']);

    Route::get('/barangay/profile', [ProfileController::class, 'show']);

    Route::post('/email/change/request', [ProfileController::class, 'requestEmailChange']);

    Route::post('/email/change/resend', [ProfileController::class, 'resendEmailChange']); //su link pang resend email

    Route::post('/email/change/verify', [ProfileController::class, 'verifyEmailChange']);

    Route::post('/password/change', [ProfileController::class, 'changePassword']);

    Route::get('/barangay/medicine/show/{id}', [MedicineController::class, 'show']);

    Route::get('/barangay/health-programs/load', [HealthProgramController::class,'index']);

    Route::get('/barangay/health-programs/{healthProgram}', [HealthProgramController::class, 'specHP']);

    Route::get('/barangay/health-programs/enrolled/{enrolledResident}', [HealthProgramController::class, 'show']);

    Route::post('/barangay/resident/add', [ResidentController::class,'addResident']);

    Route::get('/preload', [PreloadController::class, 'index']);

    Route::post('/barangay/household/store', [HouseholdController::class, 'store']);

    Route::post('/barangay/family/store', [FamilyController::class, 'store']);

    Route::get('/barangay/household/show/{household}', [HouseholdController::class, 'show']);

    Route::get('/barangay/medicines/get', [MedicineController::class, 'getMedicines']);

    Route::post('/barangay/health-program/consultation/update', [ConsultationController::class, 'updateConsultation']);

    Route::patch('/firebase/token', [App\Http\Controllers\FirebaseController::class, 'updateToken'])
    ->name('firebase.token');

    Route::get('/barangay/get/philpen', [PhilpenController::class, 'getLatestPhilpenData']);

    Route::put('/barangay/household/update', [HouseholdController::class, 'update']);

    Route::get('/barangay/household/get', [HouseholdController::class, 'householdGet']);

    Route::put('/barangay/household/head/set', [HouseholdController::class, 'setHead']);

    Route::put('/barangay/family/update/{family}', [FamilyController::class, 'update']);

    Route::put('/barangay/resident/update/{id}', [ResidentController::class, 'updateResident']);

    Route::post('/barangay/consultation/create', [ConsultationController::class, 'createConsultation']);

    Route::post('/barangay/households/sync', [HouseholdController::class, 'storeOrUpdateHouseholdSync']);
    Route::post('/barangay/families/sync', [FamilyController::class, 'storeOrUpdateFamilySync']);
    Route::post('/barangay/residents/sync', [ResidentController::class, 'storeOrUpdateResidentSync']);
    Route::post('/barangay/basic-health-records/sync', [SyncController::class, 'storeOrUpdateBasicHealthRecordSync']);
    Route::post('/barangay/consultations/sync', [SyncController::class, 'storeConsultationSync']);
    Route::post('/barangay/philpen/sync', [SyncController::class, 'syncPhilpenAssessments']);
    Route::get('/barangay/offline-data', [SyncController::class, 'fetchAllByPuroks']);


    Route::put('/barangay/family/transfer', [FamilyController::class, 'transfer']);
    Route::put('/barangay/resident/transfer', [ResidentController::class, 'transfer']);


    
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