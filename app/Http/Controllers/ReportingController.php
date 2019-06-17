<?php

namespace App\Http\Controllers;

use Request;
use DateTime;
use App\Http\Controllers\ServiceController;
//session_start();
class ReportingController extends Controller
{

	public function ViewReportingPage(){

		return view('report.reporting');
	}
	public function exportReport(){
		$reportTemplateName = Request::get('reportTemplateName');
        $weekNum = Request::get('weekNum');

        if($weekNum == ''){
            $weekString = " and event_time BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY)  AND NOW() ";
        }
        else{
            $weekString = " and week(event_time,0)=$weekNum";
        }
		if($reportTemplateName == 'top_10_isp_reports_downtime_weekly'){
			//echo 'asdf';

			$report_query = "SELECT Time(sum(duration)) as duration,(SELECT client_table.client_name FROM phoenix_tt_db.client_table WHERE client_table.client_id= fault_table.client_id) AS client_name, count(fault_id) as fault_count FROM phoenix_tt_db.fault_table WHERE clear_time !='' ".$weekString." GROUP BY client_id ORDER BY duration DESC LIMIT 7";
			$report_lists = \DB::select(\DB::raw($report_query));
            //return $report_query;
			//return $report_query;
			$fp_report = fopen('../TicketFiles/report.csv','w');

            $report_arr_title = array();
            array_push($report_arr_title, 'Client Name');
            array_push($report_arr_title, 'Fault Count');
            array_push($report_arr_title, 'Down Time');
            fputcsv($fp_report, (array)$report_arr_title);
            if(count($report_lists)>0){
            	foreach($report_lists as $report_list){
            	$report_single_arr = array();
            	array_push($report_single_arr, $report_list->client_name); 
            	array_push($report_single_arr, $report_list->fault_count); 
            	array_push($report_single_arr, $report_list->duration); 
                fputcsv($fp_report, (array)$report_single_arr);
                //print_r($report_single_arr);
            	}
            }
            
            $path = '../TicketFiles/report.csv';
            //echo 'asdf';
            //return '';
            date_default_timezone_set('Asia/Dhaka');
    		$current_time_obj = new DateTime();
        	$current_time = $current_time_obj->format('Y-m-d H:i:s');
        	$headers = array(
              'Content-Type: text/csv',
            );
            $filename = $current_time.'-top_10_isp_reports_downtime_weekly.csv';
            return response()->download($path,$filename ,$headers);

		}
		//return 'asdf';
		if($reportTemplateName == 'top_10_robi_site_reports_downtime_weekly'){
			$report_query = "SELECT f.*,t.concated_value from 
							(SELECT fault_table.fault_id,fault_table.ticket_id,Time(duration) as duration,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time,(select site_name from site_table where element_id=site_name_id) as element_name from phoenix_tt_db.fault_table where client_id=29 and clear_time !='' and element_type='site' ".$weekString.") as f, 
							(select task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from phoenix_tt_db.task_table  GROUP BY task_table.fault_id) as t 
							where f.fault_id = t.fault_id order by f.duration desc limit 5";
            $report_query = $this->appendContatedValues($report_query);  
            //return $report_query;           
			$this->puttingReportInCSV($report_query);
            $path = '../TicketFiles/report.csv';
            date_default_timezone_set('Asia/Dhaka');
    		$current_time_obj = new DateTime();
        	$current_time = $current_time_obj->format('Y-m-d H:i:s');
        	$headers = array(
              'Content-Type: text/csv',
            );
            $filename = $current_time.'-top_10_robi_site_reports_downtime_weekly.csv';
            return response()->download($path, $filename,$headers);
		}
		if($reportTemplateName == 'top_10_gp_site_reports_downtime_weekly'){
			$report_query = "SELECT f.*,t.concated_value from 
							(SELECT fault_table.fault_id,fault_table.ticket_id,Time(duration) as duration,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time,(select site_name from site_table where element_id=site_name_id) as element_name  from phoenix_tt_db.fault_table where client_id=24 and clear_time !='' and element_type='site' ".$weekString.") as f,
							(select task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from phoenix_tt_db.task_table  GROUP BY task_table.fault_id) as t 
							where f.fault_id = t.fault_id order by f.duration desc limit 5";
            $report_query = $this->appendContatedValues($report_query);                            
			$this->puttingReportInCSV($report_query);
            $path = '../TicketFiles/report.csv';
            date_default_timezone_set('Asia/Dhaka');
    		$current_time_obj = new DateTime();
        	$current_time = $current_time_obj->format('Y-m-d H:i:s');
        	$headers = array(
              'Content-Type: text/csv',
            );
            $filename = $current_time.'-top_10_gp_site_reports_downtime_weekly.csv';
            return response()->download($path, $filename,$headers);
		}
		if($reportTemplateName == 'top_10_teletalk_site_reports_downtime_weekly'){
			$report_query = "SELECT f.*,t.concated_value from 
							(SELECT fault_table.fault_id,fault_table.ticket_id,Time(duration) as duration,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time,(select site_name from site_table where element_id=site_name_id) as element_name from phoenix_tt_db.fault_table where client_id=32 and clear_time !='' and element_type='site' ".$weekString.") as f,
							(select task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from phoenix_tt_db.task_table  GROUP BY task_table.fault_id) as t 
							where f.fault_id = t.fault_id order by f.duration desc limit 5";
            $report_query = $this->appendContatedValues($report_query);  
			$this->puttingReportInCSV($report_query);
            $path = '../TicketFiles/report.csv';
            date_default_timezone_set('Asia/Dhaka');
    		$current_time_obj = new DateTime();
        	$current_time = $current_time_obj->format('Y-m-d H:i:s');
        	$headers = array(
              'Content-Type: text/csv',
            );
            $filename = $current_time.'-top_10_teletalk_site_reports_downtime_weekly.csv';
            return response()->download($path, $filename,$headers);
            //return response()->download($path);
		}
		if($reportTemplateName == 'top_10_robi_link_reports_downtime_weekly'){
			$report_query = "SELECT f.*,t.concated_value from 
							(SELECT fault_table.fault_id,fault_table.ticket_id,Time(duration) as duration,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time,(select concat(link_name_nttn,',',link_name_gateway) from link_table where element_id=link_name_id) as element_name  from phoenix_tt_db.fault_table where client_id=29 and clear_time !='' and element_type='link' ".$weekString.") as f,
							(select task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from phoenix_tt_db.task_table  GROUP BY task_table.fault_id) as t 
							where f.fault_id = t.fault_id order by f.duration desc limit 5";
            $report_query = $this->appendContatedValues($report_query);                  
			$this->puttingReportInCSV($report_query);
            $path = '../TicketFiles/report.csv';
            date_default_timezone_set('Asia/Dhaka');
    		$current_time_obj = new DateTime();
        	$current_time = $current_time_obj->format('Y-m-d H:i:s');
        	$headers = array(
              'Content-Type: text/csv',
            );
            $filename = $current_time.'-top_10_robi_link_reports_downtime_weekly.csv';
            return response()->download($path, $filename,$headers);
		}
		if($reportTemplateName == 'top_10_gp_link_reports_downtime_weekly'){
			$report_query = "SELECT f.*,t.concated_value from 
							(SELECT fault_table.fault_id,fault_table.ticket_id,Time(duration) as duration,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time,(select concat(link_name_nttn,',',link_name_gateway) from link_table where element_id=link_name_id) as element_name from fault_table,task_table where client_id=24 and clear_time !='' and element_type='link' ".$weekString.") as f,
							(select task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from phoenix_tt_db.task_table  GROUP BY task_table.fault_id) as t 
							where f.fault_id = t.fault_id order by f.duration desc limit 5";
            $report_query = $this->appendContatedValues($report_query);  
			$this->puttingReportInCSV($report_query);
            $path = '../TicketFiles/report.csv';
            date_default_timezone_set('Asia/Dhaka');
    		$current_time_obj = new DateTime();
        	$current_time = $current_time_obj->format('Y-m-d H:i:s');
        	$headers = array(
              'Content-Type: text/csv',
            );
            $filename = $current_time.'-top_10_gp_link_reports_downtime_weekly.csv';
            return response()->download($path, $filename,$headers);
		}
		if($reportTemplateName == 'top_10_teletalk_link_reports_downtime_weekly'){
			$report_query = "SELECT f.*,t.concated_value from 
							(SELECT fault_table.fault_id,fault_table.ticket_id,Time(duration) as duration,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time,(select concat(link_name_nttn,',',link_name_gateway) from link_table where element_id=link_name_id) as element_name  from fault_table where client_id=32 and clear_time !='' and element_type='link' ".$weekString.") as f,
							(select task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from phoenix_tt_db.task_table  GROUP BY task_table.fault_id) as t 
							where f.fault_id = t.fault_id order by f.duration desc limit 5";
            $report_query = $this->appendContatedValues($report_query);  
			$this->puttingReportInCSV($report_query);
            $path = '../TicketFiles/report.csv';
            date_default_timezone_set('Asia/Dhaka');
    		$current_time_obj = new DateTime();
        	$current_time = $current_time_obj->format('Y-m-d H:i:s');
        	$headers = array(
              'Content-Type: text/csv',
            );
            $filename = $current_time.'-top_10_teletalk_link_reports_downtime_weekly.csv';
            return response()->download($path, $filename,$headers);
		}
		if($reportTemplateName == 'top_10_banglalink_link_reports_downtime_weekly'){
			$report_query = "SELECT f.*,t.concated_value from 
							(SELECT fault_table.fault_id,fault_table.ticket_id,Time(duration) as duration,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time,(select concat(link_name_nttn,',',link_name_gateway) from link_table where element_id=link_name_id) as element_name from fault_table where client_id=15 and clear_time !='' and element_type='link' ".$weekString.") as f,
							(select task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from phoenix_tt_db.task_table  GROUP BY task_table.fault_id) as t 
							where f.fault_id = t.fault_id order by f.duration desc limit 5";
            $report_query = $this->appendContatedValues($report_query);  
			$this->puttingReportInCSV($report_query);
            $path = '../TicketFiles/report.csv';
            date_default_timezone_set('Asia/Dhaka');
    		$current_time_obj = new DateTime();
        	$current_time = $current_time_obj->format('Y-m-d H:i:s');
        	$headers = array(
              'Content-Type: text/csv',
            );
            $filename = $current_time.'-top_10_banglalink_link_reports_downtime_weekly.csv';
            return response()->download($path, $filename,$headers);
		}
		if($reportTemplateName == 'top_10_airtel_link_reports_downtime_weekly'){
			$report_query = "SELECT f.*,t.concated_value from 
							(SELECT fault_table.fault_id,fault_table.ticket_id,Time(duration) as duration,(select client_table.client_name from client_table where client_table.client_id= fault_table.client_id) as client_name,reason,event_time,clear_time,(select concat(link_name_nttn,',',link_name_gateway) from link_table where element_id=link_name_id) as element_name  from fault_table where client_id=12 and clear_time !='' and element_type='link' ".$weekString.") as f, 
							(select task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from phoenix_tt_db.task_table  GROUP BY task_table.fault_id) as t 
							where f.fault_id = t.fault_id order by f.duration desc limit 5";
            $report_query = $this->appendContatedValues($report_query);  
			$this->puttingReportInCSV($report_query);
            $path = '../TicketFiles/report.csv';
            date_default_timezone_set('Asia/Dhaka');
    		$current_time_obj = new DateTime();
        	$current_time = $current_time_obj->format('Y-m-d H:i:s');
        	$headers = array(
              'Content-Type: text/csv',
            );
            $filename = $current_time.'-top_10_airtel_link_reports_downtime_weekly.csv';
            return response()->download($path, $filename,$headers);
		}

		if($reportTemplateName == 'top_10_client_oh_problem_downtime_weekly'){
			$report_query = "SELECT f.*,t.concated_value from 
							(SELECT fault_table.fault_id,fault_table.ticket_id,Time(duration) as duration,(select client_table.client_name from client_table where client_table.client_id = fault_table.client_id) as client_name, reason,event_time,clear_time,(select concat(link_name_nttn,',',link_name_gateway) from link_table where element_id=link_name_id) as element_name  FROM fault_table where element_type='link' ".$weekString.") and link_type='OH') as f,
							(select task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from phoenix_tt_db.task_table  GROUP BY task_table.fault_id) as t 
							where f.fault_id = t.fault_id order by f.duration desc limit 5";
            $report_query = $this->appendContatedValues($report_query);  
			$this->puttingReportInCSV($report_query);
            $path = '../TicketFiles/report.csv';
            date_default_timezone_set('Asia/Dhaka');
    		$current_time_obj = new DateTime();
        	$current_time = $current_time_obj->format('Y-m-d H:i:s');
        	$headers = array(
              'Content-Type: text/csv',
            );
            $filename = $current_time.'-top_10_client_oh_problem_downtime_weekly.csv';
            return response()->download($path, $filename,$headers);
		}
		if($reportTemplateName == 'top_10_client_ug_problem_downtime_weekly'){
			$report_query = "SELECT f.*,t.concated_value from 
							(SELECT fault_table.fault_id,fault_table.ticket_id,Time(duration) as duration,(select client_table.client_name from client_table where client_table.client_id = fault_table.client_id) as client_name, reason,event_time,clear_time,(select concat(link_name_nttn,',',link_name_gateway) from link_table where element_id=link_name_id) as element_name FROM fault_table,task_table where element_type='link' ".$weekString." and link_type='UG') as f,
							(select task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from phoenix_tt_db.task_table  GROUP BY task_table.fault_id) as t 
							where f.fault_id = t.fault_id order by f.duration desc limit 5";
            $report_query = $this->appendContatedValues($report_query);  
			$this->puttingReportInCSV($report_query);
            $path = '../TicketFiles/report.csv';
            date_default_timezone_set('Asia/Dhaka');
    		$current_time_obj = new DateTime();
        	$current_time = $current_time_obj->format('Y-m-d H:i:s');
        	$headers = array(
              'Content-Type: text/csv',
            );
            $filename = $current_time.'-top_10_client_ug_problem_downtime_weekly.csv';
            return response()->download($path, $filename,$headers);
		}
		// if($reportTemplateName == "allFaults"){
		// 	$report_query = "(SELECT A.*,B.concated_value,C.concated_value_resolution,scl.scl_comments,noc.noc_comments,client.client_comments FROM 
		// 	(SELECT fault_table.fault_id,ticket_id,element_type,issue_type,client_priority,provider,link_type,problem_category,problem_source,reason,event_time,escalation_time,clear_time,client_side_impact,provider_side_impact,remarks,responsible_concern,responsible_field_team,fault_status,duration,fault_row_created_date,(select client_table.client_name from client_table where client_table.client_id = fault_table.client_id) as client_name,(select concat(link_name_nttn,',',link_name_gateway) from link_table where element_id=link_name_id) as element_name FROM fault_table WHERE element_type='link' ".$weekString.")  AS A
		// 	LEFT JOIN

