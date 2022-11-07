<?php

namespace App\Http\Controllers;

use App\Mail\BanMail;
use App\Mail\UnbanMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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
                $request->session()->put('successMessage', 'Unban email sent success.');
            }else{
                $request->session()->put('failMessage', 'Unban email sent failed.');
            }

        return redirect(route("dashboard.admin.userlist"));

    }



}
