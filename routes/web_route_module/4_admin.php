<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Admin
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//==========================================================================================================
// Admin Dashboard
//=============================================================================================

Route::get('/dashboard/admin', function() {
    return redirect(route("dashboard.profile"));
})->name('dashboard.admin');

// Route::get('/dashboard/admin/profile', function() {
//     return view('dashboard/dashboard_profile', [
//         'user' => 'Admin',
//         'page' => 'Profile',
//         'header' => 'Profile'
//     ]);
// })->name('dashboard.admin.profile');

Route::get('/dashboard/admin/report', function() {
    return view('dashboard/admin/dashboard_report', [
        'user' => 'Admin',
        'page' => 'Report',
        'header' => 'Report'
    ]);
})->name('dashboard.admin.report');

Route::get('/dashboard/admin/topselectioncriterialist', function() {
    return view('dashboard/admin/dashboard_topselectioncriterialist', [
        'user' => 'Admin',
        'page' => 'Top Selection Criteria List',
        'header' => 'Top Selection Criteria List',
        'back' => true
    ]);
})->name('dashboard.admin.topselectioncriterialist');