		// 	(SELECT task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from 	phoenix_tt_db.task_table  GROUP BY task_table.fault_id) AS B

		// 	ON A.fault_id = B.fault_id

		// 	LEFT JOIN
		// 	(SELECT task_resolution_table.fault_id,GROUP_CONCAT('(',task_resolution_table.task_resolution_id,'--',task_resolution_table.task_id,'--',task_resolution_table.reason,'--',task_resolution_table.resolution_type,'--',task_resolution_table.inventory_type,'--',task_resolution_table.inventory_detail,'--',task_resolution_table.quantity,'--',task_resolution_table.remark,'--',task_resolution_table.task_resolution_create_time,'--',task_resolution_table.task_resolution_update_time,')') as concated_value_resolution from phoenix_tt_db.task_resolution_table  GROUP BY task_resolution_table.fault_id) AS C

		// 	ON A.fault_id = C.fault_id 
			
		// 	LEFT JOIN
  //           (SELECT scl_comment_table.ticket_id,GROUP_CONCAT(scl_comment_table.user_id,':',scl_comment_table.comment,',') as scl_comments FROM scl_comment_table GROUP BY ticket_id) as scl
  //           ON A.ticket_id = scl.ticket_id
  //           LEFT JOIN
  //           (SELECT noc_comment_table.ticket_id,GROUP_CONCAT(noc_comment_table.user_id,':',noc_comment_table.comment,',') as noc_comments FROM noc_comment_table GROUP BY ticket_id) as noc
  //           ON A.ticket_id = noc.ticket_id
  //           LEFT JOIN
  //           (SELECT client_comment_table.ticket_id,GROUP_CONCAT(client_comment_table.user_id,':',client_comment_table.comment,',') as client_comments FROM client_comment_table GROUP BY ticket_id) as client
  //           ON A.ticket_id = client.ticket_id    
		// 	)

