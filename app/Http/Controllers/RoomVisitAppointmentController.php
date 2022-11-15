<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class RoomVisitAppointmentController extends Controller
{
    //
    public $name = 'Room Visit Appointment';

    public function index(Request $request)
    {
        $account = $request->session()->get('account');
        $id = $account->account_id;
        $user = $account->role;

        if ($user == "T") {
            //get room visit appointment lists from database for tenant
            $roomVisitAppointmentLists = DB::table('visit_appointments')
                ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'visit_appointments.post_id')
                ->orderBy('visit_appointments.created_at', 'desc')
                ->where('visit_appointments.account_id', $id)
                ->select('visit_appointments.appointment_id', 'visit_appointments.status', 'visit_appointments.created_at', 'room_rental_posts.title')
                ->get();
        } else {
            //get room visit appointment lists from database for owner
            $roomVisitAppointmentLists = DB::table('visit_appointments')
                ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'visit_appointments.post_id')
                ->orderBy('visit_appointments.created_at', 'desc')
                ->where('room_rental_posts.account_id', $id)
                ->select('visit_appointments.appointment_id', 'visit_appointments.status', 'visit_appointments.created_at', 'room_rental_posts.title')
                ->get();
        }

        return view('dashboard/tenant/dashboard_roomvisitappointment_list', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Room Visit Appointment List',
            'roomVisitAppointmentLists' => $roomVisitAppointmentLists
        ]);
    }

    public function getRoomVisitAppoitmentDetails(Request $request, $roomVisitAppointmentID)
    {
        //Decrypt the parameter
        try {
            $roomVisitAppointmentID = Crypt::decrypt($roomVisitAppointmentID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }
        $account = $request->session()->get('account');
        $user = $account->role;

        //get room visit appoitment details from database 
        $roomVisitAppointmentDetails = DB::table('visit_appointments')
            ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'visit_appointments.post_id')
            ->where('visit_appointments.appointment_id', $roomVisitAppointmentID)
            ->select('visit_appointments.appointment_id', 'visit_appointments.datetime', 'visit_appointments.note', 'visit_appointments.status', 'visit_appointments.created_at', 'room_rental_posts.title')
            ->get();


        //Display roomVisitAppointmentDetails
        return view('dashboard/tenant/dashboard_roomvisitappointmentdetails', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Room Visit Appointment Details',
            'back' => '/dashboard/roomvisitappointment/index',
            'roomVisitAppointmentDetails' => $roomVisitAppointmentDetails
        ]);
    }


    public function approveAppointment(Request $request, $roomVisitAppointmentID)
    {
        //Decrypt the parameter
        try {
            $roomVisitAppointmentID = Crypt::decrypt($roomVisitAppointmentID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }
        $account = $request->session()->get('account');
        $user = $account->role;

        //update room visit appoitment status in database 
        $updated = DB::table('visit_appointments')
            ->where('appointment_id', $roomVisitAppointmentID)
            ->update(['status' => "approved"]);

        //getLatestNotificationID
        $latestNotificationID = $this->getLatestNotificationID();

        //make new NotificationID
        $newNotificationID = $this->notificationID($latestNotificationID);

        //get room rental post details from database 
        $roomRentalPost = DB::table('room_rental_posts')
            ->join('visit_appointments', 'visit_appointments.post_id', '=', 'room_rental_posts.post_id')
            ->where('visit_appointments.appointment_id', $roomVisitAppointmentID)
            ->select('room_rental_posts.account_id', 'room_rental_posts.title')
            ->get();

        if ($user == "T") {
            //need sent notification to owner
            //add notification to database
            $addNotification = DB::table('notifications')->insert([
                'notification_id' => $newNotificationID,
                'title' => "Room Visit Appointment Approved",
                'message' => "Visit Appointment for <b>" . $roomRentalPost[0]->title . "</b> had been approved.",
                'type' => "visit_appointment",
                'status' => "unread",
                'account_id' => $roomRentalPost[0]->account_id
            ]);
        } else {
            //need sent notification to tenant
            //get tenant details from database 
            $roomVisitAppointment = DB::table('visit_appointments')
                ->where('appointment_id', $roomVisitAppointmentID)
                ->select('account_id')
                ->get();

            //add notification to database
            $addNotification = DB::table('notifications')->insert([
                'notification_id' => $newNotificationID,
                'title' => "Room Visit Appointment Approved",
                'message' => "Visit Appointment for <b>" . $roomRentalPost[0]->title . "</b> had been approved.",
                'type' => "visit_appointment",
                'status' => "unread",
                'account_id' => $roomVisitAppointment[0]->account_id
            ]);
        }

        if ($addNotification > 0) {
            $request->session()->put('successMessage', 'Visit appointment approved.');
        } else {
            $request->session()->put('failMessage', 'Visit appointment fail to approved.');
        }

        return redirect(URL('/dashboard/roomvisitappointment/getRoomVisitAppoitmentDetails/' . Crypt::encrypt($roomVisitAppointmentID)));
    }

    public function rejectAppointment(Request $request, $roomVisitAppointmentID)
    {
        //Decrypt the parameter
        try {
            $roomVisitAppointmentID = Crypt::decrypt($roomVisitAppointmentID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }
        $account = $request->session()->get('account');
        $user = $account->role;

        //update room visit appoitment status in database 
        $updated = DB::table('visit_appointments')
            ->where('appointment_id', $roomVisitAppointmentID)
            ->update(['status' => "rejected"]);

        //getLatestNotificationID
        $latestNotificationID = $this->getLatestNotificationID();

        //make new NotificationID
        $newNotificationID = $this->notificationID($latestNotificationID);

        //get room rental post details from database 
        $roomRentalPost = DB::table('room_rental_posts')
            ->join('visit_appointments', 'visit_appointments.post_id', '=', 'room_rental_posts.post_id')
            ->where('visit_appointments.appointment_id', $roomVisitAppointmentID)
            ->select('room_rental_posts.account_id', 'room_rental_posts.title')
            ->get();

        if ($user == "T") {
            //need sent notification to owner
            //add notification to database
            $addNotification = DB::table('notifications')->insert([
                'notification_id' => $newNotificationID,
                'title' => "Room Visit Appointment Rejected",
                'message' => "Visit Appointment for <b>" . $roomRentalPost[0]->title . "</b> had been rejected.",
                'type' => "visit_appointment",
                'status' => "unread",
                'account_id' => $roomRentalPost[0]->account_id
            ]);
        } else {
            //need sent notification to tenant
            //get tenant details from database 
            $roomVisitAppointment = DB::table('visit_appointments')
                ->where('appointment_id', $roomVisitAppointmentID)
                ->select('account_id')
                ->get();

            //add notification to database
            $addNotification = DB::table('notifications')->insert([
                'notification_id' => $newNotificationID,
                'title' => "Room Visit Appointment Rejected",
                'message' => "Visit Appointment for <b>" . $roomRentalPost[0]->title . "</b> had been rejected.",
                'type' => "visit_appointment",
                'status' => "unread",
                'account_id' => $roomVisitAppointment[0]->account_id
            ]);
        }

        if ($addNotification > 0) {
            $request->session()->put('successMessage', 'Visit appointment rejected.');
        } else {
            $request->session()->put('failMessage', 'Visit appointment fail to rejected.');
        }

        return redirect(URL('/dashboard/roomvisitappointment/getRoomVisitAppoitmentDetails/' . Crypt::encrypt($roomVisitAppointmentID)));
    }

    public function cancelAppointment(Request $request, $roomVisitAppointmentID)
    {
        //Decrypt the parameter
        try {
            $roomVisitAppointmentID = Crypt::decrypt($roomVisitAppointmentID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }
        $account = $request->session()->get('account');
        $user = $account->role;

        //update room visit appoitment status in database 
        $updated = DB::table('visit_appointments')
            ->where('appointment_id', $roomVisitAppointmentID)
            ->update(['status' => "canceled"]);

        //getLatestNotificationID
        $latestNotificationID = $this->getLatestNotificationID();

        //make new NotificationID
        $newNotificationID = $this->notificationID($latestNotificationID);

        //get room rental post details from database 
        $roomRentalPost = DB::table('room_rental_posts')
            ->join('visit_appointments', 'visit_appointments.post_id', '=', 'room_rental_posts.post_id')
            ->where('visit_appointments.appointment_id', $roomVisitAppointmentID)
            ->select('room_rental_posts.account_id', 'room_rental_posts.title')
            ->get();

        if ($user == "T") {
            //need sent notification to owner
            //add notification to database
            $addNotification = DB::table('notifications')->insert([
                'notification_id' => $newNotificationID,
                'title' => "Room Visit Appointment Canceled",
                'message' => "Visit Appointment for <b>" . $roomRentalPost[0]->title . "</b> had been canceled.",
                'type' => "visit_appointment",
                'status' => "unread",
                'account_id' => $roomRentalPost[0]->account_id
            ]);
        } else {
            //need sent notification to tenant
            //get tenant details from database 
            $roomVisitAppointment = DB::table('visit_appointments')
                ->where('appointment_id', $roomVisitAppointmentID)
                ->select('account_id')
                ->get();

            //add notification to database
            $addNotification = DB::table('notifications')->insert([
                'notification_id' => $newNotificationID,
                'title' => "Room Visit Appointment Canceled",
                'message' => "Visit Appointment for <b>" . $roomRentalPost[0]->title . "</b> had been canceled.",
                'type' => "visit_appointment",
                'status' => "unread",
                'account_id' => $roomVisitAppointment[0]->account_id
            ]);
        }

        if ($addNotification > 0) {
            $request->session()->put('successMessage', 'Visit appointment canceled.');
        } else {
            $request->session()->put('failMessage', 'Visit appointment fail to canceled.');
        }

        return redirect(URL('/dashboard/roomvisitappointment/getRoomVisitAppoitmentDetails/' . Crypt::encrypt($roomVisitAppointmentID)));
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
