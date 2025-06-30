<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyGuestMiddleWare
{
    
    public function handle(Request $request, Closure $next)
    {
       if($request->session()->exists("user")) {
            return redirect('/');
        }else{
             return $next($request);
        }
      
    }
}
