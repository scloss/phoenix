<?php

namespace App\Http\Controllers;

use App\posts_table;
use App\image_table;
use File;
use DB;
use Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Input;
use DateTime;
use Zipper;
use App\Http\Controllers\LogController;
use AccessTable;
use App\AccessModel;
use App\unms_table;
//header("Content-Type: application/json; charset=UTF-8");

class PhoenixController extends Controller
{

	/************************************OUTAGE ALL******************************************************/
	public function onuserver_api_outage_summary(){
		$url = "http://172.16.136.35/outage/api/api_site_down.php";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$node_label_arr = array();
		
		for($i=0;$i<count($json_data);$i++){
			array_push($node_label_arr, $json_data[$i]['nodelabel']);
		}
		
		$total_site_down_str = implode("','", $node_label_arr);
		$select_site_down_with_region_query = "SELECT site_name,region FROM phoenix_tt_db.site_table WHERE site_name IN ('".$total_site_down_str."')";
		$site_region_lists = \DB::select(\DB::raw($select_site_down_with_region_query));
		
		$select_site_down_with_region_group_query = "SELECT region,count(site_name) as counted_val FROM phoenix_tt_db.site_table WHERE site_name IN ('".$total_site_down_str."') GROUP BY region";
		$site_region_group_lists = \DB::select(\DB::raw($select_site_down_with_region_group_query));
		$total_site_down_count = count($site_region_lists);

		if($total_site_down_count > 0){
			$outage_all_str = 'Total Site Down : '.$total_site_down_count.' ';

			foreach($site_region_group_lists as $site_region_group_list){
				$outage_all_str .= '( '.$site_region_group_list->region.' : '.$site_region_group_list->counted_val.' )';
			}

			return json_encode($outage_all_str);
		}
		else{
			$outage_all_str = 'No Outage Found';
			return json_encode($outage_all_str);
		}
	}


	/************************************OUTAGE SUMMARY******************************************************/
	public function onuserver_api_outage_all(){
		$url = "http://172.16.136.35/outage/api/api_site_down.php";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$node_label_arr = array();
		
		for($i=0;$i<count($json_data);$i++){
			array_push($node_label_arr, $json_data[$i]['nodelabel']);
		}
		
		$total_site_down_str = implode("','", $node_label_arr);
		$select_site_down_with_region_query = "SELECT site_name,region FROM phoenix_tt_db.site_table WHERE site_name IN ('".$total_site_down_str."')";
		$site_region_lists = \DB::select(\DB::raw($select_site_down_with_region_query));
		
		$select_site_down_with_region_group_query = "SELECT region,group_concat(site_name) as site_name FROM phoenix_tt_db.site_table WHERE site_name IN ('".$total_site_down_str."') GROUP BY region";
		$site_region_group_lists = \DB::select(\DB::raw($select_site_down_with_region_group_query));
		$total_site_down_count = count($site_region_lists);

		//return $site_region_group_lists;

		if($total_site_down_count > 0){
			$outage_all_str = 'Total Site Down : '.$total_site_down_count.' ';

			foreach($site_region_group_lists as $site_region_group_list){
				$outage_all_str .= '( '.$site_region_group_list->region.' : '.$site_region_group_list->site_name.' )';
			}

			return json_encode($outage_all_str);
		}
		else{
			$outage_all_str = 'No Outage Found';
			return json_encode($outage_all_str);
		}
	}

	/************************************OUTAGE (DISTRICT NAME)******************************************************/

	public function onuserver_api_outage_district(){
		$district =  Request::get("district");

		$url = "http://172.16.136.35/outage/api/api_site_down.php";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$node_label_arr = array();
		
		for($i=0;$i<count($json_data);$i++){
			array_push($node_label_arr, $json_data[$i]['nodelabel']);
		}
		
		$total_site_down_str = implode("','", $node_label_arr);
		$select_site_down_with_district_query = "SELECT site_name,district FROM phoenix_tt_db.site_table WHERE site_name IN ('".$total_site_down_str."') AND district='$district'";
		$site_district_lists = \DB::select(\DB::raw($select_site_down_with_district_query));
		
		$select_site_down_with_district_group_query = "SELECT district,count(site_name) as counted_val FROM phoenix_tt_db.site_table WHERE site_name IN ('".$total_site_down_str."') AND district='$district' group by district";
		$site_district_group_lists = \DB::select(\DB::raw($select_site_down_with_district_group_query));
		$total_site_down_count = count($site_district_lists);

		if($total_site_down_count > 0){
			$outage_all_str = 'Total Site Down : '.$total_site_down_count.' ';

			foreach($site_district_group_lists as $site_district_group_list){
				$outage_all_str .= '( '.$site_district_group_list->district.' : '.$site_district_group_list->counted_val.' )';
			}

			return json_encode($outage_all_str);
		}
		else{
			$outage_all_str = 'No Outage Found';
			return json_encode($outage_all_str);
		}

	}

