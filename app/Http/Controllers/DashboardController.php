<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;

class DashboardController extends Controller
{
     	public function dashboard_tt(){
            //echo $_SESSION['department'];
        //print_r($_SESSION);

    	  $total_open_tickets_query = "SELECT DISTINCT ticket_id FROM phoenix_tt_db.task_table WHERE ticket_id IN (SELECT ticket_id FROM phoenix_tt_db.ticket_table WHERE ticket_status !='closed') AND task_assigned_dept=".$_SESSION['dept_id']."";
        $total_open_ticket_lists = \DB::select(\DB::raw($total_open_tickets_query));

        $total_open_tickets_count_arr = array();

        foreach($total_open_ticket_lists as $total_open_ticket_list){
            array_push($total_open_tickets_count_arr, $total_open_ticket_list->ticket_id);
            //$dashboard_client_confirmation_pending_ticket_ids .= $dashboard_client_confirmation_pending_list->ticket_id.",";
        }

        $total_open_tickets_count_arr = array_unique($total_open_tickets_count_arr);
        //echo $total_open_tickets_query;
        $total_open_tickets_count = count($total_open_tickets_count_arr);

        /*****************************************************************************************************/


        $my_open_tickets_query = "SELECT DISTINCT ticket_id FROM phoenix_tt_db.task_table WHERE ticket_id IN (SELECT ticket_id FROM phoenix_tt_db.ticket_table WHERE ticket_status !='closed') AND task_assigned_dept=".$_SESSION['dept_id']." AND task_status !='closed'";
        $my_open_tickets_lists = \DB::select(\DB::raw($my_open_tickets_query));

        $my_open_tickets_count_arr = array();

        foreach($my_open_tickets_lists as $my_open_tickets_list){
            array_push($my_open_tickets_count_arr, $my_open_tickets_list->ticket_id);
            //$dashboard_client_confirmation_pending_ticket_ids .= $dashboard_client_confirmation_pending_list->ticket_id.",";
        }

        $my_open_tickets_count_arr = array_unique($my_open_tickets_count_arr);
        //echo $total_open_tickets_query;
        $my_open_tickets_count = count($my_open_tickets_count_arr);

        /*********************************************************************************************************/


        //$my_open_tickets_count = count($my_open_tickets_lists);

        $my_inititated_open_tickets_query = "SELECT * FROM phoenix_tt_db.ticket_table WHERE ticket_status !='closed' and ticket_initiator_dept=".$_SESSION['dept_id']."";
        $my_inititated_open_tickets_lists = \DB::select(\DB::raw($my_inititated_open_tickets_query));
        $my_inititated_open_tickets_count = count($my_inititated_open_tickets_lists);

        $session_dept_id = $_SESSION['dept_id'];

        $my_notification_query = "SELECT * FROM phoenix_tt_db.notification_table  WHERE notification_flag = 0 AND  (assigned_dept LIKE '$session_dept_id,%' OR assigned_dept LIKE '%,$session_dept_id' OR assigned_dept LIKE '%,$session_dept_id,%') ORDER BY notification_row_id DESC";
        $my_notification_lists = \DB::select(\DB::raw($my_notification_query));

        $my_notification_count_arr = array();

        foreach($my_notification_lists as $my_notification_list){
            array_push($my_notification_count_arr, $my_notification_list->ticket_id);
            //$dashboard_client_confirmation_pending_ticket_ids .= $dashboard_client_confirmation_pending_list->ticket_id.",";
        }

        $my_notification_count_arr = array_unique($my_notification_count_arr);
        //echo $total_open_tickets_query;
        $my_notification_count = count($my_notification_count_arr);


        //$my_notification_count = count($my_notification_lists);



        /************************************************Mehraj*****************************************/
        $dashboard_client_confirmation_pending_query = "SELECT DISTINCT(phoenix_tt_db.fault_table.fault_id),phoenix_tt_db.fault_table.*,phoenix_tt_db.task_table.*,phoenix_tt_db.ticket_table.* FROM phoenix_tt_db.task_table,phoenix_tt_db.fault_table,phoenix_tt_db.ticket_table where phoenix_tt_db.task_table.fault_id=phoenix_tt_db.fault_table.fault_id AND phoenix_tt_db.fault_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status!='Closed' AND (phoenix_tt_db.task_table.task_assigned_dept=43 OR
            phoenix_tt_db.task_table.task_assigned_dept=45)";
        $dashboard_client_confirmation_pending_lists = \DB::select(\DB::raw($dashboard_client_confirmation_pending_query));

        $dashboard_client_confirmation_pending_ticket_arr = array();

        foreach($dashboard_client_confirmation_pending_lists as $dashboard_client_confirmation_pending_list){
            array_push($dashboard_client_confirmation_pending_ticket_arr, $dashboard_client_confirmation_pending_list->ticket_id);
            //$dashboard_client_confirmation_pending_ticket_ids .= $dashboard_client_confirmation_pending_list->ticket_id.",";
        }

        $dashboard_client_confirmation_pending_ticket_arr = array_unique($dashboard_client_confirmation_pending_ticket_arr);
        //print_r($dashboard_client_confirmation_pending_ticket_arr);

        $dashboard_client_confirmation_pending_count = count($dashboard_client_confirmation_pending_ticket_arr);

        /**************************************************************************************************************************/


        $dashboard_open_task_query = "SELECT * FROM phoenix_tt_db.task_table WHERE task_status!='Closed' AND task_assigned_dept=".$_SESSION['dept_id'];
        $dashboard_open_task_lists = \DB::select(\DB::raw($dashboard_open_task_query));

        $dashboard_open_task_count_arr = array();

        foreach($dashboard_open_task_lists as $dashboard_open_task_list){
            array_push($dashboard_open_task_count_arr, $dashboard_open_task_list->ticket_id);
            //$dashboard_client_confirmation_pending_ticket_ids .= $dashboard_client_confirmation_pending_list->ticket_id.",";
        }

        $dashboard_open_task_count_arr = array_unique($dashboard_open_task_count_arr);


        $dashboard_open_task_count = count($dashboard_open_task_count_arr);


        /****************************************************************************************************************************/

        $dashboard_pending_task_query = "SELECT * FROM phoenix_tt_db.task_table WHERE task_status!='Closed' AND task_assigned_dept=".$_SESSION['dept_id'];
        $dashboard_pending_task_lists = \DB::select(\DB::raw($dashboard_pending_task_query));

        $dashboard_pending_task_count_arr = array();

        foreach($dashboard_pending_task_lists as $dashboard_pending_task_list){
            array_push($dashboard_pending_task_count_arr, $dashboard_pending_task_list->ticket_id);
            // array_push($dashboard_pending_task_count_arr, $dashboard_pending_task_list->task_id);
            //$dashboard_client_confirmation_pending_ticket_ids .= $dashboard_client_confirmation_pending_list->ticket_id.",";
        }