		// 	UNION

		// 	(
		// 	SELECT A.*,B.concated_value,C.concated_value_resolution,scl.scl_comments,noc.noc_comments,client.client_comments FROM 
		// 	(SELECT fault_table.fault_id,ticket_id,element_type,issue_type,client_priority,provider,link_type,problem_category,problem_source,reason,event_time,escalation_time,clear_time,client_side_impact,provider_side_impact,remarks,responsible_concern,responsible_field_team,fault_status,duration,fault_row_created_date,(select client_table.client_name from client_table where client_table.client_id = fault_table.client_id) as client_name,(select site_name from site_table where element_id=site_name_id) as element_name FROM fault_table WHERE element_type='site' ".$weekString.")  AS A
		// 	LEFT JOIN

		// 	(SELECT task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from 	phoenix_tt_db.task_table  GROUP BY task_table.fault_id) AS B

		// 	ON A.fault_id = B.fault_id

		// 	LEFT JOIN
		// 	(SELECT task_resolution_table.fault_id,GROUP_CONCAT('(',task_resolution_table.task_resolution_id,'--',task_resolution_table.task_id,'--',task_resolution_table.reason,'--',task_resolution_table.resolution_type,'--',task_resolution_table.inventory_type,'--',task_resolution_table.inventory_detail,'--',task_resolution_table.quantity,'--',task_resolution_table.remark,'--',task_resolution_table.task_resolution_create_time,'--',task_resolution_table.task_resolution_update_time,')') as concated_value_resolution from phoenix_tt_db.task_resolution_table  GROUP BY task_resolution_table.fault_id) AS C