	/****************************************OUTAGE (SITE NAME)********************************************************************/

	public function onuserver_api_outage_site(){
		$sitename =  Request::get("sitename");

		$url = "http://172.16.136.35/outage/api/api_site_down.php";
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		$node_label_arr = array();
		
		for($i=0;$i<count($json_data);$i++){
			array_push($node_label_arr, $json_data[$i]['nodelabel']);
		}
		
		if(in_array($sitename,$node_label_arr)){
			$text = 'Site is down at the moment';
			return json_encode($text);
		}
		else{
			$text = 'No Site is down with this name';
			return json_encode($text);
		}

	}

	/****************************************OH LINK STATUS********************************************************************/

	public function onuserver_api_outage_oh_link(){

		$select_oh_link_query = "SELECT element_id FROM phoenix_tt_db.outage_table WHERE link_type='OH' AND element_type='link' AND problem_category='Link Down' and ( not find_in_set('34',assigned_dept)) and ( not find_in_set('35',assigned_dept)) and ( not find_in_set('36',assigned_dept)) and ( not find_in_set('43',assigned_dept))";

		$oh_link_lists = \DB::select(\DB::raw($select_oh_link_query));

		$element_id_arr = array();
		foreach($oh_link_lists as $oh_link_list){
			array_push($element_id_arr, $oh_link_list->element_id);
		}
		$element_id_str = implode(',', $element_id_arr);

		$select_link_down_query = "SELECT link_name_id FROM phoenix_tt_db.link_table WHERE link_name_id IN (".$element_id_str.")";
		$link_lists = \DB::select(\DB::raw($select_link_down_query));

		$select_link_down_with_region_group_query = "SELECT region,count(link_name_id) as counted_val FROM phoenix_tt_db.link_table WHERE link_name_id IN (".$element_id_str.") GROUP BY region";
		$link_region_group_lists = \DB::select(\DB::raw($select_link_down_with_region_group_query));
		//echo $element_id_str;
		//return $select_link_down_with_region_group_query;
		$total_link_down_count = count($link_lists);

		if($total_link_down_count > 0){
			$outage_all_str = 'Total OH Link Down : '.$total_link_down_count.' ';

			foreach($link_region_group_lists as $link_region_group_list){
				$outage_all_str .= '( '.$link_region_group_list->region.' : '.$link_region_group_list->counted_val.' )';
			}

			return json_encode($outage_all_str);
		}
		else{
			$outage_all_str = 'No Outage Found';
			return json_encode($outage_all_str);
		}
		

	}


	/****************************************POWER ALARM STATUS********************************************************************/

	public function onuserver_api_outage_power_alarm(){

		$select_power_alarm_query = "SELECT element_id FROM phoenix_tt_db.outage_table WHERE link_type='Env Alarm'";

		$power_alarm_lists = \DB::select(\DB::raw($select_power_alarm_query));

		$element_id_arr = array();
		foreach($power_alarm_lists as $power_alarm_list){
			array_push($element_id_arr, $power_alarm_list->element_id);
		}
		$element_id_str = implode(',', $element_id_arr);

		$select_power_alarm_query = "SELECT link_name_id FROM phoenix_tt_db.link_table WHERE link_name_id IN (".$element_id_str.")";
		$power_alarm_lists = \DB::select(\DB::raw($select_power_alarm_query));

		$select_power_alarm_with_region_group_query = "SELECT region,count(link_name_id) as counted_val FROM phoenix_tt_db.link_table WHERE link_name_id IN (".$element_id_str.") GROUP BY region";
		$power_region_group_lists = \DB::select(\DB::raw($select_power_alarm_with_region_group_query));
		//echo $element_id_str;
		//return $select_power_alarm_with_region_group_query;
		$total_power_alarm_count = count($power_alarm_lists);

		if($total_power_alarm_count > 0){
			$outage_all_str = 'Total Power Alarm : '.$total_power_alarm_count.' ';

			foreach($power_region_group_lists as $power_region_group_list){
				$outage_all_str .= '( '.$power_region_group_list->region.' : '.$power_region_group_list->counted_val.' )';
			}

			return json_encode($outage_all_str);
		}
		else{
			$outage_all_str = 'No Outage Found';
			return json_encode($outage_all_str);
		}
		

	}



