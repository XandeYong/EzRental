<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\RentalPostListController;
use App\Http\Controllers\RentingRecordController;
use App\Http\Controllers\RentRequestController;
use App\Http\Controllers\RoomVisitAppointmentController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Tenant
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//==========================================================================================================
// Tenant Dashboard
//=============================================================================================

Route::get('/dashboard/tenant', function() {
    return redirect(route("dashboard.profile"));
})->name('dashboard.tenant');


//Room Visit Appointment
// Route::get('/dashboard/room_visit_appointment_list', function() {
//     return view('dashboard/tenant/dashboard_roomvisitappointment_list', [
//         'user' => 'Tenant',
//         'page' => 'Room Visit Appointment',
//         'header' => 'Room Visit Appointment List'
//     ]);
// })->name('dashboard.tenant.room_visit_appointment_list');

// Route::get('/dashboard/room_visit_appointment_list/room_visit_appointment', function() {
//     return view('dashboard/tenant/dashboard_roomvisitappointment', [
//         'user' => 'Tenant',
//         'page' => 'Room Visit Appointment',
//         'header' => 'Room Visit Appointment',
//         'back' => '/dashboard/room_visit_appointment_list'
//     ]);
// })->name('dashboard.tenant.room_visit_appointment_list.room_visit_appointment');


//Controller
//FavoriteControlle
Route::get('/dashboard/favorite/index', [FavoriteController::class, 'index'])->name('dashboard.tenant.favorite');
Route::get('/dashboard/favorite/removeFavorite/{postID}', [FavoriteController::class, 'removeFavorite']); 
Route::get('/dashboard/favorite/addFavorite/{postID}', [FavoriteController::class, 'addFavorite']); 

//RecommendationController
Route::get('/dashboard/recommendation/index', [RecommendationController::class, 'index'])->name('dashboard.tenant.recommendation');
Route::get('/dashboard/recommendation/getCriteriaList', [RecommendationController::class, 'getCriteriaList']);
Route::post("/dashboard/recommendation/updateSelectionCriteriaToDB", [RecommendationController::class, 'updateSelectionCriteriaToDB']);

//RentingRecordController
Route::get('/dashboard/rentingrecord/index/{value}', [RentingRecordController::class, 'index'])->name('dashboard.tenant.rentingrecord');
Route::get('/dashboard/rentingrecord/getrecordDetails/{rentingID}', [RentingRecordController::class, 'getrecordDetails']);


//Payment
Route::get('/dashboard/payment/index/{rentingID}', [PaymentController::class, 'index'])->name('dashboard.tenant.payment');
Route::get('/dashboard/payment/getPaymentDetails/{paymentID}', [PaymentController::class, 'getPaymentDetails']);
Route::post('/dashboard/payment/makePayment', [PaymentController::class, 'makePayment']);
Route::get('/dashboard/payment/paymentSuccess', [PaymentController::class, 'paymentSuccess']);


//MailController
Route::get('/mail/sentPaymentReceiptMail/{paymentDetails}/{paymentDetailsName}', [MailController::class, 'sentPaymentReceiptMail']);

//MaintenanceRequestController
Route::get('/dashboard/rentingrecord/maintenancerequest/index/{rentingID}', [MaintenanceRequestController::class, 'index'])->name('dashboard.tenant.maintenancerequest');
Route::get('/dashboard/rentingrecord/maintenancerequest/getMaintenanceRequestDetails/{maintenanceRequestID}', [MaintenanceRequestController::class, 'getMaintenanceRequestDetails']);
Route::get("/dashboard/rentingrecord/maintenancerequest/createMaintenanceRequest/{rentingID}", [MaintenanceRequestController::class, 'createMaintenanceRequest']);
Route::post("/dashboard/rentingrecord/maintenancerequest/createMaintenanceRequestToDB", [MaintenanceRequestController::class, 'createMaintenanceRequestToDB']);


//RentalPostListController
Route::get('/rental_post_list/recommend', [RentalPostListController::class, 'autoSearchMatchRecommendation'])->name('rental_post_list.recommend');


//MaintenanceRequestController
Route::get('/dashboard/rentingrecord/contract/index/{rentingID}', [ContractController::class, 'index'])->name('dashboard.tenant.contract');

//RentRequestController
Route::get('/dashboard/rentrequest/index', [RentRequestController::class, 'index'])->name('dashboard.tenant.rentrequest');
Route::get('/dashboard/rentrequest/getRentRequestDetails/{rentRequestID}', [RentRequestController::class, 'getRentRequestDetails']);

//RoomVisitAppointmentController
Route::get('/dashboard/roomvisitappointment/index', [RoomVisitAppointmentController::class, 'index'])->name('dashboard.tenant.roomvisitappointment');
Route::get('/dashboard/roomvisitappointment/getRoomVisitAppoitmentDetails/{roomVisitAppointmentID}', [RoomVisitAppointmentController::class, 'getRoomVisitAppoitmentDetails']);
Route::get('/dashboard/roomvisitappointment/approveAppointment/{roomVisitAppointmentID}', [RoomVisitAppointmentController::class, 'approveAppointment']);
Route::get('/dashboard/roomvisitappointment/rejectAppointment/{roomVisitAppointmentID}', [RoomVisitAppointmentController::class, 'rejectAppointment']);
Route::get('/dashboard/roomvisitappointment/cancelAppointment/{roomVisitAppointmentID}', [RoomVisitAppointmentController::class, 'cancelAppointment']);




//need remove
Route::get('/dashboard/favorite/test/{postID}', [FavoriteController::class, 'test']); //need remove
Route::get('/autoUnbannedUser', [TestController::class, 'autoUnbannedUser']); 
Route::get('/autoAddMonthlyPayment', [TestController::class, 'autoAddMonthlyPayment']); 
Route::get('/autoReminderForTenant', [TestController::class, 'autoReminderForTenant']); 
Route::get('/autoReminderForOwner', [TestController::class, 'autoReminderForOwner']); 
Route::get('/autoCheckRoomVisitAppointment', [TestController::class, 'autoCheckRoomVisitAppointment']); 