		// 	ON A.fault_id = C.fault_id 

		// 	LEFT JOIN
  //           (SELECT scl_comment_table.ticket_id,GROUP_CONCAT(scl_comment_table.user_id,':',scl_comment_table.comment,',') as scl_comments FROM scl_comment_table GROUP BY ticket_id) as scl
  //           ON A.ticket_id = scl.ticket_id
  //           LEFT JOIN
  //           (SELECT noc_comment_table.ticket_id,GROUP_CONCAT(noc_comment_table.user_id,':',noc_comment_table.comment,',') as noc_comments FROM noc_comment_table GROUP BY ticket_id) as noc
  //           ON A.ticket_id = noc.ticket_id
  //           LEFT JOIN
  //           (SELECT client_comment_table.ticket_id,GROUP_CONCAT(client_comment_table.user_id,':',client_comment_table.comment,',') as client_comments FROM client_comment_table GROUP BY ticket_id) as client
  //           ON A.ticket_id = client.ticket_id
		// 	    )";
  //               //return $report_query;
		// 	$this->puttingReportInCSVAll($report_query);
  //           $path = '../TicketFiles/report.csv';
  //           date_default_timezone_set('Asia/Dhaka');
  //   		$current_time_obj = new DateTime();
  //       	$current_time = $current_time_obj->format('Y-m-d H:i:s');
  //       	$headers = array(
  //             'Content-Type: text/csv',
  //           );
  //           $filename = $current_time.'-allFaults.csv';
  //           return response()->download($path, $filename,$headers);
		// }
		return view('report.reporting');
	}
	public function puttingReportInCSV($report_query){
		$report_lists = \DB::select(\DB::raw($report_query));
		$fp_report = fopen('../TicketFiles/report.csv','w');
		$big_array = array();

        $report_arr_title = array();
        array_push($report_arr_title, 'Fault ID');
        array_push($report_arr_title, 'Element Name');
        array_push($report_arr_title, 'Client Name');
        array_push($report_arr_title, 'Reason');
        array_push($report_arr_title, 'Event Time');
        array_push($report_arr_title, 'Clear Time');
        array_push($report_arr_title, 'Down Time');
        array_push($report_arr_title, 'Task Details [(,task_table.task_id,--,task_table.task_name,--,task_table.task_description,--,task_table.task_status,--,task_table.task_assigned_dept,--,task_table.task_start_time,--,task_table.task_end_time,--,task_table.task_comment,--,task_table.task_resolver,--,task_table.task_resolution_ids,)]');
        fputcsv($fp_report, (array)$report_arr_title);
        array_push($big_array, $report_arr_title);

        foreach($report_lists as $report_list){
            $report_single_arr = array();
            array_push($report_single_arr, $report_list->fault_id);
            array_push($report_single_arr, $report_list->element_name);
            array_push($report_single_arr, $report_list->client_name); 
            array_push($report_single_arr, $report_list->reason); 
            array_push($report_single_arr, $report_list->event_time); 
            array_push($report_single_arr, $report_list->clear_time);
            array_push($report_single_arr, $report_list->duration);
            array_push($report_single_arr, $report_list->concated_value);
            //print_r($report_single_arr);
            fputcsv($fp_report, (array)$report_single_arr);
            array_push($big_array, $report_single_arr);
                
        }
        //print_r($big_array);
	}
	public function puttingReportInCSVAll($report_query){
		$report_lists = \DB::select(\DB::raw($report_query));
		$fp_report = fopen('../TicketFiles/report.csv','w');
		$big_array = array();

        $report_arr_title = array();
        array_push($report_arr_title, 'Fault ID');
        array_push($report_arr_title, 'Ticket ID');
        array_push($report_arr_title, 'Element Type');
        array_push($report_arr_title, 'Issue Type');
        array_push($report_arr_title, 'Client Priority');
        array_push($report_arr_title, 'Provider');
        array_push($report_arr_title, 'Link Type');
        array_push($report_arr_title, 'Problem Category');
        array_push($report_arr_title, 'Problem Source');
        array_push($report_arr_title, 'Reason');
        array_push($report_arr_title, 'Event Time');
        array_push($report_arr_title, 'Escalation Time');
        array_push($report_arr_title, 'Clear Time');
        array_push($report_arr_title, 'Client Side Impact');
        array_push($report_arr_title, 'Provider Side Impact');
        array_push($report_arr_title, 'Remarks');
        array_push($report_arr_title, 'Responsible Concern');
        array_push($report_arr_title, 'Responsible Field Team');
        array_push($report_arr_title, 'Fault Status');
        array_push($report_arr_title, 'Duration');
        array_push($report_arr_title, 'Fault Creation Time');
        array_push($report_arr_title, 'Client Name');
        array_push($report_arr_title, 'Link Name');
        array_push($report_arr_title, 'Task Details [(,task_table.task_id,--,task_table.task_name,--,task_table.task_description,--,task_table.task_status,--,task_table.task_assigned_dept,--,task_table.task_start_time,--,task_table.task_end_time,--,task_table.task_comment,--,task_table.task_resolver,--,task_table.task_resolution_ids,)]');
        array_push($report_arr_title, 'SCL Comments');
        array_push($report_arr_title, 'NOC Comments');
        array_push($report_arr_title, 'Client Comments');
        array_push($report_arr_title, 'Resolution');

        fputcsv($fp_report, (array)$report_arr_title);
        array_push($big_array, $report_arr_title);

        foreach($report_lists as $report_list){
            $report_single_arr = array();
            array_push($report_single_arr, $report_list->fault_id);
            array_push($report_single_arr, $report_list->ticket_id);
           	array_push($report_single_arr, $report_list->element_type);
           	array_push($report_single_arr, $report_list->issue_type);
           	array_push($report_single_arr, $report_list->client_priority);
           	array_push($report_single_arr, $report_list->provider);
           	array_push($report_single_arr, $report_list->link_type);
           	array_push($report_single_arr, $report_list->problem_category);
           	array_push($report_single_arr, $report_list->problem_source);
           	array_push($report_single_arr, $report_list->reason);
           	array_push($report_single_arr, $report_list->event_time);
           	array_push($report_single_arr, $report_list->escalation_time);
           	array_push($report_single_arr, $report_list->clear_time);
           	array_push($report_single_arr, $report_list->client_side_impact);
           	array_push($report_single_arr, $report_list->provider_side_impact);
           	array_push($report_single_arr, $report_list->remarks);
            array_push($report_single_arr, $report_list->responsible_concern);
            array_push($report_single_arr, $report_list->responsible_field_team);
            array_push($report_single_arr, $report_list->fault_status);
            array_push($report_single_arr, $report_list->duration);
            array_push($report_single_arr, $report_list->fault_row_created_date);
            array_push($report_single_arr, $report_list->client_name);
            array_push($report_single_arr, $report_list->element_name);
            array_push($report_single_arr, $report_list->concated_value);
            array_push($report_single_arr, $report_list->scl_comments);
            array_push($report_single_arr, $report_list->noc_comments);
            array_push($report_single_arr, $report_list->client_comments);
            array_push($report_single_arr, $report_list->concated_value_resolution);
            //print_r($report_single_arr);
            fputcsv($fp_report, (array)$report_single_arr);
            array_push($big_array, $report_single_arr);
                
        }
	}
    public function appendContatedValues($query){
        $query = "SELECT A.*,C.concated_value_resolution,client.client_comments,scl.scl_comments,noc.noc_comments FROM (".$query.") as A
LEFT JOIN
            (SELECT task_resolution_table.fault_id,GROUP_CONCAT('(',task_resolution_table.task_resolution_id,'--',task_resolution_table.task_id,'--',task_resolution_table.reason,'--',task_resolution_table.resolution_type,'--',task_resolution_table.inventory_type,'--',task_resolution_table.inventory_detail,'--',task_resolution_table.quantity,'--',task_resolution_table.remark,'--',task_resolution_table.task_resolution_create_time,'--',task_resolution_table.task_resolution_update_time,')') as concated_value_resolution from phoenix_tt_db.task_resolution_table  GROUP BY task_resolution_table.fault_id) AS C

            ON A.fault_id = C.fault_id 
            
            LEFT JOIN
            (SELECT scl_comment_table.ticket_id,GROUP_CONCAT(scl_comment_table.user_id,':',scl_comment_table.comment,',') as scl_comments FROM scl_comment_table GROUP BY ticket_id) as scl
            ON A.ticket_id = scl.ticket_id
            LEFT JOIN
            (SELECT noc_comment_table.ticket_id,GROUP_CONCAT(noc_comment_table.user_id,':',noc_comment_table.comment,',') as noc_comments FROM noc_comment_table GROUP BY ticket_id) as noc
            ON A.ticket_id = noc.ticket_id
LEFT JOIN
            (SELECT client_comment_table.ticket_id,GROUP_CONCAT(client_comment_table.user_id,':',client_comment_table.comment,',') as client_comments FROM client_comment_table GROUP BY ticket_id) as client
            ON A.ticket_id = client.ticket_id";
            return $query;
    }



    public function export_ug_ccp(){
        $query = "SELECT f.* FROM fault_table f, task_table t where f.fault_status='open' and t.task_assigned_dept=43 and t.task_status !='Closed' and f.fault_id = t.fault_id";
        $report_lists = \DB::select(\DB::raw($query));
        
        $service_controller = New ServiceController();
        $return_arr = $service_controller->csv_export($report_lists);
        return response()->download($return_arr[0], $return_arr[1],$return_arr[2]);
        //return view('report.report_export', compact("report_lists"));
    }




	 
    
}


