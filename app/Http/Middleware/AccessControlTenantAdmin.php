<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessControlTenantAdmin
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
        if (!session()->has('account')  
        || (session()->get('account')['role'] != 'T'
        && session()->get('account')['role'] != 'A'
        && session()->get('account')['role'] != 'MA')
        ) 
        {
            $message = 'You have been redirect to homepage as unauthorized access has been detected!';
            
            session()->put('access_message_status', 'alert-danger');
            session()->put('access_message', $message);

            return redirect('/');
        }

        return $next($request);
    }
}
