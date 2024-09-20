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
use App\Http\Controllers\AppointmentReminderController;
use App\Http\Controllers\Api\ProfileController;


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
    Route::delete('/vehicles/{vehicle_number}', [VehicleManagementController::class, 'destroy']);
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
    Route::get('profile/details', [ProfileController::class, 'index']);
    Route::post('profile/update', [ProfileController::class, 'update']);
});

//available time slot
Route::get('/available-time-slots', [AppointmentController::class, 'availableTimeSlots']);

// branch details display api
Route::get('/branches/details', [BranchController::class, 'show']);

// set new appointment 
Route::post('/appointments', [AppointmentController::class, 'store'])->middleware('auth:sanctum');

// delete appointment
Route::post('/appointments/{appointmentid}/cancel', [AppointmentController::class, 'cancelAppointment']);

Route::get('/service-records/{vehicle_no}', [ServiceRecordController::class, 'getServiceRecordsByVehicle']);

// store feedback
Route::post('/feedback', [FeedbackController::class, 'store']);

Route::get('/service-records/{vehicle_no}', [ServiceRecordController::class, 'getServiceRecords']);

// send lube service records
Route::get('/get-lube-service-records/{vehicle_no}/{service_type}', [ServiceRecordController::class, 'getLubeServiceRecords']);

// send tire service records
Route::get('/get-tyre-service-records/{vehicle_no}/{service_type}', [ServiceRecordController::class, 'getTireServiceRecords']);

// send battery service records
Route::get('/get-battery-service-records/{vehicle_no}/{service_type}', [ServiceRecordController::class, 'getBatteryServiceRecords']);

// feedback submit api
Route::middleware('auth:sanctum')->post('/feedback', [FeedbackController::class, 'store']);

// routes/api.php
Route::post('/send-reminder', [AppointmentReminderController::class, 'sendReminder']);

// send profile details
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getUser']);

//change password
Route::middleware('auth:sanctum')->post('/changepassword', [UserController::class, 'changePassword']);

//delete user account
Route::middleware('auth:sanctum')->delete('/deleteuser', [UserController::class, 'deleteUser']);


// appointment reminder
Route::middleware('auth:api')->get('/notifications', function () {
    return auth()->user()->notifications;
});


