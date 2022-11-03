<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Public
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

Route::get('/', function () {
    return redirect(route("home"));
});

Route::get('/home', function () {
    return view('index');
})->name('home');

Route::get('/rental_post_list', function () {
    return view('rental_post_list');
})->name('rental_post_list');

Route::get('/chat', function () {
    return view('chat');
})->name('chat');

//--------
// Login
//--------

Route::get('/login_portal', function () {
    return view('/login/login_portal');
})->name('login.portal');


// Tenant

Route::get('/login_portal/login/tenant', function () {
    return view('/login/login', [
        'user' => 'Tenant'
    ]);
})->name('login.tenant');

Route::get('/login_portal/register/tenant', function () {
    return view('/login/register', [
        'user' => 'Tenant'
    ]);
})->name('register.tenant');


// Owner

Route::get('/login_portal/login/owner', function () {
    return view('/login/login', [
        'user' => 'Owner'
    ]);
})->name('login.owner');

Route::get('/login_portal/register/owner', function () {
    return view('/login/register', [
        'user' => 'Owner'
    ]);
})->name('register.owner');


// Admin

Route::get('/login_portal/login/admin', function () {
    return view('/login/login', [
        'user' => 'Admin'
    ]);
})->name('login.admin');

Route::get('/login_portal/register/admin', function () {
    return view('/login/register', [
        'user' => 'Admin'
    ]);
})->name('register.admin');


//----------
// Logout
//----------


Route::get('/logout', function () {
    //function to logout
    return redirect(route("home"));
})->name('logout');


//Controller
//ProfileController
Route::get('/dashboard/profile/index', [ProfileController::class, 'index'])->name('dashboard.profile');
Route::post("/dashboard/profile/changePassword", [accountController::class, 'changePassword']);




