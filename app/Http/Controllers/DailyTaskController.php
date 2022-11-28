<?php

namespace App\Http\Controllers;

use App\Mail\UnbanMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DailyTaskController extends Controller
{
    public function __construct()
    {
        $execTimeStart = microtime(true);

        //Auto unbanned user when durration arrived Function
        $this->autoUnbannedUser();
        //Auto add monthly payment when one month arrived Function
        $this->autoAddMonthlyPayment();
        //Remind if the tenant not paid the fees before 3 days from the monthly rental fees due date Function
        $this->autoReminderForTenant();
        //Remind owner if tenant not paid the fees when due date arrived Function
        $this->autoReminderForOwner();
        //Auto check is approved visit appointment already over 
        $this->autoCheckRoomVisitAppointment();
        //Auto check is rent request already expired 
        $this->autoCheckRentRequest();
        //Auto check contract is it expired and need be renew
        $this->autoCheckContract();
        //Auto check is visit appointment already expired without approved 
        $this->autoCheckRoomVisitAppointmentExpired();

        $execTimeEnd = microtime(true);

        $datetime = Carbon::now();
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();
        $status = 'success';

        $execTime = $execTimeStart - $execTimeEnd;
        $log = <<<EOT
        >>
        ==================================================
        Scheduler-Log
        --------------------------------------------------
        Task: DailyTask
        Controller: DailyTaskController
        Date: $date
        Time: $time
        Status: $status
        Execute Time: $execTime microseconds
        ==================================================
        >>\n
        EOT;

        echo $log;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $currentDate = date("Y-m-d");

                if ($currentDate >= $unbannedDate) {
                    //update to unbanned as the unbanned date arrived in database 
                    $updated = DB::table('ban_records')
                        ->join('accounts', 'accounts.account_id', '=', 'ban_records.account_id')
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
        Mail::to($userDetails[0]->email)->send(new UnbanMail($mailData)); //use this
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
                date_default_timezone_set("Asia/Kuala_Lumpur");
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
            ->select('payments.payment_id', 'payments.payment_type', 'payments.created_at', 'payments.renting_id', 'rentings.account_id')
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
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $currentDate = date("Y-m-d");

                //Check is current date exceed the due date need pay monthly rent
                if ($currentDate == $paymentDueDate) {
                    //Get payment name
                    if($unpaidPaymentRecords[$i]->payment_type=="Deposit"){
                        $paymentName = $unpaidPaymentRecords[$i]->payment_type . " " . "Payment";
                    }else{
                        $date = strtotime($unpaidPaymentRecords[$i]->created_at);
                        $paymentName = date('M', $date) . " " . date('Y', $date) . " " . $unpaidPaymentRecords[$i]->payment_type . " " . "Payment";
                    }

                    //get room rental post details from database 
                    $roomRentalPost = DB::table('room_rental_posts')
                        ->join('rentings', 'rentings.post_id', '=', 'room_rental_posts.post_id')
                        ->where('rentings.renting_id', $unpaidPaymentRecords[$i]->renting_id)
                        ->select('room_rental_posts.title')
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
                        'message' => "You have not make <b>" . $paymentName . "</b> for <b>" . $roomRentalPost[0]->title . "</b>.",
                        'type' => "payment",
                        'status' => "unread",
                        'account_id' => $unpaidPaymentRecords[$i]->account_id
                    ]);
                }
            }
        }
    }

    //Remind owner if tenant not paid the fees when due date arrived Function
    public function autoReminderForOwner()
    {

        //get all unpaid payment record from database 
        $unpaidPaymentRecords = DB::table('payments')
            ->join('rentings', 'rentings.renting_id', '=', 'payments.renting_id')
            ->where('payments.status', "unpaid")
            ->select('payments.payment_id', 'payments.payment_type', 'payments.created_at', 'payments.renting_id', 'rentings.account_id')
            ->get();

        if (!$unpaidPaymentRecords->isEmpty()) {
            for ($i = 0; $i < count($unpaidPaymentRecords); $i++) {

                //Use payment created date 
                $paymentCreatedDate = strtotime($unpaidPaymentRecords[$i]->created_at);
                $paymentCreatedDate = date('Y-m-d', $paymentCreatedDate);

                //get payment due date
                $paymentDueDate = date('Y-m-d', strtotime($paymentCreatedDate . "+ 1 months"));

                //get current date
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $currentDate = date("Y-m-d");

                //Check is current date exceed the due date need pay monthly rent
                if ($currentDate == $paymentDueDate) {
                    //Get payment name
                    if($unpaidPaymentRecords[$i]->payment_type=="Deposit"){
                        $paymentName = $unpaidPaymentRecords[$i]->payment_type . " " . "Payment";
                    }else{
                        $date = strtotime($unpaidPaymentRecords[$i]->created_at);
                        $paymentName = date('M', $date) . " " . date('Y', $date) . " " . $unpaidPaymentRecords[$i]->payment_type . " " . "Payment";
                    }

                    //get room rental post details from database 
                    $roomRentalPost = DB::table('room_rental_posts')
                        ->join('rentings', 'rentings.post_id', '=', 'room_rental_posts.post_id')
                        ->where('rentings.renting_id', $unpaidPaymentRecords[$i]->renting_id)
                        ->select('room_rental_posts.account_id', 'room_rental_posts.title')
                        ->get();

                    //sent reminder to owner by add notification in database
                    //getLatestNotificationID
                    $latestNotificationID = $this->getLatestNotificationID();

                    //make new NotificationID
                    $newNotificationID = $this->notificationID($latestNotificationID);

                    //add notification to database
                    $addNotification = DB::table('notifications')->insert([
                        'notification_id' => $newNotificationID,
                        'title' => "Payment Reminder",
                        'message' => "You have not receive <b>" . $paymentName . "</b> for <b>" . $roomRentalPost[0]->title . "</b>.",
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

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Auto check is approved visit appointment already over 
    public function autoCheckRoomVisitAppointment()
    {

        //get room visit appointment details from database 
        $roomVisitAppointments = DB::table('visit_appointments')
            ->where('status', 'approved')
            ->select('appointment_id', 'datetime')
            ->get();

        if (!$roomVisitAppointments->isEmpty()) {
            for ($i = 0; $i < count($roomVisitAppointments); $i++) {

                //get current date time in Malaysia
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $currentDate = date("Y-m-d H:i:s");

                if ($currentDate >= $roomVisitAppointments[$i]->datetime) {
                    //update room visit appoitment status in database 
                    $updated = DB::table('visit_appointments')
                        ->where('appointment_id', $roomVisitAppointments[$i]->appointment_id)
                        ->update(['status' => "success"]);
                }
            }
        }
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Auto check is rent request already expired 
    public function autoCheckRentRequest()
    {

        //get rent_requests details from database 
        $rentRequests = DB::table('rent_requests')
            ->where('status', 'pending')
            ->orWhere('status', 'approved')
            ->orWhere('status', 'signed')
            ->select('rent_request_id', 'rent_date_start')
            ->get();

        if (!$rentRequests->isEmpty()) {
            for ($i = 0; $i < count($rentRequests); $i++) {

                //get current date time in Malaysia
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $currentDate = date("Y-m-d");

                if ($currentDate >= $rentRequests[$i]->rent_date_start) {
                    //update rent request status in database 
                    $updated = DB::table('rent_requests')
                        ->where('rent_request_id', $rentRequests[$i]->rent_request_id)
                        ->update(['status' => "expired"]);

                    //getLatestNotificationID
                    $latestNotificationID = $this->getLatestNotificationID();

                    //make new NotificationID
                    $newNotificationID = $this->notificationID($latestNotificationID);

                    //get room rental post details from database 
                    $roomRentalPost = DB::table('room_rental_posts')
                        ->join('rent_requests', 'rent_requests.post_id', '=', 'room_rental_posts.post_id')
                        ->where('rent_requests.rent_request_id', $rentRequests[$i]->rent_request_id)
                        ->select('room_rental_posts.account_id', 'room_rental_posts.title')
                        ->get();


                    //need sent notification to owner
                    //add notification to database
                    $addNotification = DB::table('notifications')->insert([
                        'notification_id' => $newNotificationID,
                        'title' => "Renting Request Expired",
                        'message' => "Renting request for <b>" . $roomRentalPost[0]->title . "</b> had been expired.",
                        'type' => "renting_request",
                        'status' => "unread",
                        'account_id' => $roomRentalPost[0]->account_id
                    ]);

                    //need sent notification to tenant
                    //get tenant details from database 
                    $rentRequest = DB::table('rent_requests')
                        ->where('rent_request_id', $rentRequests[$i]->rent_request_id)
                        ->select('account_id')
                        ->get();

                    //getLatestNotificationID
                    $latestNotificationID = $this->getLatestNotificationID();

                    //make new NotificationID
                    $newNotificationID = $this->notificationID($latestNotificationID);

                    //add notification to database
                    $addNotification = DB::table('notifications')->insert([
                        'notification_id' => $newNotificationID,
                        'title' => "Renting Request Expired",
                        'message' => "Renting request for <b>" . $roomRentalPost[0]->title . "</b> had been expired.",
                        'type' => "renting_request",
                        'status' => "unread",
                        'account_id' => $rentRequest[0]->account_id
                    ]);
                }
            }
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Auto check contract is it expired and need be renew
    public function autoCheckContract()
    {
        //get contracts details from database 
        $contractLists = DB::table('contracts')
            ->join('rentings', 'rentings.contract_id', '=', 'contracts.contract_id')
            ->where('contracts.status', 'active')
            ->select('contracts.*', 'rentings.renting_id', 'rentings.renew_contract', 'rentings.account_id')
            ->get();


        if (!$contractLists->isEmpty()) {
            for ($i = 0; $i < count($contractLists); $i++) {

                //get current date time in Malaysia
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $currentDate = date("Y-m-d");

                if ($currentDate >= $contractLists[$i]->expired_date) {

                    //update contracts status in database 
                    $updated = DB::table('contracts')
                        ->where('contract_id', $contractLists[$i]->contract_id)
                        ->update(['status' => "expired"]);

                    //get room rental post details from database 
                    $roomRentalPost = DB::table('room_rental_posts')
                        ->join('contracts', 'contracts.post_id', '=', 'room_rental_posts.post_id')
                        ->where('contracts.contract_id', $contractLists[$i]->contract_id)
                        ->select('room_rental_posts.account_id', 'room_rental_posts.title')
                        ->get();

                    //check does contract need to be renew
                    if ($contractLists[$i]->renew_contract != "yes") {

                        //update rentings status in database 
                        $updated = DB::table('rentings')
                            ->where('renting_id', $contractLists[$i]->renting_id)
                            ->update(['status' => "expired"]);

                        //getLatestNotificationID
                        $latestNotificationID = $this->getLatestNotificationID();

                        //make new NotificationID
                        $newNotificationID = $this->notificationID($latestNotificationID);

                        //need sent notification to owner about renting expired
                        //add notification to database
                        $addNotification = DB::table('notifications')->insert([
                            'notification_id' => $newNotificationID,
                            'title' => "Renting Expired",
                            'message' => "Renting for <b>" . $roomRentalPost[0]->title . "</b> had been expired.",
                            'type' => "renting",
                            'status' => "unread",
                            'account_id' => $roomRentalPost[0]->account_id
                        ]);

                        //need sent notification to tenant
                        //getLatestNotificationID
                        $latestNotificationID = $this->getLatestNotificationID();

                        //make new NotificationID
                        $newNotificationID = $this->notificationID($latestNotificationID);

                        //add notification to database
                        $addNotification = DB::table('notifications')->insert([
                            'notification_id' => $newNotificationID,
                            'title' => "Renting Expired",
                            'message' => "renting for <b>" . $roomRentalPost[0]->title . "</b> had been expired.",
                            'type' => "contract",
                            'status' => "unread",
                            'account_id' => $contractLists[$i]->account_id
                        ]);

                        //getLatestNotificationID
                        $latestNotificationID = $this->getLatestNotificationID();

                        //make new NotificationID
                        $newNotificationID = $this->notificationID($latestNotificationID);

                        //need sent notification to owner about contract expired
                        //add notification to database
                        $addNotification = DB::table('notifications')->insert([
                            'notification_id' => $newNotificationID,
                            'title' => "Contract Expired",
                            'message' => "Contract for <b>" . $roomRentalPost[0]->title . "</b> had been expired.",
                            'type' => "contract",
                            'status' => "unread",
                            'account_id' => $roomRentalPost[0]->account_id
                        ]);

                        //need sent notification to tenant
                        //getLatestNotificationID
                        $latestNotificationID = $this->getLatestNotificationID();

                        //make new NotificationID
                        $newNotificationID = $this->notificationID($latestNotificationID);

                        //add notification to database
                        $addNotification = DB::table('notifications')->insert([
                            'notification_id' => $newNotificationID,
                            'title' => "Contract Expired",
                            'message' => "Contract for <b>" . $roomRentalPost[0]->title . "</b> had been expired.",
                            'type' => "contract",
                            'status' => "unread",
                            'account_id' => $contractLists[$i]->account_id
                        ]);
                    } else {

                        //calculate expired date for new contract
                        //Creates DateTime objects
                        $date1 = date_create($contractLists[$i]->start_date);
                        $date2 = date_create($contractLists[$i]->expired_date);
                        $different = date_diff($date1, $date2);

                        $different = $different->format("%r %a days");

                        //get newExpiredDate
                        $newExpiredDate = date('Y-m-d', strtotime($contractLists[$i]->expired_date . ' ' . $different));

                        //getLatestContractID
                        $latestContractID = $this->getLatestContractID();

                        //make new ContractID
                        $newContractID = $this->contractID($latestContractID);

                        //Insert new contract to database
                        $addNewContract = DB::table('contracts')->insert([
                            'contract_id' => $newContractID,
                            'content' => $contractLists[$i]->content,
                            'start_date' => $currentDate,
                            'expired_date' => $newExpiredDate,
                            'owner_signature' => $contractLists[$i]->owner_signature,
                            'tenant_signature' => $contractLists[$i]->tenant_signature,
                            'deposit_price' => $contractLists[$i]->deposit_price,
                            'monthly_price' => $contractLists[$i]->monthly_price,
                            'status' => 'active',
                            'post_id' => $contractLists[$i]->post_id
                        ]);

                        //Update the contract id in rentings
                        $updated = DB::table('rentings')
                            ->where('renting_id', $contractLists[$i]->renting_id)
                            ->update(['contract_id' => $newContractID]);

                        //getLatestNotificationID
                        $latestNotificationID = $this->getLatestNotificationID();

                        //make new NotificationID
                        $newNotificationID = $this->notificationID($latestNotificationID);

                        //need sent notification to owner
                        //add notification to database
                        $addNotification = DB::table('notifications')->insert([
                            'notification_id' => $newNotificationID,
                            'title' => "Contract Renewed",
                            'message' => "Contract for <b>" . $roomRentalPost[0]->title . "</b> had been renewed.",
                            'type' => "contract",
                            'status' => "unread",
                            'account_id' => $roomRentalPost[0]->account_id
                        ]);

                        //need sent notification to tenant
                        //getLatestNotificationID
                        $latestNotificationID = $this->getLatestNotificationID();

                        //make new NotificationID
                        $newNotificationID = $this->notificationID($latestNotificationID);

                        //add notification to database
                        $addNotification = DB::table('notifications')->insert([
                            'notification_id' => $newNotificationID,
                            'title' => "Contract Renewed",
                            'message' => "Contract for <b>" . $roomRentalPost[0]->title . "</b> had been renewed.",
                            'type' => "contract",
                            'status' => "unread",
                            'account_id' => $contractLists[$i]->account_id
                        ]);
                    }
                }
            }
        }
    }


    public function getLatestContractID()
    {
        $contractID = DB::table('contracts')
            ->select('contract_id')
            ->whereRaw("CHAR_LENGTH(contract_id) = (SELECT MAX(CHAR_LENGTH(contract_id)) from contracts)")
            ->orderByDesc('contract_id')
            ->distinct()
            ->select('contract_id')
            ->get();

        if ($contractID->isEmpty()) {
            return "CT0";
        }
        return $contractID[0]->contract_id;
    }

    //add 1 to ID to make new ID 
    private function contractID($value)
    {
        $result = substr($value, 2);

        //parse result to int
        $ans = ((int)$result) + 1;

        //combine char and int into string
        $result = "CT" . ((string)$ans);

        return $result;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Auto check is visit appointment already expired without approved 
    public function autoCheckRoomVisitAppointmentExpired()
    {

        //get room visit appointment details from database 
        $roomVisitAppointments = DB::table('visit_appointments')
            ->where('status', 'pending')
            ->orWhere('status', 'rescheduled')
            ->select('appointment_id', 'datetime', 'account_id')
            ->get();

        if (!$roomVisitAppointments->isEmpty()) {
            for ($i = 0; $i < count($roomVisitAppointments); $i++) {

                //get current date time in Malaysia
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $currentDate = date("Y-m-d H:i:s");

                if ($currentDate >= $roomVisitAppointments[$i]->datetime) {
                    //update room visit appoitment status in database 
                    $updated = DB::table('visit_appointments')
                        ->where('appointment_id', $roomVisitAppointments[$i]->appointment_id)
                        ->update(['status' => "expired"]);

                    //getLatestNotificationID
                    $latestNotificationID = $this->getLatestNotificationID();

                    //make new NotificationID
                    $newNotificationID = $this->notificationID($latestNotificationID);

                    //get room rental post details from database 
                    $roomRentalPost = DB::table('room_rental_posts')
                        ->join('visit_appointments', 'visit_appointments.post_id', '=', 'room_rental_posts.post_id')
                        ->where('visit_appointments.appointment_id', $roomVisitAppointments[$i]->appointment_id)
                        ->select('room_rental_posts.account_id', 'room_rental_posts.title')
                        ->get();


                    //need sent notification to owner
                    //add notification to database
                    $addNotification = DB::table('notifications')->insert([
                        'notification_id' => $newNotificationID,
                        'title' => "Visit Appointment Expired",
                        'message' => "Visit Appointment for <b>" . $roomRentalPost[0]->title . "</b> had been expired.",
                        'type' => "visit_appointment",
                        'status' => "unread",
                        'account_id' => $roomRentalPost[0]->account_id
                    ]);

                    //need sent notification to tenant
                    //getLatestNotificationID
                    $latestNotificationID = $this->getLatestNotificationID();

                    //make new NotificationID
                    $newNotificationID = $this->notificationID($latestNotificationID);

                    //add notification to database
                    $addNotification = DB::table('notifications')->insert([
                        'notification_id' => $newNotificationID,
                        'title' => "Visit Appointment Expired",
                        'message' => "Visit Appointment for <b>" . $roomRentalPost[0]->title . "</b> had been expired.",
                        'type' => "visit_appointment",
                        'status' => "unread",
                        'account_id' => $roomVisitAppointments[$i]->account_id
                    ]);

                }
            }
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



}
