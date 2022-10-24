<?php

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
    return view('/login/tenant/register_tenant');
})->name('register.tenant');


// Owner

Route::get('/login_portal/login/owner', function () {
    return view('/login/login', [
        'user' => 'Owner'
    ]);
})->name('login.owner');

Route::get('/login_portal/register/owner', function () {
    return view('/login/owner/register_owner');
})->name('register.owner');


// Admin

Route::get('/login_portal/login/admin', function () {
    return view('/login/login', [
        'user' => 'Admin'
    ]);
})->name('login.admin');

Route::get('/login_portal/register/admin', function () {
    return view('/login/admin/register_admin');
})->name('register.admin');