        $dashboard_pending_task_count_arr = array_unique($dashboard_pending_task_count_arr);


        $dashboard_pending_task_count = count($dashboard_pending_task_count_arr);               

        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-1 hour");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        $dashboard_last_hour_closed_ticket_query = "SELECT * FROM phoenix_tt_db.ticket_table WHERE ticket_closing_time BETWEEN '$previous_time' AND '$current_time' AND ticket_initiator_dept=".$_SESSION['dept_id'];
        $dashboard_last_hour_closed_ticket_lists = \DB::select(\DB::raw($dashboard_last_hour_closed_ticket_query));
        $dashboard_last_hour_closed_ticket_count = count($dashboard_last_hour_closed_ticket_lists);

        $qa_tickets_query =   "SELECT DISTINCT ft.ticket_id 
                              FROM phoenix_tt_db.fault_table ft
                              JOIN phoenix_tt_db.ticket_table tt ON ft.ticket_id = tt.ticket_id
                              JOIN phoenix_tt_db.task_table tat ON ft.fault_id = tat.fault_id
                              WHERE problem_category like 'QA-%' AND tt.ticket_status != 'Closed' AND tat.task_status != 'Closed' AND tat.task_assigned_dept =".$_SESSION['dept_id'];


        $qa_tts = \DB::select(\DB::raw($qa_tickets_query ));
        $count_qa_tt = count($qa_tts);


