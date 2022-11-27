<?php

namespace App\Http\Middleware;

use App\Models\Account;
use Closure;
use Illuminate\Http\Request;

class AccountControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('account')) {
            $id = session()->get('account')['account_id'];
            $account = Account::find($id);
            
            if ($account->status == 'banned') {
                $message = 'You have been redirect to homepage as your account has been banned!';
            
                session()->put('access_message_status', 'alert-danger');
                session()->put('access_message', $message);

                session()->forget('account');
    
                return redirect('/');
            }
        }

        return $next($request);
    }
}
