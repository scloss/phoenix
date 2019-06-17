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

class ClassB
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
            $accesses_query = "SELECT * FROM phoenix_tt_db.access_table WHERE user_id='$user_id'";
            $accesses = \DB::select(\DB::raw($accesses_query));
            if($accesses[0]->type == 'A' || $accesses[0]->type == 'B' || $accesses[0]->type == 'EA' || $accesses[0]->type == 'SL'){
                return $next($request);
            }
            else{
                return redirect('restricted');
            }
        }  
        return redirect('/');
    }
}
