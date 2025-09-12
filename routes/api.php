<?php
//api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Mobile\AuthController;
use App\Http\Controllers\Mobile\HomeController;
use App\Http\Controllers\Mobile\ScheduleController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/home', [HomeController::class, 'index']);

    Route::post('/barangay/schedule/get', [ScheduleController::class, 'getSched']); // this api will accept a month and a year
    // You can keep adding more protected API routes here
    // e.g. Route::get('/schedules', [ScheduleController::class, 'index']);
});
