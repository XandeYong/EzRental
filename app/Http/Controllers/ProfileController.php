<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Security\Encryption;
use Illuminate\Http\Request;
use App\Rules\EmailValidation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\BinaryOp\Equal;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Encryption\DecryptException;

class ProfileController extends Controller
{
    //
    public $user = "Tenant"; //need edit to what xande put in session
    public $name = 'Profile';

    public function index(Request $request)
    {
        //get profile data from database  
        // $id = session::get('accountData')->account_id; 
        $id = "A6"; //need edit

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
                'age' => $age
            ]);

    }


    public function changePassword(Request $request)
    {
        // $id = session::get('accountData')->account_id; 
        $id = "A6"; //need edit
        //get passwords from Profile View  
        $newPassword = $request->input('newPassword');
        $oldPassword = $request->input('oldPassword');
        $correctOldPassword = $request->input('correctOldPassword');

        if(trim($correctOldPassword) == trim($oldPassword) && strlen($newPassword) >= 6){

        //Change password in database
        $updated = DB::table('accounts')
        ->where('account_id', $id)
        ->update(['password' => $newPassword]);

        $request->session()->put('successMessage', 'Password change success.');

        }else{
            $errorMessage = "Error Message:";

            if(strlen($newPassword) < 6){
                $errorMessage .=",*Password must have 6 value or more than 6 value!";
            }
            if(trim($correctOldPassword) != trim($oldPassword)){
                $errorMessage .=",*Invalid old password!";
            }

            $request->session()->put('errorMessage', $errorMessage);

        }

        return redirect(route("dashboard.profile"));

    }

    public function editProfileIndex() {
        //get profile data from database  
        // $id = session::get('accountData')->account_id; 
        $id = "A6"; //need edit

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
            'page' => "Edit Profile",
            'header' => "Edit Profile",
            'back' => true,
            'profile' => $profile,
            'age' => $age
        ]);

    }

    public function validateEditProfileDetails(Request $request) {

        //Laravel validation
        $request->validate([
         'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048' ],
         'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
         'gender' => ['required', 'regex:/^[M|F]$/'],
         'age' => ['required', 'numeric'],
         'phoneNumber' => ['required', 'numeric'],
         'email' => ['required',new EmailValidation]
        ]);


        $this->updateProfileInDatabase($request);


    }

    public function updateProfileInDatabase(Request $request) {
        //get profile data from database  
        // $id = session::get('accountData')->account_id; 
        $id = "A6"; //need edit

        

        

    }


    
}
