<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\RoomRentalPostController;
use App\Http\Controllers\RoomRentalPostListController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentRequestController;
use App\Http\Controllers\RoomVisitAppointmentController;
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
Route::get('/dashboard/room_rental_post_list/{postID}', [
    RoomRentalPostController::class, 'ownerIndex'
])->name('dashboard.owner.room_rental_post');

Route::get('/dashboard/room_rental_post/create_room_rental_post', function() {
    return view('dashboard/owner/dashboard_rentalpost_create', [
        'page' => 'Room Rental Post',
        'header' => 'Create Room Rental Post',
        'back' => '/dashboard/room_rental_post_list'
    ]);
})->name('dashboard.owner.room_rental_post.create_form');

Route::post('/dashboard/room_rental_post/create_room_rental_post/create', [
    RoomRentalPostController::class, 'createPost'
])->name('dashboard.owner.room_rental_post.create_form.create');

Route::get('/dashboard/room_rental_post_list/{postID}/edit_form', [
    RoomRentalPostController::class, 'editPostForm'
])->name('dashboard.owner.room_rental_post.edit_form');

Route::post('/dashboard/room_rental_post_list/{postID}/edit_form.edit', [
    RoomRentalPostController::class, 'updatePost'
])->name('dashboard.owner.room_rental_post.edit_form.edit');

Route::post('/dashboard/room_rental_post_list/{postID}/delete', [
    RoomRentalPostController::class, 'deletePost'
])->name('dashboard.owner.room_rental_post.delete');

    //Contract inside RRP
    Route::get('/dashboard/room_rental_post_list/{postID}/contract_list/', [
        ContractController::class, 'contractList'
    ])->name('dashboard.owner.room_rental_post.contract.list');
    
    Route::get('/dashboard/room_rental_post_list/{postID}/contract_list/{contractID}', [
        ContractController::class, 'ownerIndex'
    ])->name('dashboard.owner.room_rental_post.contract');
    
    Route::get('/dashboard/room_rental_post_list/{postID}/contract_list/{contractID}/edit_form', [
        ContractController::class, 'editContractForm'
    ])->name('dashboard.owner.room_rental_post.contract.edit_form');
    
    Route::post('/dashboard/room_rental_post_list/{postID}/contract_list/{contractID}/edit_form/edit', [
        ContractController::class, 'updateContract'
    ])->name('dashboard.owner.room_rental_post.contract.edit_form.edit');

    //Criteria inside RRP
    Route::get('/dashboard/room_rental_post_list/{postID}/criteria', [
        CriteriaController::class, 'ownerIndex'
    ])->name('dashboard.owner.room_rental_post.criteria');

    Route::post('/dashboard/room_rental_post_list/{postID}/criteria/update', [
        CriteriaController::class, 'updateCriteria'
    ])->name('dashboard.owner.room_rental_post.criteria.update');
    

//Maintenance Request Controller
Route::get('/dashboard/room_rental_post/maintenance_request/{postID}', [
    MaintenanceRequestController::class, 'indexForOwner'
]);

Route::get("/dashboard/room_rental_post/maintenance_request/approveMaintenanceRequest/{maintenanceRequestID}/{postID?}", [
    MaintenanceRequestController::class, 'approveMaintenanceRequest'
]);

Route::get("/dashboard/room_rental_post/maintenance_request/rejectMaintenanceRequest/{maintenanceRequestID}/{postID?}", [
    MaintenanceRequestController::class, 'rejectMaintenanceRequest'
]);

Route::post("/dashboard/room_rental_post/maintenance_request/submitProofOfMaintenance", [
    MaintenanceRequestController::class, 'submitProofOfMaintenance'
]);



//Rent Request Controller
Route::get('/dashboard/rentrequest/approveRentRequest/{rentRequestID}', [RentRequestController::class, 'approveRentRequest']);
Route::get('/dashboard/rentrequest/rejectRentRequest/{rentRequestID}', [RentRequestController::class, 'rejectRentRequest']);
Route::get('/dashboard/rentrequest/confirmRentRequest/{rentRequestID}', [RentRequestController::class, 'confirmRentRequest']);
Route::get('/dashboard/rentrequest/cancelRentRequest/{rentRequestID}', [RentRequestController::class, 'cancelRentRequest']);



//Payment Controller
Route::get('/dashboard/rentalpost/payment/indexForOwner/{postID}', [
    PaymentController::class, 'indexForOwner'
]);

//Contract Controller
Route::get('/dashboard/contract_list', [
    ContractController::class, 'contractList'
])->name('dashboard.owner.contract.list');

Route::get('/dashboard/contract_list/{contractID}', [
    ContractController::class, 'ownerIndex'
])->name('dashboard.owner.contract');

Route::get('/dashboard/contract_list/{contractID}/edit_form', [
    ContractController::class, 'editContractForm'
])->name('dashboard.owner.contract.edit_form');

Route::post('/dashboard/contract_list/{contractID}/edit_form/edit', [
    ContractController::class, 'updateContract'
])->name('dashboard.owner.contract.edit_form.edit');

//Route::get('/dashboard/rentalpost/contract/indexForOwner/{postID}', [ContractController::class, 'indexForOwner']);


//RoomVisitAppointmentController
Route::post('/dashboard/roomvisitappointment/editVisitAppointment', [RoomVisitAppointmentController::class, 'editVisitAppointment']);


