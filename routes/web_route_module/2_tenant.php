<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RecommendationController;
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


Route::get('/dashboard/current_renting_record', function() {
    return view('dashboard/tenant/dashboard_rentingrecord_list', [
        'user' => 'Tenant',
        'page' => 'Renting Record',
        'header' => 'Current Renting Record List',
        //'back' => ''
    ]);
})->name('dashboard.tenant.current_renting_record.list');


Route::get('/dashboard/past_renting_record', function() {
    return view('dashboard/tenant/dashboard_rentingrecord_list', [
        'user' => 'Tenant',
        'page' => 'Renting Record',
        'header' => 'Past Renting Record List',
        //'back' => ''
    ]);
})->name('dashboard.tenant.past_renting_record.list');


Route::get('/dashboard/current_renting_record/record', function() {
    return view('dashboard/tenant/dashboard_rentingrecord', [
        'user' => 'Tenant',
        'page' => 'Renting Record',
        'header' => 'Current Renting Record',
        'back' => '/dashboard/current_renting_record'
    ]);
})->name('dashboard.tenant.current_renting_record');

// Payment
Route::get('/dashboard/current_renting_record/record/payment_history', function() {
    return view('dashboard/tenant/dashboard_payment_history', [
        'user' => 'Tenant',
        'page' => 'Renting Record',
        'header' => 'Payment History',
        'back' => '/dashboard/current_renting_record/record'
    ]);
})->name('dashboard.tenant.current_renting_record.payment_history');

Route::get('/dashboard/current_renting_record/record/payment_history/payment_detail', function() {
    return view('dashboard/tenant/dashboard_payment', [
        'user' => 'Tenant',
        'page' => 'Renting Record',
        'header' => 'Payment Detail',
        'back' => '/dashboard/current_renting_record/record/payment_history'
    ]);
})->name('dashboard.tenant.current_renting_record.payment_history.payment');


//Controller
//FavoriteControlle
Route::get('/dashboard/favorite/index', [FavoriteController::class, 'index'])->name('dashboard.tenant.favorite');
Route::get('/dashboard/favorite/removeFavorite/{postID}', [FavoriteController::class, 'removeFavorite']); 
Route::get('/dashboard/favorite/addFavorite/{postID}', [FavoriteController::class, 'addFavorite']); 

//RecommendationController
Route::get('/dashboard/recommendation/index', [RecommendationController::class, 'index'])->name('dashboard.tenant.recommendation');
Route::get('/dashboard/recommendation/getCriteriaList', [RecommendationController::class, 'getCriteriaList']);
Route::post("/dashboard/recommendation/updateSelectionCriteriaToDB", [RecommendationController::class, 'updateSelectionCriteriaToDB']);




//need remove
Route::get('/dashboard/favorite/test/{postID}', [FavoriteController::class, 'test']); //need remove
Route::get('/dashboard/test', [TestController::class, 'test']); //need remove













