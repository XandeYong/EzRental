<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class PaymentController extends Controller
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

        //Remove payment id array from session
        if (session()->has('payments')) {
            session()->forget('payments');
        }

        //get paid payment from database 
        $paidPayments = DB::table('payments')
            ->join('rentings', 'rentings.renting_id', '=', 'payments.renting_id')
            ->orderBy('payments.created_at', 'desc')
            ->where('rentings.renting_id', $rentingID)
            ->select('payments.payment_id', 'payments.payment_type', 'payments.created_at', 'payments.paid_date', 'payments.status')
            ->get();

        if (!$paidPayments->isEmpty()) {
            $paidPaymentsName = array();

            //get unpaid payment name
            foreach ($paidPayments as $paidPayment) {

                if($paidPayment->payment_type=="Deposit"){
                    $paidPaymentName = $paidPayment->payment_type . " " . "Payment";
                }else{
                    $date = strtotime($paidPayment->created_at);
                    $paidPaymentName = date('M', $date) . " " . date('Y', $date) . " " . $paidPayment->payment_type . " " . "Payment";
                }

                array_push($paidPaymentsName, $paidPaymentName);
            }
        } else {
            $paidPaymentsName = null;
        }


        return view('dashboard/tenant/dashboard_payment_history', [
            'page' => $this->name,
            'header' => 'Payment History',
            'back' => "/dashboard/rentingrecord/getrecordDetails/" . Crypt::encrypt($rentingID),
            'paidPayments' => $paidPayments,
            'paidPaymentsName' => $paidPaymentsName
        ]);
    }

    public function indexForOwner(Request $request, $postID)
    {
        //Decrypt the parameter
        try {
            $postID = Crypt::decrypt($postID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        //Remove payment id array from session
        if (session()->has('payments')) {
            session()->forget('payments');
        }

        //get paid payment from database 
        $paidPayments = DB::table('payments')
            ->join('rentings', 'rentings.renting_id', '=', 'payments.renting_id')
            ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'rentings.post_id')
            ->orderBy('payments.created_at', 'desc')
            ->where('room_rental_posts.post_id', $postID)
            ->select('payments.payment_id', 'payments.payment_type', 'payments.created_at', 'payments.paid_date', 'payments.status', 'payments.renting_id')
            ->get();


        if (!$paidPayments->isEmpty()) {
            $paidPaymentsName = array();

            //get unpaid payment name
            foreach ($paidPayments as $paidPayment) {

                if($paidPayment->payment_type=="Deposit"){
                    $paidPaymentName = $paidPayment->payment_type . " " . "Payment";
                }else{
                    $date = strtotime($paidPayment->created_at);
                    $paidPaymentName = date('M', $date) . " " . date('Y', $date) . " " . $paidPayment->payment_type . " " . "Payment";
                }

                array_push($paidPaymentsName, $paidPaymentName);
            }
        } else {
            $paidPaymentsName = null;
        }


        return view('dashboard/tenant/dashboard_payment_history', [
            'page' => 'Room Rental Post',
            'header' => 'Payment History',
            'back' => "/dashboard/room_rental_post_list/" . Crypt::encrypt($postID),
            'paidPayments' => $paidPayments,
            'paidPaymentsName' => $paidPaymentsName
        ]);
    }


    public function getPaymentDetails(Request $request, $paymentID)
    {
        //Decrypt the parameter
        try {
            $paymentID = Crypt::decrypt($paymentID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }
        $account = $request->session()->get('account');
        $user = $account->role;

        //get payment details from database 
        $paymentDetails = DB::table('payments')
            ->join('rentings', 'rentings.renting_id', '=', 'payments.renting_id')
            ->where('payments.payment_id', $paymentID)
            ->select('payments.*', 'rentings.post_id')
            ->get();


        $paymentDetailsName = array();
        //get payment name

        if($paymentDetails[0]->payment_type=="Deposit"){
            $paymentDetailName = $paymentDetails[0]->payment_type . " " . "Payment";
        }else{
            $date = strtotime($paymentDetails[0]->created_at);
            $paymentDetailName = date('M', $date) . " " . date('Y', $date) . " " . $paymentDetails[0]->payment_type . " " . "Payment";
        }
        array_push($paymentDetailsName, $paymentDetailName);


        if ($user == "T") {
        //Display paymentDetails for tenant
        return view('dashboard/tenant/dashboard_paymentdetails', [
            'page' => $this->name,
            'header' => 'Payment Details',
            'back' => "/dashboard/payment/index/" . Crypt::encrypt($paymentDetails[0]->renting_id),
            'paymentDetails' => $paymentDetails,
            'paymentDetailsName' => $paymentDetailsName
        ]);
        } else {

        //Display paymentDetails for owner
        return view('dashboard/tenant/dashboard_paymentdetails', [
            'page' => 'Room Rental Post',
            'header' => 'Payment Details',
            'back' => "/dashboard/rentalpost/payment/indexForOwner/" . Crypt::encrypt($paymentDetails[0]->post_id),
            'paymentDetails' => $paymentDetails,
            'paymentDetailsName' => $paymentDetailsName
        ]);

        }

    }


    public function makePayment(Request $request)
    {
        //Get checkbox array from post
        $payments = $_POST["payment"];
        $payAmount = 0;


        for ($i = 0; $i < count($payments); $i++) {
            //get unpaid payment amount from database 
            $unpaidPaymentsAmount = DB::table('payments')
                ->where('payment_id', $payments[$i])
                ->select('amount', 'renting_id')
                ->get();

            $payAmount += $unpaidPaymentsAmount[0]->amount;
        }

        //Remove payment array from session
        if (session()->has('payments')) {
            session()->forget('payments');
        }
        //Put payment id array session
        $request->session()->put('payments', $payments);

        //link to paypal
        return view('paypal/paypalpage', [
            'payAmount' => $payAmount,
            'renting_id' => $unpaidPaymentsAmount[0]->renting_id
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $account = $request->session()->get('account');

        //Get payment id array from session
        if (session()->has('payments')) {
            $payments = $request->session()->get('payments');
        }

        $paymentDetails = array();
        $paymentDetailsName = array();

        for ($i = 0; $i < count($payments); $i++) {

            //update payments details in database 
            $updated = DB::table('payments')
                ->where('payment_id', $payments[$i])
                ->update(['payment_method' => 'PayPal', 'status' => 'paid', 'paid_date' => date("Y-m-d")]);

            //get unpaid payment from database 
            $paymentDetail = DB::table('payments')
                ->join('rentings', 'rentings.renting_id', '=', 'payments.renting_id')
                ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'rentings.post_id')
                ->where('payments.payment_id', $payments[$i])
                ->select('payments.*', 'room_rental_posts.account_id', 'room_rental_posts.title')
                ->get();

            array_push($paymentDetails, $paymentDetail[0]);


            //get payment name
            if($paymentDetail[0]->payment_type=="Deposit"){
                $paymentDetailName = $paymentDetail[0]->payment_type . " " . "Payment";
            }else{
                $date = strtotime($paymentDetail[0]->created_at);
                $paymentDetailName = date('M', $date) . " " . date('Y', $date) . " " . $paymentDetail[0]->payment_type . " " . "Payment";
            }
            array_push($paymentDetailsName, $paymentDetailName);


            //need sent notification to owner
            //getLatestNotificationID
            $latestNotificationID = $this->getLatestNotificationID();

            //make new NotificationID
            $newNotificationID = $this->notificationID($latestNotificationID);

            //add notification to database
            $addNotification = DB::table('notifications')->insert([
                'notification_id' => $newNotificationID,
                'title' => "Payment Received",
                'message' => $account->name . " from <b>" . $paymentDetail[0]->title . "</b> have made " .  $paymentDetailName . ".",
                'type' => "payment",
                'status' => "unread",
                'account_id' => $paymentDetail[0]->account_id
            ]);
        }

        //need sent email
        return redirect(URL('/mail/sentPaymentReceiptMail/' . Crypt::encrypt($paymentDetails) . "/" . Crypt::encrypt($paymentDetailsName)));
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
