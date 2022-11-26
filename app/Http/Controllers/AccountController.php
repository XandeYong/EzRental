<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Rules\EmailValidation;
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

        $route = route('login.portal');
        $roleValidation = 'Tenant|Owner';
        if (session()->has('account') && session()->get('account')['role'] == 'MA') {
            $route = route('dashboard.admin.register_admin');
            $roleValidation = 'Admin';
        }

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'min:5', 'max:255'],
            'gender' => ['required', 'regex:/^[M|F]$/'],
            'dob' => ['required', 'date', 'before:13 years ago'],
            'phoneNumber' => ['required', 'numeric'],
            'email' => ['required', new EmailValidation, 'max:255'],
            'password' => ['required', 'min:6', 'max:255'],
            'role' => ["regex:/^($roleValidation)$/"],
        ]);


        $insert['account_id'] = $this->generateID(Account::class);
        $insert['name'] = $name = $request->input('name', '');
        $insert['gender'] = $gender = $request->input('gender', '');
        $insert['dob'] = $dob = $request->input('dob', '');
        $insert['mobile_number'] = $phoneNumber = $request->input('phoneNumber', '');
        $insert['email'] = $email = $request->input('email', '');
        $insert['password'] = $password = $request->input('password', '');
        $insert['image'] = $image = 'profile.png';
        $insert['status'] = $status = 'offline';
        $insert['role'] = $role = $request->input('role', '')[0];
        
        if (empty(Account::where('email', $email)->first())) {
            Account::insert($insert);
            session()->put('access_message_status', 'alert-success');
            session()->put('access_message', 'Account has been created');
        } else {
            session()->put('access_message_status', 'alert-danger');
            session()->put('access_message', 'Email has been registered before, please pick a new email.');
        }

        if ($role == 'T') {
            $route = route('login.tenant');
        } elseif ($role == 'O') {
            $route = route('login.owner');
        }

        return redirect($route);
    }

    public function sendPasswordResetLink(Request $request) {
        $email = $request->input('forget_email', '');
        $user = $request->input('role', '');

        $account = Account::where('email', $email)->first();
        if (!empty($account)) {
            $account_id = $account->account_id;

            $return = [
                'accountID' => Crypt::encrypt($account_id),
            ];

            return redirect(route('mail.reset_password', $return));
        }
        
        if ($user == 'Tenant') {
            $route = route('login.tenant');
        } elseif ($user == 'Owner') {
            $route = route('login.owner');
        } elseif ($user == 'Admin') {
            $route = route('login.admin');
        } else {
            $route = route('login.portal');
        }

        return redirect($route);
    }

    public function resetPasswordForm($email = "", $key = "") {

        if (!empty($email) && !empty($key)) {
            $account = Account::where('email', $email)
                ->where('reset_password', $key)
                ->first();

            if (!empty($account) || session()->has('reset_password_key')) {
                if (!session()->has('reset_password_key')) {
                    session()->put('reset_password_key', $account->reset_password);
                    $account->reset_password = '';
                    $account->save();
                } else {
                    $key = session()->get('reset_password_key');
                }
                
                $return = [
                    'email' => $email,
                    'key' => $key
                ];

                return view('login/reset_password', $return);
            } else {
                session()->put('access_message', 'The link you are trying to access is no longer available.');
            }
        }

        return redirect('/');
    }

    public function resetPassword(Request $request, $email = "", $key = "") {

        $request->validate([
            'password' => ['required', 'min:6', 'max:255']
        ]);

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

    //Custom fucntion
    public function generateID($model)
    {
        $table = $model::$tableName;
        $idCol = $model::$idColumn;
        $idCode = $model::$idCode;
        $idCodeLength = strlen($idCode);

        $newID = $model::select($idCol)
            ->whereRaw("CHAR_LENGTH($idCol) = (SELECT MAX(CHAR_LENGTH($idCol)) from $table)")
            ->orderByDesc($idCol)
            ->distinct()
            ->first();
            
        if (empty($newID)) {
            return $idCode . '1';
        } else {
            $newID = $newID->$idCol;
            $idCode = substr($newID, 0, $idCodeLength);
            $id = intval(substr($newID, $idCodeLength) + 1);
            $newID = $idCode . $id;
        }

        return $newID;
    }

}
