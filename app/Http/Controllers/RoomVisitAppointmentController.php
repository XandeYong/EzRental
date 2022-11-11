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

        //get room visit appointment lists from database 
        $roomVisitAppointmentLists = DB::table('visit_appointments')
            ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'visit_appointments.post_id')
            ->orderBy('visit_appointments.created_at', 'desc')
            ->where('visit_appointments.account_id', $id)
            ->select('visit_appointments.appointment_id', 'visit_appointments.status', 'visit_appointments.created_at', 'room_rental_posts.title')
            ->get();


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



}
