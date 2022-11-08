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
            ->join('maintenance_images', 'maintenance_images.maintenance_id', '=', 'maintenance_requests.maintenance_id')
            ->orderBy('maintenance_requests.created_at', 'desc')
            ->where('rentings.renting_id', $rentingID)
            ->select('maintenance_requests.*', 'maintenance_images.maintenance_image_id', 'maintenance_images.image')
            ->get();


        return view('dashboard/tenant/dashboard_maintenancerequest_history', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Maintenance Request History',
            'back' => "/dashboard/rentingrecord/getrecordDetails/" . Crypt::encrypt($rentingID),
            'button' => '/dashboard/current_renting_record/record/maintenance_request_history/create_maintenance_request', //need edit
            'maintenanceRequests' => $maintenanceRequests
        ]);

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
            ->join('maintenance_images', 'maintenance_images.maintenance_id', '=', 'maintenance_requests.maintenance_id')
            ->where('maintenance_requests.maintenance_id', $maintenanceRequestID)
            ->select('maintenance_requests.*', 'maintenance_images.maintenance_image_id', 'maintenance_images.image')
            ->get();

        dd($maintenanceRequestDetails);


        //Display paymentDetails
        // return view('dashboard/tenant/dashboard_paymentdetails', [
        //     'user' => $user,
        //     'page' => $this->name,
        //     'header' => 'Payment Details',
        //     'back' => "/dashboard/payment/index/" . Crypt::encrypt($paymentDetails[0]->renting_id),
        //     'paymentDetails' => $paymentDetails,
        //     'paymentDetailsName' => $paymentDetailsName
        // ]);

    }



}