	/****************************************IIG ISSUE********************************************************************/

	public function onuserver_api_outage_iig_issue(){

		$select_iig_issue_query = "SELECT element_id,element_type FROM phoenix_tt_db.outage_table WHERE issue_type='IIG'";

		$iig_issue_lists = \DB::select(\DB::raw($select_iig_issue_query));

		$element_id_link_arr = array();
		$element_id_site_arr = array();
		foreach($iig_issue_lists as $iig_issue_list){
			if($iig_issue_list->element_type == 'link'){
				array_push($element_id_link_arr, $iig_issue_list->element_id);
			}
			else{
				array_push($element_id_site_arr, $iig_issue_list->element_id);
			}
			
		}
		$element_id_link_str = implode(',', $element_id_link_arr);
		$element_id_site_str = implode(',', $element_id_site_arr);
		$outage_all_str_site = '';
		$outage_all_str_link = '';
		$total_iig_issue_count = 0;

		if(count($element_id_site_arr) > 0){
			$select_site_iig_issue_query = "SELECT site_name_id FROM phoenix_tt_db.site_table WHERE site_name_id IN (".$element_id_site_str.")";
			$site_iig_issue_lists = \DB::select(\DB::raw($select_site_iig_issue_query));

			$select_site_iig_issue_with_region_group_query = "SELECT site_name_id FROM phoenix_tt_db.site_table WHERE site_name_id IN (".$element_id_site_str.")";
			$site_iig_issue_group_lists = \DB::select(\DB::raw($select_site_iig_issue_with_region_group_query));
			$outage_all_str_site .= ' Site Down : ';
			foreach($site_iig_issue_group_lists as $site_iig_issue_group_list){
				$outage_all_str_site .= '( '.$site_iig_issue_group_lists->site_name_id.' ),';
			}
			$total_iig_issue_count =  $total_iig_issue_count + count($site_iig_issue_lists);
		}
		if(count($element_id_link_arr) > 0){
			$select_link_iig_issue_query = "SELECT link_name_id FROM phoenix_tt_db.link_table WHERE link_name_id IN (".$element_id_link_str.")";
			$site_iig_issue_lists = \DB::select(\DB::raw($select_link_iig_issue_query));

			$select_link_iig_issue_with_region_group_query = "SELECT link_name_nttn,link_name_gateway FROM phoenix_tt_db.link_table WHERE link_name_id IN (".$element_id_link_str.") ";
			$link_iig_issue_group_lists = \DB::select(\DB::raw($select_link_iig_issue_with_region_group_query));

			$outage_all_str_link .= ' Link Down : ';
			foreach($link_iig_issue_group_lists as $link_iig_issue_group_list){
				$outage_all_str_link .= '( '.$link_iig_issue_group_list->link_name_nttn.','.$link_iig_issue_group_list->link_name_gateway.' ),';
			}
			$total_iig_issue_count =  $total_iig_issue_count + count($site_iig_issue_lists);
		}

		
		//echo $element_id_str;
		//return $select_power_alarm_with_region_group_query;
		//$total_iig_issue_count = count($site_iig_issue_lists) + count($link_iig_issue_lists);

		if($total_iig_issue_count > 0){
			$outage_all_str = 'Total IIG ISSUE : '.$total_iig_issue_count.$outage_all_str_site.$outage_all_str_link;
			

			return json_encode($outage_all_str);
		}
		else{
			$outage_all_str = 'No Outage Found';
			return json_encode($outage_all_str);
		}

	}


	/****************************************ICX ISSUE********************************************************************/

