<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class MaintenanceRequestController extends Controller
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

        //get maintenance requests from database 
        $maintenanceRequests = DB::table('maintenance_requests')
            ->join('rentings', 'rentings.renting_id', '=', 'maintenance_requests.renting_id')
            ->orderBy('maintenance_requests.created_at', 'desc')
            ->where('rentings.renting_id', $rentingID)
            ->select('maintenance_requests.*')
            ->get();

        //get renting status from database 
        $rentingStatus = DB::table('rentings')
            ->where('renting_id', $rentingID)
            ->select('status')
            ->get();

        //If renting status is expired then cannot create maintenance request
        if ($rentingStatus[0]->status == "active") {
            return view('dashboard/tenant/dashboard_maintenancerequest_history', [
                'user' => $user,
                'page' => $this->name,
                'header' => 'Maintenance Request History',
                'back' => "/dashboard/rentingrecord/getrecordDetails/" . Crypt::encrypt($rentingID),
                'button' => '/dashboard/rentingrecord/maintenancerequest/createMaintenanceRequest/' . Crypt::encrypt($rentingID),
                'maintenanceRequests' => $maintenanceRequests
            ]);
        } else {
            return view('dashboard/tenant/dashboard_maintenancerequest_history', [
                'user' => $user,
                'page' => $this->name,
                'header' => 'Maintenance Request History',
                'back' => "/dashboard/rentingrecord/getrecordDetails/" . Crypt::encrypt($rentingID),
                'maintenanceRequests' => $maintenanceRequests
            ]);
        }


    }

    public function getMaintenanceRequestDetails(Request $request, $maintenanceRequestID)
    {
        //Decrypt the parameter
        try {
            $maintenanceRequestID = Crypt::decrypt($maintenanceRequestID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }
        $account = $request->session()->get('account');
        $user = $account->role;

        //get maintenance request details from database 
        $maintenanceRequestDetails = DB::table('maintenance_requests')
            ->where('maintenance_requests.maintenance_id', $maintenanceRequestID)
            ->select('maintenance_requests.*')
            ->get();

        //get maintenance request images from database 
        $maintenanceRequestImages = DB::table('maintenance_images')
            ->where('maintenance_images.maintenance_id', $maintenanceRequestDetails[0]->maintenance_id)
            ->select('maintenance_images.image')
            ->get();

        // //Display maintenanceRequestDetails
        return view('dashboard/tenant/dashboard_maintenancerequestdetails', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Maintenance Request Detail',
            'back' => '/dashboard/rentingrecord/maintenancerequest/index/' . Crypt::encrypt($maintenanceRequestDetails[0]->renting_id),
            'maintenanceRequestDetails' => $maintenanceRequestDetails,
            'maintenanceRequestImages' => $maintenanceRequestImages
        ]);
    }

    public function createMaintenanceRequest(Request $request, $rentingID)
    {
        //
        //Decrypt the parameter
        try {
            $rentingID = Crypt::decrypt($rentingID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        $account = $request->session()->get('account');
        $user = $account->role;

        return view('dashboard/tenant/dashboard_maintenancerequest_create', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Create Maintenance Request',
            'back' => '/dashboard/rentingrecord/maintenancerequest/index/' . Crypt::encrypt($rentingID),
            'rentingID' => $rentingID
        ]);
    }

    public function createMaintenanceRequestToDB(Request $request)
    {
        //Laravel validation
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:65535']
        ]);

        $account = $request->session()->get('account');

        //get details from Create Maintenance Request View  
        $title = $request->input('title');
        $description = $request->input('description');
        $rentingID = $request->input('rentingID');

        //getLatestMaintenanceRequestID
        $latestMaintenanceRequestID = $this->getLatestMaintenanceRequestID();

        //make new MaintenanceRequestID
        $newMaintenanceRequestID = $this->maintenanceRequestID($latestMaintenanceRequestID);

        //Insert maintenance request in to database
        DB::table('maintenance_requests')->insert([
            'maintenance_id' => $newMaintenanceRequestID,
            'title' => $title,
            'description' => $description,
            'status' => "pending",
            'renting_id' => $rentingID
        ]);

        //need sent notification to owner
        //getLatestNotificationID
        $latestNotificationID = $this->getLatestNotificationID();

        //make new NotificationID
        $newNotificationID = $this->notificationID($latestNotificationID);


        //get room rental post details from database 
        $roomRentalPost = DB::table('room_rental_posts')
            ->join('rentings', 'rentings.post_id', '=', 'room_rental_posts.post_id')
            ->where('rentings.renting_id', $rentingID)
            ->select('room_rental_posts.account_id', 'room_rental_posts.title')
            ->get();

        //add notification to database
        $addNotification = DB::table('notifications')->insert([
            'notification_id' => $newNotificationID,
            'title' => "Maintenance Request Received",
            'message' => $account->name . " have created a maintenance request for <b>" . $roomRentalPost[0]->title . "</b>.",
            'type' => "maintenance_request",
            'status' => "unread",
            'account_id' => $roomRentalPost[0]->account_id
        ]);

        if ($addNotification > 0) {
            $request->session()->put('successMessage', 'Maintenance request created.');
        } else {
            $request->session()->put('failMessage', 'Maintenance request failed to create.');
        }

        return redirect(URL('/dashboard/rentingrecord/maintenancerequest/getMaintenanceRequestDetails/' . Crypt::encrypt($newMaintenanceRequestID)));
    }

    public function getLatestMaintenanceRequestID()
    {
        $maintenanceRequestID = DB::table('maintenance_requests')
            ->orderBy('created_at', 'desc')
            ->select('maintenance_id')
            ->get();

        if ($maintenanceRequestID->isEmpty()) {
            return "MR0";
        }
        return $maintenanceRequestID[0]->maintenance_id;
    }

    //add 1 to ID to make new ID 
    private function maintenanceRequestID($value)
    {
        $result = substr($value, 2);

        //parse result to int
        $ans = ((int)$result) + 1;

        //combine char and int into string
        $result = "MR" . ((string)$ans);

        return $result;
    }

    public function getLatestNotificationID()
    {
        $notificationID = DB::table('notifications')
            ->orderBy('created_at', 'desc')
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