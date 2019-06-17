<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DB;

class LogController extends Controller
{
	public function insert_all_table_log($ticket_id){
		$this->insert_ticket_table_log($ticket_id);
		$this->insert_fault_table_log($ticket_id);
		$this->insert_incident_table_log($ticket_id);
	}
    public function insert_ticket_table_log($ticket_id){

    	$select_table_query = "SELECT * FROM phoenix_tt_db.ticket_table WHERE ticket_id=$ticket_id";
    	$ticket_lists = \DB::select(\DB::raw($select_table_query));

    	$ticket_id = $ticket_lists[0]->ticket_id;
    	$incident_id = addslashes($ticket_lists[0]->incident_id);
    	$ticket_status =addslashes( $ticket_lists[0]->ticket_status);
    	$ticket_row_created_date = addslashes($ticket_lists[0]->ticket_row_created_date);
    	$ticket_row_update_time =addslashes( $ticket_lists[0]->ticket_row_update_time);
    	$ticket_title = addslashes($ticket_lists[0]->ticket_title);
    	$ticket_initiator = addslashes($ticket_lists[0]->ticket_initiator);
    	$ticket_initiator_dept = addslashes($ticket_lists[0]->ticket_initiator_dept);
    	$assigned_dept = addslashes($ticket_lists[0]->assigned_dept);
    	$ticket_file_path = addslashes($ticket_lists[0]->ticket_file_path);

    	$user_id = '';
    	$user_dept = '';

    	/***********************TICKET TABLE INSERT QUERY*******************************************/

        $insert_ticket_table_query = "INSERT INTO phoenix_tt_db.ticket_table_log (ticket_id,ticket_title,incident_id,ticket_status,ticket_initiator,ticket_initiator_dept,assigned_dept,ticket_row_created_date,ticket_row_update_time,ticket_file_path,user_id,user_dept) VALUES ($ticket_id,'$ticket_title',$incident_id,'$ticket_status','$ticket_initiator','$ticket_initiator_dept','$assigned_dept','$ticket_row_created_date','$ticket_row_update_time','$ticket_file_path','$user_id','$user_dept')";
        \DB::insert(\DB::raw($insert_ticket_table_query));

        /*******************************************************************************************/
    }
    public function insert_fault_table_log($ticket_id){

    	$select_table_query = "SELECT * FROM phoenix_tt_db.fault_table WHERE ticket_id=$ticket_id";
    	$fault_lists = \DB::select(\DB::raw($select_table_query));

    	foreach($fault_lists as $fault_list){

    		$fault_id = addslashes($fault_list->fault_id);
    		$ticket_id = addslashes($fault_list->ticket_id);
	    	$element_type = addslashes($fault_list->element_type);
	    	$element_id = addslashes($fault_list->element_id);
	    	$client_id = addslashes($fault_list->client_id);
	    	$client_priority = addslashes($fault_list->client_priority);
	    	$issue_type = addslashes($fault_list->issue_type);
	    	$provider = addslashes($fault_list->provider);
	    	$link_type = addslashes($fault_list->link_type);
	    	$problem_category = addslashes($fault_list->problem_category);
	    	$problem_source = addslashes($fault_list->problem_source);
	    	$reason = addslashes($fault_list->reason);
	    	$event_time = addslashes($fault_list->event_time);
	    	$escalation_time = addslashes($fault_list->escalation_time);
	    	$clear_time = addslashes($fault_list->clear_time);
	    	$client_side_impact = addslashes($fault_list->client_side_impact);
	    	$provider_side_impact = addslashes($fault_list->provider_side_impact);
	    	$responsible_concern = addslashes($fault_list->responsible_concern);
	    	$responsible_field_team = addslashes($fault_list->responsible_field_team);
	    	$fault_status = addslashes($fault_list->fault_status);
	    	$fault_row_created_date = addslashes($fault_list->fault_row_created_date);
	    	$remarks = addslashes($fault_list->remarks);

	    	$user_id = '';
    		$user_dept = '';

	    	/***********************TICKET TABLE INSERT QUERY*******************************************/

	        $insert_fault_table_query = "INSERT INTO phoenix_tt_db.fault_table_log (fault_id,ticket_id,element_type,element_id,client_id,issue_type,client_priority,provider,link_type,problem_category,problem_source,reason,event_time,escalation_time,client_side_impact,provider_side_impact,remarks,responsible_concern,responsible_field_team,fault_status,fault_row_created_date,user_id,user_dept) VALUES ('$fault_id','$ticket_id','$element_type',$element_id,$client_id,'$issue_type','$client_priority','$provider','$link_type','$problem_category','$problem_source','$reason','$event_time','$escalation_time','$client_side_impact','$provider_side_impact','$remarks','$responsible_concern','$responsible_field_team','$fault_status','$fault_row_created_date','$user_id','$user_dept')";
	        \DB::insert(\DB::raw($insert_fault_table_query));

	        /*******************************************************************************************/
    	}
	
    }

