<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\GroupChatController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NegotiationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomRentalPostController;
use App\Http\Controllers\RoomRentalPostListController;
use App\Models\Chat;
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
    return view('rentalpost_list');
})->name('rental_post_list');


route::middleware('account.no')->group(function () {

    //--------
    // Login
    //--------

    Route::get('/login_portal', function () {
        return view('/login/login_portal');
    })->name('login.portal');

    Route::post('/login_portal/login/account_login', [
        AccountController::class, 'login'
    ])->name('login.portal.login');

    Route::post('/login_portal/register/account_register', [
        AccountController::class, 'register'
    ])->name('login.portal.register');


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

    
    //-----------------
    // Reset Password
    //-----------------

    Route::post('/login_portal/login/forget_password', [
        AccountController::class, 'sendPasswordResetLink'
    ])->name('login.portal.forget_password');


    // Mail
    Route::get('/mail/reset_password/{accountID}', [
        MailController::class, 'sendResetPassword'
    ])->name('mail.reset_password');

});


Route::get('/reset_password/{email}/{key}', [
    AccountController::class, 'resetPasswordForm'
])->name('reset_password.form');

Route::post('/reset_password/{email}/{key}/reset', [
    AccountController::class, 'resetPassword'
])->name('reset_password.form.reset');



route::middleware(['account', 'account.has'])->group(function () {

    // Chat
    Route::get('/chat', [
        ChatController::class, 'index'
    ])->name('chat');

        // Chat Message
        Route::get('/chat/message/{id?}', [
            ChatController::class, 'getMessage'
        ])->name('chat.user');

        Route::post('/chat/message/send', [
            ChatController::class, 'sendMessage'
        ])->name('chat.user.send');


        // Group Chat Message
        Route::get('/chat/message/group/{id?}', [
            GroupChatController::class, 'getMessage'
        ])->name('chat.group');

        Route::post('/chat/message/group/create', [
            GroupChatController::class, 'createGroup'
        ])->name('chat.group.create');

        Route::post('/chat/message/group/send', [
            GroupChatController::class, 'sendMessage'
        ])->name('chat.group.send');

        Route::post('/chat/message/group/delete', [
            GroupChatController::class, 'deleteGroup'
        ])->name('chat.group.delete');

        Route::post('/chat/message/group/leave', [
            GroupChatController::class, 'leaveGroup'
        ])->name('chat.group.leave');


        //Negotiation
        Route::post('/chat/negotiation/accept', [
            NegotiationController::class, 'acceptNegotiation'
        ])->name('chat.negotiation.accept');

        Route::get('/chat/negotiation/reject/{id?}', [
            NegotiationController::class, 'rejectNegotiation'
        ])->name('chat.negotiation.reject');

        Route::post('/chat/negotiation/further_negotiation', [
            NegotiationController::class, 'furtherNegotiation'
        ])->name('chat.negotiation.further_negotiation');


            // Group Chat User
            Route::post('/chat/message/group/user/add/{id?}', [
                GroupChatController::class, 'addUser'
            ])->name('chat.group.user.add');
    
            Route::post('/chat/message/group/user/remove/{id?}', [
                GroupChatController::class, 'removeUser'
            ])->name('chat.group.user.remove');
    
            Route::post('/chat/message/group/user/promote/{id?}', [
                GroupChatController::class, 'promoteUser'
            ])->name('chat.group.user.promote');
            
            Route::post('/chat/message/group/user/demote/{id?}', [
                GroupChatController::class, 'demoteUser'
            ])->name('chat.group.user.demote');
            
            Route::post('/chat/message/group/user/transfer/{id?}', [
                GroupChatController::class, 'transferOwnership'
            ])->name('chat.group.user.transfer');

            Route::get('/chat/message/group/userlist/{id?}', [
                GroupChatController::class, 'displayGroupUser'
            ])->name('chat.group.user.list');


    

    Route::get('/dashboard', function () {
        $role = session()->get('account')['role'];

        switch ($role) {
            case 'A':
                return redirect(route('dashboard.admin'));
            case 'O':
                return redirect(route('dashboard.owner'));
            case 'T':
                return redirect(route('dashboard.tenant'));
            case 'MA':
                return redirect(route('dashboard.admin'));
            default:
                session()->put('access_message', 'Unknowned Error Occur, Please contact Admin to solve the issue.');
                return redirect('/');
        }
    })->name('dashboard');


    //----------
    // Logout
    //----------

    Route::get('/logout', function () {
        if (session()->has('account')) {
            DB::table('accounts')
                ->where('account_id', session()->get('account')['account_id'])
                ->update(['status' => "offline"]);

            session()->forget('account');
            session()->forget('access_message');
            session()->forget('access_message_status');
        }
        return redirect(route("home"));
    })->name('logout');


    //Controller
    //ProfileController
    Route::get('/dashboard/profile/index', [ProfileController::class, 'index'])->name('dashboard.profile');
    Route::post("/dashboard/profile/changePassword", [ProfileController::class, 'changePassword']);
    Route::get("/dashboard/profile/editProfileIndex", [ProfileController::class, 'editProfileIndex'])->name('dashboard.profile.edit');
    Route::post("/dashboard/profile/updateProfileInDatabase", [ProfileController::class, 'updateProfileInDatabase']);


    //NotificationConroller
    Route::get('/dashboard/notification/index', [NotificationController::class, 'index'])->name('dashboard.notification');


    route::middleware('account.tenant')->group(function () {

        //Room Rental Post (tenant only)
        Route::post('/rental_post_list/rental_post/create_visit_appointment', [
            RoomRentalPostController::class, 'createVisitAppointment'
        ])->name('rental_post_list.rental_post.create_visit_appointment');
        
        
        Route::post('/rental_post_list/rental_post/create_negotiation', [
            RoomRentalPostController::class, 'createNegotiation'
        ])->name('rental_post_list.rental_post.create_negotiation');
        
        
        Route::post('/rental_post_list/rental_post/create_rent_request', [
            RoomRentalPostController::class, 'createRentRequest'
        ])->name('rental_post_list.rental_post.create_rent_request');
        
        
        Route::post('/rental_post_list/rental_post/create_comment', [
            RoomRentalPostController::class, 'createComment'
        ])->name('rental_post_list.rental_post.create_comment');
        
        
        Route::post('/rental_post_list/rental_post/update_comment', [
            RoomRentalPostController::class, 'updateComment'
        ])->name('rental_post_list.rental_post.update_comment');
        
    });

    route::middleware('account.tenant.admin')->group(function () {

        // Admin & Tenant
        Route::get('/rental_post_list/rental_post/delete_comment/{comment_id}', [
            RoomRentalPostController::class, 'deleteComment'
        ])->name('rental_post_list.rental_post.delete_comment');

    });

    route::middleware('account.tenant.owner')->group(function () {

        // Owner & Tenant
        Route::get('/renting/contract/renew_contract/{rentingID}', [
            ContractController::class, 'renewContract'
        ])->name('renting.contract.renew_contract');

    });


});


//Room Rental Post List
Route::get('/rental_post_list', [
    RoomRentalPostListController::class, 'index'
])->name('rental_post_list');

Route::post("/rental_post_list/search", [RoomRentalPostListController::class, 'searchRentalPost']);
Route::get('/rental_post_list/recommend', [RoomRentalPostListController::class, 'autoSearchMatchRecommendation'])->name('rental_post_list.recommend');
Route::get('/rental_post_list/sort/{sort}', [RoomRentalPostListController::class, 'sortRentalPost'])->name('rental_post_list.sort');
Route::post('/rental_post_list/filter', [RoomRentalPostListController::class, 'filterRentalPost']);


//Room Rental Post (public)
Route::get('/rental_post_list/rental_post/{post_id}', [
    RoomRentalPostController::class, 'index'
])->name('rental_post_list.rental_post');