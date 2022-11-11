<?php

namespace App\Http\Controllers;

use App\Mail\UnbanMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class TestController extends Controller
{
    //
    public $name = 'Test for All Auto Function';

    //Auto unbanned user when durration arrived Function
    public function autoUnbannedUser()
    {

        //get all ban records with banned from database  
        $banRecords = DB::table('ban_records')
            ->join('accounts', 'accounts.account_id', '=', 'ban_records.account_id')
            ->where('ban_records.status', 'banned')
            ->where('ban_records.duration', '!=', 0)
            ->select('accounts.account_id', 'ban_records.ban_id', 'ban_records.duration', 'ban_records.created_at')
            ->get();

        if (!$banRecords->isEmpty()) {
            for ($i = 0; $i < count($banRecords); $i++) {

                $date = strtotime($banRecords[$i]->created_at);
                $date = date('Y-m-d', $date);

                //get unbanned date
                $unbannedDate = date('Y-m-d', strtotime($date . "+" . $banRecords[$i]->duration . " days"));

                //get current date
                $currentDate = date("Y-m-d");

                if ($currentDate >= $unbannedDate) {
                    //update to unbanned as the unbanned date arrived in database 
                    $updated = DB::table('ban_records')
                        ->join('accounts', 'accounts.account_id', '=', 'accounts.account_id')
                        ->where('ban_records.ban_id', $banRecords[$i]->ban_id)
                        ->update(['ban_records.status' => 'unbanned', 'accounts.status' => 'offline']);

                    //need sent email
                    $this->autoSentUnbanMail($banRecords[$i]->account_id);
                }
            }
        }
    }


    public function autoSentUnbanMail($accountID)
    {
        //get all userdetails from database  
        $userDetails = DB::table('accounts')
            ->where('account_id', $accountID)
            ->select('name', 'email')
            ->get();

        $mailData = [
            'name' => $userDetails[0]->name,
            'dateTime' => date("Y/m/d h:i:s")
        ];

        //sent email
        // Mail::to($userDetails[0]->email)->send(new UnbanMail($mailData)); //use this
        Mail::to("mcgallery21@gmail.com")->send(new UnbanMail($mailData)); //remove this
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Auto add monthly payment when one month arrived Function
    public function autoAddMonthlyPayment()
    {

        //get all active renting record from database 
        $rentingRecords = DB::table('rentings')
            ->join('contracts', 'contracts.contract_id', '=', 'rentings.contract_id')
            ->where('rentings.status', "active")
            ->select('rentings.renting_id', 'rentings.created_at', 'contracts.monthly_price')
            ->get();


        if (!$rentingRecords->isEmpty()) {
            for ($i = 0; $i < count($rentingRecords); $i++) {
                //get latest payment details of the renting record from database 
                $paymentDetails = DB::table('payments')
                    ->orderBy('created_at', 'desc')
                    ->where('renting_id', $rentingRecords[$i]->renting_id)
                    ->where('payment_type', 'Monthly')
                    ->select('payment_id', 'created_at')
                    ->get();

                if ($paymentDetails->isEmpty()) {
                    //Use rent created date as no monthly payment is created
                    $rentingCreatedDate = strtotime($rentingRecords[$i]->created_at);
                    $rentingCreatedDate = date('Y-m-d', $rentingCreatedDate);

                    //get add payment date
                    $addPaymentDate = date('Y-m-d', strtotime($rentingCreatedDate . "+ 1 months"));
                } else {
                    //Use latest payment created date as got monthly payment previously created
                    $paymentCreatedDate = strtotime($paymentDetails[0]->created_at);
                    $paymentCreatedDate = date('Y-m-d', $paymentCreatedDate);

                    //get add payment date
                    $addPaymentDate = date('Y-m-d', strtotime($paymentCreatedDate . "+ 1 months"));
                }

                //get current date
                $currentDate = date("Y-m-d");

                //Check is current date exceed the date need pay monthly rent
                if ($currentDate >= $addPaymentDate) {

                    //getLatestPaymentID
                    $latestPaymentID = $this->getLatestPaymentID();

                    //make new PaymentID
                    $newPaymentID = $this->paymentID($latestPaymentID);

                    //Insert maintenance request in to database
                    DB::table('payments')->insert([
                        'payment_id' => $newPaymentID,
                        'payment_type' => 'Monthly',
                        'amount' => $rentingRecords[$i]->monthly_price,
                        'status' => "unpaid",
                        'renting_id' => $rentingRecords[$i]->renting_id
                    ]);
                }
            }
        }
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

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Remind if the tenant not paid the fees before 3 days from the monthly rental fees due date Function
    public function autoReminderForTenant()
    {

        //get all unpaid payment record from database 
        $unpaidPaymentRecords = DB::table('payments')
            ->join('rentings', 'rentings.renting_id', '=', 'payments.renting_id')
            ->where('payments.status', "unpaid")
            ->select('payments.payment_id', 'payments.payment_type','payments.created_at', 'payments.renting_id', 'rentings.account_id')
            ->get();

        if (!$unpaidPaymentRecords->isEmpty()) {
            for ($i = 0; $i < count($unpaidPaymentRecords); $i++) {

                //Use payment created date 
                $paymentCreatedDate = strtotime($unpaidPaymentRecords[$i]->created_at);
                $paymentCreatedDate = date('Y-m-d', $paymentCreatedDate);

                //get payment due date
                $paymentDueDate = date('Y-m-d', strtotime($paymentCreatedDate . "+ 1 months"));
                //get 3 days before payment due date
                $paymentDueDate = date('Y-m-d', strtotime($paymentDueDate . "- 3 days"));

                //get current date
                $currentDate = date("Y-m-d");

                //Check is current date exceed the due date need pay monthly rent
                if ($currentDate >= $paymentDueDate) {
                    //Get payment name
                    $date = strtotime($unpaidPaymentRecords[$i]->created_at);
                    $paymentName = date('M', $date) . " " . $unpaidPaymentRecords[$i]->payment_type . " " . "Payment";

                    
                    
                    //get room rental post details from database 
                    $roomRentalPost = DB::table('room_rental_posts')
                        ->join('rentings', 'rentings.post_id', '=', 'room_rental_posts.post_id')
                        ->where('rentings.renting_id', $unpaidPaymentRecords[$i]->renting_id)
                        ->select('room_rental_posts.account_id', 'room_rental_posts.title')
                        ->get();

                    //sent reminder to tenant by add notification in database
                    //getLatestNotificationID
                    $latestNotificationID = $this->getLatestNotificationID();

                    //make new NotificationID
                    $newNotificationID = $this->notificationID($latestNotificationID);

                    //add notification to database
                    $addNotification = DB::table('notifications')->insert([
                        'notification_id' => $newNotificationID,
                        'title' => "Payment Reminder",
                        'message' => "You have not make <b>". $paymentName . "</b> for <b>" . $roomRentalPost[0]->title . "</b>.",
                        'type' => "payment",
                        'status' => "unread",
                        'account_id' => $unpaidPaymentRecords[$i]->account_id
                    ]);


                    //sent reminder to owner by add notification in database
                    //getLatestNotificationID
                    $latestNotificationID = $this->getLatestNotificationID();

                    //make new NotificationID
                    $newNotificationID = $this->notificationID($latestNotificationID);

                    //add notification to database
                    $addNotification = DB::table('notifications')->insert([
                        'notification_id' => $newNotificationID,
                        'title' => "Payment Reminder",
                        'message' => "You have not receive <b>". $paymentName . "</b> for <b>" . $roomRentalPost[0]->title . "</b>.",
                        'type' => "payment",
                        'status' => "unread",
                        'account_id' => $roomRentalPost[0]->account_id
                    ]);


                }
            }
        }
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
