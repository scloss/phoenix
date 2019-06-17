<?php

namespace App\Http\Controllers;

use App\posts_table;
use App\image_table;
use File;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Request;
use Input;
use DateTime;
use Zipper;
use App\Http\Controllers\LogController;
use Excel;
session_start();

class FaultController extends Controller
{
    


    




    // public function query_test(){
    //     $query = "SELECT sum(TIMESTAMPDIFF(second,t.task_start_time, t.task_end_time)/3600) as duration,count(DISTINCT(t.fault_id)) as fault_count , subcenter, (sum(TIMESTAMPDIFF(second,t.task_start_time, t.task_end_time)/3600)/count(DISTINCT(t.fault_id))) as MTTR FROM phoenix_tt_db.task_table t, phoenix_tt_db.fault_table f where t.fault_id = f.fault_id and f.event_time between '2017-10-01 14:59:00' and '2017-10-15 14:59:00' group by t.subcenter ";
    //     $query_lists = \DB::select(\DB::raw($query));
    //     return $query_lists;
    // }

    public function fault_search_view(){

        $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29";
        $department_lists = \DB::connection('mysql3')->select(\DB::raw($department_query));

        $link_type_query = 'SELECT * FROM phoenix_tt_db.link_type_table';
        $link_type_lists = \DB::select(\DB::raw($link_type_query));

        $client_list_query = 'SELECT * FROM phoenix_tt_db.client_table order by client_name asc';
        $client_lists = \DB::select(\DB::raw($client_list_query));

        $problem_category_query = 'SELECT * FROM phoenix_tt_db.problem_category_table';
        $problem_category_lists = \DB::select(\DB::raw($problem_category_query));

        $problem_source_query = 'SELECT * FROM phoenix_tt_db.problem_source_table';
        $problem_source_lists = \DB::select(\DB::raw($problem_source_query));

        $reason_query = 'SELECT * FROM phoenix_tt_db.reason_table';
        $reason_lists = \DB::select(\DB::raw($reason_query));

        $issue_type_query = 'SELECT * FROM phoenix_tt_db.issue_type_table';
        $issue_type_lists = \DB::select(\DB::raw($issue_type_query));  

        $district_select_query = "SELECT * FROM `district_table` ORDER BY `district_name`";
        $district_lists = \DB::select(\DB::raw($district_select_query));   


        $fault_arr = array();

        $client_id_temp = addslashes(Request::get('client_id'));
        $fault_arr['client_id'] = $client_id_temp;

        $element_type_temp = addslashes(Request::get('element_type'));
        $fault_arr['element_type'] = $element_type_temp;

        $element_name_temp = addslashes(Request::get('element_name'));
        $fault_arr['element_name'] = $element_name_temp;

        $element_id_temp = addslashes(Request::get('element_id'));
        $fault_arr['element_id'] = $element_id_temp;

        $vlan_id_temp = addslashes(Request::get('vlan_id'));
        $fault_arr['vlan_id'] = $vlan_id_temp;

        $link_type_temp = addslashes(Request::get('link_type'));
        $fault_arr['link_type'] = $link_type_temp;

        $link_id_temp = addslashes(Request::get('link_id'));
        $fault_arr['link_id'] = $link_id_temp;

        $site_ip_address_temp = addslashes(Request::get('site_ip_address'));
        $fault_arr['site_ip_address'] = $site_ip_address_temp;

        $district_temp = addslashes(Request::get('district'));
        $fault_arr['district'] = $district_temp;

        $region_temp = addslashes(Request::get('region'));
        $fault_arr['region'] = $region_temp;

        $sms_group_temp = addslashes(Request::get('sms_group'));
        $fault_arr['sms_group'] = $sms_group_temp;

        $client_priority_temp = addslashes(Request::get('client_priority'));
        $fault_arr['client_priority'] = $client_priority_temp;

        $client_side_impact_temp = addslashes(Request::get('client_side_impact'));
        $fault_arr['client_side_impact'] = $client_side_impact_temp;

        $responsible_field_team_temp = addslashes(Request::get('responsible_field_team'));
        $fault_arr['responsible_field_team'] = $responsible_field_team_temp;

        $provider_temp = addslashes(Request::get('provider'));
        $fault_arr['provider'] = $provider_temp;

        $reason_temp = addslashes(Request::get('reason'));
        $fault_arr['reason'] = $reason_temp;

        $fault_status_temp = addslashes(Request::get('fault_status'));
        $fault_arr['fault_status'] = $fault_status_temp;

        $issue_type_temp = addslashes(Request::get('issue_type'));
        $fault_arr['issue_type'] = $issue_type_temp;

        $problem_category_temp = addslashes(Request::get('problem_category'));
        $fault_arr['problem_category'] = $problem_category_temp;

        $problem_source_temp = addslashes(Request::get('problem_source'));
        $fault_arr['problem_source'] = $problem_source_temp;

        $responsible_vendor_temp = addslashes(Request::get('responsible_vendor'));
        $fault_arr['responsible_vendor'] = $responsible_vendor_temp;

        // $escalation_time_temp = addslashes(Request::get('escalation_time'));
        // $fault_arr['escalation_time'] = $escalation_time_temp;

        // $escalation_time_to_temp = addslashes(Request::get('escalation_time_to'));
        // $fault_arr['escalation_time_to'] = $escalation_time_to_temp;

        $clear_time_temp = addslashes(Request::get('clear_time'));
        $fault_arr['clear_time'] = $clear_time_temp;

        $clear_time_to_temp = addslashes(Request::get('clear_time_to'));
        $fault_arr['clear_time_to'] = $clear_time_to_temp;




        $responsible_concern_temp = addslashes(Request::get('responsible_concern'));
        $fault_arr['responsible_concern'] = $responsible_concern_temp;

        $event_time_temp = addslashes(Request::get('event_time'));
        $fault_arr['event_time'] = $event_time_temp;

        $event_time_temp_to = addslashes(Request::get('event_time_to'));
        // $event_time_obj_to = new DateTime($event_time_temp_to);
        // $event_time_to = $event_time_obj_to->format('Y-m-d H:i:s');       
        $fault_arr['event_time_to'] = $event_time_temp_to;

        $provider_side_impact_temp = addslashes(Request::get('provider_side_impact'));
        $fault_arr['provider_side_impact'] = $provider_side_impact_temp;
        $remarks_temp = addslashes(Request::get('remarks'));
        $fault_arr['remarks'] = $remarks_temp;

        $minimum_occurence = addslashes(Request::get('min_oc'));


        $dashboard_value = Request::get('dashboard_value');



        $form_type = Request::get('formType');

        // if( $form_type == "Export" ){
        //     $time_frame_choosen = false;
        //     if(($event_time_temp != "") && ($event_time_temp_to != "")){
        //         $time_frame_choosen = true;
        //     }

        //     if( ($clear_time_temp != "") && ($clear_time_to_temp != "") ){
        //         $time_frame_choosen = true;
        //     }

        //     if( ($fault_arr['issue_type'] == "IIG") || ($fault_arr['issue_type'] == "ITC") || ($fault_arr['issue_type'] == "ICX") ){
        //         if($time_frame_choosen){

        //         }else{
        //             return "Please choose a time frame.";
        //         }
        //     }
        //     else{
        //         if($fault_arr['fault_status'] == "open"){

        //         }
        //         else{
        //             if($time_frame_choosen){
        //                 //////////////// 31 days duration check //////////////////////
        //                 if($event_time_temp != ""){
        //                     $start_date = $event_time_temp_to;
        //                     $end_date = $event_time_temp;
        //                     $diff = abs(strtotime($end_date) - strtotime($start_date));
        //                     $days = $diff / (60*60*24);
    
        //                     if($days > 31){
        //                         return "Duration can not be more than 31 days.";
        //                     }
        //                 }
    
        //                 if($clear_time_temp != ""){
        //                     $start_date = $clear_time_to_temp;
        //                     $end_date = $clear_time_temp;
        //                     $diff = abs(strtotime($end_date) - strtotime($start_date));
        //                     $days = $diff / (60*60*24);
        //                     if($days > 31){
        //                         return "Duration can not be more than 31 days.";
        //                     }
        //                 }
        //                 /////////////////////////////////////////////////////////////
        //             }else{
        //                 return "Please choose a time frame.";
        //             }
        //         }     
        //     }
        // }


        

        


        if($dashboard_value!=""){
            if($dashboard_value == 'nms_site_down'){
                // $json = file_get_contents('http://172.16.132.55/outage_dashboard_android/api_site_down.php');
                // $obj = json_decode($json);
                // $nms_down_arr = array();
                // $down_lists = $obj->siteDown;
                // //print_r($down_lists[0]->nodelabel);
                // return view('dashboard.site_down_nms',compact('down_lists'));
                // //return count($obj->siteDown);

                if (false !== ($contents = @file_get_contents('http://172.16.136.80/unms_api/public/dashboard_response'))) {
                    // all good
                    $json = file_get_contents('http://172.16.136.80/unms_api/public/dashboard_response');
                    $obj = json_decode($json);
                } else {
                    // error happened
                }
                
                try {
                    if(isset($obj)){
                        if($obj->api_response == 'OK'){
                          $down_lists = $obj->data;
                          $json_data = json_encode($down_lists);
                        }
                        else{
                          $down_lists = array();
                          $down_site_nms_count = 0;
                          $json_data = json_encode($down_lists);
                        }
                    }
                    else{
                        $down_lists = array();
                        $down_site_nms_count = 0;
                        $json_data = json_encode($down_lists);
            
                    }
                  }
                  
                  //catch exception
                  catch(Exception $e) {
                        $down_lists = array();
                        $down_site_nms_count = 0;
                        $json_data = json_encode($down_lists);
                  }
                

                // $obj = json_decode($json);
                // $nms_down_arr = array();
                // $down_lists = $obj->siteDown;
                //print_r($down_lists[0]->nodelabel);
                return view('dashboard.site_down_nms',compact('down_lists','json_data'));
                //return count($obj->siteDown);
            }

            if($dashboard_value == 'site_down'){

                    $site_down_query =  "SELECT fault_id FROM phoenix_tt_db.outage_table WHERE element_type='site' AND problem_category='Site Down'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery1 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery1 = "fault_id <1";
                    }

                    $site_down_query =  "SELECT fault_id FROM phoenix_tt_db.outage_table WHERE element_type='link' AND problem_category='Site Down' ";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }

                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    //  $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);

                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.site_table where phoenix_tt_db.site_table.site_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);


                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }    

                if($dashboard_value == 'lhtx_issue'){

                    $site_down_query =  "SELECT fault_id FROM phoenix_tt_db.outage_table WHERE (link_type='LX' or link_type='TX') AND element_type='site' ";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery1 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery1 = "fault_id <1";
                    }

                    $site_down_query =  "SELECT fault_id FROM phoenix_tt_db.outage_table WHERE (link_type='LX' or link_type='TX') AND element_type='link' ";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }

                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    //  $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);

                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);


                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }          
                if($dashboard_value == 'oh_link_down'){

                   //  $site_down_query =  "SELECT fault_id FROM phoenix_tt_db.outage_table WHERE link_type='OH' AND element_type='site'";


                   //  $site_down_lists = \DB::select(\DB::raw($site_down_query));

                   //  // print_r($total_client_confirmation_lists);
                   // $dashboard_site_down_ticket_ids ='';

                   //  foreach($site_down_lists as $site_down_list){
                   //      $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                   //  }

                    // print_r($total_client_confirmation_ticket_ids);

                    //$dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    // $whereQuery1 = " fault_id IN($dashboard_site_down_ticket_ids)";
                    // if(count($site_down_lists)<1){
                    //     $whereQuery1 = "fault_id <1";
                    // }

                     $whereQuery1 = "fault_id <1";

                    $site_down_query =  "SELECT fault_id FROM phoenix_tt_db.outage_table WHERE link_type='OH' AND element_type='link'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }


                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    // $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);


                    //--------------------- Ahnaf  --------------------------
                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);


                    // $fault_lists22 = \DB::table('phoenix_tt_db.fault_table')->selectRaw('phoenix_tt_db.fault_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.fault_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.fault_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->get();

                    // $fault_lists1 = \DB::table('phoenix_tt_db.fault_table')->selectRaw('phoenix_tt_db.fault_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.fault_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.fault_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->get();
                    
                    

                    //  $fault_lists20 = \DB::table('phoenix_tt_db.fault_table')->selectRaw('phoenix_tt_db.fault_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.fault_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.fault_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(20);
                    // $fault_lists22 = trim($fault_lists22,']');

                    //  $fault_lists11 = \DB::table('phoenix_tt_db.fault_table')->selectRaw('phoenix_tt_db.fault_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.fault_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.fault_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->get();
                    //$fault_lists11 = trim($fault_lists11,'['); 
                    //$fault_lists23 = $fault_lists22.','.$fault_lists11;
                    // $fault_lists23 = $fault_lists11;
                    // $fault_lists23 = trim($fault_lists23,'['); 
                    // $fault_lists23 = trim($fault_lists23,']'); 
                    //$fault_lists2 = json_decode($fault_lists2,true);
                    // $fault_lists2 = $this->paginate($fault_lists2,5);
                    // $fault_lists23 = stripslashes(json_encode($fault_lists23));
                    // $fault_lists23 = trim($fault_lists23,'"');
                    //$fault_lists25 = json_decode('{ "test" :'.$fault_lists23.'}', true);
                    // /$fault_lists2 = collect($fault_lists25);

                    //$fault_lists2 = $fault_lists2->paginate(20);

                    //return $fault_lists23;
                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }    
                if($dashboard_value == 'ug_link_down'){

                    $site_down_query =  "SELECT fault_id FROM phoenix_tt_db.outage_table WHERE link_type='UG' AND element_type='site'";


                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery1 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery1 = "fault_id <1";
                    }

                    $site_down_query =  "SELECT fault_id FROM phoenix_tt_db.outage_table WHERE link_type='UG' AND element_type='link' ";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }

                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    //  $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);

                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter,(select GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.fault_id=phoenix_tt_db.outage_table.fault_id and phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept_concated")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter,(select GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.fault_id=phoenix_tt_db.outage_table.fault_id and phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept_concated")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);


                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }

                if($dashboard_value == 'quality_problem'){

                    // SELECT count(outage_table_row_id) as quality_count FROM phoenix_tt_db.outage_table WHERE problem_category='High Loss' OR problem_category='Packet loss' OR problem_category='Frame loss' OR problem_category='Latency Issue' OR problem_category='TX Degraded' OR problem_category='IIG: Service Interruption: BW Fall' OR problem_category='IIG: Service Interruption: Packet loss' OR problem_category='IIG: Service Interruption: BW Problem' OR problem_category='IIG: Quality of Service: High latency' OR problem_category='IIG: Quality of Service: Browsing Problem' OR problem_category='IIG: Quality of Service: Download/Upload Problem' OR problem_category='Link Flapping'

                    $site_down_query =  "SELECT fault_id FROM phoenix_tt_db.outage_table WHERE (problem_category='High Loss' OR problem_category='Packet loss' OR problem_category='Frame loss' OR problem_category='Latency Issue' OR problem_category='TX Degraded' OR problem_category='IIG: Service Interruption: BW Fall' OR problem_category='IIG: Service Interruption: Packet loss' OR problem_category='IIG: Service Interruption: BW Problem' OR problem_category='IIG: Quality of Service: High latency' OR problem_category='IIG: Quality of Service: Browsing Problem' OR problem_category='IIG: Quality of Service: Download/Upload Problem' OR problem_category='Link Flapping')";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery1 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery1 = "fault_id <1";
                    }

                    $site_down_query =  "SELECT fault_id FROM phoenix_tt_db.outage_table WHERE (problem_category='High Loss' OR problem_category='Link Flapping') AND element_type='link'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }

                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    //  $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);

                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);


                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }            

                if($dashboard_value == 'external_power_alarm'){

                    $site_down_query =  "SELECT fault_id FROM outage_table WHERE link_type='Env Alarm' AND element_type='site'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery1 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery1 = "fault_id <1";
                    }

                    $site_down_query =  "SELECT fault_id FROM outage_table WHERE link_type='Env Alarm' AND element_type='link'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }

                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    //  $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);

                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);


                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }            

                if($dashboard_value == 'iig_issue'){

                    $site_down_query =  "SELECT fault_id FROM outage_table WHERE issue_type='IIG' AND element_type='site'";

                    
                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery1 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery1 = "fault_id <1";
                    }

                    $site_down_query =  "SELECT fault_id FROM outage_table WHERE issue_type='IIG' AND element_type='link'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }

                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    //  $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);

                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);


                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }  
                if($dashboard_value == 'icx_issue'){

                    $site_down_query =  "SELECT fault_id FROM outage_table WHERE issue_type='ICX' AND element_type='site'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery1 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery1 = "fault_id <1";
                    }

                    $site_down_query =  "SELECT fault_id FROM outage_table WHERE issue_type='ICX' AND element_type='link'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }

                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    //  $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);

                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);

                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }   
                if($dashboard_value == 'itc_issue'){

                   $site_down_query =  "SELECT fault_id FROM outage_table WHERE issue_type='ITC' AND element_type='site'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery1 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery1 = "fault_id <1";
                    }

                    $site_down_query =  "SELECT fault_id FROM outage_table WHERE issue_type='ITC' AND element_type='link'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }

                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    //  $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);

                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);


                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }            
                if($dashboard_value == 'info_banbeis_issue'){

                    $site_down_query = "SELECT fault_id FROM outage_table WHERE (client_id=38 or client_id=167) AND element_type='site'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery1 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery1 = "fault_id <1";
                    }

                    $site_down_query =  "SELECT fault_id FROM outage_table WHERE (client_id=38 or client_id=167) AND element_type='link'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }

                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    //  $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);

                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);


                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }  
                if($dashboard_value == 'implementation_issue'){

                    $site_down_query = "SELECT ot.* FROM phoenix_tt_db.outage_table ot, phoenix_tt_db.task_table t WHERE ot.fault_id=t.fault_id AND (t.task_assigned_dept =34 OR t.task_assigned_dept =35 OR t.task_assigned_dept=36) AND element_type='site'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery1 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery1 = "fault_id <1";
                    }

                    $site_down_query =  "SELECT ot.* FROM phoenix_tt_db.outage_table ot, phoenix_tt_db.task_table t WHERE ot.fault_id=t.fault_id AND (t.task_assigned_dept =34 OR t.task_assigned_dept =35 OR t.task_assigned_dept=36) AND element_type='link'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }

                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    //  $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);

                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);


                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }             
                if($dashboard_value == 'long_pending'){

                    $site_down_query = "SELECT * 
                                FROM (

                                SELECT * , timestampdiff( HOUR , `event_time` , now( ) ) AS duration
                                FROM phoenix_tt_db.outage_table
                                ) AS A
                                WHERE A.duration >48
                                AND A.fault_status != 'closed' AND A.element_type='site'";

                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_fault_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_fault_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_fault_ids = trim($dashboard_site_down_fault_ids,',');

                    $whereQuery1 = "fault_id IN($dashboard_site_down_fault_ids)  order by `phoenix_tt_db`.`outage_table`.`event_time`";
                    if(count($site_down_lists)<1){
                        $whereQuery1 = "fault_id <1";
                    }

                    $link_down_query = "SELECT * 
                                FROM (

                                SELECT * , timestampdiff( HOUR , `event_time` , now( ) ) AS duration
                                FROM phoenix_tt_db.outage_table
                                ) AS A
                                WHERE A.duration >48
                                AND A.fault_status != 'closed' AND A.element_type='link'";

                    $link_down_lists = \DB::select(\DB::raw($link_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_link_down_fault_ids ='';

                    foreach($link_down_lists as $link_down_list){
                        $dashboard_link_down_fault_ids .= $link_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_link_down_fault_ids = trim($dashboard_link_down_fault_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_link_down_fault_ids) order by `phoenix_tt_db`.`outage_table`.`event_time`";
                    if(count($link_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }

                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    //  $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);

                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.site_table where phoenix_tt_db.site_table.site_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);


                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }
                

                if($dashboard_value == 'qa_issue'){

                    $site_down_query = "SELECT * FROM phoenix_tt_db.fault_table ft WHERE ft.problem_category like 'QA-%' AND ft.fault_status != 'Closed' AND ft.element_type = 'site'";
                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery1 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery1 = "fault_id <1";
                    }

                    $site_down_query = "SELECT * FROM phoenix_tt_db.fault_table ft WHERE ft.problem_category like 'QA-%' AND ft.fault_status != 'Closed' AND ft.element_type = 'link'";
                    $site_down_lists = \DB::select(\DB::raw($site_down_query));

                    // print_r($total_client_confirmation_lists);
                   $dashboard_site_down_ticket_ids ='';

                    foreach($site_down_lists as $site_down_list){
                        $dashboard_site_down_ticket_ids .= $site_down_list->fault_id.",";
                    }

                    // print_r($total_client_confirmation_ticket_ids);

                    $dashboard_site_down_ticket_ids = trim($dashboard_site_down_ticket_ids,',');

                    $whereQuery2 = "fault_id IN($dashboard_site_down_ticket_ids)";
                    if(count($site_down_lists)<1){
                        $whereQuery2 = "fault_id <1";
                    }

                    // $fault_lists1 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery1")->paginate(500);
                    

                    //  $fault_lists2 = \DB::table('phoenix_tt_db.outage_table')->selectRaw('phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")->whereRaw("$whereQuery2")->paginate(500);

                    $fault_lists1 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.site_table','phoenix_tt_db.outage_table.element_id','=','phoenix_tt_db.site_table.site_name_id')
                                    ->join('phoenix_tt_db.client_table','phoenix_tt_db.outage_table.client_id','=','phoenix_tt_db.client_table.client_id')
                                    ->whereRaw("$whereQuery1")->paginate(500);

                

                    $fault_lists2 = 
                                    \DB::table('phoenix_tt_db.outage_table')
                                    ->selectRaw("phoenix_tt_db.outage_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.outage_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.outage_table.ticket_id) as task_subcenter")
                                    ->join('phoenix_tt_db.link_table',"phoenix_tt_db.outage_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                    ->join('phoenix_tt_db.client_table',"phoenix_tt_db.outage_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                    ->whereRaw("$whereQuery2")->paginate(500);


                   

                    return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists1','fault_lists2','fault_arr','dashboard_value'));
                }
                


            // return $ticket_lists;


        }


        if(Request::get('formType')){

            $formType = Request::get('formType');
        }
        else{
            $formType = "Search";
        }

    
       


        $fault_lists = $this->fault_search($fault_arr);

        if($formType=="Search"){

            if($fault_lists==""){

                    $fault_lists = DB::table('phoenix_tt_db.fault_table')
                                ->selectRaw('phoenix_tt_db.fault_table.*')
                                ->whereRaw("fault_id<0")
                                ->paginate(2);

            }

            if($fault_arr['element_type']=="link"){

                    // $fault_lists = DB::table('phoenix_tt_db.fault_table')
                    //             ->selectRaw('phoenix_tt_db.fault_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')
                    //             ->join('phoenix_tt_db.link_table',"phoenix_tt_db.fault_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                    //             ->join('phoenix_tt_db.client_table',"phoenix_tt_db.fault_table.client_id","=","phoenix_tt_db.client_table.client_id")
                    //             ->whereRaw("$fault_lists")
                    //             ->paginate(20);

                    $fault_lists = DB::table('phoenix_tt_db.fault_table')
                                ->selectRaw("phoenix_tt_db.fault_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'current_time_duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.fault_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.fault_table.ticket_id) as task_subcenter")
                                ->join('phoenix_tt_db.link_table',"phoenix_tt_db.fault_table.element_id","=","phoenix_tt_db.link_table.link_name_id")
                                ->join('phoenix_tt_db.client_table',"phoenix_tt_db.fault_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                ->whereRaw("$fault_lists")
                                ->orderBy('phoenix_tt_db.fault_table.fault_id', 'desc')
                      //           ->toSql();
                     //return    $fault_lists;         
                                ->paginate(20);
                    //return $fault_lists;
            }
            
            if($fault_arr['element_type']=="site"){

                    // $fault_lists = DB::table('phoenix_tt_db.fault_table')
                    //             ->selectRaw('phoenix_tt_db.fault_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')
                    //             ->join('phoenix_tt_db.site_table',"phoenix_tt_db.fault_table.element_id","=","phoenix_tt_db.site_table.site_name_id")
                    //             ->join('phoenix_tt_db.client_table',"phoenix_tt_db.fault_table.client_id","=","phoenix_tt_db.client_table.client_id")
                    //             ->whereRaw("$fault_lists")
                    //             ->paginate(20);

                    $fault_lists = DB::table('phoenix_tt_db.fault_table')
                                ->selectRaw("phoenix_tt_db.fault_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*,TIMESTAMPDIFF(MINUTE,`event_time`,now()) as 'current_time_duration',(select region from phoenix_tt_db.link_table where phoenix_tt_db.link_table.link_name_id = phoenix_tt_db.fault_table.element_id) as region,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.fault_table.ticket_id) as task_subcenter")
                                ->join('phoenix_tt_db.site_table',"phoenix_tt_db.fault_table.element_id","=","phoenix_tt_db.site_table.site_name_id")
                                ->join('phoenix_tt_db.client_table',"phoenix_tt_db.fault_table.client_id","=","phoenix_tt_db.client_table.client_id")
                                ->whereRaw("$fault_lists")
                                ->orderBy('phoenix_tt_db.fault_table.fault_id', 'desc')
                                ->paginate(20);

            }



            



             //return $fault_lists;

            return view('ticket.fault_search_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists','fault_arr','dashboard_value','district_lists'));

        }

        if($formType=="Export"){
            $user_id = $_SESSION['user_id'];

            $report_log_id = DB::table('report_download_log')->insertGetId(
                [
                    'user_id' => $user_id,
                    'report_type' => 'Fault Export'
                ]
                );

            
            $fault_lists = $this->fault_search_export($fault_arr);

            $gourp_concat_limit_query = 'SET group_concat_max_len = ‎1000000';

            $user_dept = $_SESSION['department'];
            $assigned_to_me = Request::get('assigned_to_me');
            //$fault_lists = \DB::select(\DB::raw($gourp_concat_limit_query));

            $occurence_count_query = "SELECT FT.element_type,FT.element_id,COUNT(FT.fault_id) as occurence_count FROM phoenix_tt_db.`fault_table` as FT WHERE ";


            if($event_time_temp != ""){
                $occurence_count_query .= " (FT.event_time > '$event_time_temp') AND";

            }

            if($event_time_temp_to != ""){
                $occurence_count_query .= " (FT.event_time < '$event_time_temp_to') AND";
            }

            if($element_type_temp != ""){
                $occurence_count_query .= " (FT.element_type = '$element_type_temp') AND";
            }


            $occurence_count_query = rtrim( $occurence_count_query,"AND");

            $occurence_count_query = rtrim( $occurence_count_query,"WHERE ");

            $occurence_count_query .= " GROUP BY FT.element_type,FT.element_id";

            if($minimum_occurence != "" ){
                $minimum_oc_filter = " HAVING COUNT(FT.fault_id) >= $minimum_occurence";
                $occurence_count_query .= $minimum_oc_filter;    
            }

            // echo $occurence_count_query;
            // echo "<br>";
            // echo "<br>";

            $fault_occurence_per_elements = \DB::select(\DB::raw($occurence_count_query));

            $fault_per_element_dictionary = array();

            foreach ($fault_occurence_per_elements as $fault_occurence_per_element) {
                # code...
                $fault_per_element_dictionary[$fault_occurence_per_element->element_id] = $fault_occurence_per_element->occurence_count;     
            }

            if($fault_arr['element_type']=="link"){


                // $fault_lists_query = "SELECT *,(select region from link_table where link_name_id=f.element_id) as region, (select GROUP_CONCAT('[',t.task_comment_user_id,']','[',t.dept_name,']','[',t.task_comment_time,']','[',t.task_status,'] :',t.task_comment SEPARATOR '||') as task_coms from task_update_log t where t.fault_id=f.fault_id  group by t.fault_id order by t.task_update_log_row_id asc) as task_comments, (SELECT i.incident_id FROM incident_table i,ticket_table tt2 WHERE i.incident_id = tt2.incident_id and tt2.ticket_id = f.ticket_id) as incident_id, (SELECT incident_title FROM incident_table i,ticket_table tt2 WHERE i.incident_id = tt2.incident_id and tt2.ticket_id = f.ticket_id) as incident_title,(SELECT ticket_title FROM ticket_table tt WHERE tt.ticket_id = f.ticket_id) as ticket_title, (SELECT client_name FROM client_table cc WHERE cc.client_id = f.provider) as provider_name,(SELECT GROUP_CONCAT(DISTINCT (SELECT dept_name  from hr_tool_db.department_table dt where dt.dept_row_id = tsk1.task_assigned_dept) SEPARATOR ',') FROM task_table tsk1 WHERE tsk1.fault_id = f.fault_id group by tsk1.fault_id) as total_fault_dept, (SELECT GROUP_CONCAT(DISTINCT subcenter SEPARATOR ',') FROM task_table tsk WHERE tsk.fault_id = f.fault_id group by tsk.fault_id) as subcenter, (SELECT GROUP_CONCAT(trk.reason,'->',trk.resolution_type,' || ') FROM task_resolution_table trk WHERE trk.fault_id = f.fault_id group by trk.fault_id) as task_resolutions,timestampdiff(second,f.event_time,f.clear_time)/3600 as duration,(SELECT task_closer_id FROM phoenix_tt_db.task_table WHERE (task_assigned_dept !='10' AND task_on_behalf_flag=0) AND task_assigned_dept !='43'AND task_assigned_dept !='44'AND task_assigned_dept !='45' AND fault_id=f.fault_id ORDER BY task_id DESC limit 1) as last_om_comment_id,(SELECT task_end_time_db FROM phoenix_tt_db.task_table WHERE (task_assigned_dept !='10' AND task_on_behalf_flag=0) AND task_assigned_dept !='43'AND task_assigned_dept !='44'AND task_assigned_dept !='45' AND fault_id=f.fault_id ORDER BY task_id DESC limit 1) as last_om_end_time_db,(SELECT task_end_time FROM phoenix_tt_db.task_table WHERE (task_assigned_dept !='10' AND task_on_behalf_flag=0) AND task_assigned_dept !='43'AND task_assigned_dept !='44'AND task_assigned_dept !='45' AND fault_id=f.fault_id ORDER BY task_id DESC limit 1) as last_om_end_time,(SELECT ticket_initiator FROM ticket_table tt WHERE tt.ticket_id = f.ticket_id) as ticket_initiator_id,(SELECT ticket_closer_id FROM ticket_table tt WHERE tt.ticket_id = f.ticket_id) as ticket_closer_id,f.fault_closer_id    FROM phoenix_tt_db.fault_table f,phoenix_tt_db.link_table l, phoenix_tt_db.client_table c WHERE f.element_id = l.link_name_id AND f.client_id = c.client_id AND ".$fault_lists;

                $fault_lists_query = "SELECT *,(select region from link_table where link_name_id=f.element_id) as region,(select GROUP_CONCAT((select dept_name from hr_tool_db.department_table where dept_row_id=tt.task_assigned_dept)) as dept_names from task_table tt where tt.task_status ='escalated' and tt.fault_id= f.fault_id) as 'assigned_dept_names',(select GROUP_CONCAT('[',t.task_comment_user_id,']','[',t.dept_name,']','[',t.task_comment_time,']','[',t.task_status,'] :',t.task_comment SEPARATOR '||') as task_coms from task_update_log t where t.fault_id=f.fault_id  group by t.fault_id order by t.task_update_log_row_id asc) as task_comments,(SELECT i.incident_id FROM incident_table i,ticket_table tt2 WHERE i.incident_id = tt2.incident_id and tt2.ticket_id = f.ticket_id) as incident_id, (SELECT incident_title FROM incident_table i,ticket_table tt2 WHERE i.incident_id = tt2.incident_id and tt2.ticket_id = f.ticket_id) as incident_title,(SELECT client_name FROM client_table cc WHERE cc.client_id = f.provider) as provider_name,(SELECT ticket_title FROM ticket_table tt WHERE tt.ticket_id = f.ticket_id) as ticket_title,(SELECT GROUP_CONCAT(DISTINCT (SELECT dept_name  from hr_tool_db.department_table dt where dt.dept_row_id = tsk1.task_assigned_dept) SEPARATOR ',')FROM task_table tsk1 WHERE tsk1.fault_id = f.fault_id group by tsk1.fault_id) as total_fault_dept, (SELECT GROUP_CONCAT(DISTINCT subcenter SEPARATOR ',')FROM task_table tsk WHERE tsk.fault_id = f.fault_id group by tsk.fault_id) as subcenter, (SELECT GROUP_CONCAT(trk.reason,'->',trk.resolution_type,' || ') FROM task_resolution_table trk WHERE trk.fault_id = f.fault_id group by trk.fault_id) as task_resolutions,timestampdiff(second,f.event_time,f.clear_time)/3600 as duration,(SELECT task_closer_id FROM phoenix_tt_db.task_table WHERE (task_assigned_dept !='10' AND task_on_behalf_flag=0) AND task_assigned_dept !='43'AND task_assigned_dept !='44'AND task_assigned_dept !='45' AND fault_id=f.fault_id ORDER BY task_id DESC limit 1) as last_om_comment_id,(SELECT task_end_time_db FROM phoenix_tt_db.task_table WHERE (task_assigned_dept !='10' AND task_on_behalf_flag=0) AND task_assigned_dept !='43'AND task_assigned_dept !='44'AND task_assigned_dept !='45' AND fault_id=f.fault_id ORDER BY task_id DESC limit 1) as last_om_end_time_db,(SELECT task_end_time FROM phoenix_tt_db.task_table WHERE (task_assigned_dept !='10' AND task_on_behalf_flag=0) AND task_assigned_dept !='43'AND task_assigned_dept !='44'AND task_assigned_dept !='45' AND fault_id=f.fault_id ORDER BY task_id DESC limit 1) as last_om_end_time,(SELECT ticket_initiator FROM ticket_table tt WHERE tt.ticket_id = f.ticket_id) as ticket_initiator_id,(SELECT ticket_closer_id FROM ticket_table tt WHERE tt.ticket_id = f.ticket_id) as ticket_closer_id,f.fault_closer_id    FROM fault_table f,link_table l, client_table c WHERE f.element_id = l.link_name_id AND f.client_id = c.client_id AND ".$fault_lists;

                // $row_count = 0;

                // $explain_fault_query = "EXPLAIN  ".$fault_lists_query;
                // $explain_fault_data = \DB::select(\DB::raw($explain_fault_query));

                // foreach($explain_fault_data as $exd_rows){
                //     if($exd_rows->table == "c"){
                //         $row_count = $exd_rows->rows;
                //     }
                // }

                // if($row_count > 1000){
                //     return "Please reduce duration. Your yield data is too big.";
                // }
              

        
                //return $fault_lists_query;



                

                //return $fault_lists_query;
                //return $fault_lists;
                $fault_lists = \DB::select(\DB::raw($fault_lists_query));

                //return count($fault_lists);
                //return 'done';
                //return $fault_lists_query; 
                    // $fault_lists = DB::table('phoenix_tt_db.fault_table')
                    //             ->selectRaw('phoenix_tt_db.fault_table.*,phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.link_table',"phoenix_tt_db.fault_table.element_id","=","phoenix_tt_db.link_table.link_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.fault_table.client_id","=","phoenix_tt_db.client_table.client_id")
                    //             ->whereRaw("$fault_lists")->paginate(200000);
            }
            
            if($fault_arr['element_type']=="site"){

                // $fault_lists_query = "SELECT *,(select region from site_table where site_name_id=f.element_id) as region, (select GROUP_CONCAT('[',t.task_comment_user_id,']','[',t.dept_name,']','[',t.task_comment_time,']','[',t.task_status,'] :',t.task_comment SEPARATOR '||') as task_coms from task_update_log t where t.fault_id=f.fault_id group by t.fault_id order by t.task_update_log_row_id asc) as task_comments,  (SELECT incident_id FROM incident_table i WHERE i.ticket_id = f.ticket_id) as incident_id, (SELECT incident_title FROM incident_table i WHERE i.ticket_id = f.ticket_id) as incident_title,(SELECT ticket_title FROM ticket_table tt WHERE tt.ticket_id = f.ticket_id) as ticket_title, (SELECT client_name FROM client_table cc WHERE cc.client_id = f.provider) as provider_name, (SELECT GROUP_CONCAT(DISTINCT subcenter SEPARATOR ',') FROM task_table tsk WHERE tsk.fault_id = f.fault_id group by tsk.fault_id) as subcenter,(SELECT GROUP_CONCAT(trk.reason,'->',trk.resolution_type,' || ') FROM task_resolution_table trk WHERE trk.fault_id = f.fault_id group by trk.fault_id) as task_resolutions,timestampdiff(second,f.event_time,f.clear_time)/3600 as duration,(SELECT task_closer_id FROM phoenix_tt_db.task_table WHERE (task_assigned_dept !='10' AND task_on_behalf_flag=0) AND task_assigned_dept !='43'AND task_assigned_dept !='44'AND task_assigned_dept !='45' AND fault_id=f.fault_id ORDER BY task_id DESC limit 1) as last_om_comment_id,(SELECT task_end_time FROM phoenix_tt_db.task_table WHERE (task_assigned_dept !='10' AND task_on_behalf_flag=0) AND task_assigned_dept !='43'AND task_assigned_dept !='44'AND task_assigned_dept !='45' AND fault_id=f.fault_id ORDER BY task_id DESC limit 1) as last_om_end_time_db,(SELECT task_end_time FROM phoenix_tt_db.task_table WHERE (task_assigned_dept !='10' AND task_on_behalf_flag=0) AND task_assigned_dept !='43'AND task_assigned_dept !='44'AND task_assigned_dept !='45' AND fault_id=f.fault_id ORDER BY task_id DESC limit 1) as last_om_end_time,(SELECT ticket_initiator FROM ticket_table tt WHERE tt.ticket_id = f.ticket_id) as ticket_initiator_id,(SELECT ticket_closer_id FROM ticket_table tt WHERE tt.ticket_id = f.ticket_id) as ticket_closer_id,f.fault_closer_id   FROM fault_table f,site_table s, client_table c WHERE f.element_id = s.site_name_id AND f.client_id = c.client_id AND ".$fault_lists;

                $fault_lists_query = "SELECT *,(select region from site_table where site_name_id=f.element_id) as region,(select GROUP_CONCAT((select dept_name from hr_tool_db.department_table where dept_row_id=tt.task_assigned_dept)) as dept_names from task_table tt where tt.task_status ='escalated' and tt.fault_id= f.fault_id) as 'assigned_dept_names', (select GROUP_CONCAT('[',t.task_comment_user_id,']','[',t.dept_name,']','[',t.task_comment_time,']','[',t.task_status,'] :',t.task_comment SEPARATOR '||') as task_coms from task_update_log t where t.fault_id=f.fault_id group by t.fault_id order by t.task_update_log_row_id asc) as task_comments, (SELECT i.incident_id FROM incident_table i,ticket_table tt2 WHERE i.incident_id = tt2.incident_id and tt2.ticket_id = f.ticket_id) as incident_id, (SELECT incident_title FROM incident_table i,ticket_table tt2 WHERE i.incident_id = tt2.incident_id and tt2.ticket_id = f.ticket_id) as incident_title, (SELECT ticket_title FROM ticket_table tt WHERE tt.ticket_id = f.ticket_id) as ticket_title, (SELECT client_name FROM client_table cc WHERE cc.client_id = f.provider) as provider_name, (SELECT GROUP_CONCAT(DISTINCT subcenter SEPARATOR ',') FROM task_table tsk WHERE tsk.fault_id = f.fault_id group by tsk.fault_id) as subcenter,(SELECT GROUP_CONCAT(trk.reason,'->',trk.resolution_type,' || ') FROM task_resolution_table trk WHERE trk.fault_id = f.fault_id group by trk.fault_id) as task_resolutions,timestampdiff(second,f.event_time,f.clear_time)/3600 as duration,(SELECT task_closer_id FROM phoenix_tt_db.task_table WHERE (task_assigned_dept !='10' AND task_on_behalf_flag=0) AND task_assigned_dept !='43'AND task_assigned_dept !='44'AND task_assigned_dept !='45' AND fault_id=f.fault_id ORDER BY task_id DESC limit 1) as last_om_comment_id,(SELECT task_end_time FROM phoenix_tt_db.task_table WHERE (task_assigned_dept !='10' AND task_on_behalf_flag=0) AND task_assigned_dept !='43'AND task_assigned_dept !='44'AND task_assigned_dept !='45' AND fault_id=f.fault_id ORDER BY task_id DESC limit 1) as last_om_end_time_db,(SELECT task_end_time FROM phoenix_tt_db.task_table WHERE (task_assigned_dept !='10' AND task_on_behalf_flag=0) AND task_assigned_dept !='43'AND task_assigned_dept !='44'AND task_assigned_dept !='45' AND fault_id=f.fault_id ORDER BY task_id DESC limit 1) as last_om_end_time,(SELECT ticket_initiator FROM ticket_table tt WHERE tt.ticket_id = f.ticket_id) as ticket_initiator_id,(SELECT ticket_closer_id FROM ticket_table tt WHERE tt.ticket_id = f.ticket_id) as ticket_closer_id,f.fault_closer_id   FROM fault_table f,site_table s, client_table c WHERE f.element_id = s.site_name_id AND f.client_id = c.client_id AND ".$fault_lists;



                //return $fault_lists_query;

                // echo $fault_lists_query;

                // return $fault_lists_query;
                $fault_lists = \DB::select(\DB::raw($fault_lists_query));
                //return $fault_lists; 
                    // $fault_lists = DB::table('phoenix_tt_db.fault_table')
                    //             ->selectRaw('phoenix_tt_db.fault_table.*,phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.*')->join('phoenix_tt_db.site_table',"phoenix_tt_db.fault_table.element_id","=","phoenix_tt_db.site_table.site_name_id")->join('phoenix_tt_db.client_table',"phoenix_tt_db.fault_table.client_id","=","phoenix_tt_db.client_table.client_id")
                    //             ->whereRaw("$fault_lists")->paginate(200000);

            }



            $ticket_id_arr = array();
            $sms_time_arr = array();
            $numrows = count($fault_lists);

            if($numrows == 0) {
                return "0 fault found";
            }

            foreach ($fault_lists as $fault_list) {
                array_push($ticket_id_arr, $fault_list->ticket_id);
            }  
            $ticket_id_str = implode(',', $ticket_id_arr);

            $sms_time_select_query = "SELECT * FROM scl_sms_db.ticket_sms_log WHERE ticket_id IN ($ticket_id_str)";

            try {
                $sms_time_lists = \DB::connection('mysql5')->select(\DB::raw($sms_time_select_query));//\DB::select(\DB::raw($sms_group_select_query));
            } catch (Exception $e) {
                $sms_time_lists = array();
            }
            
            
            foreach($sms_time_lists as $sms_time_list){
                $sms_time_arr[$sms_time_list->ticket_id] = $sms_time_list->time;
            }   

            

            if($fault_arr['element_type']=="link"){
                $headerArr = array('incident_id','incident_title','ticket_id','element_id','ticket_title','fault_id','client_name','link_name_nttn','link_name_gateway','link_id','LH','capacity_nttn','capacity_gateway','issue_type','client_priority','link_type','problem_category','problem_source','reason','event_time','escalation_time','clear_time','client_side_impact','provider_side_impact','remarks','responsible_concern','responsible_field_team','fault_status','created_time','task_comments','provider','task resolutions','subcenter','region',  'vendor',    'duration','Last OM Commenter ID','Last OM End Time','Last OM End Time DB','Ticket Initiator ID','Ticket Closer ID','Fault Closer ID','SMS Time','Force Majeure','vlan_id','assigned_dept_names','Number Of Occuerence','UNMS TT ID','Alarm ID','IP','Host Name', 'BW','Msg','Resource Alias','Resource Name','Alarm Time');
            }
            if($fault_arr['element_type']=="site"){
                $headerArr = array('incident_id','incident_title','ticket_id','element_id','ticket_title','fault_id','client_name','site_name','site_ip_address','issue_type','client_priority','link_type','problem_category','problem_source','reason','event_time','escalation_time','clear_time','client_side_impact','provider_side_impact','remarks','responsible_concern','responsible_field_team','fault_status','created_time','task_comments','provider','task resolutions','subcenter','region', 'vendor', 'duration','Last OM Commenter ID','Last OM End Time','Last OM End Time DB','Ticket Initiator ID','Ticket Closer ID','Fault Closer ID','SMS Time','Force Majeure','assigned_dept_names','Number Of Occuerence','UNMS TT ID','Alarm ID','IP','Host Name', 'BW','Msg','Resource Alias','Resource Name','Alarm Time');
            }            
                 //cho count($headerArr);
                $bigArr = array();

                $sheets_array = array();
                array_push($bigArr, $headerArr);

               

                $row_count = count($fault_lists);

                $update_row_count_in_log = "UPDATE phoenix_tt_db.report_download_log SET row_count = $row_count WHERE id = $report_log_id";
                \DB::update(\DB::raw($update_row_count_in_log));

                //////////////////////////// Fault ID array for getting task resolutions /////////////////////////////////////////
                $fault_id_array = array();
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
               
                foreach ($fault_lists as $fault_list) {
                    array_push($fault_id_array,$fault_list->fault_id);

                    if(array_key_exists($fault_list->element_id,$fault_per_element_dictionary)){
                    $smallArr = array();
                    array_push($smallArr, $fault_list->incident_id);
                    array_push($smallArr, $fault_list->incident_title);
                    array_push($smallArr, $fault_list->ticket_id);
                    array_push($smallArr, $fault_list->element_id);
                    array_push($smallArr, $fault_list->ticket_title);
                    array_push($smallArr, $fault_list->fault_id);
                    
                     array_push($smallArr, $fault_list->client_name);
                    // array_push($smallArr, $fault_list->element_type);

                    // array_push($smallArr, $fault_list->element_id);
                    if($fault_arr['element_type']=="link"){

                        array_push($smallArr, $fault_list->link_name_nttn);
                        array_push($smallArr, $fault_list->link_name_gateway);
                        if($fault_list->link_id !=''){
                           array_push($smallArr, $fault_list->link_id); 
                        }
                        else{
                            array_push($smallArr, 'NA'); 
                        }
                        array_push($smallArr, $fault_list->LH);
                        array_push($smallArr, $fault_list->capacity_nttn);
                        array_push($smallArr, $fault_list->capacity_gateway);
                        

                    }
                    if($fault_arr['element_type']=="site"){

                        array_push($smallArr, $fault_list->site_name);
                        array_push($smallArr, $fault_list->site_ip_address);

                    }


                   
                    array_push($smallArr, $fault_list->issue_type);
                    array_push($smallArr, $fault_list->client_priority);
                    array_push($smallArr, $fault_list->link_type);
                    array_push($smallArr, stripslashes($fault_list->problem_category));
                    array_push($smallArr, $fault_list->problem_source);
                    array_push($smallArr, $fault_list->reason);
                    array_push($smallArr, $fault_list->event_time);
                    array_push($smallArr, $fault_list->escalation_time);
                    array_push($smallArr, $fault_list->clear_time);
                    array_push($smallArr, $fault_list->client_side_impact);
                    array_push($smallArr, $fault_list->provider_side_impact);
                    array_push($smallArr, stripslashes ($fault_list->remarks));
                    array_push($smallArr, $fault_list->responsible_concern);
                    array_push($smallArr, $fault_list->responsible_field_team);
                    array_push($smallArr, $fault_list->fault_status);
                    array_push($smallArr, $fault_list->fault_row_created_date);
                    array_push($smallArr, stripslashes ($fault_list->task_comments));
                    array_push($smallArr, $fault_list->provider_name);
                    array_push($smallArr, $fault_list->task_resolutions);
                    array_push($smallArr, $fault_list->subcenter);
                    array_push($smallArr, $fault_list->region);
                    array_push($smallArr, $fault_list->vendor);
                    array_push($smallArr, $fault_list->duration);
                    array_push($smallArr, $fault_list->last_om_comment_id);
                    array_push($smallArr, $fault_list->last_om_end_time);
                    array_push($smallArr, $fault_list->last_om_end_time_db);
                    array_push($smallArr, $fault_list->ticket_initiator_id);
                    array_push($smallArr, $fault_list->ticket_closer_id);
                    array_push($smallArr, $fault_list->fault_closer_id);
                    if (array_key_exists($fault_list->ticket_id,$sms_time_arr))
                    {
                        array_push($smallArr, $sms_time_arr[$fault_list->ticket_id]);
                    }
                    else
                    {
                        array_push($smallArr, ' No SMS Found for this ticket');
                    }
                    array_push($smallArr, $fault_list->force_majeure);

                    if($fault_arr['element_type']=="link"){
                        array_push($smallArr, $fault_list->vlan_id);
                    }


                    array_push($smallArr, $fault_list->assigned_dept_names);

                    if(array_key_exists($fault_list->element_id,$fault_per_element_dictionary)){
                        array_push($smallArr, $fault_per_element_dictionary[$fault_list->element_id]);
                    }

                    ////////////////// @Ahnaf ///////////////////////////
                    ////////////////// UNMS Ticket ID //////////////////

                    array_push($smallArr, $fault_list->unms_tt_id);
                    

                    try {
                        $unms_tt = $this->get_unms_tt_info($fault_list->unms_tt_info);
                        array_push($smallArr, $unms_tt['alarmno']);
                        array_push($smallArr, $unms_tt['poll_addr']);
                        array_push($smallArr, $unms_tt['hostname']);
                        array_push($smallArr, $unms_tt['bw_configured']);
                        array_push($smallArr, $unms_tt['msg']);
                        array_push($smallArr, $unms_tt['resource_alias']);
                        array_push($smallArr, $unms_tt['name']);
                        array_push($smallArr, $unms_tt['alarm_time']);
                    } catch (Exception $e) {
                        array_push($smallArr, 'NA');
                        array_push($smallArr, 'NA');
                        array_push($smallArr, 'NA');
                        array_push($smallArr, 'NA');
                        array_push($smallArr, 'NA');
                        array_push($smallArr, 'NA');
                        array_push($smallArr, 'NA');
                        array_push($smallArr, 'NA');
                    }

                    array_push($smallArr, $unms_tt['alarmno']);
                    array_push($smallArr, $unms_tt['poll_addr']);
                    array_push($smallArr, $unms_tt['hostname']);
                    array_push($smallArr, $unms_tt['bw_configured']);
                    array_push($smallArr, $unms_tt['msg']);
                    array_push($smallArr, $unms_tt['resource_alias']);
                    array_push($smallArr, $unms_tt['name']);
                    array_push($smallArr, $unms_tt['alarm_time']);


                    ////////////////////////////////////////////////////

                    if($assigned_to_me == 'yes'){
                        if (strpos($fault_list->assigned_dept_names, $user_dept) !== false) {
                            echo strpos($fault_list->assigned_dept_names, $user_dept);
                            array_push($bigArr, $smallArr);
                        }
                    }
                    if($assigned_to_me == 'no'){
                     
                        if (strpos($fault_list->assigned_dept_names, $user_dept) !== false) {
                            
                        }
                        else{
                            echo strpos($fault_list->assigned_dept_names, $user_dept);
                            array_push($bigArr, $smallArr);
                        }

                    }


                    if($assigned_to_me == ''){
                        array_push($bigArr, $smallArr);
                    }



                    //array_push($bigArr, $smallArr);
                    //echo count($smallArr).'<br/>';
                }
                }
                
                array_push($sheets_array,$bigArr);
                $fauld_id_string = implode(",",$fault_id_array);

                //dd($fauld_id_string);
                $resolution_query = "SELECT * FROM phoenix_tt_db.task_resolution_table WHERE fault_id in ($fauld_id_string)";
                $resolution_lists = \DB::select(\DB::raw($resolution_query));

                $resolution_sheet = array();
                $resolution_sheet_header = array("task_resolution_id","task_id","fault_id","reason","resolution_type","inventory_type","inventory_detail",
                "quantity","remark","task_resolution_create_time","task_resolution_update_time","loss","is_force_majeure","lat","lon");
                array_push($resolution_sheet,$resolution_sheet_header);
                //dd($resolution_lists);
                foreach($resolution_lists as $resolution_row){
                    $row = array();
                    array_push($row,$resolution_row->task_resolution_id);
                    array_push($row,$resolution_row->task_id);
                    array_push($row,$resolution_row->fault_id);
                    array_push($row,$resolution_row->reason);
                    array_push($row,$resolution_row->resolution_type);
                    array_push($row,$resolution_row->inventory_type);
                    array_push($row,$resolution_row->inventory_detail);
                    array_push($row,$resolution_row->quantity);
                    array_push($row,$resolution_row->remark);
                    array_push($row,$resolution_row->task_resolution_create_time);
                    array_push($row,$resolution_row->task_resolution_update_time);
                    array_push($row,$resolution_row->loss);
                    array_push($row,$resolution_row->is_force_majeure);
                    array_push($row,$resolution_row->lat);
                    array_push($row,$resolution_row->lon);

                    array_push($resolution_sheet,$row);

                }
                
                array_push($sheets_array,$resolution_sheet);
                //////// Export XlSL Faisal starts ///////
                //print_r($bigArr);
                //dd("ok");
                //dd($sheets_array);
                $this->writeXLSX($sheets_array);

                //////// Export XlSL Faisal ends ///////

            //     $export = fopen('../Uploaded_Files/export.csv','w');
            //     //print_r($bigArr);
            //     //echo count($bigArr);
            //     foreach ($bigArr as $fields) {
            //         fputcsv($export, $fields);
            //     }
            //     //return "safdsadfsfdsfdd sadfasdf asdfasdf asdfs ";
            //     $path = '../Uploaded_Files/export.csv';

            //    // return $bigArr;
            //     return response()->download($path);            


        }
    }


    public function writeXLSX($sheets_array)
    {
    
        //dd($sheets_array);
        Excel::create('download', function ($excel) use ($sheets_array) {
    
            $excel->setTitle('Title');
            $i = 0;
            
            for($i = 0; $i<count($sheets_array);$i++)
            {
                $excel->sheet("sheet_$i", function ($data_sheet) use ($sheets_array,$i) {
                // Set background color for a specific cell
                $data_sheet->getStyle('A1:BL1')->applyFromArray(array(
                    // 'fill' => array(
                    //     'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                    //     'bold' => true
                    // ),
                    'font' => [
                        'bold' => true
                    ]
                ));
                $data_sheet->setAutoSize(false);
                    $data_sheet->fromArray(
                        $sheets_array[$i], null, 'A1', false, false
                    );
                    
                });
            }
            
    
    
        })->store('xlsx',\storage_path('../fault report/'))->export('xlsx');
    
      
    }

public function fault_search_export($fault_arr){


        $sql ="";


        if(!$fault_arr['element_type']){

            return "";
        }

        if($fault_arr['element_type']){


            if($fault_arr['element_type']=="link"){ 

                $sql.= "f.element_type='link' AND ";

            }

             if($fault_arr['element_type']=="site"){    

                $sql.= "f.element_type='site' AND ";

            }



        }

        if($fault_arr['client_id']){

            $sql.= "f.client_id=".$fault_arr['client_id']. " AND ";

        }

        if($fault_arr['fault_status']){

            $sql.= "f.fault_status="."'".$fault_arr['fault_status']."'". " AND ";

        }               

        if($fault_arr['element_name']){

            if($fault_arr['element_type']=="link"){

                $sql.= " (l.link_name_nttn like "."'%".$fault_arr['element_name']."%'". " OR ";
                $sql.= "l.link_name_gateway like "."'%".$fault_arr['element_name']."%'". ") AND ";

            }
            
            if($fault_arr['element_type']=="site"){


                $sql.= "s.site_name like "."'%".$fault_arr['element_name']."%'". " AND ";
            }

        }

        if($fault_arr['link_type']){

            $sql.= "f.link_type like "."'%".$fault_arr['link_type']."%'". " AND ";

        }


        if($fault_arr['vlan_id']){

            if($fault_arr['element_type']=="link"){

                $sql.= "l.vlan_id like "."'%".$fault_arr['vlan_id']."%'". " AND ";

            }

        }

        if($fault_arr['link_id']){

            
            if($fault_arr['element_type']=="link"){

                $sql.= "l.link_id like "."'%".$fault_arr['link_id']."%'". " AND ";

            }

        }     
        if($fault_arr['site_ip_address']){

            if($fault_arr['element_type']=="site"){

                $sql.= "s.site_ip_address like "."'%".$fault_arr['site_ip_address']."%'". " AND ";

            }

        }                                                   
        if($fault_arr['district']){

            if($fault_arr['element_type']=="link"){

                $sql.= "l.district like "."'%".$fault_arr['district']."%'". "AND ";

            }
            if($fault_arr['element_type']=="site"){


                $sql.= "s.district like "."'%".$fault_arr['district']."%'". "AND ";
            }

        }   
        if($fault_arr['region']){

            if($fault_arr['element_type']=="link"){

                $sql.= "l.region like "."'%".$fault_arr['region']."%'". "AND ";

            }
            if($fault_arr['element_type']=="site"){


                $sql.= "s.region like "."'%".$fault_arr['region']."%'". "AND ";
            }

            

        }   
        if($fault_arr['sms_group']){

            if($fault_arr['element_type']=="link"){

                $sql.= "l.sms_group like "."'%".$fault_arr['sms_group']."%'". "AND ";

            }
            if($fault_arr['element_type']=="site"){


                $sql.= "s.sms_group like "."'%".$fault_arr['sms_group']."%'". "AND ";
            }
            

        }
        if($fault_arr['client_priority']){


            $sql.= "c.priority like"."'%".$fault_arr['client_priority']."%'". "AND ";

        }
        if($fault_arr['client_side_impact']){

            $sql.= "f.client_side_impact like"."'%".$fault_arr['client_side_impact']."%'". "AND ";

        }
        if($fault_arr['responsible_field_team']){

            $sql.= "f.responsible_field_team like"."'%".$fault_arr['responsible_field_team']."%'". "AND ";


        }

        if($fault_arr['reason']){

            $sql.= "f.reason like"."'%".$fault_arr['reason']."%'". "AND ";

        }
        if($fault_arr['provider']){

            $sql.= "phoenix_tt_db.client_table.client_name ="."'".$fault_arr['provider']."'". "AND ";


        }

        if($fault_arr['issue_type']){

            $sql.= "f.issue_type like"."'%".$fault_arr['issue_type']."%'". "AND ";

        }
        if($fault_arr['problem_category']){

            $sql.= "f.problem_category like"."'%".$fault_arr['problem_category']."%'". "AND ";

        }
        if($fault_arr['problem_source']){

            $sql.= "f.problem_source like"."'%".$fault_arr['problem_source']."%'". "AND ";

        }
        if($fault_arr['responsible_vendor']){


            if($fault_arr['element_type']=="link"){

                $sql.= "l.vendor like "."'%".$fault_arr['vendor']."%'". "AND ";

            }
            if($fault_arr['element_type']=="site"){


                $sql.= "s.vendor like "."'%".$fault_arr['vendor']."%'". "AND ";
            }
            

        }
        // if($fault_arr['escalation_time'] && $fault_arr['escalation_time_to']){

        //     $escalation_time_obj = new DateTime($fault_arr['escalation_time']);
        //     $escalation_time = $escalation_time_obj->format('Y-m-d H:i:s');

        //     $escalation_time_obj_to = new DateTime($fault_arr['escalation_time_to']);
        //     $escalation_time_to = $escalation_time_obj_to->format('Y-m-d H:i:s');

        //     $sql.= "f.escalation_time BETWEEN '$escalation_time' AND '$escalation_time_to' AND ";

        // }

        if($fault_arr['clear_time'] && $fault_arr['clear_time_to']){

            $clear_time_obj = new DateTime($fault_arr['clear_time']);
            $clear_time = $clear_time_obj->format('Y-m-d H:i:s');

            $clear_time_obj_to = new DateTime($fault_arr['clear_time_to']);
            $clear_time_to = $clear_time_obj_to->format('Y-m-d H:i:s');

            $sql.= "f.clear_time BETWEEN '$clear_time' AND '$clear_time_to' AND ";

        }                       
        if($fault_arr['responsible_concern']){

            $sql.= "f.responsible_concern like"."'%".$fault_arr['responsible_concern']."%'". "AND ";

        }  
        if($fault_arr['event_time'] && $fault_arr['event_time_to']){

            $event_time_obj = new DateTime($fault_arr['event_time']);
            $event_time = $event_time_obj->format('Y-m-d H:i:s');

            $event_time_obj_to = new DateTime($fault_arr['event_time_to']);
            $event_time_to = $event_time_obj_to->format('Y-m-d H:i:s');

            $sql.= "f.event_time BETWEEN '$event_time' AND '$event_time_to' AND ";

        }  
        if($fault_arr['provider_side_impact']){

            $sql.= "f.provider_side_impact like"."'%".$fault_arr['provider_side_impact']."%'". "AND ";

        }                                       

        if($fault_arr['remarks']){

            $sql.= "f.remarks like"."'%".$fault_arr['remarks']."%'". "AND ";

        }  

    


        $sql=trim($sql,"AND ");

        return $sql;



    }



    public function fault_search($fault_arr){


        $sql ="";


        if(!$fault_arr['element_type']){

            return "";
        }

        if($fault_arr['element_type']){


            if($fault_arr['element_type']=="link"){ 

                $sql.= "phoenix_tt_db.fault_table.element_type='link' AND ";

            }

             if($fault_arr['element_type']=="site"){    

                $sql.= "phoenix_tt_db.fault_table.element_type='site' AND ";

            }



        }

        if($fault_arr['client_id']){

            $sql.= "phoenix_tt_db.fault_table.client_id=".$fault_arr['client_id']. " AND ";

        }

        if($fault_arr['fault_status']){

            $sql.= "phoenix_tt_db.fault_table.fault_status="."'".$fault_arr['fault_status']."'". "AND ";

        }               

        if($fault_arr['element_name']){

            if($fault_arr['element_type']=="link"){

                $sql.= " (phoenix_tt_db.link_table.link_name_nttn like "."'%".$fault_arr['element_name']."%'". " OR ";
                $sql.= "phoenix_tt_db.link_table.link_name_gateway like "."'%".$fault_arr['element_name']."%' ) ". "AND ";

            }
            
            if($fault_arr['element_type']=="site"){


                $sql.= "phoenix_tt_db.site_table.site_name like "."'%".$fault_arr['element_name']."%'". " AND ";
            }

        }

        if($fault_arr['link_type']){

            $sql.= "phoenix_tt_db.fault_table.link_type like "."'%".$fault_arr['link_type']."%'". " AND ";

        }


        if($fault_arr['vlan_id']){

            if($fault_arr['element_type']=="link"){

                $sql.= "phoenix_tt_db.link_table.vlan_id like "."'%".$fault_arr['vlan_id']."%'". "AND ";

            }

        }

        if($fault_arr['link_id']){

            
            if($fault_arr['element_type']=="link"){

                $sql.= "phoenix_tt_db.link_table.link_id like "."'%".$fault_arr['link_id']."%'". "AND ";

            }

        }     
        if($fault_arr['site_ip_address']){

            if($fault_arr['element_type']=="site"){

                $sql.= "phoenix_tt_db.site_table.site_ip_address like "."'%".$fault_arr['site_ip_address']."%'". "AND ";

            }

        }                                                   
        if($fault_arr['district']){

            if($fault_arr['element_type']=="link"){

                $sql.= "phoenix_tt_db.link_table.district like "."'%".$fault_arr['district']."%'". "AND ";

            }
            if($fault_arr['element_type']=="site"){


                $sql.= "phoenix_tt_db.site_table.district like "."'%".$fault_arr['district']."%'". "AND ";
            }

        }   
        if($fault_arr['region']){

            if($fault_arr['element_type']=="link"){

                $sql.= "phoenix_tt_db.link_table.region like "."'%".$fault_arr['region']."%'". "AND ";

            }
            if($fault_arr['element_type']=="site"){


                $sql.= "phoenix_tt_db.site_table.region like "."'%".$fault_arr['region']."%'". "AND ";
            }

            

        }   
        if($fault_arr['sms_group']){

            if($fault_arr['element_type']=="link"){

                $sql.= "phoenix_tt_db.link_table.sms_group like "."'%".$fault_arr['sms_group']."%'". "AND ";

            }
            if($fault_arr['element_type']=="site"){


                $sql.= "phoenix_tt_db.site_table.sms_group like "."'%".$fault_arr['sms_group']."%'". "AND ";
            }
            

        }
        if($fault_arr['client_priority']){


            $sql.= "phoenix_tt_db.link_table.priority like"."'%".$fault_arr['client_priority']."%'". "AND ";

        }
        if($fault_arr['client_side_impact']){

            $sql.= "phoenix_tt_db.fault_table.client_side_impact like"."'%".$fault_arr['client_side_impact']."%'". "AND ";

        }
        if($fault_arr['responsible_field_team']){

            $sql.= "phoenix_tt_db.fault_table.responsible_field_team like"."'%".$fault_arr['responsible_field_team']."%'". "AND ";


        }

        if($fault_arr['reason']){

            $sql.= "phoenix_tt_db.fault_table.reason like"."'%".$fault_arr['reason']."%'". "AND ";

        }
        if($fault_arr['provider']){

            $sql.= "phoenix_tt_db.client_table.client_name ="."'".$fault_arr['provider']."'". "AND ";


        }

        if($fault_arr['issue_type']){

            $sql.= "phoenix_tt_db.fault_table.issue_type like"."'%".$fault_arr['issue_type']."%'". "AND ";

        }
        if($fault_arr['problem_category']){

            $sql.= "phoenix_tt_db.fault_table.problem_category like"."'%".$fault_arr['problem_category']."%'". "AND ";

        }
        if($fault_arr['problem_source']){

            $sql.= "phoenix_tt_db.fault_table.problem_source like"."'%".$fault_arr['problem_source']."%'". "AND ";

        }
        if($fault_arr['responsible_vendor']){


            if($fault_arr['element_type']=="link"){

                $sql.= "phoenix_tt_db.link_table.vendor like "."'%".$fault_arr['vendor']."%'". "AND ";

            }
            if($fault_arr['element_type']=="site"){


                $sql.= "phoenix_tt_db.site_table.vendor like "."'%".$fault_arr['vendor']."%'". "AND ";
            }
            

        }
        // if($fault_arr['escalation_time'] && $fault_arr['escalation_time_to']){

        //     $escalation_time_obj = new DateTime($fault_arr['escalation_time']);
        //     $escalation_time = $escalation_time_obj->format('Y-m-d H:i:s');

        //     $escalation_time_obj_to = new DateTime($fault_arr['escalation_time_to']);
        //     $escalation_time_to = $escalation_time_obj_to->format('Y-m-d H:i:s');

        //     $sql.= "phoenix_tt_db.fault_table.escalation_time BETWEEN '$escalation_time' AND '$escalation_time_to' AND ";

        // }

        if($fault_arr['clear_time'] && $fault_arr['clear_time_to']){

            $clear_time_obj = new DateTime($fault_arr['clear_time']);
            $clear_time = $clear_time_obj->format('Y-m-d H:i:s');

            $clear_time_obj_to = new DateTime($fault_arr['clear_time_to']);
            $clear_time_to = $clear_time_obj_to->format('Y-m-d H:i:s');

            $sql.= "phoenix_tt_db.fault_table.clear_time BETWEEN '$clear_time' AND '$clear_time_to' AND ";

        }                       
        if($fault_arr['responsible_concern']){

            $sql.= "phoenix_tt_db.fault_table.responsible_concern like"."'%".$fault_arr['responsible_concern']."%'". "AND ";

        }  
        if($fault_arr['event_time'] && $fault_arr['event_time_to']){

            $event_time_obj = new DateTime($fault_arr['event_time']);
            $event_time = $event_time_obj->format('Y-m-d H:i:s');

            $event_time_obj_to = new DateTime($fault_arr['event_time_to']);
            $event_time_to = $event_time_obj_to->format('Y-m-d H:i:s');

            $sql.= "phoenix_tt_db.fault_table.event_time BETWEEN '$event_time' AND '$event_time_to' AND ";

        }  
        if($fault_arr['provider_side_impact']){

            $sql.= "phoenix_tt_db.fault_table.provider_side_impact like"."'%".$fault_arr['provider_side_impact']."%'". "AND ";

        }                                       

        if($fault_arr['remarks']){

            $sql.= "phoenix_tt_db.fault_table.remarks like"."'%".$fault_arr['remarks']."%'". "AND ";

        }  

    


        $sql=trim($sql,"AND ");

        return $sql;



    }

    public function get_unms_tt_info($tt_info){
        $unms_tt = array();
        $unms_tt['alarmno'] = 'NA';
        $unms_tt['poll_addr'] = 'NA';
        $unms_tt['hostname'] = 'NA';
        $unms_tt['bw_configured'] = 'NA';
        $unms_tt['msg'] = 'NA';
        $unms_tt['resource_alias'] = 'NA';
        $unms_tt['name'] = 'NA';
        $unms_tt['alarm_time'] = 'NA';
        if($tt_info != ''){
            if($tt_info != 'No ticket found in UNMS'){
                $tt_info_array = json_decode($tt_info);
                // var_dump($tt_info_array);
                // dd($tt_info_array);
                // return
                $unms_tt['alarmno'] = $tt_info_array->alarmno;
                $unms_tt['poll_addr'] = $tt_info_array->poll_addr;
                $unms_tt['hostname'] = $tt_info_array->hostname;
                $unms_tt['bw_configured'] = $tt_info_array->bw_configured;
                $unms_tt['msg'] = $tt_info_array->msg;
                $unms_tt['resource_alias'] = $tt_info_array->resource_alias;
                $unms_tt['name'] = $tt_info_array->name;

                $date_time = $tt_info_array->last_event;
                $unms_tt['alarm_time'] = date('r', $date_time);      

                // $unms_tt['alarmno'] = $tt_info_array ['alarmno'];
                // $unms_tt['ip_addr'] = $tt_info_array ['ip_addr'];
                // $unms_tt['hostname'] = $tt_info_array ['hostname'];
                // $unms_tt['bw_configured'] = $tt_info_array ['bw_configured'];
                // $unms_tt['msg'] = $tt_info_array ['msg'];
                // $unms_tt['resource_alias'] = $tt_info_array ['resource_alias'];
                // $unms_tt['name'] = $tt_info_array ['name'];    
            }
        }
        return $unms_tt;

    }

    // public function kpi_view(){

    //     $query_middle_part = '';
    //     $hasSearchKpi = false;

    //     $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29";
    //     $department_lists = \DB::connection('mysql3')->select(\DB::raw($department_query));

    //     $link_type_query = 'SELECT * FROM phoenix_tt_db.link_type_table';
    //     $link_type_lists = \DB::select(\DB::raw($link_type_query));

    //     $client_list_query = 'SELECT * FROM phoenix_tt_db.client_table';
    //     $client_lists = \DB::select(\DB::raw($client_list_query));

    //     $problem_category_query = 'SELECT * FROM phoenix_tt_db.problem_category_table';
    //     $problem_category_lists = \DB::select(\DB::raw($problem_category_query));

    //     $problem_source_query = 'SELECT * FROM phoenix_tt_db.problem_source_table';
    //     $problem_source_lists = \DB::select(\DB::raw($problem_source_query));

    //     $reason_query = 'SELECT * FROM phoenix_tt_db.reason_table';
    //     $reason_lists = \DB::select(\DB::raw($reason_query));

    //     $issue_type_query = 'SELECT * FROM phoenix_tt_db.issue_type_table';
    //     $issue_type_lists = \DB::select(\DB::raw($issue_type_query));  

    //     $fault_arr = array();

    //     $client_id_temp = addslashes(Request::get('client_id'));
    //     $fault_arr['client_id'] = $client_id_temp;
    //     if($client_id_temp != ''){
    //         $query_middle_part .= " and f.client_id=$client_id_temp ";
            
    //     }
        
    //     $element_type_temp = addslashes(Request::get('element_type'));
    //     $fault_arr['element_type'] = $element_type_temp;
        

    //     $element_name_temp = addslashes(Request::get('element_name'));
    //     $fault_arr['element_name'] = $element_name_temp;

    //     $element_id_temp = addslashes(Request::get('element_id'));
    //     $fault_arr['element_id'] = $element_id_temp;
    //     if($element_id_temp != ''){
    //         $query_middle_part .= " and f.element_id=$element_id_temp ";
            
    //     }

    //     $vlan_id_temp = addslashes(Request::get('vlan_id'));
    //     $fault_arr['vlan_id'] = $vlan_id_temp;

    //     $link_type_temp = addslashes(Request::get('link_type'));
    //     $fault_arr['link_type'] = $link_type_temp;

    //     $link_id_temp = addslashes(Request::get('link_id'));
    //     $fault_arr['link_id'] = $link_id_temp;

    //     $site_ip_address_temp = addslashes(Request::get('site_ip_address'));
    //     $fault_arr['site_ip_address'] = $site_ip_address_temp;

    //     $district_temp = addslashes(Request::get('district'));
    //     $fault_arr['district'] = $district_temp;
    //     if($district_temp != ''){
    //         $query_middle_part .= " and f.district like '%$district_temp%' ";
            
    //     }


    //     $region_temp = addslashes(Request::get('region'));
    //     $fault_arr['region'] = $region_temp;
    //     if($region_temp != ''){
    //         $query_middle_part .= " and f.region like '%$region_temp%' ";
            
    //     }

    //     $sms_group_temp = addslashes(Request::get('sms_group'));
    //     $fault_arr['sms_group'] = $sms_group_temp;

    //     $client_priority_temp = addslashes(Request::get('client_priority'));
    //     $fault_arr['client_priority'] = $client_priority_temp;
    //     if($client_priority_temp != ''){
    //         $query_middle_part .= " and f.client_priority like '%$client_priority_temp%' ";
            
    //     }


    //     $client_side_impact_temp = addslashes(Request::get('client_side_impact'));
    //     $fault_arr['client_side_impact'] = $client_side_impact_temp;
    //     if($client_priority_temp != ''){
    //         $query_middle_part .= " and f.client_side_impact like '%$client_side_impact_temp%' ";
            
    //     }

    //     $responsible_field_team_temp = addslashes(Request::get('responsible_field_team'));
    //     $fault_arr['responsible_field_team'] = $responsible_field_team_temp;
    //     if($responsible_field_team_temp != ''){
    //         $query_middle_part .= " and f.responsible_field_team like '%$responsible_field_team_temp%' ";
            
    //     }

    //     $provider_temp = addslashes(Request::get('provider'));
    //     $fault_arr['provider'] = $provider_temp;
    //     if($provider_temp != ''){
    //         $query_middle_part .= " and f.provider like '%$provider_temp%' ";
            
    //     }

    //     $reason_temp = addslashes(Request::get('reason'));
    //     $fault_arr['reason'] = $reason_temp;
    //     if($reason_temp != ''){
    //         $query_middle_part .= " and f.reason  like '%$reason_temp%' ";
            
    //     }

    //     $fault_status_temp = addslashes(Request::get('fault_status'));
    //     $fault_arr['fault_status'] = $fault_status_temp;
    //     if($fault_status_temp != ''){
    //         $query_middle_part .= " and f.fault_status like '%$fault_status_temp%' ";
            
    //     }

    //     $department_id_temp = addslashes(Request::get('department_id'));
    //     $fault_arr['department_id'] = $department_id_temp;
    //     if($department_id_temp != ''){
    //         $query_middle_part .= " and t.task_assigned_dept=$department_id_temp ";
            
    //     }

    //     $task_resolver_temp = addslashes(Request::get('task_resolver'));
    //     $fault_arr['task_resolver'] = $task_resolver_temp;
    //     if($task_resolver_temp != ''){
    //         $query_middle_part .= " and t.task_resolver like '%$task_resolver_temp%' ";
            
    //     }

    //     $issue_type_temp = addslashes(Request::get('issue_type'));
    //     $fault_arr['issue_type'] = $issue_type_temp;
    //     if($issue_type_temp != ''){
    //         $query_middle_part .= " and f.issue_type like '%$issue_type_temp%' ";
            
    //     }

    //     $problem_category_temp = addslashes(Request::get('problem_category'));
    //     $fault_arr['problem_category'] = $problem_category_temp;
    //     if($problem_category_temp != ''){
    //         $query_middle_part .= " and f.problem_category like '%$problem_category_temp%' ";
            
    //     }

    //     $problem_source_temp = addslashes(Request::get('problem_source'));
    //     $fault_arr['problem_source'] = $problem_source_temp;
    //     if($problem_source_temp != ''){
    //         $query_middle_part .= " and f.problem_source like '%$problem_source_temp%' ";
            
    //     }

    //     $responsible_vendor_temp = addslashes(Request::get('responsible_vendor'));
    //     $fault_arr['responsible_vendor'] = $responsible_vendor_temp;        
    //     if($responsible_vendor_temp != ''){
    //         $query_middle_part .= " and f.responsible_vendor like '%$responsible_vendor_temp%' ";
            
    //     }

    //     $responsible_concern_temp = addslashes(Request::get('responsible_concern'));
    //     $fault_arr['responsible_concern'] = $responsible_concern_temp;
    //     if($responsible_concern_temp != ''){
    //         $query_middle_part .= " and t.task_responsible like '%$responsible_concern_temp%' ";
            
    //     }

    //     $event_time_from_temp = addslashes(Request::get('event_time_from'));
    //     $fault_arr['event_time_from'] = $event_time_from_temp;

    //     $event_time_to_temp = addslashes(Request::get('event_time_to'));
    //     $fault_arr['event_time_to'] = $event_time_to_temp;
    //     if($event_time_from_temp != '' && $event_time_to_temp != ''){

    //         $date1=date_create($event_time_from_temp);
    //         $date2=date_create($event_time_to_temp);
    //         $diff=date_diff($date1,$date2);
    //         $date1 = $date1->format('Y-m-d H:i:s');
    //         $date2 = $date2->format('Y-m-d H:i:s');          

    //         if($diff->format('%m months') > 6 ){
    //             $msg = 'Please be informed that Event time from and to difference cannot be greater than 6 months';
    //             return view('errors.msg_phoenix',compact('msg'));
    //         }
        
    //         $query_middle_part .= " and f.event_time between '$date1' and '$date2' ";
    //         $hasSearchKpi = true;
    //     }
        


    //     $provider_side_impact_temp = addslashes(Request::get('provider_side_impact'));
    //     $fault_arr['provider_side_impact'] = $provider_side_impact_temp;
    //     if($provider_side_impact_temp != ''){
    //         $query_middle_part .= " and f.provider_side_impact lik '%$provider_side_impact_temp%' ";
            
    //     }

    //     $remarks_temp = addslashes(Request::get('remarks'));
    //     $fault_arr['remarks'] = $remarks_temp;
    //     if($remarks_temp != ''){
    //         $query_middle_part .= " and f.remarks like '%$remarks_temp%'";
            
    //     }

    //     $report_list = addslashes(Request::get('report_list'));
    //     $fault_arr['report_list'] = $report_list;
    //     $query_end_part = '';
    //     $query_start_part = '';

    //     $smallArrHeader = array();
        
        

    //     if($report_list == 'dept_wise_mttr'){
    //         $query_start_part .= " , (select dept_name from hr_tool_db.department_table where dept_row_id = t.task_assigned_dept) as department,";
    //         $query_end_part .= " group by t.task_assigned_dept ";
    //         //
    //         array_push($smallArrHeader,'Department Wise');
    //     }   
    //     else if($report_list == 'task_executor_wise_mttr'){
    //         $query_start_part .= " , t.task_resolver , ";
    //         $query_end_part .= " group by t.task_resolver ";
    //         //
    //         array_push($smallArrHeader,'Task Executor Wise');
    //     } 
    //     else if($report_list == 'task_responsible_wise_mttr'){
    //         $query_start_part .= " , t.task_responsible, ";
    //         $query_end_part .= " group by t.task_responsible "; 
    //         //
    //         array_push($smallArrHeader,'Task Responsible Wise'); 
    //     }
    //     else if($report_list == 'task_subcenter_wise_mttr'){
    //         $query_start_part .= " , subcenter, ";
    //         $query_end_part .= " group by t.subcenter ";
    //         //
    //         array_push($smallArrHeader,'Sub Group Wise');
    //     }
    //     else if($report_list == 'problem_category_wise_mttr'){
    //         $query_end_part .= " group by f.problem_category ";
    //         $query_start_part .= " , f.problem_category, ";
    //         //
    //         array_push($smallArrHeader,'Problem Category Wise');
    //     }
    //     else{
    //         $query_end_part .= " group by f.client_id ";
    //         $query_start_part .= " , (select client_name from phoenix_tt_db.client_table where client_id = f.client_id) as client, ";
    //         //
    //         array_push($smallArrHeader,'Client wise');
    //     }
    //     array_push($smallArrHeader,'Responsible Holding Duration');
    //     array_push($smallArrHeader,'Fault Count');

    //     /********************************TASK KPI********************************************/
    //     array_push($smallArrHeader,'Average Task Holding Time');
    //     array_push($smallArrHeader,'Total Task Holding Duration');
    //     array_push($smallArrHeader,'Task Holding Percentage');



    //     $select_dept_wise_query = "SELECT sum(TIMESTAMPDIFF(second,t.task_start_time_db, t.task_end_time_db)/3600) as duration, GROUP_CONCAT(DISTINCT(t.fault_id)) as fault_ids,count(DISTINCT(t.fault_id)) as fault_count $query_start_part (sum(TIMESTAMPDIFF(second,t.task_start_time_db, t.task_end_time_db)/3600)/count(DISTINCT(t.fault_id))) as MTTR FROM phoenix_tt_db.task_table t, phoenix_tt_db.fault_table f , phoenix_tt_db.ticket_table tt where t.fault_id = f.fault_id and t.ticket_id = tt.ticket_id and tt.ticket_status='Closed' ".$query_middle_part." ".$query_end_part;
    //     //echo $select_dept_wise_query;
    //     $fault_lists = \DB::select(\DB::raw($select_dept_wise_query)); 
    //     //return $fault_lists;
    //     $bigArr = array();
    //     $headerArr = array();
    //     //array_push($bigArr, $headerArr);
    //     array_push($bigArr, $smallArrHeader);
    //     $fault_id_lists = '';
    //     foreach ($fault_lists as $fault_list) {
            
    //         $smallArr = array();
            
    //         if($report_list == 'dept_wise_mttr'){
    //             array_push($smallArr, $fault_list->department);
    //         }   
    //         else if($report_list == 'task_executor_wise_mttr'){
    //             array_push($smallArr, $fault_list->task_resolver);
    //         } 
    //         else if($report_list == 'task_responsible_wise_mttr'){
    //             array_push($smallArr, $fault_list->task_responsible);
    //         }
    //         else if($report_list == 'task_subcenter_wise_mttr'){
    //             array_push($smallArr, $fault_list->subcenter);
    //         }
    //         else if($report_list == 'problem_category_wise_mttr'){
    //             array_push($smallArr, $fault_list->problem_category);
    //         }
    //         else{
    //             array_push($smallArr, $fault_list->client);
    //         }
    //         $fault_id_lists .= $fault_list->fault_ids.",";
    //         $select_total_duration_fault_query = "SELECT sum(TIMESTAMPDIFF(second,t.task_start_time_db, t.task_end_time_db)/3600) as duration from task_table t where t.fault_id in ($fault_list->fault_ids)";
    //         $total_duration_fault = \DB::select(\DB::raw($select_total_duration_fault_query)); 
    //         array_push($smallArr, $fault_list->duration);
    //         array_push($smallArr, $fault_list->fault_count);          
    //         array_push($smallArr, $fault_list->MTTR);
    //         array_push($smallArr, $total_duration_fault[0]->duration);
    //         array_push($smallArr, ($fault_list->duration/$total_duration_fault[0]->duration)*100);
    //         array_push($bigArr, $smallArr);

    //     }
    //     //return $bigArr;   
    //     if($hasSearchKpi == true){
    //         //return '';
    //         $export = fopen('../kpi_task_export/task_kpi_mttr_export.csv','w');
    //         foreach ($bigArr as $fields) {
    //             fputcsv($export, $fields);
    //         }
    //         //$path = '../Uploaded_Files/export.csv';
    //         //return response()->download($path); 
    //         //echo 'asdf';
    //     }
    //     /************************************************************TASK Raw KPI****************************************************************************/
    //     if($fault_id_lists !=''){
    //         //echo $fault_id_lists;
    //         $raw_small_header_arr = array();
    //         array_push($raw_small_header_arr,'Ticket ID');
    //         array_push($raw_small_header_arr,'Fault ID');
    //         array_push($raw_small_header_arr,'Task ID');
    //         array_push($raw_small_header_arr,'Task Name');
    //         array_push($raw_small_header_arr,'Task Description');
    //         array_push($raw_small_header_arr,'Task Status');
    //         array_push($raw_small_header_arr,'Task Assigned Dept');
    //         array_push($raw_small_header_arr,'Subcenter');
    //         array_push($raw_small_header_arr,'Task Start Time DB');
    //         array_push($raw_small_header_arr,'Task End Time DB');
    //         array_push($raw_small_header_arr,'Task Responsible');
    //         array_push($raw_small_header_arr,'Task Resolver');
    //         array_push($raw_small_header_arr,'Task Closer ID');



    //         $select_query_raw = "Select *,(select dept_name from hr_tool_db.department_table where dept_row_id = task_assigned_dept) as department from phoenix_tt_db.task_table where fault_id IN (".trim($fault_id_lists,',').")";
    //         //echo $select_dept_wise_query;
    //         $fault_raw_lists = \DB::select(\DB::raw($select_query_raw)); 
    //         //return $fault_lists;
    //         $bigRawArr = array();
    //         //$raw_small_header_arr = array();
    //         //array_push($bigArr, $headerArr);
    //         array_push($bigRawArr, $raw_small_header_arr);
    //         foreach ($fault_raw_lists as $fault_raw_list) {
                
    //             $smallArr = array();
    //             array_push($smallArr,$fault_raw_list->ticket_id);
    //             array_push($smallArr,$fault_raw_list->fault_id);
    //             array_push($smallArr,$fault_raw_list->task_id);
    //             array_push($smallArr,$fault_raw_list->task_name);
    //             array_push($smallArr,$fault_raw_list->task_description);
    //             array_push($smallArr,$fault_raw_list->task_status);
    //             array_push($smallArr,$fault_raw_list->department);
    //             array_push($smallArr,$fault_raw_list->subcenter);
    //             array_push($smallArr,$fault_raw_list->task_start_time_db);
    //             array_push($smallArr,$fault_raw_list->task_end_time_db);
    //             array_push($smallArr,$fault_raw_list->task_responsible);
    //             array_push($smallArr,$fault_raw_list->task_closer_id);
                
    //             array_push($bigRawArr, $smallArr);

    //         }
    //         //return $bigArr;   
    //         if($hasSearchKpi == true){
    //             //return '';
    //             $export = fopen('../kpi_task_export/task_kpi_raw_export.csv','w');
    //             foreach ($bigRawArr as $fields) {
    //                 fputcsv($export, $fields);
    //             }
    //             //$path = '../Uploaded_Files/export.csv';

    //             $pathCheck1 = '../kpi_task_export/kpi_export.zip';
           
    //             File::delete($pathCheck1);

    //             $path = '../kpi_task_export/*';
    //             $files = glob($path);
    //             $makepath = '../kpi_task_export/kpi_export.zip';
    //             Zipper::make($makepath)->add($files);
    //             // /$pathCheck = '../kpi_task_export/kpi_export.zip';
    //             return redirect('fileDownloadKpi?kpi_id=task');
    //             //return response()->download($makepath);
    //             //return response()->download($path); 
    //             //echo 'asdf';
    //         }

    //     }

    //     //echo $select_dept_wise_query;

    //     return view('kpi.kpi_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists','fault_arr'));
    // }
    // public function downloadFileKpi(){
    //     $kpi_id = Request::get('kpi_id');
    //     if($kpi_id = 'task'){
    //         $pathCheck = '../kpi_task_export/kpi_export.zip';
    //     }
        
    //     return response()->download($pathCheck);
    // }

    // public function kpi_element_view(){
    //     $element_type = Request::get('element_type');
    //     $client_id = Request::get('client_id');
    //     return view('kpi.kpi_element_view',compact('client_id','element_type'));
    // }
    // public function kpi_responsible_view(){
    //     $id = Request::get('id');
    //     return view('kpi.kpi_responsible_concern_view',compact('id'));
    // }
}