	public function onuserver_api_outage_icx_issue(){

		$select_icx_issue_query = "SELECT element_id,element_type FROM phoenix_tt_db.outage_table WHERE issue_type='ICX'";

		$icx_issue_lists = \DB::select(\DB::raw($select_icx_issue_query));

		$element_id_link_arr = array();
		$element_id_site_arr = array();
		foreach($icx_issue_lists as $icx_issue_list){
			if($icx_issue_list->element_type == 'link'){
				array_push($element_id_link_arr, $icx_issue_list->element_id);
			}
			else{
				array_push($element_id_site_arr, $icx_issue_list->element_id);
			}
			
		}
		$element_id_link_str = implode(',', $element_id_link_arr);
		$element_id_site_str = implode(',', $element_id_site_arr);
		$outage_all_str_site = '';
		$outage_all_str_link = '';
		$total_icx_issue_count = 0;

		if(count($element_id_site_arr) > 0){
			$select_site_icx_issue_query = "SELECT site_name_id FROM phoenix_tt_db.site_table WHERE site_name_id IN (".$element_id_site_str.")";
			$site_icx_issue_lists = \DB::select(\DB::raw($select_site_icx_issue_query));

			$select_site_icx_issue_with_region_group_query = "SELECT site_name_id FROM phoenix_tt_db.site_table WHERE site_name_id IN (".$element_id_site_str.")";
			$site_icx_issue_group_lists = \DB::select(\DB::raw($select_site_icx_issue_with_region_group_query));
			$outage_all_str_site .= ' Site Down : ';
			foreach($site_icx_issue_group_lists as $site_icx_issue_group_list){
				$outage_all_str_site .= '( '.$site_icx_issue_group_lists->site_name_id.' ),';
			}
			$total_icx_issue_count =  $total_icx_issue_count + count($site_icx_issue_lists);
		}
		if(count($element_id_link_arr) > 0){
			$select_link_icx_issue_query = "SELECT link_name_id FROM phoenix_tt_db.link_table WHERE link_name_id IN (".$element_id_link_str.")";
			$site_icx_issue_lists = \DB::select(\DB::raw($select_link_icx_issue_query));

			$select_link_icx_issue_with_region_group_query = "SELECT link_name_nttn,link_name_gateway FROM phoenix_tt_db.link_table WHERE link_name_id IN (".$element_id_link_str.") ";
			$link_icx_issue_group_lists = \DB::select(\DB::raw($select_link_icx_issue_with_region_group_query));

			$outage_all_str_link .= ' Link Down : ';
			foreach($link_icx_issue_group_lists as $link_icx_issue_group_list){
				$outage_all_str_link .= '( '.$link_icx_issue_group_list->link_name_nttn.','.$link_icx_issue_group_list->link_name_gateway.' ),';
			}
			$total_icx_issue_count =  $total_icx_issue_count + count($site_icx_issue_lists);
		}

		
		//echo $element_id_str;
		//return $select_power_alarm_with_region_group_query;
		//$total_icx_issue_count = count($site_icx_issue_lists) + count($link_icx_issue_lists);

		if($total_icx_issue_count > 0){
			$outage_all_str = 'Total ICX ISSUE : '.$total_icx_issue_count.$outage_all_str_site.$outage_all_str_link;
			

			return json_encode($outage_all_str);
		}
		else{
			$outage_all_str = 'No Outage Found';
			return json_encode($outage_all_str);
		}
		

	}

	/****************************************ITC ISSUE********************************************************************/

	public function onuserver_api_outage_itc_issue(){

		$select_itc_issue_query = "SELECT element_id,element_type FROM phoenix_tt_db.outage_table WHERE issue_type='itc'";

		$itc_issue_lists = \DB::select(\DB::raw($select_itc_issue_query));

		$element_id_link_arr = array();
		$element_id_site_arr = array();
		foreach($itc_issue_lists as $itc_issue_list){
			if($itc_issue_list->element_type == 'link'){
				array_push($element_id_link_arr, $itc_issue_list->element_id);
			}
			else{
				array_push($element_id_site_arr, $itc_issue_list->element_id);
			}
			
		}
		$element_id_link_str = implode(',', $element_id_link_arr);
		$element_id_site_str = implode(',', $element_id_site_arr);
		$outage_all_str_site = '';
		$outage_all_str_link = '';
		$total_itc_issue_count = 0;

		if(count($element_id_site_arr) > 0){
			$select_site_itc_issue_query = "SELECT site_name_id FROM phoenix_tt_db.site_table WHERE site_name_id IN (".$element_id_site_str.")";
			$site_itc_issue_lists = \DB::select(\DB::raw($select_site_itc_issue_query));

			$select_site_itc_issue_with_region_group_query = "SELECT site_name_id FROM phoenix_tt_db.site_table WHERE site_name_id IN (".$element_id_site_str.")";
			$site_itc_issue_group_lists = \DB::select(\DB::raw($select_site_itc_issue_with_region_group_query));
			$outage_all_str_site .= ' Site Down : ';
			foreach($site_itc_issue_group_lists as $site_itc_issue_group_list){
				$outage_all_str_site .= '( '.$site_itc_issue_group_lists->site_name_id.' ),';
			}
			$total_itc_issue_count =  $total_itc_issue_count + count($site_itc_issue_lists);
		}
		if(count($element_id_link_arr) > 0){
			$select_link_itc_issue_query = "SELECT link_name_id FROM phoenix_tt_db.link_table WHERE link_name_id IN (".$element_id_link_str.")";
			$site_itc_issue_lists = \DB::select(\DB::raw($select_link_itc_issue_query));

			$select_link_itc_issue_with_region_group_query = "SELECT link_name_nttn,link_name_gateway FROM phoenix_tt_db.link_table WHERE link_name_id IN (".$element_id_link_str.") ";
			$link_itc_issue_group_lists = \DB::select(\DB::raw($select_link_itc_issue_with_region_group_query));

			$outage_all_str_link .= ' Link Down : ';
			foreach($link_itc_issue_group_lists as $link_itc_issue_group_list){
				$outage_all_str_link .= '( '.$link_itc_issue_group_list->link_name_nttn.','.$link_itc_issue_group_list->link_name_gateway.' ),';
			}
			$total_itc_issue_count =  $total_itc_issue_count + count($site_itc_issue_lists);
		}

		
		//echo $element_id_str;
		//return $select_power_alarm_with_region_group_query;
		//$total_itc_issue_count = count($site_itc_issue_lists) + count($link_itc_issue_lists);

		if($total_itc_issue_count > 0){
			$outage_all_str = 'Total ITC ISSUE : '.$total_itc_issue_count.$outage_all_str_site.$outage_all_str_link;
			

			return json_encode($outage_all_str);
		}
		else{
			$outage_all_str = 'No Outage Found';
			return json_encode($outage_all_str);
		}
		

	}

