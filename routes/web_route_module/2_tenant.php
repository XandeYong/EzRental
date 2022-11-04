<?php

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

Route::get('/dashboard/favorite', function() {
    return view('dashboard/tenant/dashboard_favorite', [
        'user' => 'Tenant',
        'page' => 'Favorite',
        'header' => 'Favorite',
        //'back' => 'url'
    ]);
})->name('dashboard.tenant.favorite');

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

















