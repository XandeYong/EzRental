<?php

namespace App\Http\Controllers;

use App\Mail\UnbanMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class TestController extends Controller
{
    //
    public $name = 'Test for All Auto Function';

    //Auto unbanned user when durration arrived Function
    public function autoUnbannedUser(Request $request)
    {
        $account = $request->session()->get('account');
        $id = $account->account_id;
        $user = $account->role;

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

                // dd($date, $banRecords[$i]->duration, $unbannedDate);
                //get current date
                $currentDate = date("Y-m-d");

                if ($currentDate >= $unbannedDate) {
                    //update to unbanned as the unbanned date arrived in database 
                    $updated = DB::table('ban_records')
                        ->join('accounts', 'accounts.account_id', '=', 'accounts.account_id')
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
        // Mail::to($userDetails[0]->email)->send(new UnbanMail($mailData)); //use this
        Mail::to("mcgallery21@gmail.com")->send(new UnbanMail($mailData)); //remove this
    }





















    
}