    public function insert_incident_table_log($ticket_id){

    	$select_table_query = "SELECT * FROM phoenix_tt_db.incident_table WHERE ticket_id=$ticket_id";
    	$incident_lists = \DB::select(\DB::raw($select_table_query));

    	foreach($incident_lists as $incident_list){
    		$incident_id = addslashes($incident_list->incident_id);
    		$ticket_id = addslashes($incident_list->ticket_id);
    		$incident_title = addslashes($incident_list->incident_title);
            $incident_description = addslashes($incident_list->incident_description);
    		$incident_status = addslashes($incident_list->incident_status);
    		$incident_row_created_date = addslashes($incident_list->incident_row_created_date);
    		$incident_merge_time =addslashes( $incident_list->incident_merge_time);

    		$user_id = '';
    		$user_dept = '';

    		if($incident_merge_time == ''){
    			$insert_incident_table_query = "INSERT INTO phoenix_tt_db.incident_table_log(incident_id,ticket_id,incident_title,incident_description,incident_status,incident_row_created_date,user_id,user_dept) VALUES ('$incident_id','$ticket_id','$incident_title','$incident_description','$incident_status','$incident_row_created_date','$user_id','$user_dept')";
    		}
    		else{
    			$insert_incident_table_query = "INSERT INTO phoenix_tt_db.incident_table_log(incident_id,ticket_id,incident_title,incident_description,incident_status,incident_row_created_date,incident_merge_time,user_id,user_dept) VALUES ('$incident_id','$ticket_id','$incident_title','$incident_description','$incident_status','$incident_row_created_date','$incident_merge_time','$user_id','$user_dept')";
    		}
    		\DB::insert(\DB::raw($insert_incident_table_query));
    	}
    }
}


// Top 10 ISP depending on downtime
/*

SELECT (clear_time-event_time) as downtime,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name, count(fault_id) as fault_count FROM fault_table where event_time BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() and client_id NOT IN (29,24,15,32,12) group by client_id order by downtime desc limit 7

*/


// Top 10 Telco depending on downtime
/*

SELECT sum(clear_time-event_time) as downtime,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name, count(fault_id) as fault_count FROM `fault_table` where client_id=9 and event_time BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) group by client_id order by downtime desc limit 7

*/

// Top 10 OH reason wise ISP

/*
SELECT (clear_time-event_time) as downtime,(select client_table.client_name from client_table where client_table.client_id = fault_table.client_id) as client_name, reason as fault_count FROM `fault_table` where event_time BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() and link_type='OH' order by downtime desc limit 7
*/

// Top 10 UG reason wise ISP

/*
SELECT (clear_time-event_time) as downtime,(select client_table.client_name from client_table where client_table.client_id = fault_table.client_id) as client_name, reason as fault_count FROM `fault_table` where event_time BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() and link_type='UG' order by downtime desc limit 7
*/

// Top 10 Robi 
/*

SELECT (clear_time-event_time) as downtime,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time  FROM `fault_table` where client_id=29 and clear_time !='' and event_time BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() order by downtime desc limit 5

*/

// Top 10 GP 
/*

SELECT (clear_time-event_time) as downtime,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time  FROM `fault_table` where client_id=24 and clear_time !='' and event_time BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() order by downtime desc limit 5

*/

// Top 10 Banglalink 
/*

SELECT (clear_time-event_time) as downtime,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time  FROM `fault_table` where client_id=15 and clear_time !='' and event_time BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() order by downtime desc limit 5

*/

// Top 10 Teletalk
/*

SELECT (clear_time-event_time) as downtime,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time  FROM `fault_table` where client_id=32 and clear_time !='' and event_time BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() order by downtime desc limit 5

*/

// Top 10 Teletalk
/*

SELECT (clear_time-event_time) as downtime,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time  FROM `fault_table` where client_id=12 and clear_time !='' and event_time BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() order by downtime desc limit 5

*/