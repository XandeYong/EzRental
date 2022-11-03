<?php

use App\Http\Controllers\AccountController;
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

Route::get('/dashboard', function () {
    $role = session()->get('account')['role'];
    switch ($role) {
        case 'A':
            return redirect(route('dashboard.admin'));
        case 'O':
            return redirect(route('dashboard.owner'));
        case 'T':
            return redirect(route('dashboard.tenant'));
        default:
            return redirect('/');
    }
})->name('dashboard');

//--------
// Login
//--------

Route::get('/login_portal', function () {
    if (session()->get('account')) { return redirect('/'); }

    return view('/login/login_portal');
})->name('login.portal');

Route::post('/login_portal/login/account_login', [AccountController::class, 'login'])->name('login.portal.login');


// Tenant

Route::get('/login_portal/login/tenant', function () {
    if (session()->get('account')) { return redirect('/'); }

    return view('/login/login', [
        'user' => 'Tenant'
    ]);
})->name('login.tenant');

Route::get('/login_portal/register/tenant', function () {
    if (session()->get('account')) { return redirect('/'); }

    return view('/login/register', [
        'user' => 'Tenant'
    ]);
})->name('register.tenant');


// Owner

Route::get('/login_portal/login/owner', function () {
    if (session()->get('account')) { return redirect('/'); }

    return view('/login/login', [
        'user' => 'Owner'
    ]);
})->name('login.owner');

Route::get('/login_portal/register/owner', function () {
    if (session()->get('account')) { return redirect('/'); }

    return view('/login/register', [
        'user' => 'Owner'
    ]);
})->name('register.owner');


// Admin

Route::get('/login_portal/login/admin', function () {
    if (session()->get('account')) { return redirect('/'); }

    return view('/login/login', [
        'user' => 'Admin'
    ]);
})->name('login.admin');


//----------
// Logout
//----------


Route::get('/logout', function () {
    session()->forget('account');
    return redirect(route("home"));
})->name('logout');


//Controller
//ProfileController
Route::get('/dashboard/profile/index', [ProfileController::class, 'index'])->name('dashboard.profile');
Route::post("/dashboard/profile/changePassword", [ProfileController::class, 'changePassword']);
Route::get('/dashboard/profile/errMsgDisChgPass/{newPassError?}/{oldPassError?}', [ProfileController::class, 'errMsgDisChgPass']);

Route::get("/dashboard/profile/edit", [ProfileController::class, 'editProfile'])->name('dashboard.profile.edit');





