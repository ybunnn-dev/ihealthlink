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

// Public routes
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login'); ;

// Protected routes (require Sanctum token)
Route::middleware(['auth:sanctum',
'verified',
'throttle:auth-web',]
)->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

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
    
});
