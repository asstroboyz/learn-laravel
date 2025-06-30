<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyMemberMiddleware
{
   
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->exists("user")) {
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
