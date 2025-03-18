<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notification;


class CheckSession
{
    public function handle(Request $request, Closure $next): Response
    {
        // if (session()->has('id')) {
        //     return redirect('/home');
        // }

        return $next($request);        
    }
}