// SELECT * from  (SELECT fault_id,ticket_id,element_type,issue_type,client_priority,provider,link_type,problem_category,problem_source,reason,event_time,escalation_time,clear_time,client_side_impact,provider_side_impact,remarks,responsible_concern,responsible_field_team,fault_status,duration,fault_row_created_date,(select client_table.client_name from client_table where client_table.client_id = fault_table.client_id) as client_name,(select link_name from link_table where element_id=link_name_id) as element_name FROM fault_table WHERE element_type='link' ) as f,
// (select task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from phoenix_tt_db.task_table  GROUP BY task_table.fault_id) as t,
// (select task_resolution_table.fault_id,GROUP_CONCAT( '(',task_resolution_table.task_resolution_id,task_resolution_table.task_id,task_resolution_table.reason,task_resolution_table.resolution_type,task_resolution_table.inventory_type,task_resolution_table.inventory_detail,task_resolution_table.quantity,task_resolution_table.remark,task_resolution_table.task_resolution_create_time,task_resolution_table.task_resolution_update_time,')') as concated_value from phoenix_tt_db.task_resolution_table  GROUP BY task_resolution_table.fault_id) as tr
// where f.fault_id = t.fault_id and t.fault_id = tr.fault_id

// select * from ((select task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from 	phoenix_tt_db.task_table  GROUP BY task_table.fault_id) as t,(select task_resolution_table.fault_id,GROUP_CONCAT( 					'(',task_resolution_table.task_resolution_id,task_resolution_table.task_id,task_resolution_table.reason,task_resolution_table.resolution_type,task_resolution_table.inventory_type,task_resolution_table.inventory_detail,task_resolution_table.quantity,task_resolution_table.remark,task_resolution_table.task_resolution_create_time,task_resolution_table.task_resolution_update_time,')') as concated_value from phoenix_tt_db.task_resolution_table  GROUP BY task_resolution_table.fault_id) as tr 
// where t.fault_id = tr.fault_id))















