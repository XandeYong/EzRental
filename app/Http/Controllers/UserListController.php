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
        // $request->validate([
        //     'accountId' => ['required', 'max:255']
        // ]);

        $account = $request->session()->get('account');
        $user = $account->role;

        //get accountID from search field in User List 
        $accountID = trim($request->input('accountId'));


        $pattern = "/^[A|a]{1}[0-9]+$/";
        preg_match($pattern, $accountID);

        if (strlen($accountID) <= 255 && preg_match($pattern, $accountID)) {

        //get all userlist from database  
        $userList = DB::table('accounts')
            ->where('role', '!=', 'A')
            ->where('role', '!=', 'MA')
            ->where('account_id', $accountID)
            ->select('account_id', 'name', 'email', 'status')
            ->get();

        } else {
            $errorMessage = "Error Message:";
            $errorMessage .= ",*Input cannot be more than 255 characters!";


            $pattern = "/^[A|a]{1}[0-9]+$/";
            preg_match($pattern, $accountID);

            if (preg_match($pattern, $accountID) == 0) {
                $errorMessage .= ",*Invalid format!";
            }

            $request->session()->put('errorMessage', $errorMessage);
        }




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
            'duration' => ['required', 'numeric', 'max:255'],
            'reason' => ['required', 'max:255']
        ]);


        //get accountID from search field in User List 
        $accountID = trim($request->input('accountID'));
        $reason = trim($request->input('reason'));
        $duration = trim($request->input('duration'));

        //getLatestBanRecordsID
        $latestBanRecordID = $this->getLatestBanRecordsID();

        //make new BanRecordsID
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
        return redirect(URL('/mail/sentBanMail/' . Crypt::encrypt($accountID) . "/" .  Crypt::encrypt($reason) . "/" . Crypt::encrypt($duration)));
    }


    public function getLatestBanRecordsID()
    {
        $banRecordID = DB::table('ban_records')
            ->select('ban_id')
            ->whereRaw("CHAR_LENGTH(ban_id) = (SELECT MAX(CHAR_LENGTH(ban_id)) from ban_records)")
            ->orderByDesc('ban_id')
            ->distinct()
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
            ->where('status', 'banned')
            ->update(['status' => "unbanned"]);


        //need sent email
        return redirect(URL('/mail/sentUnbanMail/' . Crypt::encrypt($accountID)));
    }
}
