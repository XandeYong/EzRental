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



Route::get('/dashboard/recommendation', function() {
    return view('dashboard/tenant/dashboard_recommendation', [
        'user' => 'Tenant',
        'page' => 'Recommendation',
        'header' => 'Recommendation Criteria',
        //'back' => 'url'
    ]);
})->name('dashboard.tenant.recommendation');

Route::get('/dashboard/recommendation/select', function() {
    return view('dashboard/tenant/dashboard_recommendation_select', [
        'user' => 'Tenant',
        'page' => 'Recommendation',
        'header' => 'Recommendation Criteria',
        'back' => '/dashboard/recommendation'
    ]);
})->name('dashboard.tenant.recommendation.select');


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