// SELECT fault_table.fault_id,ticket_id,element_type,issue_type,client_priority,provider,link_type,problem_category,problem_source,reason,event_time,escalation_time,clear_time,client_side_impact,provider_side_impact,remarks,responsible_concern,responsible_field_team,fault_status,duration,fault_row_created_date,(select client_table.client_name from client_table where client_table.client_id = fault_table.client_id) as client_name,(select link_name from link_table where element_id=link_name_id) as element_name FROM fault_table WHERE element_type='link' 

















// SELECT task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from 	phoenix_tt_db.task_table  GROUP BY task_table.fault_id















// SELECT task_resolution_table.fault_id,GROUP_CONCAT('(',task_resolution_table.task_resolution_id,task_resolution_table.task_id,task_resolution_table.reason,task_resolution_table.resolution_type,task_resolution_table.inventory_type,task_resolution_table.inventory_detail,task_resolution_table.quantity,task_resolution_table.remark,task_resolution_table.task_resolution_create_time,task_resolution_table.task_resolution_update_time,')') as concated_value from phoenix_tt_db.task_resolution_table  GROUP BY task_resolution_table.fault_id






// SELECT A.*,B.concated_value,C.concated_value_resolution FROM 
// (SELECT fault_table.fault_id,ticket_id,element_type,issue_type,client_priority,provider,link_type,problem_category,problem_source,reason,event_time,escalation_time,clear_time,client_side_impact,provider_side_impact,remarks,responsible_concern,responsible_field_team,fault_status,duration,fault_row_created_date,(select client_table.client_name from client_table where client_table.client_id = fault_table.client_id) as client_name,(select link_name from link_table where element_id=link_name_id) as element_name FROM fault_table WHERE element_type='link')  AS A
// LEFT JOIN

// (SELECT task_table.fault_id,GROUP_CONCAT( '(',task_table.task_id,'--',task_table.task_name,'--',task_table.task_description,'--',task_table.task_status,'--',task_table.task_assigned_dept,'--',task_table.task_start_time,'--',task_table.task_end_time,'--',task_table.task_comment,'--',task_table.task_resolver,'--',task_table.task_resolution_ids,')') as concated_value from 	phoenix_tt_db.task_table  GROUP BY task_table.fault_id) AS B

// ON A.fault_id = B.fault_id

// LEFT JOIN
// (SELECT task_resolution_table.fault_id,GROUP_CONCAT('(',task_resolution_table.task_resolution_id,task_resolution_table.task_id,task_resolution_table.reason,task_resolution_table.resolution_type,task_resolution_table.inventory_type,task_resolution_table.inventory_detail,task_resolution_table.quantity,task_resolution_table.remark,task_resolution_table.task_resolution_create_time,task_resolution_table.task_resolution_update_time,')') as concated_value_resolution from phoenix_tt_db.task_resolution_table  GROUP BY task_resolution_table.fault_id) AS C

// ON A.fault_id = C.fault_id 
// ORDER BY A.fault_id













