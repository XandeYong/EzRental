<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\DB;
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
    $validation = isLogin();

    if ($validation['valid'] == true) {
        $role = session()->get('account')['role'];
        switch ($role) {
            case 'A':
                return redirect(route('dashboard.admin'));
            case 'O':
                return redirect(route('dashboard.owner'));
            case 'T':
                return redirect(route('dashboard.tenant'));
            default:
                session()->put('access_message', 'Unknowned Error Occur, Please contact Admin to solve the issue.');
                return redirect('/');
        }
    } else {
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
    isTenant();

    return view('/login/login', [
        'user' => 'Tenant'
    ]);
})->name('login.tenant');

Route::get('/login_portal/register/tenant', function () {
    isTenant();

    return view('/login/register', [
        'user' => 'Tenant'
    ]);
})->name('register.tenant');


// Owner

Route::get('/login_portal/login/owner', function () {
    isOwner();

    return view('/login/login', [
        'user' => 'Owner'
    ]);
})->name('login.owner');

Route::get('/login_portal/register/owner', function () {
    isOwner();

    return view('/login/register', [
        'user' => 'Owner'
    ]);
})->name('register.owner');


// Admin

Route::get('/login_portal/login/admin', function () {
    isAdmin();

    return view('/login/login', [
        'user' => 'Admin'
    ]);
})->name('login.admin');


//----------
// Logout
//----------


Route::get('/logout', function () {
    DB::table('accounts')
        ->where('account_id', session()->get('account')['account_id'])
        ->update(['status' => "offline"]);

    session()->forget('account');
    return redirect(route("home"));
})->name('logout');


//Controller
//ProfileController
Route::get('/dashboard/profile/index', [ProfileController::class, 'index'])->name('dashboard.profile');
Route::post("/dashboard/profile/changePassword", [ProfileController::class, 'changePassword']);
// Route::get('/dashboard/profile/errMsgDisChgPass/{newPassError?}', [ProfileController::class, 'errMsgDisChgPass']); //be reference

Route::get("/dashboard/profile/editProfileIndex", [ProfileController::class, 'editProfileIndex'])->name('dashboard.profile.edit');
Route::post("/dashboard/profile/validateEditProfileDetails", [ProfileController::class, 'validateEditProfileDetails']);




