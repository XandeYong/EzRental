<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ContractController extends Controller
{
    //
    public $name = 'Renting Record';

    public function index(Request $request, $rentingID)
    {
        //Decrypt the parameter
        try {
            $rentingID = Crypt::decrypt($rentingID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }


        $account = $request->session()->get('account');
        $user = $account->role;

        //get contract details from database 
        $contractDetails = DB::table('contracts')
            ->join('rentings', 'rentings.contract_id', '=', 'contracts.contract_id')
            ->where('rentings.renting_id', $rentingID)
            ->select('contracts.*')
            ->get();

        return view('dashboard/tenant/dashboard_contract', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Contract',
            'back' => "/dashboard/rentingrecord/getrecordDetails/" . Crypt::encrypt($rentingID),
            'contractDetails' => $contractDetails
        ]);
    }

    public function tenantSignContract(Request $request)
    {
        //Laravel validation
        $request->validate([
            'sign' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
            // 'sign' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
        ]);

        $account = $request->session()->get('account');
        $user = $account->role;

        //get from View  
        $imageName = $request->input('sign');
        $contractID = $request->input('contractID');
        $rentRequestID = $request->input('rentRequestID');


        $image = $request->file('sign');
        $imageName = $contractID . "_" . $user . "_sign." . $image->getClientOriginalExtension();
        $request->file('sign')->move(public_path() . '/image/contract/', $imageName);

        //update tenant signature in database
        $updated = DB::table('contracts')
            ->where('contract_id', $contractID)
            ->update(['tenant_signature' => $imageName]);

        //update rent request status in database
        $updated = DB::table('rent_requests')
            ->where('rent_request_id', $rentRequestID)
            ->update(['status' => 'signed']);



        //getLatestNotificationID
        $latestNotificationID = $this->getLatestNotificationID();

        //make new NotificationID
        $newNotificationID = $this->notificationID($latestNotificationID);

        //get room rental post details from database 
        $roomRentalPost = DB::table('room_rental_posts')
            ->join('rent_requests', 'rent_requests.post_id', '=', 'room_rental_posts.post_id')
            ->where('rent_requests.rent_request_id', $rentRequestID)
            ->select('room_rental_posts.account_id', 'room_rental_posts.title')
            ->get();

        if ($updated > 0) {
            $request->session()->put('successMessage', 'Rent request sign success.');
            //need sent notification to owner
            //add notification to database
            $addNotification = DB::table('notifications')->insert([
                'notification_id' => $newNotificationID,
                'title' => "Renting Request Signed",
                'message' => "Renting request for <b>" . $roomRentalPost[0]->title . "</b> had been signed.",
                'type' => "renting_request",
                'status' => "unread",
                'account_id' => $roomRentalPost[0]->account_id
            ]);
        } else {
            $request->session()->put('failMessage', 'Rent request sign fail.');
        }

        return redirect(URL('/dashboard/rentrequest/getRentRequestDetails/' . Crypt::encrypt($rentRequestID)));
    }


    public function getLatestNotificationID()
    {
        $notificationID = DB::table('notifications')
            ->select('notification_id')
            ->whereRaw("CHAR_LENGTH(notification_id) = (SELECT MAX(CHAR_LENGTH(notification_id)) from notifications)")
            ->orderByDesc('notification_id')
            ->distinct()
            ->select('notification_id')
            ->get();

        if ($notificationID->isEmpty()) {
            return "NTF0";
        }
        return $notificationID[0]->notification_id;
    }

    //add 1 to ID to make new ID 
    private function notificationID($value)
    {
        $result = substr($value, 3);

        //parse result to int
        $ans = ((int)$result) + 1;

        //combine char and int into string
        $result = "NTF" . ((string)$ans);

        return $result;
    }
}