	public function Hajibazi(){
		/**********************FOR FUTURE USE*****************************/
		// $total_found_site_list_arr = array();
		// foreach($site_region_lists as $site_region_list){
		// 	array_push($total_found_site_list_arr, $site_region_list->site_name);
		// }
		// $in_phoenix_site_list = array();
		// $not_in_phoenix_site_list = array();
		// for($j=0;$j<count($node_label_arr);$j++){
		// 	if(in_array($node_label_arr[$j],$total_found_site_list_arr)){
		// 		array_push($in_phoenix_site_list, $node_label_arr[$j]);
		// 	}
		// 	else{
		// 		array_push($not_in_phoenix_site_list, $node_label_arr[$j]);
		// 	}
		// }
		
		// print_r($in_phoenix_site_list);
		// print_r($not_in_phoenix_site_list);
		/**********************************************************************/
	}
	public function api_authenticate($username,$password){
		$auth_query = "SELECT * FROM login_plugin_db.login_table";
        $auth_lists = \DB::connection('mysql2')->select(\DB::raw($auth_query));
        if(count($auth_lists) > 0 ){   
        	foreach ($auth_lists as $auth_list) {        		
    			if($auth_list->user_id==$username && $auth_list->account_status!="blocked"){

    				if (password_verify($password, $auth_list->user_password)) 
        			{     				
        				return 'valid';
        			}
                    else{
                        return 'invalid';
                    }
    			}
        	}
        }
        

        

	}

    public function unms_api(){
    	
		$data_temp =  Request::get("data");
		$username = Request::get('userid');
        $password = Request::get('password');   

        //eturn $data_temp;

        $is_valid = $this->api_authenticate($username,$password);

        if($is_valid == 'valid'){	    	
	        try{
	        	$data = json_decode($data_temp);
	        	$unms_table_lists = unms_table::where('alarm_id', $data->alarmno)->get();

	        	if(count($unms_table_lists) > 0){
	        		echo json_encode("Ticket Already Exists for this alarm");
	        	}
	        	else{
	        		$unms_table = new unms_table();
		            $unms_table->alarm_id = $data->alarmno;
		            $unms_table->alarm_data = $data_temp;
		            $unms_table->created_at = date("Y-m-d H:i:s");
		            $unms_table->save();

		            echo json_encode($unms_table->id);
	        	}
	        	
	        }
	        catch(\Exception $e){
	            echo json_encode("Invalid data sent");
	        }
    	}
    	else{
    		echo json_encode("Invalid Username or Password");
    	}


    }

    public function post_test(){
    	$data_temp = '{"alarmno": "18022800001","trackid": 148,"timestamp": 1519757180,"first_event": 1519757180, "last_event": 1519757180, "alarm_count": 1, "event_count": 1,"msg": "Disk Utilization High","stat_value": "76.07 %","threshold": ">= 75 %", "severity": 5,"_severity": "Major","hostname": "Vijay-PC","alias": "Vijay-PC", "poll_addr": "127.0.0.1","name": "disk0", "resource_alias": "", "res_type": "Fixed  Disk","assetid": "", "ip_addr": "", "bw_configured": "", "ack_by": "None" }';

    	return view('ticket.post_test',compact('data_temp'));
    }
}