<?php

namespace App\Http\Controllers;

use App\Mail\UnbanMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class MailController extends Controller
{
    //
    public function sentUnbanMail($accountID)
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

         
        // Mail::to($userDetails[0]->email)->send(new UnbanMail($mailData));
        Mail::to("mcgallery21@gmail.com")->send(new UnbanMail($mailData)); //need remove
           

         dd("Email is sent successfully.");
        return redirect(route("dashboard.admin.userlist"));

    }



}
