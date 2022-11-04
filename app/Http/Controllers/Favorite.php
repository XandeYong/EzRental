<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Favorite extends Controller
{
    //
    public function index(Request $request)
    {
        //get profile data from database  
        $account = $request->session()->get('account'); //session()->get('accountData')->account_id;
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
            'user' => $user,
            'page' => $this->name,
            'header' => $this->name,
            'profile' => $profile,
            'age' => $age
        ]);
    }

}
