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

Route::get('/test/reset_password', function () {
    $email = 'gadala3838@rubeshi.com';
    $key = 'P9cIYd8LstiP1pKu8gVMEtOACor2QgOccLHGONukQ1pRMwPsUp3OWQaQO0r9ItqWeYGYtjDgGjz8wjO4JO7WJDihWiJQUH9KKLZ0PV6AeYVVdpDn6hmjUYVU3fxUhDYhJFHIUxuWxgoK07cpkGqhAAyahNvx1IMfoyCMjsnBOiN72tTaJomYdZAZsQ2M9k8zw1LDkYdQoSUPE1P9tJmWdvo8QyhelErpswHiAQrU5XorPJp0EaXRsD3nPI8jB4V';
    
    session()->put('reset_password_key', $key);

    $return = [
        'email' => $email
    ];
    return view('/login/reset_password', $return);
});



//==========================================================================================================
// Custom function
//=============================================================================================

$GLOBALS['unauthorized_access_message'] = "You have been redirect to homepage as unauthorized access has been detected!";
if (session()->has('account')) {
    $GLOBALS['logged_in_access_message'] = "You have already logged in as " . session()->get('account')['name'];
}

// function validateAccount($condition = "") {

//     switch ($condition) {
//         case 'hasAccount':
//             # code...
//             break;
        
//         default:
//             # code...
//             break;
//     }

// }

function isLogin() {
    global $unauthorized_access_message;
    $valid = true;
    
    if (!session()->has('account')) {
        session()->put('access_message', $unauthorized_access_message);
        $valid = false;
    }

    return [
        'valid' => $valid
    ];
}

function isNotLogin() {
    global $logged_in_access_message;
    
    if (session()->has('account')) {
        session()->put('access_message', $logged_in_access_message);
        return redirect('/'); 
    }
}

function isTenant() {
    global $unauthorized_access_message;

    if (!session()->has('account') 
    || session()->get('account')['role'] != 'T'
    ) { 
        session()->put('access_message', $unauthorized_access_message);
        return redirect('/'); 
    }
}

function isOwner() {
    global $unauthorized_access_message;

    if (!session()->has('account') 
    || session()->get('account')['role'] != 'O'
    ) { 
        session()->put('access_message', $unauthorized_access_message);
        return redirect('/'); 
    }
}

function isAdmin() {
    global $unauthorized_access_message;

    if (!session()->has('account') 
    || (session()->get('account')['role'] != 'A' 
    && session()->get('account')['role'] != 'MA')
    ) { 
        session()->put('access_message', $unauthorized_access_message);
        return redirect('/'); 
    }
}

function isMasterAdmin() {
    global $unauthorized_access_message;

    if (session()->has('account') 
    && session()->get('account')['role'] == 'MA'
    ) { 
        session()->put('access_message', $unauthorized_access_message);
        return redirect('/'); 
    }
}