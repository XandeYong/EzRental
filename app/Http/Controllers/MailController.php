<?php

namespace App\Http\Controllers;

use App\Mail\BanMail;
use App\Mail\UnbanMail;
use Illuminate\Http\Request;
use App\Mail\PaymentReceiptMail;
use App\Mail\ResetPasswordMail;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class MailController extends Controller
{
    //
    public function sentUnbanMail(Request $request, $accountID)
    {
        //Decrypt the parameter
        try {
            $accountID = Crypt::decrypt($accountID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        //get all userdetails from database  
        $userDetails = DB::table('accounts')
        ->where('account_id', $accountID)
        ->select('name', 'email')
        ->get();             
        
        $mailData = [
            'name' => $userDetails[0]->name,
            'dateTime' => date("Y/m/d h:i:s")
        ];


        //check is email sent success
        // if(Mail::to($userDetails[0]->email)->send(new UnbanMail($mailData))){ //use this
        if(Mail::to('mcgallery21@gmail.com')->send(new UnbanMail($mailData))){ //need remove
            $request->session()->put('successMessage', 'Unban email sent success.');
        }else{
            $request->session()->put('failMessage', 'Unban email sent failed.');
        }

        return redirect(route("dashboard.admin.userlist"));

    }

    public function sentBanMail(Request $request, $accountID, $reason, $duration)
    {
        //Decrypt the parameter
        try {
            $accountID = Crypt::decrypt($accountID);
            $reason = Crypt::decrypt($reason);
            $duration = Crypt::decrypt($duration);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        //get all userdetails from database  
        $userDetails = DB::table('accounts')
        ->where('account_id', $accountID)
        ->select('name', 'email')
        ->get();             
        
        $mailData = [
            'name' => $userDetails[0]->name,
            'reason' => $reason,
            'duration' => $duration,
            'dateTime' => date("Y/m/d h:i:s")
        ];


        //check is email sent success
        // if(Mail::to($userDetails[0]->email)->send(new BanMail($mailData))){ //use this
            if(Mail::to('mcgallery21@gmail.com')->send(new BanMail($mailData))){ //need remove
                $request->session()->put('successMessage', 'Ban email sent success.');
            }else{
                $request->session()->put('failMessage', 'Ban email sent failed.');
            }

        return redirect(route("dashboard.admin.userlist"));

    }

    public function sentPaymentReceiptMail(Request $request, $paymentDetails, $paymentDetailsName)
    {
        //Decrypt the parameter
        try {
            $paymentDetails = Crypt::decrypt($paymentDetails);
            $paymentDetailsName = Crypt::decrypt($paymentDetailsName);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        $account = $request->session()->get('account');
        $id = $account->account_id;
        $user = $account->role;
        
        //get all userdetails from database  
        $userDetails = DB::table('accounts')
        ->where('account_id', $id)
        ->select('name', 'email')
        ->get();             
        
        $mailData = [
            'name' => $userDetails[0]->name,
            'dateTime' => date("Y/m/d h:i:s"),
            'paymentDetails' => $paymentDetails,
            'paymentDetailsName' => $paymentDetailsName
        ];


        //check is email sent success
        // if(Mail::to($userDetails[0]->email)->send(new PaymentReceiptMail($mailData))){ //use this
            Mail::to('mcgallery21@gmail.com')->send(new PaymentReceiptMail($mailData)); //need remove


        //Display paymentDetails
        return view('dashboard/tenant/dashboard_paymentdetails', [
            'page' => 'Renting Record',
            'header' => 'Payment Receipt',
            'back' => "/dashboard/payment/index/" . Crypt::encrypt($paymentDetails[0]->renting_id),
            'paymentDetails' => $paymentDetails,
            'paymentDetailsName' => $paymentDetailsName
        ]);

    }


    public function sendResetPassword(Request $request, $accountID)
    {
        try {
            $accountID = Crypt::decrypt($accountID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        $host = $request->getHttpHost();
        $account = Account::find($accountID);
        $account->reset_password = Str::random(255);
        $account->save();

        $url = "$host/reset_password/$account->email/$account->reset_password";

        $datetime = Carbon::now();
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();

        $mailData = [
            'name' => $account->name,
            'email' => $account->email,
            'url' => $url,
            'date' => $date,
            'time' => $time
        ];
        
        Mail::to($account->email)->send(new ResetPasswordMail($mailData));

        return redirect(route('login.portal'));
    }



}
