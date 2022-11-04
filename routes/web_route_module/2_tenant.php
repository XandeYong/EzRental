<?php

use App\Http\Controllers\Favorite;
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



Route::get('/dashboard/recommentation', function() {
    return view('dashboard/tenant/dashboard_recommentation', [
        'user' => 'Tenant',
        'page' => 'Recommentation',
        'header' => 'Recommentation Criteria',
        //'back' => 'url'
    ]);
})->name('dashboard.tenant.recommentation');

Route::get('/dashboard/recommentation/select', function() {
    return view('dashboard/tenant/dashboard_recommentation_select', [
        'user' => 'Tenant',
        'page' => 'Recommentation',
        'header' => 'Recommentation Criteria',
        'back' => '/dashboard/recommentation'
    ]);
})->name('dashboard.tenant.recommentation.select');


//Controller
Route::get('/dashboard/favorite/index', [Favorite::class, 'index'])->name('dashboard.tenant.favorite');
Route::get('/dashboard/favorite/removeFavorite/{postID}', [Favorite::class, 'removeFavorite']); 
Route::get('/dashboard/favorite/addFavorite/{postID}', [Favorite::class, 'addFavorite']); 

Route::get('/dashboard/favorite/test/{postID}', [Favorite::class, 'test']); //need remove














