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
            ->where('role','!=','A')
            ->where('role','!=','MA')
            ->select('account_id', 'name', 'email', 'status')
            ->get();

        return view('dashboard/admin/dashboard_userlist', [
            'user' => $user,
            'page' => $this->name,
            'header' => $this->name,
            'userList' => $userList
        ]);
    }

    public function banuser(Request $request, $accountID)
    {
        $account = $request->session()->get('account');
        $user = $account->role;

        
        //Decrypt the parameter
        try {
            $accountID = Crypt::decrypt($accountID);
            $status = Crypt::decrypt($status);
        } catch (DecryptException $ex) {
            abort('500', $ex->getMessage());
        }
        
        //update account status in database
        $updated = DB::table('accounts')
        ->where('account_id', $accountID)
        ->update(['status' => "banned"]);


        return redirect(route("dashboard.admin.userlist"));

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
        // $updated = DB::table('accounts')
        // ->where('account_id', $accountID)
        // ->update(['status' => "offline"]);

     

        //need sent email
        return redirect(URL('/mail/sentUnbanmail/' . Crypt::encrypt($accountID)));

        // $this->sendEmail($userDetails[0]->email, $message, "Your Account In EZRental Had Been Unbanned!");


        

    }

    public function sendEmail($email, $message, $title)
    {   

        //  $to = $email; //correct
         $to = "mcgallery21@gmail.com"; //need remove
         $subject = $title;  
         
         $header = "From:ezrentalofficial@gmail.com \r\n";
         $header .= "Cc:".$email." \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to, $subject, $message, $header);
         
         if( $retval == true ) {
            session()->put('successMessage', 'Success to sent email to user.');
         }else {
            session()->put('failMessage', 'Fail to sent email to user.');
         }


    }
    


}
