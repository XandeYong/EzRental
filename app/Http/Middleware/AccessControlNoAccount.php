<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessControlNoAccount
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
            $message = "You have already logged in as " . session()->get('account')['name'];
            
            session()->put('access_message_status', 'alert-warning');
            session()->put('access_message', $message);

            return redirect('/');
        }
        
        return $next($request);
    }
}
