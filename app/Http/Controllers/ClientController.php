<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Request;
use Input;
use DB;

class ClientController extends Controller
{
    
    public function create_client(){

    	return view('client.create_client');


    }
    public function insert_client(){



    	$client_name = Request::get('client_name');
    	$client_priority = Request::get('client_priority');
    	$kam = Request::get('kam');
    	$email = Request::get('email');
    	$phone = Request::get('phone');
    	$client_type = Request::get('client_type');

    	$client_insert_query = "INSERT INTO phoenix_tt_db.client_table (client_name,priority,kam_name,email,phone,client_type) VALUES ('$client_name','$client_priority','$kam','$email','$phone','$client_type')";

    	\DB::insert(\DB::raw($client_insert_query));


    	return redirect('view_client');
    	

    }
    public function view_client(){

    	$client_name = Request::get('client_name');
    	$client_priority = Request::get('client_priority');
    	$kam = Request::get('kam');
    	$email = Request::get('email');
    	$phone = Request::get('phone');
    	$client_type = Request::get('client_type');	

    	$whereQuery = "";

    	if($client_name){

    		$whereQuery.= "client_name like '%$client_name%' AND ";

    	}
    	if($client_priority){

    		$whereQuery.= "priority like '%$client_priority%' AND ";

    	}
    	if($kam){

    		$whereQuery.= "kam_name like '%$kam%' AND ";

    	}
     	if($email){

    		$whereQuery.= "email like '%$email%' AND ";

    	}
    	if($phone){

    		$whereQuery.= "phone like '%$phone%' AND ";

    	}
    	if($client_type){

    		$whereQuery.= "client_type like '%$client_type%' AND ";

    	}



    	if($whereQuery==""){

    		    $client_lists = DB::table('phoenix_tt_db.client_table')
    						    ->selectRaw('phoenix_tt_db.client_table.*')
    						    ->whereRaw("client_id<0")
    						    ->paginate(20);
    	}

    	else{
    			// $whereQuery = trim($whereQuery,"AND ");
    			$whereQuery .= "flag!='Disabled'";
    		    $client_lists = DB::table('phoenix_tt_db.client_table')
    						    ->selectRaw('phoenix_tt_db.client_table.*')
    						    ->whereRaw("$whereQuery")
    						    ->paginate(20);

    	}  	    	

    	return view('client.view_client',compact('client_lists'));
    }

    public function delete_client(){

    	$client_id = Request::get('client_id');

    	$client_update_query = "UPDATE phoenix_tt_db.client_table SET flag='Disabled' WHERE client_id='$client_id'";

    	\DB::update(\DB::raw($client_update_query));

    	return redirect('view_client');
    }

    public function edit_client(){

    	$client_id = Request::get('client_id');

    	$client_select_query = "SELECT * FROM phoenix_tt_db.client_table where client_id='$client_id'";
    	$client_lists = \DB::select(\DB::raw($client_select_query));

    	return view('client.edit_client',compact('client_lists'));
    }

    public function update_client(){

    	$client_id = Request::get('client_id');
    	$client_name = Request::get('client_name');
    	$client_priority = Request::get('client_priority');
    	$kam = Request::get('kam');
    	$email = Request::get('email');
    	$phone = Request::get('phone');
    	$client_type = Request::get('client_type');

    	$client_update_query = "UPDATE phoenix_tt_db.client_table SET client_name='$client_name',priority='$client_priority',kam_name='$kam',email='$email',phone='$phone',client_type='$client_type' where client_id='$client_id'";

    	\DB::update(\DB::raw($client_update_query));


    	return redirect('view_client');
    	


    }



    
}
