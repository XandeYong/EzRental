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

// Route::get('/dashboard/tenant/profile', function() {
//     return view('dashboard/dashboard_profile', [
//         'user' => 'Tenant',
//         'page' => 'Profile',
//         'header' => 'Profile',
//         //'back' => true
//     ]);
// })->name('dashboard.tenant.profile');

Route::get('/dashboard/tenant/favorite', function() {
    return view('dashboard/tenant/dashboard_favorite', [
        'user' => 'Tenant',
        'page' => 'Favorite',
        'header' => 'Favorite',
        //'back' => true
    ]);
})->name('dashboard.tenant.favorite');


//Controller

















