<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Owner
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//==========================================================================================================
// Owner Dashboard
//=============================================================================================

Route::get('/dashboard/owner', function() {
    return redirect(route('dashboard.profile'));
})->name('dashboard.owner');

// Route::get('/dashboard/owner/profile', function() {
//     return view('dashboard/dashboard_profile', [
//         'user' => 'Owner',
//         'page' => 'Profile',
//         'header' => 'Profile'
//     ]);
// })->name('dashboard.owner.profile');

//Controller


//Controller


