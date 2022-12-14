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
// Error Pages
//=============================================================================================
Route::get('/401', function () {
    return view('/errors/401');
})->name('401');

Route::get('/404', function () {
    return view('/errors/404');
})->name('404');

Route::get('/500', function () {
    return view('/errors/500');
})->name('500');

Route::get('/502', function () {
    return view('/errors/502');
})->name('502');