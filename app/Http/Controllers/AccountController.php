<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    //

    public function login(Request $request) {
        $message = "";

        $email = $request->input('email');
        $password = $request->input('password');
        $user = $request->input('role');
        $role = $user[0];

        $account = Account::where('email', $email)
            ->where('password', $password)
            ->first();

        if ($account) {

            if ($account->role == $role || $account->role == "MA") {
                $account->status = "online";
                $account->save();

                $account->password = "";
                $request->session()->put('account', $account);

                // dd($request->session()->get('account'));
                $message = "Welcome back! " . $account->name;
                $request->session()->put('login_message', $message);
                return redirect(route('dashboard.' . strToLower($user)));
            } else {
                $message = "Have you login into a wrong login portal?";
            }

        } else {
            $message = "Either your email or password is incorrect.";
        }

        return redirect(route('login.' . strToLower($user)))->with('error_msg', $message);

    }
}
