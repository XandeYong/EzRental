<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    //
    public $name = 'Notification';

    public function index(Request $request)
    {
        $account = $request->session()->get('account');
        $id = $account->account_id;
        $user = $account->role;

        //get notifiaction lists from database 
        $notificationLists = DB::table('notifications')
            ->orderBy('created_at', 'desc')
            ->where('account_id', $id)
            ->get();


        if (!$notificationLists->isEmpty()) {
            //update all notification status to read
            foreach ($notificationLists as $notificationList) {
                $updated = DB::table('notifications')
                    ->where('notification_id', $notificationList->notification_id)
                    ->where('status', 'unread')
                    ->update(['status' => "read"]);
            }
        }



        return view('/dashboard/dashboard_notification', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Notification',
            'notificationLists' => $notificationLists
        ]);
    }
}
