<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\BinaryOp\Equal;

class ProfileController extends Controller
{
    //
    public $user = "Tenant"; //need edit to what xande put in session
    public $name = 'Profile';

    public function index()
    {
        //get profile data from database  
        // $id = session::get('accountData')->account_id; 
        $id = "A6"; //meed edit

        $profile = DB::table('accounts')
            ->where('account_id', $id) 
            ->select('account_id', 'name', 'gender', 'dob', 'mobile_number', 'email', 'image', 'role', 'password')
            ->get();

        if ($profile->isNotEmpty()) {
        //calculate age
        $age=Carbon::parse($profile[0]->dob)->age;
        }else{
        $age=0;
        }

            return view('dashboard/dashboard_profile', [
                'user' => $this->user,
                'page' => $this->name,
                'header' => $this->name,
                'profile' => $profile,
                'age' => $age,
                'newPassError' => "",
                'oldPassError' => ""
            ]);

    }


    public function changePassword(Request $request)
    {
        //get passwords from Profile View  
        $newPassword = $request->input('newPassword');
        $oldPassword = $request->input('oldPassword');
        $correctOldPassword = $request->input('correctOldPassword');

        if(trim($correctOldPassword) == trim($oldPassword) && strlen($newPassword) >= 6){
            return redirect(route("dashboard.profile"));

        }else{
            $newPassError = "";
            $oldPassError = "";

            if(strlen($newPassword) < 6){
                $newPassError="*Password must have 6 value or more than 6 value!";
            }
            if(trim($correctOldPassword) == trim($oldPassword)){
                $oldPassError="*Invalid old password!";
            }
            return redirect(route("/dashboard/profile/errMsgDisChgPass. '/' .$newPassError. '/' .$oldPassError"));


        }


    }


    public function errMsgDisChgPass($newPassError,  $oldPassError)
    {
        //get profile data from database  
        // $id = session::get('accountData')->account_id; 
        $id = "A6"; //meed edit

        $profile = DB::table('accounts')
            ->where('account_id', $id) 
            ->select('account_id', 'name', 'gender', 'dob', 'mobile_number', 'email', 'image', 'role', 'password')
            ->get();

            if ($profile->isNotEmpty()) {
            //calculate age
            $age=Carbon::parse($profile[0]->dob)->age;
            }else{
            $age=0;
            }

            return view('dashboard/dashboard_profile', [
                'user' => $this->user,
                'page' => $this->name,
                'header' => $this->name,
                'profile' => $profile,
                'age' => $age,
                'newPassError' => $newPassError,
                'oldPassError' => $oldPassError
            ]);

    }

    public function editProfile() {
        $id = "A6"; //meed edit

        $profile = DB::table('accounts')
            ->where('account_id', $id) 
            ->select('account_id', 'name', 'gender', 'dob', 'mobile_number', 'email', 'image', 'role', 'password')
            ->get();

        if ($profile->isNotEmpty()) {
            //calculate age
            $age=Carbon::parse($profile[0]->dob)->age;
        }else{
            $age=0;
        }

        return view('dashboard/dashboard_profile_edit', [
            'user' => $this->user,
            'page' => $this->name,
            'header' => "Edit Profile",
            'profile' => $profile,
            'age' => $age
        ]);

    }




    
}
