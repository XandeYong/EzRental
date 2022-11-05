<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RecommendationController;
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



Route::get('/dashboard/recommendation/select', function() {
    return view('dashboard/tenant/dashboard_recommendation_select', [
        'user' => 'Tenant',
        'page' => 'Recommendation',
        'header' => 'Recommendation Criteria',
        'back' => '/dashboard/recommendation'
    ]);
})->name('dashboard.tenant.recommendation.select');


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
    return view('dashboard/tenant/dashboard_currentrentingrecord', [
        'user' => 'Tenant',
        'page' => 'Renting Record',
        'header' => 'Current Renting Record',
        'back' => '/dashboard/current_renting_record'
    ]);
})->name('dashboard.tenant.current_renting_record');


//Controller
//FavoriteControlle
Route::get('/dashboard/favorite/index', [FavoriteController::class, 'index'])->name('dashboard.tenant.favorite');
Route::get('/dashboard/favorite/removeFavorite/{postID}', [FavoriteController::class, 'removeFavorite']); 
Route::get('/dashboard/favorite/addFavorite/{postID}', [FavoriteController::class, 'addFavorite']); 
Route::get('/dashboard/favorite/index', [FavoriteController::class, 'index'])->name('dashboard.tenant.favorite');

//RecommendationController
Route::get('/dashboard/recommendation/index', [RecommendationController::class, 'index'])->name('dashboard.tenant.recommendation');
Route::get('/dashboard/recommendation/getCriteriaList', [RecommendationController::class, 'getCriteriaList']);


//need remove
Route::get('/dashboard/favorite/test/{postID}', [FavoriteController::class, 'test']); //need remove














