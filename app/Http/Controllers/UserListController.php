<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UserListController extends Controller
{
    //
    public $name = 'User List';

    public function index(Request $request)
    {
        $account = $request->session()->get('account');
        $user = $account->role;

        //get all userlist from database  
        $userList = DB::table('accounts')
            ->where('role', '!=', 'A')
            ->where('role', '!=', 'MA')
            ->select('account_id', 'name', 'email', 'status')
            ->get();

        return view('dashboard/admin/dashboard_userlist', [
            'user' => $user,
            'page' => $this->name,
            'header' => $this->name,
            'userList' => $userList
        ]);
    }

    public function filterUserList(Request $request, $filter)
    {
        $account = $request->session()->get('account');
        $user = $account->role;

        //Decrypt the parameter
        try {
            $filter = Crypt::decrypt($filter);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }
        if ($filter == "banned") {
            //get all userlist from database with status banned  
            $userList = DB::table('accounts')
                ->where('role', '!=', 'A')
                ->where('role', '!=', 'MA')
                ->where('status', 'banned')
                ->select('account_id', 'name', 'email', 'status')
                ->get();
        } else {
            //get all userlist from database  with status not banned  
            $userList = DB::table('accounts')
                ->where('role', '!=', 'A')
                ->where('role', '!=', 'MA')
                ->where('status', '!=', 'banned')
                ->select('account_id', 'name', 'email', 'status')
                ->get();
        }



        return view('dashboard/admin/dashboard_userlist', [
            'user' => $user,
            'page' => $this->name,
            'header' => $this->name,
            'userList' => $userList
        ]);
    }

    public function searchUser(Request $request)
    {
        //Laravel validation
        $request->validate([
            'accountId' => ['required', 'regex:/^[A|a]{1}[0-9]+$/']
        ]);

        $account = $request->session()->get('account');
        $user = $account->role;

        //get accountID from search field in User List 
        $accountID = trim($request->input('accountId'));


        //get all userlist from database  
        $userList = DB::table('accounts')
            ->where('role', '!=', 'A')
            ->where('role', '!=', 'MA')
            ->where('account_id', $accountID)
            ->select('account_id', 'name', 'email', 'status')
            ->get();

        return view('dashboard/admin/dashboard_userlist', [
            'user' => $user,
            'page' => $this->name,
            'header' => $this->name,
            'userList' => $userList
        ]);
    }



    public function banuser(Request $request)
    {
        //Laravel validation
        $request->validate([
            'duration' => ['required', 'numeric'],
            'reason' => ['required']
        ]);


        //get accountID from search field in User List 
        $accountID = trim($request->input('accountID'));
        $reason = trim($request->input('reason'));
        $duration = trim($request->input('duration'));

         //getLatestOrderID
         $latestBanRecordID = $this->getLatestBanRecordsID();

         //make new orderID
         $newBanRecordID = $this->banRecordID($latestBanRecordID);  
        

        //update ban records in database
        DB::table('ban_records')->insert([
            'ban_id' => $newBanRecordID,
            'reason' => $reason,
            'duration' => $duration,
            'status' => "banned",
            'account_id' => $accountID
        ]);     


        //update account status in database
        $updated = DB::table('accounts')
            ->where('account_id', $accountID)
            ->update(['status' => "banned"]);


        //need sent email
        return redirect(URL('/mail/sentBanMail/' . Crypt::encrypt($accountID) . "/" .  Crypt::encrypt($reason) . "/" . Crypt::encrypt($duration) ));
    }


    public function getLatestBanRecordsID()
    {
        $banRecordID = DB::table('ban_records')
            ->orderBy('created_at', 'desc')
            ->select('ban_id')
            ->get();

        if ($banRecordID->isEmpty()) {
            return "BR0";
        }
        return $banRecordID[0]->ban_id;
    }

    //add 1 to ID to make new ID 
    private function banRecordID($value)
    {
        $result = substr($value, 2);

        //parse result to int
        $ans = ((int)$result) + 1;

        //combine char and int into string
        $result = "BR" . ((string)$ans);

        return $result;
    }



    public function unbanuser($accountID)
    {
        //Decrypt the parameter
        try {
            $accountID = Crypt::decrypt($accountID);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }

        //update account status in database
        $updated = DB::table('accounts')
            ->where('account_id', $accountID)
            ->update(['status' => "offline"]);

        //update ban_records status in database
        $updated = DB::table('ban_records')
            ->where('account_id', $accountID)
            ->update(['status' => "unbanned"]);


        //need sent email
        return redirect(URL('/mail/sentUnbanMail/' . Crypt::encrypt($accountID)));
    }







}
