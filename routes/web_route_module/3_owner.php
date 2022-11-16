<?php

use App\Http\Controllers\MaintenanceRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes - Owner
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//==========================================================================================================
// Owner Dashboard
//=============================================================================================

Route::get('/dashboard/owner', function() {
    return redirect(route('dashboard.profile'));
})->name('dashboard.owner');


//Controller
//RentRequestController
Route::get('/dashboard/rentrequest/approveRentRequest/{rentRequestID}', [RentRequestController::class, 'approveRentRequest']);
Route::get('/dashboard/rentrequest/rejectRentRequest/{rentRequestID}', [RentRequestController::class, 'rejectRentRequest']);

//MaintenanceRequestController
Route::get('/dashboard/rentingrecord/maintenancerequest/indexForOwner', [MaintenanceRequestController::class, 'indexForOwner']);
Route::get("/dashboard/rentingrecord/maintenancerequest/approveMaintenanceRequest/{maintenanceRequestID}", [MaintenanceRequestController::class, 'approveMaintenanceRequest']);
Route::get("/dashboard/rentingrecord/maintenancerequest/rejectMaintenanceRequest/{maintenanceRequestID}", [MaintenanceRequestController::class, 'rejectMaintenanceRequest']);