    		return view('dashboard.dashboard_tt',compact('total_open_tickets_count','my_open_tickets_count','my_inititated_open_tickets_count','my_inititated_open_tickets_count','my_notification_count','dashboard_client_confirmation_pending_count','dashboard_open_task_count','dashboard_pending_task_count','dashboard_last_hour_closed_ticket_count','count_qa_tt'));
   	 	}
   	 	
     	public function dashboard_graph(){

        $down_site_query = "SELECT count(outage_table_row_id) as site_down_count FROM phoenix_tt_db.outage_table WHERE element_type='site' AND problem_category='Site Down'";
        $down_site_lists =  \DB::select(\DB::raw($down_site_query));   
        $down_site_count = $down_site_lists[0]->site_down_count;

        // $json = file_get_contents('http://172.16.132.55/outage_dashboard_android/api_site_down.php');
        // $obj = json_decode($json);
        
        // $nms_down_arr = array();

        // if(isset($obj)){
        //     $down_lists = $obj->siteDown;
        //     $down_site_nms_count = count($down_lists);

        // }
        // else{
        //     $down_lists = 0;
        //     $down_site_nms_count = 0;

        // }


        if (false !== ($contents = @file_get_contents('http://172.16.136.80/unms_api/public/dashboard_response'))) {
            // all good
            $json = file_get_contents('http://172.16.136.80/unms_api/public/dashboard_response');
            $obj = json_decode($json);
        } else {
            // error happened
        }

        $nms_down_arr = array();

        if(isset($obj)){
            if($obj->api_response == 'OK'){
              //$down_lists = $obj->count;
              $down_site_nms_count = $obj->count;
            }
            else{
              $down_lists = 0;
              $down_site_nms_count = 0;
            }
        }
        else{
            $down_lists = 0;
            $down_site_nms_count = 0;

        }
        

        // $down_site_nms_query = "select  distinct  t2.nodesysname,t2.nodelabel,t1.lasteventtime,t3.ipaddr,char_length(t2.nodesysname) as length, concat(extract(Day from (now() - t1.lasteventtime)) ,' D ', extract(Hour from (now() - t1.lasteventtime)) ,' Hr ', extract(Minute from (now() - t1.lasteventtime)),' Mn') as duration
        // from alarms as t1,node as t2,ipinterface as t3
        //                           where t1.nodeid=t2.nodeid
        //                           and (t1.eventuei like 'uei.opennms.org/nodes/nodeDown')
        //                           and t3.nodeid= t1.nodeid
        //                           and t3.ifindex is null
        //                           order by t2.nodesysname";
        // $down_site_nms_lists =  \DB::connection('pgsql')->select(\DB::raw($down_site_nms_query));  
        //$down_site_nms_count = 10;
        $lx_tx_issue_query = "SELECT count(outage_table_row_id) as lx_tx_count FROM phoenix_tt_db.outage_table WHERE link_type='LX' or link_type='TX' and ( not find_in_set('34',assigned_dept)) and ( not find_in_set('35',assigned_dept)) and ( not find_in_set('36',assigned_dept)) and ( not find_in_set('43',assigned_dept))";
        $lx_tx_issue_lists =  \DB::select(\DB::raw($lx_tx_issue_query));   
        $lx_tx_issue_count = $lx_tx_issue_lists[0]->lx_tx_count;

        $oh_query = "SELECT count(outage_table_row_id) as oh_count FROM phoenix_tt_db.outage_table WHERE link_type='OH' AND element_type='link' AND problem_category='Link Down' and ( not find_in_set('34',assigned_dept)) and ( not find_in_set('35',assigned_dept)) and ( not find_in_set('36',assigned_dept)) and ( not find_in_set('43',assigned_dept))";
        $oh_lists =  \DB::select(\DB::raw($oh_query));   
        $oh_count = $oh_lists[0]->oh_count;

        $ug_query = "SELECT count(outage_table_row_id) as ug_count FROM phoenix_tt_db.outage_table WHERE link_type='UG'  AND element_type='link' AND problem_category='Link Down' and ( not find_in_set('34',assigned_dept)) and ( not find_in_set('35',assigned_dept)) and ( not find_in_set('36',assigned_dept)) and ( not find_in_set('43',assigned_dept))";
        $ug_lists =  \DB::select(\DB::raw($ug_query));   
        $ug_count = $ug_lists[0]->ug_count;

        $quality_query = "SELECT count(outage_table_row_id) as quality_count FROM phoenix_tt_db.outage_table WHERE problem_category='High Loss' 
        OR problem_category='Packet loss' 
        OR problem_category='Frame loss' 
        OR problem_category='Latency Issue' 
        OR problem_category='TX Degraded' 
        OR problem_category='IIG: Service Interruption: BW Fall' 
        OR problem_category='IIG: Service Interruption: Packet loss' 
        OR problem_category='IIG: Service Interruption: BW Problem' 
        OR problem_category='IIG: Quality of Service: High latency' 
        OR problem_category='IIG: Quality of Service: Browsing Problem' 
        OR problem_category='IIG: Quality of Service: Download/Upload Problem' 
        OR problem_category='Link Flapping'";
        $quality_lists =  \DB::select(\DB::raw($quality_query));   
        $quality_count = $quality_lists[0]->quality_count;

        $external_power_count_query = "SELECT count(outage_table_row_id) as external_power_count FROM phoenix_tt_db.outage_table WHERE link_type='Env Alarm'";
        $external_power_count_lists =  \DB::select(\DB::raw($external_power_count_query));   
        $external_power_count = $external_power_count_lists[0]->external_power_count;

        $iig_query = "SELECT count(outage_table_row_id) as iig_count FROM phoenix_tt_db.outage_table WHERE issue_type='IIG'";
        $iig_lists =  \DB::select(\DB::raw($iig_query));   
        $iig_count = $iig_lists[0]->iig_count;

        $icx_query = "SELECT count(outage_table_row_id) as icx_count FROM phoenix_tt_db.outage_table WHERE issue_type='ICX'";
        $icx_lists =  \DB::select(\DB::raw($icx_query));   
        $icx_count = $icx_lists[0]->icx_count;

        $itc_query = "SELECT count(outage_table_row_id) as itc_count FROM phoenix_tt_db.outage_table WHERE issue_type='ITC'";
        $itc_lists =  \DB::select(\DB::raw($itc_query));   
        $itc_count = $itc_lists[0]->itc_count;

        $info_banbeis_query = "SELECT count(outage_table_row_id) as info_banbeis_count FROM phoenix_tt_db.outage_table WHERE client_id=38 or client_id=167";
        $info_banbeis_lists =  \DB::select(\DB::raw($info_banbeis_query));   
        $info_banbeis_count = $info_banbeis_lists[0]->info_banbeis_count;

        $implementation_query = "SELECT count(outage_table_row_id) as implementation_count FROM phoenix_tt_db.outage_table ot, phoenix_tt_db.task_table t WHERE ot.fault_id=t.fault_id AND (t.task_assigned_dept =34 OR t.task_assigned_dept =35 OR t.task_assigned_dept=36)";
        $implementation_lists =  \DB::select(\DB::raw($implementation_query));   
        $implementation_count = $implementation_lists[0]->implementation_count;

        $long_pending_query = "SELECT * 
                                FROM (

                                SELECT * , timestampdiff( HOUR , `event_time` , now( ) ) AS duration
                                FROM phoenix_tt_db.outage_table
                                ) AS A
                                WHERE A.duration > 48
                                AND A.fault_status != 'closed'";

        $long_pending_lists =  \DB::select(\DB::raw($long_pending_query));       
        
        $long_pending_count = count($long_pending_lists);                


        // $red_limpia_query = "SELECT count(outage_table_row_id) as itc_count FROM outage_table WHERE ='ITC'";
        // $itc_lists =  \DB::select(\DB::raw($red_limpia_query));   
        // $itc_count = $itc_lists[0]->itc_count;


        $site_availability_count = $this->count_site_availability_last_12_hours();
        $site_total_hour_count = 1948*12;

        $link_availability_count = $this->count_link_availability_last_12_hours();
        $link_total_hour_count = 2650*12;

        $top_5_district_site_arr = $this->count_top_5_district_wise_down_sites();
        $top_5_district_site_count_arr = $this->count_top_5_district_wise_down_sites_count_arr();

        $top_5_district_link_arr = $this->count_top_5_district_wise_down_links();
        $top_5_district_link_count_arr = $this->count_top_5_district_wise_down_links_count_arr();

        $robi_site_availability_count_arr = $this->count_robi_site_availability_last_12_hours();

        $gp_site_availability_count_arr = $this->count_gp_site_availability_last_12_hours();
        //$gp_total_hour_count = 850*12;

        $robi_link_availability_count_arr = $this->count_robi_link_availability_last_12_hours();
        //$robi_link_total_hour_count = 850*12;

        $gp_link_availability_count_arr = $this->count_gp_link_availability_last_12_hours();
        //$gp_link_total_hour_count = 850*12;

        $agg_site_availability_count = $this->count_agg_site_availability_last_12_hours();
        $agg_total_hour_count = 1948*12;
        $preagg_site_availability_count = $this->count_preagg_site_availability_last_12_hours();
        $preagg_total_hour_count = 1948*12;

        $backbone_link_availability_count = $this->count_backbone_link_availability_last_12_hours();
        //echo $backbone_link_availability_count;
        $backbone_link_total_hour_count = 1948*12;

        $district_list = ['Dhaka','Chittagong','Khulna','Rajshahi','Sylhet','Barishal','Rangpur','Mymensingh','Cumilla','Narayanganj'];
        // print_r($top_5_district_link_arr);
        // echo "<br>";
        // return $top_5_district_link_count_arr;
        if(count($top_5_district_site_arr)<6){
          $temp_count = count($top_5_district_site_arr);
          $i = 0 ;
          while($temp_count !=5){
            $temp_count = count($top_5_district_site_arr);
            if(!array_key_exists($district_list[$i],$top_5_district_site_arr)){
              $top_5_district_site_arr[$district_list[$i]] = 0;
            }
            $i++;
          }
        }
        if(count($top_5_district_link_arr)<6){
          $temp_count = count($top_5_district_link_arr);
          $i = 0 ;
          while($temp_count !=5){
            $temp_count = count($top_5_district_link_arr);
            if(!array_key_exists($district_list[$i],$top_5_district_link_arr)){
              $top_5_district_link_arr[$district_list[$i]] = 0;
            }
            $i++;
          }
        }
        $top_5_district_site_arr_keys = array_keys($top_5_district_site_arr);
        $top_5_district_link_arr_keys = array_keys($top_5_district_link_arr);
        //
        // for($i=0;$i<count($top_5_district_site_arr_keys);$i++){
        //   $top_5_district_site_arr[$top_5_district_site_arr_keys[$i]] = ((int)$top_5_district_site_arr[$top_5_district_site_arr_keys[$i]]*100)/$site_total_hour_count;
        // }
        // for($i=0;$i<count($top_5_district_link_arr_keys);$i++){
        //   $top_5_district_link_arr[$top_5_district_link_arr_keys[$i]] = ((int)$top_5_district_link_arr[$top_5_district_link_arr_keys[$i]]*100)/$link_total_hour_count;
        // }
        arsort($top_5_district_site_arr);
        arsort($top_5_district_link_arr);
        $top_5_district_site_arr_keys = array_keys($top_5_district_site_arr);
        $top_5_district_link_arr_keys = array_keys($top_5_district_link_arr);




        // $total_open_tickets_query = "SELECT DISTINCT ticket_id FROM phoenix_tt_db.task_table WHERE ticket_id IN (SELECT ticket_id FROM phoenix_tt_db.ticket_table WHERE ticket_status !='closed') AND task_assigned_dept=".$_SESSION['dept_id']."";
        // $total_open_ticket_lists = \DB::select(\DB::raw($total_open_tickets_query));
        // //echo $total_open_tickets_query;
        // $total_open_tickets_count = count($total_open_ticket_lists);


        // $my_open_tickets_query = "SELECT DISTINCT ticket_id FROM phoenix_tt_db.task_table WHERE ticket_id IN (SELECT ticket_id FROM phoenix_tt_db.ticket_table WHERE ticket_status !='closed') AND task_assigned_dept=".$_SESSION['dept_id']." AND task_status !='closed'";
        // $my_open_tickets_lists = \DB::select(\DB::raw($my_open_tickets_query));
        // $my_open_tickets_count = count($my_open_tickets_lists);

        // $my_inititated_open_tickets_query = "SELECT * FROM phoenix_tt_db.ticket_table WHERE ticket_status !='closed' and ticket_initiator_dept=".$_SESSION['dept_id']."";
        // $my_inititated_open_tickets_lists = \DB::select(\DB::raw($my_inititated_open_tickets_query));
        // $my_inititated_open_tickets_count = count($my_inititated_open_tickets_lists);

        // $my_notification_query = "SELECT * FROM phoenix_tt_db.notification_table WHERE notification_flag !=1 and assigned_dept=".$_SESSION['dept_id'];
        // $my_notification_lists = \DB::select(\DB::raw($my_notification_query));
        // $my_notification_count = count($my_notification_lists);



        // /********************Mehraj*****************************************/
        // $dashboard_client_confirmation_pending_query = "SELECT DISTINCT(phoenix_tt_db.fault_table.fault_id),phoenix_tt_db.fault_table.*,phoenix_tt_db.task_table.*,phoenix_tt_db.ticket_table.* FROM phoenix_tt_db.task_table,phoenix_tt_db.fault_table,phoenix_tt_db.ticket_table where phoenix_tt_db.task_table.fault_id=phoenix_tt_db.fault_table.fault_id AND phoenix_tt_db.fault_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status!='Closed' AND phoenix_tt_db.task_table.task_assigned_dept='Client' AND phoenix_tt_db.ticket_table.ticket_initiator_dept=".$_SESSION['dept_id'];
        // $dashboard_client_confirmation_pending_lists = \DB::select(\DB::raw($dashboard_client_confirmation_pending_query));
        // $dashboard_client_confirmation_pending_count = count($dashboard_client_confirmation_pending_lists);


        // $dashboard_open_task_query = "SELECT * FROM phoenix_tt_db.task_table WHERE task_status!='Closed' AND task_assigned_dept=".$_SESSION['dept_id'];
        // $dashboard_open_task_lists = \DB::select(\DB::raw($dashboard_open_task_query));
        // $dashboard_open_task_count = count($dashboard_open_task_lists);

        // $dashboard_pending_task_query = "SELECT * FROM phoenix_tt_db.task_table WHERE task_status!='Closed' AND task_assigned_dept=".$_SESSION['dept_id'];
        // $dashboard_pending_task_lists = \DB::select(\DB::raw($dashboard_pending_task_query));
        // $dashboard_pending_task_count = count($dashboard_pending_task_lists);               

        // date_default_timezone_set('Asia/Dhaka');
        // $current_time_obj = new DateTime();
        // $current_time = $current_time_obj->format('Y-m-d H:i:s');

        // $previous_time_obj_temp = new DateTime();
        // $previous_time_obj = $previous_time_obj_temp->modify("-1 hour");
        // $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        // $dashboard_last_hour_closed_ticket_query = "SELECT * FROM phoenix_tt_db.ticket_table WHERE ticket_closing_time BETWEEN '$previous_time' AND '$current_time' AND ticket_initiator_dept=".$_SESSION['dept_id'];
        // $dashboard_last_hour_closed_ticket_lists = \DB::select(\DB::raw($dashboard_last_hour_closed_ticket_query));
        // $dashboard_last_hour_closed_ticket_count = count($dashboard_last_hour_closed_ticket_lists);
        /*********************************************************************/

        //return $top_5_district_site_arr;

        $qa_faults_query = "SELECT * FROM phoenix_tt_db.fault_table ft WHERE ft.problem_category like 'QA-%' AND ft.fault_status != 'Closed'";
        $qa_faults = \DB::select(\DB::raw($qa_faults_query));
        
        $qa_fault_count = count($qa_faults);


        // $down_site_nms_count = 21;
        // $down_site_count = 61;
        // $oh_count = 15;
        // $ug_count = 7;
        // $quality_count = 23;
        // $external_power_count = 2;
        // $iig_count = 7;
        // $itc_count = 3;
        // $icx_count = 1;
        // $info_banbeis_count = 37;
        // $implementation_count = 26;
        // $lx_tx_issue_count = 56;
        // $long_pending_count = 52;
        // $qa_fault_count = 55;

    		return view('dashboard.dashboard_graph',compact('site_availability_count','site_total_hour_count','link_availability_count','link_total_hour_count','top_5_district_site_arr','top_5_district_site_arr_keys','top_5_district_link_arr','top_5_district_link_arr_keys','robi_site_availability_count_arr','robi_total_hour_count','gp_site_availability_count_arr','gp_total_hour_count','robi_link_availability_count_arr','robi_link_total_hour_count','gp_link_availability_count_arr','gp_link_total_hour_count','agg_site_availability_count','agg_total_hour_count','preagg_site_availability_count','preagg_total_hour_count','backbone_link_availability_count','backbone_link_total_hour_count','total_open_tickets_count','my_open_tickets_count','my_inititated_open_tickets_count','my_notification_count','top_5_district_site_count_arr','top_5_district_link_count_arr','dashboard_client_confirmation_pending_count','dashboard_open_task_count','dashboard_pending_task_count','dashboard_last_hour_closed_ticket_count','down_site_count','lx_tx_issue_count','oh_count','ug_count','quality_count','external_power_count','iig_count','itc_count','icx_count','info_banbeis_count','implementation_count','long_pending_count','down_site_nms_count','qa_fault_count'));
   	 	}  
   	 	public function count_site_availability_last_12_hours(){
   	 		date_default_timezone_set('Asia/Dhaka');
    		$current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time FROM phoenix_tt_db.fault_table WHERE clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL AND element_type='site'";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));

        // print_r($down_site_list_query_12_hours);
        $total_duration = 0;
        foreach($down_site_lists as $down_site_list){
          $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
          $event_time_temp_obj = new DateTime($down_site_list->event_time);
          $total_duration +=$this->temp_duration($current_time_obj,$clear_time_temp_obj,$event_time_temp_obj,$previous_time_obj,$down_site_list->clear_time);
          
        }
        return $total_duration;
   	 	} 
      public function count_agg_site_availability_last_12_hours(){
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time,(SELECT site_type FROM phoenix_tt_db.site_table WHERE site_name_id=element_id) AS site_type FROM phoenix_tt_db.fault_table WHERE clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL AND element_type='site'";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));

        //print_r($down_site_lists);
        $total_duration = 0;
        foreach($down_site_lists as $down_site_list){
          if($down_site_list->site_type == 'agg' || $down_site_list->site_type == 'preagg'){
            $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
            $event_time_temp_obj = new DateTime($down_site_list->event_time);

            $total_duration += $this->temp_duration($current_time_obj,$clear_time_temp_obj,$event_time_temp_obj,$previous_time_obj,$down_site_list->clear_time);
            
          }
        }
        //echo $total_duration;
        return $total_duration;
      }

      
      public function count_preagg_site_availability_last_12_hours(){
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time,(SELECT site_type FROM phoenix_tt_db.site_table WHERE site_name_id='element_id') AS site_type FROM phoenix_tt_db.fault_table WHERE clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL AND element_type='site'";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));

        // print_r($down_site_list_query_12_hours);
        $total_duration = 0;
        foreach($down_site_lists as $down_site_list){
          if($down_site_list->site_type == 'preagg'){
            $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
            $event_time_temp_obj = new DateTime($down_site_list->event_time);
            if($event_time_temp_obj < $previous_time_obj){
              $total_duration +=$this->temp_duration($current_time_obj,$clear_time_temp_obj,$event_time_temp_obj,$previous_time_obj,$down_site_list->clear_time);
            
            }
          }
        }
        return $total_duration;
      }
      public function count_robi_site_availability_last_12_hours(){
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time,client_id FROM phoenix_tt_db.fault_table WHERE clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL AND element_type='site'";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));
        //echo $down_site_list_query_12_hours;
        //print_r($down_site_lists);
        $get_robi_id_query = "SELECT client_id FROM phoenix_tt_db.client_table WHERE client_name='Robi'";
        $robi_id_lists = \DB::select(\DB::raw($get_robi_id_query));

        $robi_id = $robi_id_lists[0]->client_id;
        //echo $previous_time;
        $total_duration_arr = array();
        $sla_0_to_9990 = 0;
        $sla_9990_to_9995 =0;

        foreach($down_site_lists as $down_site_list){
          if($down_site_list->client_id == $robi_id){
            $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
            $event_time_temp_obj = new DateTime($down_site_list->event_time);
            if($event_time_temp_obj < $previous_time_obj){
              if($down_site_list->clear_time !=''){
                $interval= strtotime($clear_time_temp_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));
                //$interval= $previous_time_obj->diff($clear_time_temp_obj);
                //$temp_duration = ($interval->days * 24) + $interval->h;
                //echo $interval->i.' clear_time not null';
                $tempTime = $interval/(60);
                $sla_value = $this->sla_count(12*60*60,$tempTime);
                //echo $sla_value;
                if($sla_value == 'sla_9990_to_9995'){
                  $sla_9990_to_9995++;
                }
                if($sla_value == 'sla_0_to_9990'){
                  $sla_0_to_9990++;
                }
                // $total_duration += $temp_duration;
              }
              else{
                $interval= strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));
                $tempTime = $interval/(60);
                $sla_value = $this->sla_count(12*60*60,$tempTime);
                //echo $tempTime;
                if($sla_value == 'sla_9990_to_9995'){
                  $sla_9990_to_9995++;
                }
                if($sla_value == 'sla_0_to_9990'){
                  $sla_0_to_9990++;
                }

              }
            }
            else{
              if($down_site_list->clear_time !=''){
                $interval= strtotime($clear_time_temp_obj->format('Y-m-d H:i:s'))-strtotime($event_time_temp_obj->format('Y-m-d H:i:s'));


                $tempTime = $interval/(60);
                $sla_value = $this->sla_count(12*60*60,$tempTime);
                //echo $sla_value;
                if($sla_value == 'sla_9990_to_9995'){
                  $sla_9990_to_9995++;
                }
                if($sla_value == 'sla_0_to_9990'){
                  $sla_0_to_9990++;
                }

              }
              else{
                $interval= strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($event_time_temp_obj->format('Y-m-d H:i:s'));
                return $interval;
                $temp_duration = ($interval->days * 24) + $interval->h;
                // echo $temp_duration.'<br>';
                $tempTime = $interval/(60);
                $sla_value = $this->sla_count(12*60*60,$tempTime);
                //echo $sla_value;
                if($sla_value == 'sla_9990_to_9995'){
                  $sla_9990_to_9995++;
                }
                if($sla_value == 'sla_0_to_9990'){
                  $sla_0_to_9990++;
                }

              }
            }
          }

        }
        array_push($total_duration_arr, $sla_0_to_9990);
        array_push($total_duration_arr, $sla_9990_to_9995);
        //print_r($total_duration_arr);

        
        return $total_duration_arr;
      }

      public function sla_count($total_hour,$down_hour){
        $percentage_value = (($total_hour-$down_hour)/$total_hour)*100;
        //echo $down_hour.'<br>';
        if($percentage_value >= 99.90 && $percentage_value <=99.95){
          //echo $percentage_value;
          return 'sla_9990_to_9995';
        }
        else if($percentage_value < 99.90){
          //echo $percentage_value;
          return 'sla_0_to_9990';
        }
        else{
          return 'good';
        }
      }

      public function count_gp_site_availability_last_12_hours(){
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time,client_id FROM phoenix_tt_db.fault_table WHERE clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL AND element_type='site'";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));

        // print_r($down_site_list_query_12_hours);
        $get_robi_id_query = "SELECT client_id FROM phoenix_tt_db.client_table WHERE client_name='GP'";
        $gp_id_lists = \DB::select(\DB::raw($get_robi_id_query));

        $gp_id = $gp_id_lists[0]->client_id;

        $total_duration_arr = array();
        $sla_0_to_9990 = 0;
        $sla_9990_to_9995 =0;
        foreach($down_site_lists as $down_site_list){
          if($down_site_list->client_id == $gp_id){
            $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
            $event_time_temp_obj = new DateTime($down_site_list->event_time);
            if($event_time_temp_obj < $previous_time_obj){
              if($down_site_list->clear_time !=''){
                $interval= strtotime($clear_time_temp_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));
                //$interval= $previous_time_obj->diff($clear_time_temp_obj);


                $tempTime = $interval/60;
                $sla_value = $this->sla_count(12*60*60,$tempTime);
                if($sla_value == 'sla_9990_to_9995'){
                  $sla_9990_to_9995++;
                }
                if($sla_value == 'sla_0_to_9990'){
                  $sla_0_to_9990++;
                }
              }
              else{

                $interval= strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));

                $tempTime = $interval/60;
                $sla_value = $this->sla_count(12*60*60,$tempTime);
                if($sla_value == 'sla_9990_to_9995'){
                  $sla_9990_to_9995++;
                }
                if($sla_value == 'sla_0_to_9990'){
                  $sla_0_to_9990++;
                }
              }
            }
            else{
              if($down_site_list->clear_time !=''){

                $interval= strtotime($clear_time_temp_obj->format('Y-m-d H:i:s'))-strtotime($event_time_temp_obj->format('Y-m-d H:i:s'));

                $tempTime = $interval/60;
                $sla_value = $this->sla_count(12*60*60,$tempTime);
                if($sla_value == 'sla_9990_to_9995'){
                  $sla_9990_to_9995++;
                }
                if($sla_value == 'sla_0_to_9990'){
                  $sla_0_to_9990++;
                }
              }
              else{
                //$interval= $event_time_temp_obj->diff($current_time_obj);
                $interval= strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($event_time_temp_obj->format('Y-m-d H:i:s'));

                $tempTime = $interval/60;
                $sla_value = $this->sla_count(12*60*60,$tempTime);
                if($sla_value == 'sla_9990_to_9995'){
                  $sla_9990_to_9995++;
                }
                if($sla_value == 'sla_0_to_9990'){
                  $sla_0_to_9990++;
                }
              }
            }
          }

        }
          
        array_push($total_duration_arr, $sla_0_to_9990);
        array_push($total_duration_arr, $sla_9990_to_9995);
        return $total_duration_arr;
      }

      public function count_link_availability_last_12_hours(){
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time FROM phoenix_tt_db.fault_table WHERE clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL AND element_type='link'";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));

        // print_r($down_site_list_query_12_hours);
        $total_duration = 0;
        foreach($down_site_lists as $down_site_list){
          $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
          $event_time_temp_obj = new DateTime($down_site_list->event_time);
          $total_duration +=$this->temp_duration($current_time_obj,$clear_time_temp_obj,$event_time_temp_obj,$previous_time_obj,$down_site_list->clear_time);
          
        }
        //print_r($down_site_list_query_12_hours);
        return $total_duration;
      }

      public function count_backbone_link_availability_last_12_hours(){
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time,(SELECT link_conn_type FROM phoenix_tt_db.link_table WHERE link_name_id=element_id) AS link_conn_type FROM phoenix_tt_db.fault_table WHERE clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL AND element_type='link'";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));

        
        $total_duration = 0;
        foreach($down_site_lists as $down_site_list){
          if($down_site_list->link_conn_type == 'backbone'){
            //print_r($down_site_lists);
            $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
            $event_time_temp_obj = new DateTime($down_site_list->event_time);
            $total_duration +=$this->temp_duration($current_time_obj,$clear_time_temp_obj,$event_time_temp_obj,$previous_time_obj,$down_site_list->clear_time);
           
          }
        }
        //print_r($total_duration);
        return $total_duration;
      }

      public function count_robi_link_availability_last_12_hours(){
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time,client_id FROM phoenix_tt_db.fault_table WHERE clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL AND element_type='link'";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));

        $get_robi_id_query = "SELECT client_id FROM phoenix_tt_db.client_table WHERE client_name='Robi'";
        $robi_id_lists = \DB::select(\DB::raw($get_robi_id_query));

        $robi_id = $robi_id_lists[0]->client_id;

        // print_r($down_site_list_query_12_hours);
        $total_duration_arr = array();
        $sla_0_to_9990 = 0;
        $sla_9990_to_9995 =0;
        foreach($down_site_lists as $down_site_list){
          if($down_site_list->client_id == $robi_id){
            $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
            $event_time_temp_obj = new DateTime($down_site_list->event_time);
            if($event_time_temp_obj < $previous_time_obj){
              if($down_site_list->clear_time !=''){
                //$interval= $previous_time_obj->diff($clear_time_temp_obj);
                $interval= strtotime($clear_time_temp_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));

                $tempTime = $interval/60;
                  $sla_value = $this->sla_count(12*60*60,$tempTime);
                  if($sla_value == 'sla_9990_to_9995'){
                    $sla_9990_to_9995++;
                  }
                  if($sla_value == 'sla_0_to_9990'){
                    $sla_0_to_9990++;
                  }
              }
              else{

                $interval= strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));

                $tempTime = $interval/60;
                  $sla_value = $this->sla_count(12*60*60,$tempTime);
                  if($sla_value == 'sla_9990_to_9995'){
                    $sla_9990_to_9995++;
                  }
                  if($sla_value == 'sla_0_to_9990'){
                    $sla_0_to_9990++;
                  }
              }
            }
            else{
              if($down_site_list->clear_time !=''){

                $interval= strtotime($clear_time_temp_obj->format('Y-m-d H:i:s'))-strtotime($event_time_temp_obj->format('Y-m-d H:i:s'));

                $tempTime = $interval/60;
                  $sla_value = $this->sla_count(12*60*60,$tempTime);
                  if($sla_value == 'sla_9990_to_9995'){
                    $sla_9990_to_9995++;
                  }
                  if($sla_value == 'sla_0_to_9990'){
                    $sla_0_to_9990++;
                  }
              }
              else{
                //$interval= $event_time_temp_obj->diff($current_time_obj);
                $interval= strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($event_time_temp_obj->format('Y-m-d H:i:s'));

                $tempTime = $interval/60;
                  $sla_value = $this->sla_count(12*60*60,$tempTime);
                  if($sla_value == 'sla_9990_to_9995'){
                    $sla_9990_to_9995++;
                  }
                  if($sla_value == 'sla_0_to_9990'){
                    $sla_0_to_9990++;
                  }
              }
            }
          }
        }
        //print_r($down_site_list_query_12_hours);
        array_push($total_duration_arr, $sla_0_to_9990);
        array_push($total_duration_arr, $sla_9990_to_9995);
        //print_r($total_duration_arr);
        return $total_duration_arr;
      }

      public function count_gp_link_availability_last_12_hours(){
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time,client_id FROM phoenix_tt_db.fault_table WHERE clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL AND element_type='link'";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));

        $get_gp_id_query = "SELECT client_id FROM phoenix_tt_db.client_table WHERE client_name='GP'";
        $gp_id_lists = \DB::select(\DB::raw($get_gp_id_query));

        $gp_id = $gp_id_lists[0]->client_id;

        // print_r($down_site_list_query_12_hours);
        $total_duration_arr = array();
        $sla_0_to_9990 = 0;
        $sla_9990_to_9995 =0;
        foreach($down_site_lists as $down_site_list){
          $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
          $event_time_temp_obj = new DateTime($down_site_list->event_time);
          if($event_time_temp_obj < $previous_time_obj){
            if($down_site_list->clear_time !=''){
              $interval= strtotime($clear_time_temp_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));
              $tempTime = $interval/60;
                $sla_value = $this->sla_count(12*60*60,$tempTime);
                if($sla_value == 'sla_9990_to_9995'){
                  $sla_9990_to_9995++;
                }
                if($sla_value == 'sla_0_to_9990'){
                  $sla_0_to_9990++;
                }
            }
            else{
              $interval= strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));
              $tempTime = $interval/60;
                $sla_value = $this->sla_count(12*60*60,$tempTime);
                if($sla_value == 'sla_9990_to_9995'){
                  $sla_9990_to_9995++;
                }
                if($sla_value == 'sla_0_to_9990'){
                  $sla_0_to_9990++;
                }
            }
          }
          else{
            if($down_site_list->clear_time !=''){
              $interval= strtotime($clear_time_temp_obj->format('Y-m-d H:i:s'))-strtotime($event_time_temp_obj->format('Y-m-d H:i:s'));
              $tempTime = $interval/60;
                $sla_value = $this->sla_count(12*60*60,$tempTime);
                if($sla_value == 'sla_9990_to_9995'){
                  $sla_9990_to_9995++;
                }
                if($sla_value == 'sla_0_to_9990'){
                  $sla_0_to_9990++;
                }
            }
            else{
              $interval= strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($event_time_temp_obj->format('Y-m-d H:i:s'));
              $tempTime = $interval/60;
                $sla_value = $this->sla_count(12*60*60,$tempTime);
                if($sla_value == 'sla_9990_to_9995'){
                  $sla_9990_to_9995++;
                }
                if($sla_value == 'sla_0_to_9990'){
                  $sla_0_to_9990++;
                }
            }
          }
        }
        //print_r($down_site_list_query_12_hours);
        array_push($total_duration_arr, $sla_0_to_9990);
        array_push($total_duration_arr, $sla_9990_to_9995);
        return $total_duration_arr;
      }

      public function count_top_5_district_wise_down_sites(){
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        $down_site_list_query_12_hours = "SELECT element_id,fault_id,event_time,clear_time,(SELECT district FROM phoenix_tt_db.site_table WHERE site_name_id=element_id) as district FROM phoenix_tt_db.fault_table WHERE element_type='site' AND (clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL)";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));

        $top_5_district_arr = array();
        $top_5_district_count_arr = array();
        $Dhaka_duration = 0;
        foreach($down_site_lists as $down_site_list){
          $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
          $event_time_temp_obj = new DateTime($down_site_list->event_time);
          if(array_key_exists(rtrim($down_site_list->district),$top_5_district_arr)){
            //$district_duration = 0;
            $district_duration = $this->duration($down_site_list->clear_time,$clear_time_temp_obj,$event_time_temp_obj);
            //echo $down_site_list->district." ".$district_duration;
            $top_5_district_arr[rtrim($down_site_list->district)] = (int)$top_5_district_arr[rtrim($down_site_list->district)] + (int)$district_duration;
            $top_5_district_count_arr[rtrim($down_site_list->district)] = (int)$top_5_district_count_arr[rtrim($down_site_list->district)] +1;
          }
          else{
            // $district_duration = 0;
            $district_duration = $this->duration($down_site_list->clear_time,$clear_time_temp_obj,$event_time_temp_obj);
            // echo $down_site_list->district." ".$district_duration;
            $top_5_district_arr[rtrim($down_site_list->district)] = (int)$district_duration;
            $top_5_district_count_arr[rtrim($down_site_list->district)] = 0;
          }
          // print_r($top_5_district_arr);
          // echo "<br>";
        }
        // echo $down_site_list_query_12_hours;
        
        // print_r($down_site_lists); 
        // echo "<br>";
        return $top_5_district_arr;
      }
      public function count_top_5_district_wise_down_sites_count_arr(){
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        $down_site_list_query_12_hours = "SELECT element_id,fault_id,event_time,clear_time,(SELECT district FROM phoenix_tt_db.site_table WHERE site_name_id=element_id) as district FROM phoenix_tt_db.fault_table WHERE element_type='site' AND (clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL)";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));

        $top_5_district_arr = array();
        $top_5_district_count_arr = array();
        $Dhaka_duration = 0;
        foreach($down_site_lists as $down_site_list){
          $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
          $event_time_temp_obj = new DateTime($down_site_list->event_time);
          if(array_key_exists(rtrim($down_site_list->district),$top_5_district_count_arr)){
            //$district_duration = 0;
            //$district_duration = $this->duration($down_site_list->clear_time,$clear_time_temp_obj,$event_time_temp_obj);
            //echo $down_site_list->district." ".$district_duration;
            //$top_5_district_arr[rtrim($down_site_list->district)] = (int)$top_5_district_arr[rtrim($down_site_list->district)] + (int)$district_duration;
            $top_5_district_count_arr[rtrim($down_site_list->district)] = (int)$top_5_district_count_arr[rtrim($down_site_list->district)] +1;
          }
          else{
            // $district_duration = 0;
            //$district_duration = $this->duration($down_site_list->clear_time,$clear_time_temp_obj,$event_time_temp_obj);
            // echo $down_site_list->district." ".$district_duration;
            //$top_5_district_arr[rtrim($down_site_list->district)] = (int)$district_duration;
            $top_5_district_count_arr[rtrim($down_site_list->district)] = 1;
          }
          // print_r($top_5_district_arr);
          // echo "<br>";
        }
        // echo $down_site_list_query_12_hours;
        
        // print_r($down_site_lists); 
        // echo "<br>";
        return $top_5_district_count_arr;
      }
      public function count_top_5_district_wise_down_links_count_arr(){
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        // $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time,(SELECT district FROM link_table WHERE link_name_id=element_id) as district FROM phoenix_tt_db.fault_table WHERE clear_time is NULL AND element_type='link'";

        $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time,(SELECT district FROM phoenix_tt_db.link_table WHERE link_name_id=element_id) as district FROM phoenix_tt_db.fault_table WHERE (clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL) AND element_type='link'";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));
        //echo $down_site_list_query_12_hours;
        $top_5_district_arr = array();
        $top_5_district_count_arr = array();
        foreach($down_site_lists as $down_site_list){
          $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
          $event_time_temp_obj = new DateTime($down_site_list->event_time);
          if(array_key_exists(rtrim($down_site_list->district),$top_5_district_count_arr)){
            //echo $down_site_list->district."<br>";
            // $district_duration = $this->duration($down_site_list->clear_time,$clear_time_temp_obj,$event_time_temp_obj);

            // $top_5_district_arr[rtrim($down_site_list->district)] = (int)$top_5_district_arr[rtrim($down_site_list->district)] + (int)$district_duration;

            $top_5_district_count_arr[rtrim($down_site_list->district)] = (int)$top_5_district_count_arr[rtrim($down_site_list->district)] +1;
            //echo $down_site_list->district.'=';
          }
          else{
            //echo $down_site_list->district."<br>";
            // $district_duration = $this->duration($down_site_list->clear_time,$clear_time_temp_obj,$event_time_temp_obj);
            // $top_5_district_arr[rtrim($down_site_list->district)] = (int)$district_duration;
            $top_5_district_count_arr[rtrim($down_site_list->district)] = 1;
          }
        }
        
        return $top_5_district_count_arr;
      }
      public function count_top_5_district_wise_down_links(){
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");
        $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

        // $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time,(SELECT district FROM link_table WHERE link_name_id=element_id) as district FROM phoenix_tt_db.fault_table WHERE clear_time is NULL AND element_type='link'";

        $down_site_list_query_12_hours = "SELECT element_id,event_time,clear_time,(SELECT district FROM phoenix_tt_db.link_table WHERE link_name_id=element_id) as district FROM phoenix_tt_db.fault_table WHERE (clear_time BETWEEN '$previous_time' AND '$current_time' OR clear_time is NULL) AND element_type='link'";
        $down_site_lists = \DB::select(\DB::raw($down_site_list_query_12_hours));
        //echo $down_site_list_query_12_hours;
        $top_5_district_arr = array();

        foreach($down_site_lists as $down_site_list){
          $clear_time_temp_obj = new DateTime($down_site_list->clear_time);
          $event_time_temp_obj = new DateTime($down_site_list->event_time);
          if(array_key_exists(rtrim($down_site_list->district),$top_5_district_arr)){
            //echo $down_site_list->district."<br>";
            $district_duration = $this->duration($down_site_list->clear_time,$clear_time_temp_obj,$event_time_temp_obj);

            $top_5_district_arr[rtrim($down_site_list->district)] = (int)$top_5_district_arr[rtrim($down_site_list->district)] + (int)$district_duration;
            //echo $down_site_list->district.'=';
          }
          else{
            //echo $down_site_list->district."<br>";
            $district_duration = $this->duration($down_site_list->clear_time,$clear_time_temp_obj,$event_time_temp_obj);
            $top_5_district_arr[rtrim($down_site_list->district)] = (int)$district_duration;
          }
        }
        
        return $top_5_district_arr;
      }

      public function duration($clear_time,$clear_time_temp_obj,$event_time_temp_obj){
        date_default_timezone_set('Asia/Dhaka');
        $total_duration = 0;
        $current_time_obj = new DateTime();
        $previous_time_obj_temp = new DateTime();
        $previous_time_obj = $previous_time_obj_temp->modify("-12 hours");

        // $interval= $previous_time_obj->diff($current_time_obj); //date_diff($current_time_obj, $previous_time_obj);//strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));
              //$temp_duration =  date('h',$interval);
              // /$total_duration += $temp_duration;

        // echo "current_time = ".$current_time_obj->format('Y-m-d H:i:s');
        // echo "previous_time = ".$previous_time_obj->format('Y-m-d H:i:s') .'    ';
              
        // echo $interval->format("%H") ."<br>";      
        if($event_time_temp_obj < $previous_time_obj){
            if($clear_time !=''){
              // $interval= strtotime($clear_time_temp_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));
              // $temp_duration =  date('h',$interval);
              $interval= $previous_time_obj->diff($clear_time_temp_obj);
              $total_duration += (int)$interval->format("%H");
            }
            else{
              // $interval= strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));
              // $temp_duration =  date('h',$interval);
              $interval= $previous_time_obj->diff($current_time_obj);
              $total_duration += (int)$interval->format("%H");
            }
          }
          else{
            if($clear_time !=''){
              // $interval= strtotime($clear_time_temp_obj->format('Y-m-d H:i:s'))-strtotime($event_time_temp_obj->format('Y-m-d H:i:s'));
              // $temp_duration =  date('h',$interval);
              $interval= $event_time_temp_obj->diff($clear_time_temp_obj);
              $total_duration += (int)$interval->format("%H");
            }
            else{
              // $interval= strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($event_time_temp_obj->format('Y-m-d H:i:s'));
              // $temp_duration =  date('h',$interval);
              $interval= $event_time_temp_obj->diff($current_time_obj);
              $total_duration += (int)$interval->format("%H");
            }
          }
          //echo $total_duration.'<br>';
        return $total_duration;
      }
      public function temp_duration($current_time_obj,$clear_time_temp_obj,$event_time_temp_obj,$previous_time_obj,$clear_time){
        $total_duration = 0;
        if($event_time_temp_obj < $previous_time_obj){
            if($clear_time !=''){
                // $interval= strtotime($clear_time_temp_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));
                // $tempTime = $interval/60;
                $interval= $previous_time_obj->diff($clear_time_temp_obj);
                $tempTime = (int)$interval->format("%H");
                $total_duration += $tempTime;
              }
              else{
                // $interval= strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($previous_time_obj->format('Y-m-d H:i:s'));
                // $tempTime = $interval/60;
                $interval= $previous_time_obj->diff($current_time_obj);
                $tempTime = (int)$interval->format("%H");
                $total_duration += $tempTime;
              }
            }
            else{
              if($clear_time !=''){
                // $interval= strtotime($clear_time_temp_obj->format('Y-m-d H:i:s'))-strtotime($event_time_temp_obj->format('Y-m-d H:i:s'));
                // $tempTime = $interval/60;
                $interval= $event_time_temp_obj->diff($clear_time_temp_obj);
                $tempTime = (int)$interval->format("%H");
                $total_duration += $tempTime;
              }
              else{
                // $interval= strtotime($current_time_obj->format('Y-m-d H:i:s'))-strtotime($event_time_temp_obj->format('Y-m-d H:i:s'));
                // $tempTime = $interval/60;
                $interval= $event_time_temp_obj->diff($current_time_obj);
                $tempTime = (int)$interval->format("%H");
                $total_duration += $tempTime;
              }
            }
            return $total_duration;
      }	 	
}



