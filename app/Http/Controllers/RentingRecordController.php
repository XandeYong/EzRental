<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class RentingRecordController extends Controller
{
    //
    public $name = 'Renting Record';

    public function index(Request $request, $value)
    {
        //Decrypt the parameter
        try {
            $value = Crypt::decrypt($value);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }        

        $account = $request->session()->get('account'); 
        $id = $account->account_id;
        $user = $account->role;

        if($value == "current"){
        //get current renting record from database 
        $rentingRecords = DB::table('rentings')
        ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'rentings.post_id')
        ->where('rentings.account_id', $id)
        ->where('rentings.status', "active")
        ->select('room_rental_posts.title', 'rentings.renting_id')
        ->get();
        
        $header="Current Renting Record";

        }else{
         //get past renting record from database 
         $rentingRecords = DB::table('rentings')
         ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'rentings.post_id')
         ->where('rentings.account_id', $id)
         ->where('rentings.status', "expired")
         ->select('room_rental_posts.title', 'rentings.renting_id')
         ->get();
        
        $header="Past Renting Record";

        }

        
        return view('dashboard/tenant/dashboard_rentingrecord_list', [
            'page' => $this->name,
            'header' => $header,
            'rentingRecords' => $rentingRecords
        ]);

    }

    public function getrecordDetails(Request $request, $rentingID)
    {
        //Decrypt the parameter
        try {
            $rentingID = Crypt::decrypt($rentingID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }
        
        // Remove Session variable set for payment
        if (session()->has('payments')) {
            session()->forget('payments');
        } 


        $account = $request->session()->get('account'); 
        $id = $account->account_id;
        $user = $account->role;

        //get renting record details from database 
        $rentingRecordDetails = DB::table('rentings')
        ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'rentings.post_id')
        ->join('accounts', 'accounts.account_id', '=', 'room_rental_posts.account_id')
        ->join('contracts', 'contracts.contract_id', '=', 'rentings.contract_id')
        ->where('rentings.renting_id', $rentingID)
        ->select('room_rental_posts.post_id', 'room_rental_posts.title', 'room_rental_posts.description', 'room_rental_posts.room_size', 'room_rental_posts.address', 'room_rental_posts.condominium_name', 'room_rental_posts.block', 'room_rental_posts.floor', 'room_rental_posts.unit', 'accounts.name', 'rentings.status', 'rentings.renting_id', 'rentings.contract_id', 'contracts.deposit_price', 'contracts.monthly_price')
        ->get();


        //get renting record post images from database 
        $rentingRecordImages = DB::table('post_images')
        ->join('room_rental_posts', 'room_rental_posts.post_id', '=', 'post_images.post_id')
        ->where('room_rental_posts.post_id', $rentingRecordDetails[0]->post_id)
        ->select('post_images.image')
        ->get();    

        //get unpaid payment from database 
        $unpaidPaymentsID = DB::table('payments')
        ->join('rentings', 'rentings.renting_id', '=', 'payments.renting_id')
        ->where('payments.renting_id', $rentingID)
        ->where('payments.status', "unpaid")
        ->select('payments.payment_id', 'payments.payment_type', 'payments.created_at')
        ->get(); 

        if (!$unpaidPaymentsID->isEmpty()){
            $unpaidPaymentsName=array();

            //get unpaid payment name
            foreach ($unpaidPaymentsID as $unpaidPaymentID){
            $date = strtotime ( $unpaidPaymentID->created_at );
            $unpaidPaymentName=date('M' , $date ) . " " . $unpaidPaymentID->payment_type . " " . "Payment";

            array_push( $unpaidPaymentsName, $unpaidPaymentName);
            }
        
        }else{
            $unpaidPaymentsName=null;
        }

        //See which header suitable
        if($rentingRecordDetails[0]->status == "active"){
        $header="Current Renting Record Details";
        $status="current";
        }else{
        $header="Past Renting Record Details";
        $status="past";
        }
        

        return view('dashboard/tenant/dashboard_rentingrecord', [
            'page' => $this->name,
            'header' => $header,
            'back' => "/dashboard/rentingrecord/index/" . Crypt::encrypt($status),
            'rentingRecordDetails' => $rentingRecordDetails,
            'rentingRecordImages' => $rentingRecordImages,
            'unpaidPaymentsID' => $unpaidPaymentsID,
            'unpaidPaymentsName' => $unpaidPaymentsName,
        ]);
    }







}
