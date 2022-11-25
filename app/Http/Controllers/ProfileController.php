<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Account;
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
    public $name = 'Profile';

    public function index(Request $request)
    {
        //get profile data from database  
        $account = $request->session()->get('account'); 
        $id = $account->account_id;
        $user = $account->role;

        $profile = DB::table('accounts')
            ->where('account_id', $id)
            ->select('account_id', 'name', 'gender', 'dob', 'mobile_number', 'email', 'image', 'role', 'password')
            ->get();

        if ($profile->isNotEmpty()) {
            //calculate age
            $age = Carbon::parse($profile[0]->dob)->age;
        } else {
            $age = 0;
        }
        return view('dashboard/dashboard_profile', [
            'page' => $this->name,
            'header' => $this->name,
            'profile' => $profile,
            'age' => $age
        ]);
    }


    public function changePassword(Request $request)
    {
        $account = $request->session()->get('account');
        $id = $account->account_id;

        //get passwords from Profile View  
        $newPassword = $request->input('newPassword');
        $oldPassword = $request->input('oldPassword');
        $correctOldPassword = $request->input('correctOldPassword');

        if (trim($correctOldPassword) == trim($oldPassword) && strlen($newPassword) >= 6) {

            //Change password in database
            $updated = DB::table('accounts')
                ->where('account_id', $id)
                ->update(['password' => $newPassword]);

            $request->session()->put('successMessage', 'Password change success.');
        } else {
            $errorMessage = "Error Message:";

            if (strlen($newPassword) < 6) {
                $errorMessage .= ",*Password must have 6 value or more than 6 value!";
            }
            if (trim($correctOldPassword) != trim($oldPassword)) {
                $errorMessage .= ",*Invalid old password!";
            }

            $request->session()->put('errorMessage', $errorMessage);
        }

        return redirect(route("dashboard.profile"));
    }

    public function editProfileIndex(Request $request)
    {
        //get profile data from database  
        $account = $request->session()->get('account');
        $id = $account->account_id;
        $user = $account->role;

        $profile = DB::table('accounts')
            ->where('account_id', $id)
            ->select('account_id', 'name', 'gender', 'dob', 'mobile_number', 'email', 'image', 'role', 'password')
            ->get();

        return view('dashboard/dashboard_profile_edit', [
            'page' => $this->name,
            'header' => "Edit Profile",
            'back' => "/dashboard/profile/index",
            'profile' => $profile
        ]);
    }

    public function updateProfileInDatabase(Request $request)
    {

        //Laravel validation
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:20480'],
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
            'gender' => ['required', 'regex:/^[M|F]$/'],
            'dob' => ['required', 'date', 'before:13 years ago'],
            'phoneNumber' => ['required', 'numeric'],
            'email' => ['required', new EmailValidation, 'max:255']
        ]);


        //
        $account = $request->session()->get('account');
        $id = $account->account_id;
        //get edit profile details from Edit Profile View  
        $imageName = $request->input('oriImage');
        $name = $request->input('name');
        $gender = $request->input('gender');
        $dob = $request->input('dob');
        $phoneNumber = $request->input('phoneNumber');
        $email = $request->input('email');

        
        //check is image file empty
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $id.".".$image->getClientOriginalExtension();
            $request->file('image')->move(public_path().'/image/account/', $imageName);
            //for if same image file name
            $status=true;
        }else{
            $status=false;
        }

        
        //update profile in database
        $updated = DB::table('accounts')
            ->where('account_id', $id)
            ->update(['name' => $name, 'image' => $imageName, 'gender' => $gender, 'dob' => $dob, 'mobile_number' => $phoneNumber, 'email' => $email]);

        if ($updated > 0 || $status==true) {
            $request->session()->put('successMessage', 'Profile update success.');

            //get new account details
            $newAccountDetails = Account::where('account_id', $id)
            ->first();

            //Update account Session data
            $newAccountDetails->password = "";
            $request->session()->put('account', $newAccountDetails);

        } else {
            $request->session()->put('failMessage', 'Profile update failed because nothing to change.');
        }


        return redirect(route("dashboard.profile"));
    }






}