// select a.district,sum(a.dur),count(a.dur) from
// (SELECT element_id,event_time,clear_time, timestampdiff(second,`event_time`,clear_time)/3600  as dur,(SELECT district FROM link_table WHERE link_name_id=element_id) as district FROM phoenix_tt_db.fault_table WHERE clear_time BETWEEN DATE_SUB( now( ) , INTERVAL 12  HOUR ) AND now( )  AND element_type='link'
// UNION 
// SELECT element_id,event_time,clear_time, timestampdiff(second,`event_time`,now())/3600  as dur,(SELECT district FROM link_table WHERE link_name_id=element_id) as district FROM phoenix_tt_db.fault_table WHERE clear_time is null AND element_type='link') as a
// group by a.district
// order by sum(a.dur) desc



// select a.district,sum(a.dur),count(a.dur) from
// (SELECT element_id,event_time,clear_time, timestampdiff(second,`event_time`,clear_time)/3600  as dur,(SELECT district FROM site_table WHERE site_name_id=element_id) as district FROM phoenix_tt_db.fault_table WHERE clear_time BETWEEN DATE_SUB( now( ) , INTERVAL 12  HOUR ) AND now( )  AND element_type='site'
// UNION 
// SELECT element_id,event_time,clear_time, timestampdiff(second,`event_time`,now())/3600  as dur,(SELECT district FROM site_table WHERE site_name_id=element_id) as district FROM phoenix_tt_db.fault_table WHERE clear_time is null AND element_type='site') as a
// group by a.district
// order by sum(a.dur) desc