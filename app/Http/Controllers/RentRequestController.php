<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class RentRequestController extends Controller
{
    //
    public $name = 'Rent Request';

    public function index(Request $request)
    {
        $account = $request->session()->get('account');
        $id = $account->account_id;
        $user = $account->role;

        if ($user == "T") {
            //get rent request lists from database for tenant
            $rentRequestLists = DB::table('rent_requests')
                ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'rent_requests.post_id')
                ->orderBy('rent_requests.created_at', 'desc')
                ->where('rent_requests.account_id', $id)
                ->select('rent_requests.rent_request_id', 'rent_requests.status', 'rent_requests.created_at', 'room_rental_posts.title')
                ->get();
        } else {
            //get rent request lists from database for owner
            $rentRequestLists = DB::table('rent_requests')
                ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'rent_requests.post_id')
                ->orderBy('rent_requests.created_at', 'desc')
                ->where('room_rental_posts.account_id', $id)
                ->select('rent_requests.rent_request_id', 'rent_requests.status', 'rent_requests.created_at', 'room_rental_posts.title')
                ->get();
        }


        return view('dashboard/tenant/dashboard_rentrequest_list', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Rent Request List',
            'rentRequestLists' => $rentRequestLists
        ]);
    }

    public function getRentRequestDetails(Request $request, $rentRequestID)
    {
        //Decrypt the parameter
        try {
            $rentRequestID = Crypt::decrypt($rentRequestID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }
        $account = $request->session()->get('account');
        $user = $account->role;

        //get rent request details from database 
        $rentRequestDetails = DB::table('rent_requests')
            ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'rent_requests.post_id')
            ->where('rent_requests.rent_request_id', $rentRequestID)
            ->select('rent_requests.rent_request_id', 'rent_requests.post_id', 'rent_requests.price', 'rent_requests.rent_date_start', 'rent_requests.rent_date_end', 'rent_requests.status', 'rent_requests.created_at', 'room_rental_posts.title')
            ->get();

        $contract = DB::table('contracts')
            ->where('post_id', $rentRequestDetails[0]->post_id)
            ->where('status', 'inactive')
            ->get();


        //Display rentRequestDetails
        return view('dashboard/tenant/dashboard_rentrequestdetails', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Rent Request Details',
            'back' => '/dashboard/rentrequest/index',
            'rentRequestDetails' => $rentRequestDetails,
            'contract' => $contract
        ]);
    }


    public function approveRentRequest(Request $request, $rentRequestID)
    {
        //Decrypt the parameter
        try {
            $rentRequestID = Crypt::decrypt($rentRequestID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        //update rent_requests status in database 
        $updated = DB::table('rent_requests')
            ->where('rent_request_id', $rentRequestID)
            ->update(['status' => "approved"]);

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

        //need sent notification to tenant
        //get tenant details from database 
        $rentRequest = DB::table('rent_requests')
            ->where('rent_request_id', $rentRequestID)
            ->select('account_id')
            ->get();

        //add notification to database
        $addNotification = DB::table('notifications')->insert([
            'notification_id' => $newNotificationID,
            'title' => "Renting Request Approved",
            'message' => "Renting request for <b>" . $roomRentalPost[0]->title . "</b> had been approved.",
            'type' => "renting_request",
            'status' => "unread",
            'account_id' => $rentRequest[0]->account_id
        ]);


        if ($addNotification > 0) {
            $request->session()->put('successMessage', 'Rent request approved.');
        } else {
            $request->session()->put('failMessage', 'Rent request fail to approved.');
        }

        return redirect(URL('/dashboard/rentrequest/getRentRequestDetails/' . Crypt::encrypt($rentRequestID)));
    }

    public function rejectRentRequest(Request $request, $rentRequestID)
    {
        //Decrypt the parameter
        try {
            $rentRequestID = Crypt::decrypt($rentRequestID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        //update rent_requests status in database 
        $updated = DB::table('rent_requests')
            ->where('rent_request_id', $rentRequestID)
            ->update(['status' => "rejected"]);

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

        //need sent notification to tenant
        //get tenant details from database 
        $rentRequest = DB::table('rent_requests')
            ->where('rent_request_id', $rentRequestID)
            ->select('account_id')
            ->get();

        //add notification to database
        $addNotification = DB::table('notifications')->insert([
            'notification_id' => $newNotificationID,
            'title' => "Renting Request Rejected",
            'message' => "Renting request for <b>" . $roomRentalPost[0]->title . "</b> had been rejected.",
            'type' => "renting_request",
            'status' => "unread",
            'account_id' => $rentRequest[0]->account_id
        ]);


        if ($addNotification > 0) {
            $request->session()->put('successMessage', 'Rent request rejected.');
        } else {
            $request->session()->put('failMessage', 'Rent request fail to rejected.');
        }

        return redirect(URL('/dashboard/rentrequest/getRentRequestDetails/' . Crypt::encrypt($rentRequestID)));
    }

    public function cancelRentRequest(Request $request, $rentRequestID)
    {
        //Decrypt the parameter
        try {
            $rentRequestID = Crypt::decrypt($rentRequestID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        $account = $request->session()->get('account');
        $user = $account->role;

        //update rent_requests status in database 
        $updated = DB::table('rent_requests')
            ->where('rent_request_id', $rentRequestID)
            ->update(['status' => "canceled"]);

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

        if ($user == "T") {
            //need sent notification to owner
            //add notification to database
            $addNotification = DB::table('notifications')->insert([
                'notification_id' => $newNotificationID,
                'title' => "Renting Request Canceled",
                'message' => "Renting request for <b>" . $roomRentalPost[0]->title . "</b> had been canceled.",
                'type' => "renting_request",
                'status' => "unread",
                'account_id' => $roomRentalPost[0]->account_id
            ]);
        } else {
            //need sent notification to tenant
            //get tenant details from database 
            $rentRequest = DB::table('rent_requests')
                ->where('rent_request_id', $rentRequestID)
                ->select('account_id')
                ->get();

            //add notification to database
            $addNotification = DB::table('notifications')->insert([
                'notification_id' => $newNotificationID,
                'title' => "Renting Request Canceled",
                'message' => "Renting request for <b>" . $roomRentalPost[0]->title . "</b> had been canceled.",
                'type' => "renting_request",
                'status' => "unread",
                'account_id' => $rentRequest[0]->account_id
            ]);
        }

        if ($addNotification > 0) {
            $request->session()->put('successMessage', 'Rent request canceled.');
        } else {
            $request->session()->put('failMessage', 'Rent request fail to canceled.');
        }

        return redirect(URL('/dashboard/rentrequest/getRentRequestDetails/' . Crypt::encrypt($rentRequestID)));
    }

    public function confirmRentRequest(Request $request, $rentRequestID)
    {
        //Decrypt the parameter
        try {
            $rentRequestID = Crypt::decrypt($rentRequestID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        //update rent_requests status in database 
        $updated = DB::table('rent_requests')
            ->where('rent_request_id', $rentRequestID)
            ->update(['status' => "success"]);

        //get details from database 
        $roomRentalPost = DB::table('rent_requests')
            ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'rent_requests.post_id')
            ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
            ->where('rent_requests.rent_request_id', $rentRequestID)
            ->select('rent_requests.account_id', 'rent_requests.price', 'room_rental_posts.post_id', 'room_rental_posts.title', 'contracts.contract_id')
            ->get();


        //Create new renting record in database
        //getLatestRentingID
        $latestRentingID = $this->getLatestRentingID();

        //make new RentingID
        $newRentingID = $this->rentingID($latestRentingID);

        //Insert rentings in to database
        DB::table('rentings')->insert([
            'renting_id' => $newRentingID,
            'account_id' => $roomRentalPost[0]->account_id,
            'post_id' => $roomRentalPost[0]->post_id,
            'contract_id' => $roomRentalPost[0]->contract_id,
            'status' => "active"
        ]);

        //create new payment deposit in database
        //getLatestPaymentID
        $latestPaymentID = $this->getLatestPaymentID();

        //make new PaymentID
        $newPaymentID = $this->paymentID($latestPaymentID);

        //Insert maintenance request in to database
        DB::table('payments')->insert([
            'payment_id' => $newPaymentID,
            'payment_type' => 'Deposit',
            'amount' => $roomRentalPost[0]->price,
            'status' => "unpaid",
            'renting_id' => $newRentingID
        ]);

        //getLatestNotificationID
        $latestNotificationID = $this->getLatestNotificationID();

        //make new NotificationID
        $newNotificationID = $this->notificationID($latestNotificationID);


        //need sent notification to tenant
        //add notification to database
        $addNotification = DB::table('notifications')->insert([
            'notification_id' => $newNotificationID,
            'title' => "Renting Request Success",
            'message' => "Renting request for <b>" . $roomRentalPost[0]->title . "</b> had been success.",
            'type' => "renting_request",
            'status' => "unread",
            'account_id' => $roomRentalPost[0]->account_id
        ]);


        if ($addNotification > 0) {
            $request->session()->put('successMessage', 'Rent request success.');
        } else {
            $request->session()->put('failMessage', 'Rent request fail to success.');
        }

        return redirect(URL('/dashboard/rentrequest/getRentRequestDetails/' . Crypt::encrypt($rentRequestID)));
    }

    public function getLatestRentingID()
    {
        $rentingID = DB::table('rentings')
            ->select('renting_id')
            ->whereRaw("CHAR_LENGTH(renting_id) = (SELECT MAX(CHAR_LENGTH(renting_id)) from rentings)")
            ->orderByDesc('renting_id')
            ->distinct()
            ->select('renting_id')
            ->get();

        if ($rentingID->isEmpty()) {
            return "R0";
        }
        return $rentingID[0]->renting_id;
    }

    //add 1 to ID to make new ID 
    private function rentingID($value)
    {
        $result = substr($value, 1);

        //parse result to int
        $ans = ((int)$result) + 1;

        //combine char and int into string
        $result = "R" . ((string)$ans);

        return $result;
    }

    public function getLatestPaymentID()
    {
        $paymentID = DB::table('payments')
            ->select('payment_id')
            ->whereRaw("CHAR_LENGTH(payment_id) = (SELECT MAX(CHAR_LENGTH(payment_id)) from payments)")
            ->orderByDesc('payment_id')
            ->distinct()
            ->select('payment_id')
            ->get();

        if ($paymentID->isEmpty()) {
            return "P0";
        }
        return $paymentID[0]->payment_id;
    }

    //add 1 to ID to make new ID 
    private function paymentID($value)
    {
        $result = substr($value, 1);

        //parse result to int
        $ans = ((int)$result) + 1;

        //combine char and int into string
        $result = "P" . ((string)$ans);

        return $result;
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
