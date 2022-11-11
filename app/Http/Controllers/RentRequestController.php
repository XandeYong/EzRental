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

        //get rent request lists from database 
        $rentRequestLists = DB::table('rent_requests')
            ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'rent_requests.post_id')
            ->orderBy('rent_requests.created_at', 'desc')
            ->where('rent_requests.account_id', $id)
            ->select('rent_requests.rent_request_id', 'rent_requests.status', 'rent_requests.created_at', 'room_rental_posts.title')
            ->get();


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
            ->select('rent_requests.rent_request_id', 'rent_requests.price', 'rent_requests.rent_date_start', 'rent_requests.rent_date_end', 'rent_requests.status', 'rent_requests.created_at', 'room_rental_posts.title')
            ->get();


        //Display rentRequestDetails
        return view('dashboard/tenant/dashboard_rentrequestdetails', [
            'user' => $user,
            'page' => $this->name,
            'header' => 'Rent Request Details',
            'back' => '/dashboard/rentrequest/index',
            'rentRequestDetails' => $rentRequestDetails
        ]);

    }



}
