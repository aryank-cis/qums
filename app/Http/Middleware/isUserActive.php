<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the account is active (both department and status are valid)
        if (auth()->user()->department !== null && auth()->user()->department !== 0 && 
            auth()->user()->status !== null && auth()->user()->status !== 0) {
            session()->forget('account-error');
            return $next($request);
        }
    
        return redirect()->back()->with('account-error', 'Your account is not activated! Please contact your Administrator.');
    }
    

}
