<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use App\AccessModel;
use Illuminate\Http\Request;
use App\Http\Requests;

if(!isset($_SESSION)) 
{ 
    session_start(); 

} 
// session_start();

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            $accesses = AccessModel::where('user_id', $user_id)->get();
            if($accesses[0]['type'] == 'admin'){
                return $next($request);
            }
            else{
                return redirect('/');
            }
        }  
        return $next($request);
    }
}
