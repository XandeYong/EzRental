<?php

use App\Http\Controllers\RoomRentalPostController;
use App\Http\Controllers\RoomRentalPostListController;
use App\Http\Controllers\MaintenanceRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentRequestController;
use Illuminate\Http\Request;

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


// Room Rental Post List
Route::get('/dashboard/room_rental_post_list', [
    RoomRentalPostListController::class, 'ownerIndex'
])->name('dashboard.owner.room_rental_post.list');

// Room Rental Post
Route::get('/dashboard/room_rental_post_list/room_rental_post/{post_id}', [
    RoomRentalPostController::class, 'ownerIndex'
])->name('dashboard.owner.room_rental_post');

Route::get('/dashboard/room_rental_post_list/create_room_rental_post', function() {
    return view('dashboard/owner/dashboard_rentalpost_create', [
        'page' => 'Room Rental Post',
        'header' => 'Create Room Rental Post',
        'back' => '/dashboard/room_rental_post_list'
    ]);
})->name('dashboard.owner.room_rental_post.create_form');

Route::post('/dashboard/room_rental_post_list/create_room_rental_post/create', [
    RoomRentalPostController::class, 'createPost'
])->name('dashboard.owner.room_rental_post.create_form.create');

// test array maintenance image
Route::post("/test/maintenance/upload", function(Request $request) {
    dd($request->files->get('images'));
});

//MaintenanceRequestController
Route::get('/dashboard/rentingrecord/maintenancerequest/indexForOwner', [MaintenanceRequestController::class, 'indexForOwner']);
Route::get("/dashboard/rentingrecord/maintenancerequest/approveMaintenanceRequest/{maintenanceRequestID}", [MaintenanceRequestController::class, 'approveMaintenanceRequest']);
Route::get("/dashboard/rentingrecord/maintenancerequest/rejectMaintenanceRequest/{maintenanceRequestID}", [MaintenanceRequestController::class, 'rejectMaintenanceRequest']);


//RentRequestController
Route::get('/dashboard/rentrequest/approveRentRequest/{rentRequestID}', [RentRequestController::class, 'approveRentRequest']);
Route::get('/dashboard/rentrequest/rejectRentRequest/{rentRequestID}', [RentRequestController::class, 'rejectRentRequest']);
Route::get('/dashboard/rentrequest/confirmRentRequest/{rentRequestID}', [RentRequestController::class, 'confirmRentRequest']);
Route::get('/dashboard/rentrequest/cancelRentRequest/{rentRequestID}', [RentRequestController::class, 'cancelRentRequest']);
