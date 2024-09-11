<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VehicleManagementController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ServiceRecordController;
use App\Http\Controllers\Api\FeedbackController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);


//vehicle management
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/vehicles', [VehicleManagementController::class, 'index']);
    Route::post('/vehicles', [VehicleManagementController::class, 'store']);
    Route::get('/vehicles/{vehicle}', [VehicleManagementController::class, 'show']);
    Route::put('/vehicles/{vehicle}', [VehicleManagementController::class, 'update']);
    Route::delete('/vehicles/{vehicle}', [VehicleManagementController::class, 'destroy']);
});


//branch display api
Route::get('/branches', [BranchController::class, 'index']);

//service display api
Route::get('/services', [ServiceController::class, 'index']);

//appointment booking api
Route::middleware('auth:sanctum')->post('/appointments', [AppointmentController::class, 'store']);

// user upcoming appointment view api
Route::middleware('auth:sanctum')->group(function () {
    Route::get('appointments/upcoming', [AppointmentController::class, 'getUpcomingAppointments']);
    Route::get('appointments/history', [AppointmentController::class, 'getAppointmentHistory']);
});

//available time slot
Route::get('/available-time-slots', [AppointmentController::class, 'availableTimeSlots']);


// routes/api.php
Route::get('service-records/{vehicle_number}', [ServiceRecordController::class, 'getByVehicleNumber']);



Route::middleware('auth:sanctum')->post('/feedback', [FeedbackController::class, 'store']);

