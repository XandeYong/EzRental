<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\RentalPostListController;
use App\Http\Controllers\RentingRecordController;
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

//Maintenance Request
// Route::get('/dashboard/current_renting_record/record/mainteance_request_history', function() {
//     return view('dashboard/tenant/dashboard_maintenancerequest_history', [
//         'user' => 'Tenant',
//         'page' => 'Renting Record',
//         'header' => 'Maintenance History',
//         'back' => '/dashboard/current_renting_record/record',
//         'button' => '/dashboard/current_renting_record/record/maintenance_request_history/create_maintenance_request'
//     ]);
// })->name('dashboard.tenant.current_renting_record.maintenance_request_history');

Route::get('/dashboard/current_renting_record/record/mainteance_request_history/maintenance_detail', function() {
    return view('dashboard/tenant/dashboard_maintenancerequest', [
        'user' => 'Tenant',
        'page' => 'Renting Record',
        'header' => 'Maintenance Detail',
        'back' => '/dashboard/current_renting_record/record/maintenance_request_history'
    ]);
})->name('dashboard.tenant.current_renting_record.maintenance_request_history.maintenance_detail');


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




//RentalPostListController
Route::get('/dashboard/rentalpostlist/autoSearchMatchRecommendation', [RentalPostListController::class, 'autoSearchMatchRecommendation']); //let xande decide put where


//need remove
Route::get('/dashboard/favorite/test/{postID}', [FavoriteController::class, 'test']); //need remove
Route::get('/dashboard/test', [TestController::class, 'test']); //need remove













