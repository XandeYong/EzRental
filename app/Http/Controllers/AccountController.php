<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AccountController extends Controller
{
    //

    public function login(Request $request) {
        $message = "";

        $email = $request->input('email', '');
        $password = $request->input('password', '');
        $user = $request->input('role', '');
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

    public function register(Request $request) {
        $email = $request->input('email', '');
        $password = $request->input('password', '');
    }

    public function sendPasswordResetLink(Request $request) {
        $email = $request->input('forget_email', '');
        $account = Account::where('email', $email)->first();
        if (!empty($account)) {
            $account_id = $account->account_id;

            $return = [
                'accountID' => Crypt::encrypt($account_id),
            ];

            return redirect(route('mail.reset_password', $return));
        }

        return redirect(route('login.portal'));
    }

    public function resetPasswordForm($email = "", $key = "") {

        if (!empty($email) && !empty($key)) {
            $account = Account::where('email', $email)
                ->where('reset_password', $key)
                ->first();

            if (!empty($account)) {
                session()->put('reset_password_key', $account->reset_password);
                $account->reset_password = '';
                $account->save();

                $return = [
                    'email' => $email,
                    'key' => $key
                ];

                return view('login/reset_password', $return);
            }
        }

        return redirect('/');
    }

    public function resetPassword(Request $request, $email = "", $key = "") {

        $password = $request->input('password', '');

        if (!empty($email) && !empty($key) && !empty($password)) {

            $account = Account::where('email', $email)
                ->first();
                
            if (!empty($account) && (session()->has('reset_password_key') && session()->get('reset_password_key') == $key)) {
                session()->forget('reset_password_key');
                $account->password = $password;
                $account->save();

                return redirect(route('login.portal'));
            }
        }

        return redirect('/');
    }
}
