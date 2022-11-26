<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\TopSelectionCriteriaListController;
use App\Http\Controllers\UserListController;
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

Route::middleware('account.admin')->group(function () {
    
    Route::get('/dashboard/admin', function() {
        return redirect(route("dashboard.profile"));
    })->name('dashboard.admin');

    Route::get('/dashboard/admin/report', function() {
        return view('dashboard/admin/dashboard_report', [
            'page' => 'Report',
            'header' => 'Report'
        ]);
    })->name('dashboard.admin.report');

    //Controller
    //TopSelectionCriteriaListController
    Route::get('/dashboard/topselectioncriterialist/index', [TopSelectionCriteriaListController::class, 'index'])->name('dashboard.admin.topselectioncriterialist');


    //UserListController
    Route::get('/dashboard/userlist/index', [UserListController::class, 'index'])->name('dashboard.admin.userlist');
    Route::get('/dashboard/userlist/filterUserList/{filter}', [UserListController::class, 'filterUserList']); 
    Route::post("/dashboard/userlist/searchUser", [UserListController::class, 'searchUser']);
    Route::get('/dashboard/userlist/unbanuser/{accountID}', [UserListController::class, 'unbanuser']); 
    Route::get('/dashboard/userlist/banuser', [UserListController::class, 'banuser']); 

    //MailController
    Route::get('/mail/sentUnbanMail/{accountID}', [MailController::class, 'sentUnbanMail']);
    Route::get('/mail/sentBanMail/{accountID}/{reason}/{duration}', [MailController::class, 'sentBanMail']);


    Route::middleware('account.master')->group(function () {
    
        Route::get('/dashboard/register_admin', function() {
            return view('dashboard/admin/dashboard_register', [
                'page' => 'Register Admin',
                'header' => 'Register Admin'
            ]);
        })->name('dashboard.admin.register_admin');

        Route::post('/dashboard/register_admin/register', [
            AccountController::class, 'register'
        ])->name('dashboard.admin.register_admin.register');

    });
});