<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthManagerController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceRecordController;
use App\Http\Controllers\ProductdsController;
use App\Http\Controllers\SubServiceController;
use App\Http\Controllers\AppointmentSettingController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\UserController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
}) -> name('login');

Route::get('/login', function () {
    return view('login');
})->name('login');
//Route::post('/register', [AuthManagerController::class, 'register'])->name('registration.post');
//Route::post('/login', [AuthManagerController::class, 'login'])->name('login.post');
Route::get('/adminconsole', function () {
    return view('adminconsole');
})->name('admin');


Route::get('/appointments', [AppointmentController::class, 'showCalendar'])->name('appointments.by_date');
// Route to show the plain calendar view
Route::get('/calendar', [AppointmentController::class, 'showCalendarView'])->name('calendar.view');

// Admin routes
Route::post('/register', [AuthManagerController::class, 'registerAdmin'])->name('registration.post');
Route::post('/login', [AuthManagerController::class, 'loginAdmin'])->name('login.post');



Route::get('/admin/register', [AdminUserController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AdminUserController::class, 'registerAdmin']);
Route::post('/logout', [AdminUserController::class, 'logout'])->name('logout');


Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');
Route::get('/branches/create', [BranchController::class, 'create'])->name('branches.create');
Route::post('/branches', [BranchController::class, 'store'])->name('branches.store');
Route::get('/branches/{id}', [BranchController::class, 'show'])->name('branches.show');
Route::get('/branches/{id}/edit', [BranchController::class, 'edit'])->name('branches.edit');
Route::put('/branches/{id}', [BranchController::class, 'update'])->name('branches.update');
Route::delete('/branches/{id}', [BranchController::class, 'destroy'])->name('branches.destroy');


Route::get('/service', [ServiceController::class, 'index'])->name('service.index');
Route::get('/service/create', [ServiceController::class, 'create'])->name('service.create');
Route::post('/service', [ServiceController::class, 'store'])->name('service.store');
Route::get('/service/{id}', [ServiceController::class, 'show'])->name('service.show');
Route::get('/service/{id}/edit', [ServiceController::class, 'edit'])->name('service.edit');
Route::put('/service/{id}', [ServiceController::class, 'update'])->name('service.update');
Route::delete('/service/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');



// Display the form for creating a new service record
Route::get('/service-records/create', [ServiceRecordController::class, 'create'])->name('service_records.create');

// Handle the form submission to store a new service record
Route::post('/service-records', [ServiceRecordController::class, 'store'])->name('service_records.store');

//Route::get('/products', [ProductsController::class, 'index'])->name('products.index');




// Display a listing of the resource
Route::get('sub-services', [SubServiceController::class, 'index'])->name('sub-services.index');

// Show the form for creating a new resource
Route::get('sub-services/create', [SubServiceController::class, 'create'])->name('sub-services.create');

// Store a newly created resource in storage
Route::post('sub-services', [SubServiceController::class, 'store'])->name('sub-services.store');

// Display the specified resource
Route::get('sub-services/{id}', [SubServiceController::class, 'show'])->name('sub-services.show');

// Show the form for editing the specified resource
Route::get('sub-services/{id}/edit', [SubServiceController::class, 'edit'])->name('sub-services.edit');

// Update the specified resource in storage
Route::put('sub-services/{id}', [SubServiceController::class, 'update'])->name('sub-services.update');

// Remove the specified resource from storage
Route::delete('sub-services/{id}', [SubServiceController::class, 'destroy'])->name('sub-services.destroy');




Route::get('settings', [AppointmentSettingController::class, 'index'])->name('settings.index');
Route::post('settings/update', [AppointmentSettingController::class, 'update'])->name('settings.update');




Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');

Route::patch('/vehicles/{id}/approve', [VehicleController::class, 'approve'])->name('vehicles.approve');

Route::get('/users', [UserController::class, 'index'])->name('user.index');