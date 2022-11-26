<?php

use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//==========================================================================================================
// Public
//=============================================================================================
include(base_path() . "\\routes\\web_route_module\\1_public.php");


//==========================================================================================================
// Tenant Dashboard
//=============================================================================================
include(base_path() . "\\routes\\web_route_module\\2_tenant.php");


//==========================================================================================================
// Owner Dashboard
//=============================================================================================
include(base_path() . "\\routes\\web_route_module\\3_owner.php");


//==========================================================================================================
// Admin Dashboard
//=============================================================================================
include(base_path() . "\\routes\\web_route_module\\4_admin.php");


//==========================================================================================================
// Testing Purpose [Need to remove before Complete Version]
//=============================================================================================

//Base component only route
Route::get('/base', function () {
    return view('/base/base');
})->name('base');

Route::get('/base/dashboard', function () {
    return view('/dashboard/dashboard_index');
})->name('base.dashboard');