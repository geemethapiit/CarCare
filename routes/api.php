<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VehicleManagementController;


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
