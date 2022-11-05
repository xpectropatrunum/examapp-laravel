<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        if(str_contains($request->route()->getPrefix(), 'api')){
            if(!$request->expectsJson()){
                return route("api");
    
            }
        }else{
            if(!Auth::guard('admin')->check() && !Auth::guard('expert')->check()){
                return route("admin.login");
    
            }
        }
     
      
        
       
       
    }
}
