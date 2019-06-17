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

session_start();

class KpiController extends Controller
{

    public function kpi_view_fault(){


        $query_middle_part = '';
        $hasSearchKpi = false;

        // $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29";
        $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29 AND dept_row_id IN (4,10,11,12,15,34,35,36,41,43,45,46,47)";
        $department_lists = \DB::connection('mysql3')->select(\DB::raw($department_query));

        $link_type_query = 'SELECT * FROM phoenix_tt_db.link_type_table';
        $link_type_lists = \DB::select(\DB::raw($link_type_query));

        $client_list_query = 'SELECT * FROM phoenix_tt_db.client_table';
        $client_lists = \DB::select(\DB::raw($client_list_query));

        $problem_category_query = 'SELECT * FROM phoenix_tt_db.problem_category_table';
        $problem_category_lists = \DB::select(\DB::raw($problem_category_query));

        $problem_source_query = 'SELECT * FROM phoenix_tt_db.problem_source_table';
        $problem_source_lists = \DB::select(\DB::raw($problem_source_query));

        $reason_query = 'SELECT * FROM phoenix_tt_db.reason_table';
        $reason_lists = \DB::select(\DB::raw($reason_query));

        $district_query = 'SELECT * FROM phoenix_tt_db.district_table';
        $district_lists = \DB::select(\DB::raw($district_query));

        $issue_type_query = 'SELECT * FROM phoenix_tt_db.issue_type_table';
        $issue_type_lists = \DB::select(\DB::raw($issue_type_query));  

        $fault_arr = array();
        $element_type_temp = addslashes(Request::get('element_type'));
        $fault_arr['element_type'] = $element_type_temp;

        $client_id_temp = addslashes(Request::get('client_id'));
        $fault_arr['client_id'] = $client_id_temp;

        $district = addslashes(Request::get('district'));
        $fault_arr['ditrict'] = $district;

        $region= addslashes(Request::get('region'));
        $fault_arr['region'] = $region;



        if($client_id_temp != ''){
            $query_middle_part .= " and f.client_id=$client_id_temp ";
            if($element_type_temp =='link'){
                $total_client_count_query = "select count(client) as client_count from phoenix_tt_db.link_table where client=".$client_id_temp;
                $total_client_count_lists = \DB::select(\DB::raw($total_client_count_query));
                $total_client_count = $total_client_count_lists[0]->client_count;
            }
            if($element_type_temp =='site'){
                $total_client_count_query = "select count(client) as client_count from phoenix_tt_db.site_table where client=".$client_id_temp;
                $total_client_count_lists = \DB::select(\DB::raw($total_client_count_query));
                $total_client_count = $total_client_count_lists[0]->client_count;
            }
            
            
        }
        
        
        

        // $element_name_temp = addslashes(Request::get('element_name'));
        // $fault_arr['element_name'] = $element_name_temp;

        // $element_id_temp = addslashes(Request::get('element_id'));
        // $fault_arr['element_id'] = $element_id_temp;
        // if($element_id_temp != ''){
        //     $query_middle_part .= " and f.element_id=$element_id_temp ";
            
        // }
        // $link_type_temp = addslashes(Request::get('link_type'));
        // $fault_arr['link_type'] = $link_type_temp;

        // $vlan_id_temp = addslashes(Request::get('vlan_id'));
        // $fault_arr['vlan_id'] = $vlan_id_temp;

        

        // $link_id_temp = addslashes(Request::get('link_id'));
        // $fault_arr['link_id'] = $link_id_temp;

        // $site_ip_address_temp = addslashes(Request::get('site_ip_address'));
        // $fault_arr['site_ip_address'] = $site_ip_address_temp;

        // $district_temp = addslashes(Request::get('district'));
        // $fault_arr['district'] = $district_temp;
        // if($district_temp != ''){
        //     $query_middle_part .= " and f.district like '%$district_temp%' ";
            
        // }


        // $region_temp = addslashes(Request::get('region'));
        // $fault_arr['region'] = $region_temp;
        // if($region_temp != ''){
        //     $query_middle_part .= " and f.region like '%$region_temp%' ";
            
        // }

        // $sms_group_temp = addslashes(Request::get('sms_group'));
        // $fault_arr['sms_group'] = $sms_group_temp;

        // $client_priority_temp = addslashes(Request::get('client_priority'));
        // $fault_arr['client_priority'] = $client_priority_temp;
        // if($client_priority_temp != ''){
        //     $query_middle_part .= " and f.client_priority like '%$client_priority_temp%' ";
            
        // }


        // $client_side_impact_temp = addslashes(Request::get('client_side_impact'));
        // $fault_arr['client_side_impact'] = $client_side_impact_temp;
        // if($client_priority_temp != ''){
        //     $query_middle_part .= " and f.client_side_impact like '%$client_side_impact_temp%' ";
            
        // }

        // $responsible_field_team_temp = addslashes(Request::get('responsible_field_team'));
        // $fault_arr['responsible_field_team'] = $responsible_field_team_temp;
        // if($responsible_field_team_temp != ''){
        //     $query_middle_part .= " and f.responsible_field_team like '%$responsible_field_team_temp%' ";
            
        // }

        // $provider_temp = addslashes(Request::get('provider'));
        // $fault_arr['provider'] = $provider_temp;
        // if($provider_temp != ''){
        //     $query_middle_part .= " and f.provider like '%$provider_temp%' ";
            
        // }

        // $reason_temp = addslashes(Request::get('reason'));
        // $fault_arr['reason'] = $reason_temp;
        // if($reason_temp != ''){
        //     $query_middle_part .= " and f.reason  like '%$reason_temp%' ";
            
        // }

        // $fault_status_temp = addslashes(Request::get('fault_status'));
        // $fault_arr['fault_status'] = $fault_status_temp;
        // if($fault_status_temp != ''){
        //     $query_middle_part .= " and f.fault_status like '%$fault_status_temp%' ";
            
        // }

        // $department_id_temp = addslashes(Request::get('department_id'));
        // $fault_arr['department_id'] = $department_id_temp;
        // if($department_id_temp != ''){
        //     $query_middle_part .= " and t.task_assigned_dept=$department_id_temp ";
            
        // }

        // $task_resolver_temp = addslashes(Request::get('task_resolver'));
        // $fault_arr['task_resolver'] = $task_resolver_temp;
        // if($task_resolver_temp != ''){
        //     $query_middle_part .= " and t.task_resolver like '%$task_resolver_temp%' ";
            
        // }

        // $issue_type_temp = addslashes(Request::get('issue_type'));
        // $fault_arr['issue_type'] = $issue_type_temp;
        // if($issue_type_temp != ''){
        //     $query_middle_part .= " and f.issue_type like '%$issue_type_temp%' ";
            
        // }

        // $problem_category_temp = addslashes(Request::get('problem_category'));
        // $fault_arr['problem_category'] = $problem_category_temp;
        // if($problem_category_temp != ''){
        //     $query_middle_part .= " and f.problem_category like '%$problem_category_temp%' ";
            
        // }

        // $problem_source_temp = addslashes(Request::get('problem_source'));
        // $fault_arr['problem_source'] = $problem_source_temp;
        // if($problem_source_temp != ''){
        //     $query_middle_part .= " and f.problem_source like '%$problem_source_temp%' ";
            
        // }

        // $responsible_vendor_temp = addslashes(Request::get('responsible_vendor'));
        // $fault_arr['responsible_vendor'] = $responsible_vendor_temp;        
        // if($responsible_vendor_temp != ''){
        //     $query_middle_part .= " and f.responsible_vendor like '%$responsible_vendor_temp%' ";
            
        // }

        // $responsible_concern_temp = addslashes(Request::get('responsible_concern'));
        // $fault_arr['responsible_concern'] = $responsible_concern_temp;
        // if($responsible_concern_temp != ''){
        //     $query_middle_part .= " and t.task_responsible like '%$responsible_concern_temp%' ";
            
        // }

        $event_time_from_temp = addslashes(Request::get('event_time_from'));
        $fault_arr['event_time_from'] = $event_time_from_temp;

        $event_time_to_temp = addslashes(Request::get('event_time_to'));
        $fault_arr['event_time_to'] = $event_time_to_temp;
        //echo "$event_time_from_temp - $event_time_to_temp <br>";

        if($event_time_from_temp != '' && $event_time_to_temp != ''){

            $date1=date_create($event_time_from_temp);
            $date2=date_create($event_time_to_temp);
            $diff=date_diff($date1,$date2);
            $date1 = $date1->format('Y-m-d H:i:s');
            $date2 = $date2->format('Y-m-d H:i:s');          

            if($diff->format('%m months') > 6 ){
                $msg = 'Please be informed that Event time from and to difference cannot be greater than 6 months';
                return view('errors.msg_phoenix',compact('msg'));
            }
        
            $query_middle_part .= " and f.event_time between '$date1' and '$date2' ";
            $hasSearchKpi = true;

            $user_id = $_SESSION['user_id'];

            $report_log_id = DB::table('report_download_log')->insertGetId(
                [
                    'user_id' => $user_id,
                    'report_type' => 'Fault KPI'
                ]
                );


        }


        
        $LH = addslashes(Request::get('LH'));
        $metro = addslashes(Request::get('metro'));
        $dark_core = addslashes(Request::get('dark_core'));
        $mobile_backhaul = addslashes(Request::get('mobile_backhaul'));
        $link_category = addslashes(Request::get('link_category'));
        $link_conn_type = addslashes(Request::get('link_conn_type'));

        $searched_str = 'Searched Elements : ';

        if($LH !=''){
            $searched_str .= " (LH = ".$LH.")";
        }
        if($metro != ''){
            $searched_str .= " (metro = ".$metro.")";
        }
        if($dark_core != ''){
            $searched_str .= " (dark_core = ".$dark_core.")";
        }
        if($mobile_backhaul != ''){
            $searched_str .= " (mobile_backhaul = ".$mobile_backhaul.")";
        }
        if($link_category != ''){
            $searched_str .= " (link_category = ".$link_category.")";
        }
        if($link_conn_type != ''){
            $searched_str .= " (link_conn_type = ".$link_conn_type.")";
        }
        if($event_time_from_temp != ''){
            $searched_str .= " (event_time_from_temp = ".$event_time_from_temp.")";
        }
        if($event_time_to_temp != ''){
            $searched_str .= " (event_time_to_temp = ".$event_time_to_temp.")";
        }
        if($region != ''){
            $searched_str .= " (region = ".$region.")";
        }
        if($district != ''){
            $searched_str .= " (district = ".$district.")";
        }
        if($client_id_temp != ''){
            $searched_str .= " (client_id_temp = ".$client_id_temp.")";
        }
        if($element_type_temp != ''){
            $searched_str .= " (element_type_temp = ".$element_type_temp.")";
        }



        // $provider_side_impact_temp = addslashes(Request::get('provider_side_impact'));
        // $fault_arr['provider_side_impact'] = $provider_side_impact_temp;
        // if($provider_side_impact_temp != ''){
        //     $query_middle_part .= " and f.provider_side_impact lik '%$provider_side_impact_temp%' ";
            
        // }

        // $remarks_temp = addslashes(Request::get('remarks'));
        // $fault_arr['remarks'] = $remarks_temp;
        // if($remarks_temp != ''){
        //     $query_middle_part .= " and f.remarks like '%$remarks_temp%'";
            
        // }

        $report_list = addslashes(Request::get('report_list'));
        $fault_arr['report_list'] = $report_list;
        $query_end_part = '';
        $query_start_part = '';

        $smallArrHeader = array();
        
        $total_duration_on_element_count = 0;
        $diff_hour = (strtotime($event_time_to_temp) - strtotime($event_time_from_temp))/3600;

        $query_super_start_part = '';
        $query_super_end_part = '';



 ///////////////////////REGION-WISE FAULT/////////////////////////////////////////////


        if($report_list == 'region_wise_mttr'){
            $query_super_start_part = "select c.region_name,c.region_id as element_table_id,ff.* from region_table c LEFT JOIN (";
            $query_super_end_part = ") as ff ON c.region_name = ff.region";
            if($element_type_temp =='link'){
                $query_start_part .= " , (select region from link_table where link_name_id = f.element_id) as region,(select sub_center_primary from link_table where link_name_id = f.element_id) as subcenter,";
                $query_end_part .= " AND (select include from reason_table r where r.reason_name=f.reason) ='Include' AND (select include from problem_category_table pct where pct.problem_name = f.problem_category)='Outage' group by region ";

                $element_table_arr =  $this->kpi_element_processor($client_id_temp,$element_type_temp,$LH,$metro,$dark_core,$mobile_backhaul,$link_category,$link_conn_type,$district,$region,'region');
                $query_middle_part .= " AND f.element_id IN (".$element_table_arr['element_ids'].")  AND f.element_type='$element_type_temp'";
                $group_by_elements = $element_table_arr['element_group_by_count_arr'];
                //return $group_by_elements;
                
                //print_r($element_table_arr);
            }
            if($element_type_temp =='site'){
                $query_start_part .= " , (select region from site_table where site_name_id = f.element_id) as region,(select sub_center from site_table where site_name_id = f.element_id) as sub_center,";
                $query_end_part .= " AND (select include from reason_table r where r.reason_name=f.reason) ='Include' AND (select include from problem_category_table pct where pct.problem_name = f.problem_category)='Outage' group by region ";

                $element_table_arr =  $this->kpi_element_processor($client_id_temp,$element_type_temp,$LH,$metro,$dark_core,$mobile_backhaul,$link_category,$link_conn_type,$district,$region,'region');
                $query_middle_part .= " AND f.element_id IN (".$element_table_arr['element_ids'].")  AND f.element_type='$element_type_temp'";
                $group_by_elements = $element_table_arr['element_group_by_count_arr'];
                
            }
            //
            $group_by_name = 'region';
            array_push($smallArrHeader,'Region Wise');
            //print_r($smallArrHeader);
        }  




 ///////////////////////DISTRICT-WISE FAULT/////////////////////////////////////////////
 

        if($report_list == 'district_wise_mttr'){
            $query_super_start_part = "select c.district_name,c.district_row_id as element_table_id,ff.* from district_table c LEFT JOIN (";
            $query_super_end_part = ") as ff ON c.district_name = ff.district";
            if($element_type_temp =='link'){
                $query_start_part .= " , (select district from link_table where link_name_id = f.element_id) as district , (select sub_center_primary from link_table where link_name_id = f.element_id) as subcenter,";
                $query_end_part .= " AND (select include from reason_table r where r.reason_name=f.reason) ='Include' AND (select include from problem_category_table pct where pct.problem_name = f.problem_category)='Outage' group by district ";

                $element_table_arr =  $this->kpi_element_processor($client_id_temp,$element_type_temp,$LH,$metro,$dark_core,$mobile_backhaul,$link_category,$link_conn_type,$district,$region,'district');
                $query_middle_part .= " AND f.element_id IN (".$element_table_arr['element_ids'].") AND f.element_type='$element_type_temp'";
                $group_by_elements = $element_table_arr['element_group_by_count_arr'];
            }
            if($element_type_temp =='site'){
                $query_start_part .= " , (select district from site_table where site_name_id = f.element_id) as district , (select sub_center from site_table where site_name_id = f.element_id) as sub_center,";
                $query_end_part .= " AND (select include from reason_table r where r.reason_name=f.reason) ='Include' AND (select include from problem_category_table pct where pct.problem_name = f.problem_category)='Outage' group by district ";

                $element_table_arr =  $this->kpi_element_processor($client_id_temp,$element_type_temp,$LH,$metro,$dark_core,$mobile_backhaul,$link_category,$link_conn_type,$district,$region,'district');
                $query_middle_part .= " AND f.element_id IN (".$element_table_arr['element_ids'].")  AND f.element_type='$element_type_temp'";
                $group_by_elements = $element_table_arr['element_group_by_count_arr'];
            }
            //
            $group_by_name = 'district';
            array_push($smallArrHeader,'District Wise');
        } 


 ///////////////////////CLIENT-WISE FAULT/////////////////////////////////////////////



        if($report_list == 'client_wise_mttr'){

            $query_super_start_part = "select c.client_name,c.client_id as element_table_id,ff.* from client_table c LEFT JOIN (";
            $query_super_end_part = ") as ff ON c.client_id = ff.client_id";
            if($element_type_temp =='link'){
                $query_start_part .= " , (select client_name from phoenix_tt_db.client_table where client_id = f.client_id) as client,client_id,(select sub_center_primary from link_table where link_name_id = f.element_id) as subcenter, ";
                $query_end_part .= " AND (select include from reason_table r where r.reason_name=f.reason) ='Include' AND (select include from problem_category_table pct where pct.problem_name = f.problem_category)='Outage' group by client_id";

                $element_table_arr =  $this->kpi_element_processor($client_id_temp,$element_type_temp,$LH,$metro,$dark_core,$mobile_backhaul,$link_category,$link_conn_type,$district,$region,'client');

                $query_middle_part .= " AND f.element_id IN (".$element_table_arr['element_ids'].")  AND f.element_type='$element_type_temp'";
                $group_by_elements = $element_table_arr['element_group_by_count_arr'];
            }
            if($element_type_temp =='site'){
                $query_start_part .= "  , (select client_name from phoenix_tt_db.client_table where client_id = f.client_id) as client,client_id, (select sub_center from site_table where site_name_id = f.element_id) as sub_center, ";
                $query_end_part .= " AND (select include from reason_table r where r.reason_name=f.reason) ='Include' AND (select include from problem_category_table pct where pct.problem_name = f.problem_category)='Outage' group by client_id ";

                $element_table_arr =  $this->kpi_element_processor($client_id_temp,$element_type_temp,$LH,$metro,$dark_core,$mobile_backhaul,$link_category,$link_conn_type,$district,$region,'client');
                $query_middle_part .= " AND f.element_id IN (".$element_table_arr['element_ids'].")  AND f.element_type='$element_type_temp'";
                $group_by_elements = $element_table_arr['element_group_by_count_arr'];
            }
            //
            $group_by_name = 'client_id';
            array_push($smallArrHeader,'Client Wise');


        } 
        //print_r($group_by_elements);
        //return view('kpi.kpi_view_fault',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists','fault_arr'));
        // else if($report_list == 'task_responsible_wise_mttr'){
        //     $query_start_part .= " , t.task_responsible, ";
        //     $query_end_part .= " group by t.task_responsible "; 
        //     //
        //     array_push($smallArrHeader,'Task Responsible Wise'); 
        // }
        // else if($report_list == 'task_subcenter_wise_mttr'){
        //     $query_start_part .= " , subcenter, ";
        //     $query_end_part .= " group by t.subcenter ";
        //     //
        //     array_push($smallArrHeader,'Sub Group Wise');
        // }
        // else if($report_list == 'problem_category_wise_mttr'){
        //     $query_end_part .= " group by f.problem_category ";
        //     $query_start_part .= " , f.problem_category, ";
        //     //
        //     array_push($smallArrHeader,'Problem Category Wise');
        // }
        // else{
        //     $query_end_part .= " group by f.client_id ";
        //     $query_start_part .= " , (select client_name from phoenix_tt_db.client_table where client_id = f.client_id) as client, ";
        //     //
        //     array_push($smallArrHeader,'Client wise');
        // }
        $bigArr = array();
        $raw_small_header_arr = array();
        array_push($raw_small_header_arr,$searched_str);
        array_push($bigArr, $raw_small_header_arr);
        $raw_small_header_arr = array();

        array_push($smallArrHeader,'Outage Duration');
        array_push($smallArrHeader, 'Element Count');
        array_push($smallArrHeader,'Fault Count');

        /********************************TASK KPI********************************************/
        array_push($smallArrHeader,'NA');
        array_push($smallArrHeader,'MTTR');

        
        array_push($bigArr, $smallArrHeader);

        //,(100-((sum(TIMESTAMPDIFF(second,f.event_time, f.clear_time)/3600))/(((TIMESTAMPDIFF(second,'$date1', '$date2')/3600))*count(DISTINCT(f.fault_id))))*100) as NA

        if($hasSearchKpi == true){
            $select_dept_wise_query = $query_super_start_part."select sum(TIMESTAMPDIFF(second,f.event_time, f.clear_time)/3600) as down_time_duration,GROUP_CONCAT(DISTINCT(f.fault_id)) as fault_ids,count(DISTINCT(f.fault_id)) as fault_count   ".$query_start_part." sum(TIMESTAMPDIFF(second,f.event_time, f.clear_time)/3600)/count(DISTINCT(f.fault_id)) as MTTR 
                FROM 
                phoenix_tt_db.fault_table f , phoenix_tt_db.ticket_table tt where f.ticket_id = tt.ticket_id and tt.ticket_status='Closed'  and f.clear_time is not null ".$query_middle_part." ".$query_end_part.$query_super_end_part;
                $fault_id_lists = '';
            //echo $select_dept_wise_query;
            //return view('kpi.kpi_view_fault',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists','fault_arr','district_lists'));
            //return $select_dept_wise_query;

            ///////////and f.reason != 'Others: Client end problem' and f.reason != 'Others: No Problem Found at SCL End' and f.reason != 'Planned Work : Capacity Up-gradation' and f.reason != 'Planned Work : High Loss Rectification' and f.reason != 'Planned Work : Network Expansion' and f.reason != 'Planned Work : Other NCR Works' and f.reason != 'Planned Work : Software Up-gradation'    
            try {
                //Problem Source
                //echo 'asdf';
                // echo $select_dept_wise_query;
                // echo "<br>";

                $fault_lists = \DB::select(\DB::raw($select_dept_wise_query));
                //echo $select_dept_wise_query;
                //print_r($fault_lists);
                // echo "<br>";

                // return "success";
                //return $fault_lists;
                
                $headerArr = array();
                //array_push($bigArr, $headerArr);
                
                
                //echo 'asdf';


                //print_r($group_by_elements);
                //return '';
                foreach ($fault_lists as $fault_list) {
                    //echo $fault_list->element_table_id."<br>";
                    $smallArr = array();
                    //if (array_key_exists($fault_list->$group_by_name,$group_by_elements)){
                        if($report_list == 'region_wise_mttr'){
                            array_push($smallArr, $fault_list->region_name);
                        }   
                        if($report_list == 'district_wise_mttr'){
                            array_push($smallArr, $fault_list->district_name);
                        } 
                        if($report_list == 'client_wise_mttr'){
                            array_push($smallArr, $fault_list->client_name);
                        } 
                        //echo $fault_list->fault_ids;
                        
                        // $select_total_duration_fault_query = "SELECT sum(TIMESTAMPDIFF(second,t.task_start_time_db, t.task_end_time_db)/3600) as duration from task_table t where t.fault_id in ($fault_list->fault_ids)";
                        // $total_duration_fault = \DB::select(\DB::raw($select_total_duration_fault_query)); 
                        if($fault_list->down_time_duration == ""){
                            array_push($smallArr, "0");
                            if(array_key_exists($fault_list->$group_by_name,$group_by_elements)){
                                array_push($smallArr, $group_by_elements[$fault_list->$group_by_name]);
                                array_push($smallArr, "0");
                                array_push($smallArr, "100");
                                array_push($smallArr, "0");
                            }
                            else{
                                if(array_key_exists($fault_list->element_table_id,$group_by_elements)){
                                    
                                    array_push($smallArr, $group_by_elements[$fault_list->element_table_id]);
                                    array_push($smallArr, "0");
                                    array_push($smallArr, "100");
                                    array_push($smallArr, "0");
                                }
                                else{
                                    array_push($smallArr, "0");
                                    array_push($smallArr, "0");
                                    array_push($smallArr, "0");
                                    array_push($smallArr, "0");
                                }
                                
                            }
                        }
                        else{
                            if(array_key_exists($fault_list->$group_by_name,$group_by_elements)){
                                $fault_id_lists .= $fault_list->fault_ids.",";
                                array_push($smallArr, $fault_list->down_time_duration);
                                //echo $fault_list->$group_by_name;
                                array_push($smallArr, $group_by_elements[$fault_list->$group_by_name]);

                                $count_group_by = $group_by_elements[$fault_list->$group_by_name];
                                
                                array_push($smallArr, $fault_list->fault_count);

                                $NA = (($diff_hour*$count_group_by - $fault_list->down_time_duration)/($diff_hour*$count_group_by))*100;
                                //echo "Count Group By =  group_by_elements[".$fault_list->$group_by_name."]<br>";
                                //echo "NA =  (($diff_hour * $count_group_by - $fault_list->down_time_duration)/($diff_hour*$count_group_by))*100;<br>";
                                

                                array_push($smallArr, $NA ); 

                                array_push($smallArr, $fault_list->MTTR);
                            }

                        }
                        //return $smallArr;
                        //echo "<br>";
                        
                        array_push($bigArr, $smallArr);
                    //}
                    
                    
                }    
            } 
            catch (\Illuminate\Database\QueryException $e) {
                $msg = "No data found on the filtered value [".$searched_str."]";
                $url =  "/phoenix/public/KpiViewFault";
                return view('errors.msg_phoenix',compact('msg','url'));
            }    
            
        //return $bigArr;   
        
            //return '';
            $export = fopen('../kpi_fault_export/fault_kpi_mttr_export.csv','w');
            foreach ($bigArr as $fields) {
                fputcsv($export, $fields);
            }
            //echo $fault_id_lists;
            //$path = '../Uploaded_Files/export.csv';
            //return response()->download($path); 
            //echo 'asdf';
        }
        //return '';
        //print_r($bigArr);
        //echo $fault_id_lists;
        //return view('kpi.kpi_view_fault',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists','fault_arr'));
        /************************************************************Fault Raw KPI****************************************************************************/

        //return $hasSearchKpi; 

        if($hasSearchKpi == true){



            if($fault_id_lists !=''){
                //echo $fault_id_lists;
                //echo $fault_id_lists;



                $bigRawArr = array();
                $raw_small_header_arr = array();
                array_push($raw_small_header_arr,$searched_str);
                array_push($bigRawArr, $raw_small_header_arr);
                $raw_small_header_arr = array();
                array_push($raw_small_header_arr,'Ticket ID');
                array_push($raw_small_header_arr,'Ticket Title');
                array_push($raw_small_header_arr,'Fault ID');
                array_push($raw_small_header_arr,'Problem Category');
                array_push($raw_small_header_arr,'Element Name');
                array_push($raw_small_header_arr,'Client');
                array_push($raw_small_header_arr,'Client Side Impact');
                array_push($raw_small_header_arr,'Region');
                array_push($raw_small_header_arr,'subcenter');
                array_push($raw_small_header_arr,'District');
                array_push($raw_small_header_arr,'Event Time');
                array_push($raw_small_header_arr,'Escalation Time');
                array_push($raw_small_header_arr,'Clear Time');
                array_push($raw_small_header_arr,'Reason');
                array_push($raw_small_header_arr,'Provider Side Impact');
                array_push($raw_small_header_arr,'Link Type');
                array_push($raw_small_header_arr,'Issue Type');
                array_push($raw_small_header_arr,'Provider');



                array_push($bigRawArr, $raw_small_header_arr);

                //array_push($raw_small_header_arr,'Task_comments');

                //(select GROUP_CONCAT('[',t.task_comment_user_id,']','[',t.dept_name,']','[',t.task_comment_time,']','[',t.task_status,'] :',t.task_comment SEPARATOR '||') as task_coms from task_update_log t where t.fault_id=f.fault_id  group by t.fault_id order by t.task_update_log_row_id asc) as task_comments 
                if($fault_arr['element_type'] == 'link'){
                    $select_query_raw = "Select f.*,(select CONCAT(link_name_nttn,link_name_gateway) from phoenix_tt_db.link_table where link_name_id = f.element_id) as element_name,
                    (select region from phoenix_tt_db.link_table where link_name_id = f.element_id) as region,
                    (select sub_center_primary from phoenix_tt_db.link_table where link_name_id = f.element_id) as sub_center,
                    (select district from phoenix_tt_db.link_table where link_name_id = f.element_id) as district,
                    (select client_name from phoenix_tt_db.client_table where client_id=f.client_id) as client,
                    (select client_name from phoenix_tt_db.client_table where client_id=f.provider) as provider,
                    (select ticket_title from phoenix_tt_db.ticket_table where ticket_id=f.ticket_id) as ticket_title                    
                     from phoenix_tt_db.fault_table f where fault_id IN (".trim($fault_id_lists,',').")";

                     $export_site_file = fopen('../kpi_fault_export/total_site_summary.csv','w');
                     $site_summary_query = "select s.region,(select client_name from client_table where client_id=s.client) as client_name,count(s.site_name_id) as total_count from site_table s where s.flag !='Disabled' group by s.region,s.client";
                     $site_sum_lists = \DB::select(\DB::raw($site_summary_query)); 
                     $tempSmallArr = array();
                    array_push($tempSmallArr, 'Region');
                    array_push($tempSmallArr, 'Client');
                    array_push($tempSmallArr, 'Count');
                    fputcsv($export_site_file, $tempSmallArr);
                    foreach ($site_sum_lists as $site_sum_list) {
                        $tempSmallArr = array();
                        array_push($tempSmallArr, $site_sum_list->region);
                        array_push($tempSmallArr, $site_sum_list->client_name);
                        array_push($tempSmallArr, $site_sum_list->total_count);
                        fputcsv($export_site_file, $tempSmallArr);
                    }

                    $export_site_file = fopen('../kpi_fault_export/total_link_summary.csv','w');
                     $site_summary_query = "select s.region,s.link_conn_type,count(s.link_name_id) as total_count from link_table s where s.flag !='Disabled' and s.link_conn_type ='OH' or s.link_conn_type ='UG' group by s.region,s.link_conn_type";
                     $site_sum_lists = \DB::select(\DB::raw($site_summary_query)); 
                     $tempSmallArr = array();
                    array_push($tempSmallArr, 'Region');
                    array_push($tempSmallArr, 'Link Type');
                    array_push($tempSmallArr, 'Count');
                    fputcsv($export_site_file, $tempSmallArr);
                    foreach ($site_sum_lists as $site_sum_list) {
                        $tempSmallArr = array();
                        array_push($tempSmallArr, $site_sum_list->region);
                        array_push($tempSmallArr, $site_sum_list->link_conn_type);
                        array_push($tempSmallArr, $site_sum_list->total_count);
                        fputcsv($export_site_file, $tempSmallArr);
                    }
                }
                else{
                    $select_query_raw = "Select f.*,(select CONCAT(site_name) from phoenix_tt_db.site_table where site_name_id = element_id) as element_name,
                    (select region from phoenix_tt_db.site_table where site_name_id = f.element_id) as region,
                    (select sub_center from phoenix_tt_db.site_table where site_name_id = f.element_id) as sub_center,
                    (select district from phoenix_tt_db.site_table where site_name_id = f.element_id) as district,
                    (select client_name from phoenix_tt_db.client_table where client_id=f.provider) as provider,
                    (select client_name from phoenix_tt_db.client_table where client_id=f.client_id) as client,
                    (select ticket_title from phoenix_tt_db.ticket_table where ticket_id=f.ticket_id) as ticket_title
                     from phoenix_tt_db.fault_table f where fault_id IN (".trim($fault_id_lists,',').")";

                     $export_site_file = fopen('../kpi_fault_export/total_site_summary.csv','w');
                     $site_summary_query = "select s.region,(select client_name from client_table where client_id=s.client) as client_name,count(s.site_name_id) as total_count from site_table s where s.flag !='Disabled' group by s.region,s.client";
                     $site_sum_lists = \DB::select(\DB::raw($site_summary_query)); 
                     $tempSmallArr = array();
                    array_push($tempSmallArr, 'Region');
                    array_push($tempSmallArr, 'Client');
                    array_push($tempSmallArr, 'Count');
                    fputcsv($export_site_file, $tempSmallArr);
                    foreach ($site_sum_lists as $site_sum_list) {
                        $tempSmallArr = array();
                        array_push($tempSmallArr, $site_sum_list->region);
                        array_push($tempSmallArr, $site_sum_list->client_name);
                        array_push($tempSmallArr, $site_sum_list->total_count);
                        fputcsv($export_site_file, $tempSmallArr);
                    }

                    //select s.region,s.link_conn_type,count(s.link_name_id) as total_count from link_table s where s.flag !='Disabled' and s.link_conn_type ='OH' or s.link_conn_type ='UG' group by s.region,s.link_conn_type

                    $export_site_file = fopen('../kpi_fault_export/total_link_summary.csv','w');
                     $site_summary_query = "select s.region,s.link_conn_type,count(s.link_name_id) as total_count from link_table s where s.flag !='Disabled' and s.link_conn_type ='OH' or s.link_conn_type ='UG' group by s.region,s.link_conn_type";
                     $site_sum_lists = \DB::select(\DB::raw($site_summary_query)); 
                     $tempSmallArr = array();
                    array_push($tempSmallArr, 'Region');
                    array_push($tempSmallArr, 'Link Type');
                    array_push($tempSmallArr, 'Count');
                    fputcsv($export_site_file, $tempSmallArr);
                    foreach ($site_sum_lists as $site_sum_list) {
                        $tempSmallArr = array();
                        array_push($tempSmallArr, $site_sum_list->region);
                        array_push($tempSmallArr, $site_sum_list->link_conn_type);
                        array_push($tempSmallArr, $site_sum_list->total_count);
                        fputcsv($export_site_file, $tempSmallArr);
                    }
                }

                //dd($select_query_raw);
                
                //return $select_query_raw;

                try {


                    
                
                    $fault_raw_lists = \DB::select(\DB::raw($select_query_raw)); 


                    $row_count = count($fault_raw_lists);

                    $update_row_count_in_log = "UPDATE phoenix_tt_db.report_download_log SET row_count = $row_count WHERE id = $report_log_id";
                    \DB::update(\DB::raw($update_row_count_in_log));
                    //return $fault_lists;
                    
                    //$raw_small_header_arr = array();
                    //array_push($bigArr, $headerArr);
                    //array_push($bigRawArr, $raw_small_header_arr);
                    foreach ($fault_raw_lists as $fault_raw_list) {
                    
                        $smallArr = array();
                        array_push($smallArr,$fault_raw_list->ticket_id);
                        array_push($smallArr,$fault_raw_list->ticket_title);
                        array_push($smallArr,$fault_raw_list->fault_id);
                        array_push($smallArr,$fault_raw_list->problem_category);
                        array_push($smallArr,$fault_raw_list->element_name);
                        array_push($smallArr,$fault_raw_list->client);
                        array_push($smallArr,$fault_raw_list->client_side_impact);
                        array_push($smallArr,$fault_raw_list->region);
                        array_push($smallArr,$fault_raw_list->sub_center);
                        array_push($smallArr,$fault_raw_list->district);
                        array_push($smallArr,$fault_raw_list->event_time);
                        array_push($smallArr,$fault_raw_list->escalation_time);
                        array_push($smallArr,$fault_raw_list->clear_time);
                        array_push($smallArr,$fault_raw_list->reason);
                        array_push($smallArr,$fault_raw_list->provider_side_impact);
                        array_push($smallArr,$fault_raw_list->link_type);
                        array_push($smallArr,$fault_raw_list->issue_type);
                        array_push($smallArr,$fault_raw_list->provider);
                        //array_push($smallArr,$fault_raw_list->task_comments);
                        
                        array_push($bigRawArr, $smallArr);

                    }
                } 
                catch (\Illuminate\Database\QueryException $e) {
                    
                }
            //return $bigArr;   
            
                //return '';
                $export = fopen('../kpi_fault_export/fault_kpi_raw_export.csv','w');
                foreach ($bigRawArr as $fields) {
                    fputcsv($export, $fields);
                }

                //$path = '../Uploaded_Files/export.csv';

                $pathCheck1 = '../kpi_fault_export/kpi_export.zip';
           
                File::delete($pathCheck1);

                $path = '../kpi_fault_export/*';
                $files = glob($path);
                $makepath = '../kpi_fault_export/kpi_export.zip';
                Zipper::make($makepath)->add($files);

                // /$pathCheck = '../kpi_task_export/kpi_export.zip';
                return redirect('fileDownloadKpi?kpi_id=fault');

                
                //return response()->download($makepath);
                //return response()->download($path); 
                //echo 'asdf';
            }

        }
         return view('kpi.kpi_view_fault',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists','fault_arr','district_lists'));
    }


    /************************************TASK*************************************************************************/
    /************************************TASK*************************************************************************/
    /************************************TASK*************************************************************************/
    /************************************TASK*************************************************************************/
    /************************************TASK*************************************************************************/
    /************************************TASK*************************************************************************/
    /************************************TASK*************************************************************************/
    /************************************TASK*************************************************************************/
    /************************************TASK*************************************************************************/
    /************************************TASK*************************************************************************/

    public function kpi_element_processor($client_id,$element_type,$LH,$metro,$dark_core,$mobile_backhaul,$link_category,$link_conn_type,$district,$region,$group_by){
        $return_arr = array();
        $element_ids = '';
        $element_arr = array();

        $LH_query = '';
        $metro_query = '';
        $dark_core_query = '';
        $mobile_backhaul_query = '';

        if($link_conn_type ==''){
            $append_query_link_conn_type ="";
        }
        else{
            if($link_conn_type =='OU'){
                $append_query_link_conn_type = " AND (link_conn_type like '%UG%' AND link_conn_type like '%OH%') OR (link_conn_type like '%OU%')";
            }
            else{
                $append_query_link_conn_type = " AND link_conn_type='".$link_conn_type."'";
            }
        }
        
        if($link_category ==''){
            $append_query_link_category= "";
        }
        else{
            if($link_category == 'Normal'){
                $append_query_link_category = " AND link_category like '%".$link_category."%' ";
            }
            else if($link_category == 'Messenger'){
                $append_query_link_category = " AND link_category like '%".$link_category."%' ";
            }
            else{
                $append_query_link_category = " AND link_category='".$link_category."'";
            }
            
        }

        if($LH !=''){
            $LH_query = " AND LH='".$LH."'";
        }
        if($metro !=''){
            $metro_query = " AND metro='".$metro."'";
        }
        if($dark_core !=''){
            $dark_core_query = " AND dark_core='".$dark_core."'";
        }
        if($mobile_backhaul !=''){
            $mobile_backhaul_query = " AND mobile_backhaul='".$mobile_backhaul."'";
        }


        if($client_id == ''){
            $client_id_query = " 1 ";
        }
        else{
            $client_id_query = "client='".$client_id."'";
        }

        if($region == ''){
            $region = " ";
        }
        else{
            $region = "AND region='".$region."'";
        }

        if($district ==''){
            $district = " ";
        }
        else{
            $district = "AND district='".$district."'";
        }
        


        if($element_type == 'link'){
            $select_element_list_query = "SELECT * FROM link_table WHERE ".$client_id_query.$region.$district.$LH_query.$metro_query.$dark_core_query.$mobile_backhaul_query.$append_query_link_conn_type."  ".$append_query_link_category." AND flag !='Disabled' ";
            //echo $select_element_list_query.'<br>';

            //dd($select_element_list_query);
            $selected_element_lists = \DB::select(\DB::raw($select_element_list_query));
            foreach($selected_element_lists as $selected_element_list){
                $element_ids .= $selected_element_list->link_name_id.","; 
            }
            $return_arr['element_count'] = count($selected_element_lists);
            $return_arr['element_ids'] = trim($element_ids,",");



            $select_element_list_query_group_by = "SELECT count(link_name_id) as group_by_element_count,".$group_by." FROM link_table WHERE ".$client_id_query.$region.$district.$LH_query.$metro_query.$dark_core_query.$mobile_backhaul_query.$append_query_link_conn_type."  ".$append_query_link_category." AND flag !='Disabled' GROUP BY ".$group_by;
            //echo $select_element_list_query_group_by.'<br>';
            $selected_element_group_by_lists = \DB::select(\DB::raw($select_element_list_query_group_by));

            

            foreach($selected_element_group_by_lists as $selected_element_group_by_list){
                $element_arr[$selected_element_group_by_list->$group_by] = $selected_element_group_by_list->group_by_element_count;
            }

            $this->put_elements_in_csv_link($selected_element_lists);

            
            $return_arr['element_group_by_count_arr'] = $element_arr;
            //$return_arr['element_group_by_name_count_arr'] = $element_arr;

        }
        if($element_type == 'site'){
            $select_element_list_query = "SELECT * FROM site_table WHERE ".$client_id_query.$region.$district." AND flag !='Disabled' ";
            $selected_element_lists = \DB::select(\DB::raw($select_element_list_query));

            $this->put_elements_in_csv_site($selected_element_lists);

            $select_element_list_query_group_by = "SELECT count(site_name_id) as group_by_element_count,".$group_by." FROM site_table WHERE ".$client_id_query.$region.$district."   AND flag !='Disabled' GROUP BY ".$group_by;
            $selected_element_group_by_lists = \DB::select(\DB::raw($select_element_list_query_group_by));

            foreach($selected_element_group_by_lists as $selected_element_group_by_list){
                $element_arr[$selected_element_group_by_list->$group_by] = $selected_element_group_by_list->group_by_element_count;
            }

            foreach($selected_element_lists as $selected_element_list){
                $element_ids .= $selected_element_list->site_name_id.","; 
            }
            $return_arr['element_count'] = count($selected_element_lists);
            $return_arr['element_ids'] = trim($element_ids,",");
            $return_arr['element_group_by_count_arr'] = $element_arr;


        }
        //print_r($return_arr);

        return $return_arr;     
        
    }



    public function put_elements_in_csv_link($elementLists){

    }
    public function put_elements_in_csv_site($elementLists){

    }



    public function kpi_view(){

        $query_middle_part = '';
        $hasSearchKpi = false;

        // $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29";
        $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29 AND dept_row_id IN (4,10,11,12,15,34,35,36,41,43,45,46,47)";
        $department_lists = \DB::connection('mysql3')->select(\DB::raw($department_query));

        $link_type_query = 'SELECT * FROM phoenix_tt_db.link_type_table';
        $link_type_lists = \DB::select(\DB::raw($link_type_query));

        $client_list_query = 'SELECT * FROM phoenix_tt_db.client_table';
        $client_lists = \DB::select(\DB::raw($client_list_query));

        $problem_category_query = 'SELECT * FROM phoenix_tt_db.problem_category_table';
        $problem_category_lists = \DB::select(\DB::raw($problem_category_query));

        $problem_source_query = 'SELECT * FROM phoenix_tt_db.problem_source_table';
        $problem_source_lists = \DB::select(\DB::raw($problem_source_query));

        $reason_query = 'SELECT * FROM phoenix_tt_db.reason_table';
        $reason_lists = \DB::select(\DB::raw($reason_query));

        $issue_type_query = 'SELECT * FROM phoenix_tt_db.issue_type_table';
        $issue_type_lists = \DB::select(\DB::raw($issue_type_query));  

        $fault_arr = array();

        $client_id_temp = addslashes(Request::get('client_id'));
        $fault_arr['client_id'] = $client_id_temp;
        if($client_id_temp != ''){
            $query_middle_part .= " and f.client_id=$client_id_temp ";
            
        }
        
        $element_type_temp = addslashes(Request::get('element_type'));
        $fault_arr['element_type'] = $element_type_temp;
        

        $element_name_temp = addslashes(Request::get('element_name'));
        $fault_arr['element_name'] = $element_name_temp;

        $element_id_temp = addslashes(Request::get('element_id'));
        $fault_arr['element_id'] = $element_id_temp;
        if($element_id_temp != ''){
            $query_middle_part .= " and f.element_id=$element_id_temp ";
            
        }

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
        if($district_temp != ''){
            $query_middle_part .= " and f.district like '%$district_temp%' ";
            
        }


        $region_temp = addslashes(Request::get('region'));
        $fault_arr['region'] = $region_temp;
        if($region_temp != ''){
            $query_middle_part .= " and f.region like '%$region_temp%' ";
            
        }

        $sms_group_temp = addslashes(Request::get('sms_group'));
        $fault_arr['sms_group'] = $sms_group_temp;

        $client_priority_temp = addslashes(Request::get('client_priority'));
        $fault_arr['client_priority'] = $client_priority_temp;
        if($client_priority_temp != ''){
            $query_middle_part .= " and f.client_priority like '%$client_priority_temp%' ";
            
        }


        $client_side_impact_temp = addslashes(Request::get('client_side_impact'));
        $fault_arr['client_side_impact'] = $client_side_impact_temp;
        if($client_priority_temp != ''){
            $query_middle_part .= " and f.client_side_impact like '%$client_side_impact_temp%' ";
            
        }

        $responsible_field_team_temp = addslashes(Request::get('responsible_field_team'));
        $fault_arr['responsible_field_team'] = $responsible_field_team_temp;
        if($responsible_field_team_temp != ''){
            $query_middle_part .= " and f.responsible_field_team like '%$responsible_field_team_temp%' ";
            
        }

        $provider_temp = addslashes(Request::get('provider'));
        $fault_arr['provider'] = $provider_temp;
        if($provider_temp != ''){
            $query_middle_part .= " and f.provider like '%$provider_temp%' ";
            
        }

        $reason_temp = addslashes(Request::get('reason'));
        $fault_arr['reason'] = $reason_temp;
        if($reason_temp != ''){
            $query_middle_part .= " and f.reason  like '%$reason_temp%' ";
            
        }

        $fault_status_temp = addslashes(Request::get('fault_status'));
        $fault_arr['fault_status'] = $fault_status_temp;
        if($fault_status_temp != ''){
            $query_middle_part .= " and f.fault_status like '%$fault_status_temp%' ";
            
        }

        $department_id_temp = addslashes(Request::get('department_id'));
        $fault_arr['department_id'] = $department_id_temp;
        if($department_id_temp != ''){
            $query_middle_part .= " and t.task_assigned_dept=$department_id_temp ";
            
        }

        $task_resolver_temp = addslashes(Request::get('task_resolver'));
        $fault_arr['task_resolver'] = $task_resolver_temp;
        if($task_resolver_temp != ''){
            $query_middle_part .= " and t.task_resolver like '%$task_resolver_temp%' ";
            
        }

        $issue_type_temp = addslashes(Request::get('issue_type'));
        $fault_arr['issue_type'] = $issue_type_temp;
        if($issue_type_temp != ''){
            $query_middle_part .= " and f.issue_type like '%$issue_type_temp%' ";
            
        }

        $problem_category_temp = addslashes(Request::get('problem_category'));
        $fault_arr['problem_category'] = $problem_category_temp;
        if($problem_category_temp != ''){
            $query_middle_part .= " and f.problem_category like '%$problem_category_temp%' ";
            
        }

        $problem_source_temp = addslashes(Request::get('problem_source'));
        $fault_arr['problem_source'] = $problem_source_temp;
        if($problem_source_temp != ''){
            $query_middle_part .= " and f.problem_source like '%$problem_source_temp%' ";
            
        }

        $responsible_vendor_temp = addslashes(Request::get('responsible_vendor'));
        $fault_arr['responsible_vendor'] = $responsible_vendor_temp;        
        if($responsible_vendor_temp != ''){
            $query_middle_part .= " and f.responsible_vendor like '%$responsible_vendor_temp%' ";
            
        }

        $responsible_concern_temp = addslashes(Request::get('responsible_concern'));
        $fault_arr['responsible_concern'] = $responsible_concern_temp;
        if($responsible_concern_temp != ''){
            $query_middle_part .= " and t.task_responsible like '%$responsible_concern_temp%' ";
            
        }

        $event_time_from_temp = addslashes(Request::get('event_time_from'));
        $fault_arr['event_time_from'] = $event_time_from_temp;

        $event_time_to_temp = addslashes(Request::get('event_time_to'));
        $fault_arr['event_time_to'] = $event_time_to_temp;
        if($event_time_from_temp != '' && $event_time_to_temp != ''){

            $date1=date_create($event_time_from_temp);
            $date2=date_create($event_time_to_temp);
            $diff=date_diff($date1,$date2);
            $date1 = $date1->format('Y-m-d H:i:s');
            $date2 = $date2->format('Y-m-d H:i:s');          

            if($diff->format('%m months') > 6 ){
                $msg = 'Please be informed that Event time from and to difference cannot be greater than 6 months';
                return view('errors.msg_phoenix',compact('msg'));
            }
        
            $query_middle_part .= " and f.event_time between '$date1' and '$date2' ";
            $hasSearchKpi = true;

            $user_id = $_SESSION['user_id'];

            $report_log_id = DB::table('report_download_log')->insertGetId(
                [
                    'user_id' => $user_id,
                    'report_type' => 'Task KPI'
                ]
                );



        }
        


        $provider_side_impact_temp = addslashes(Request::get('provider_side_impact'));
        $fault_arr['provider_side_impact'] = $provider_side_impact_temp;
        if($provider_side_impact_temp != ''){
            $query_middle_part .= " and f.provider_side_impact lik '%$provider_side_impact_temp%' ";
            
        }

        $remarks_temp = addslashes(Request::get('remarks'));
        $fault_arr['remarks'] = $remarks_temp;
        if($remarks_temp != ''){
            $query_middle_part .= " and f.remarks like '%$remarks_temp%'";
            
        }

        $report_list = addslashes(Request::get('report_list'));
        $fault_arr['report_list'] = $report_list;
        $query_end_part = '';
        $query_start_part = '';

        $smallArrHeader = array();
        
        

        if($report_list == 'dept_wise_mttr'){
            $query_start_part .= " , (select dept_name from hr_tool_db.department_table where dept_row_id = t.task_assigned_dept) as department,";
            $query_end_part .= " group by t.task_assigned_dept ";
            //
            array_push($smallArrHeader,'Department Wise');
        }   
        else if($report_list == 'task_executor_wise_mttr'){
            $query_start_part .= " , t.task_resolver , ";
            $query_end_part .= " group by t.task_resolver ";
            //
            array_push($smallArrHeader,'Task Executor Wise');
        } 
        else if($report_list == 'task_responsible_wise_mttr'){
            $query_start_part .= " , t.task_responsible, ";
            $query_end_part .= " group by t.task_responsible "; 
            //
            array_push($smallArrHeader,'Task Responsible Wise'); 
        }
        else if($report_list == 'task_subcenter_wise_mttr'){
            $query_start_part .= " , subcenter, ";
            $query_end_part .= " group by t.subcenter ";
            //
            array_push($smallArrHeader,'Sub Group Wise');
        }
        else if($report_list == 'problem_category_wise_mttr'){
            $query_end_part .= " group by f.problem_category ";
            $query_start_part .= " , f.problem_category, ";
            //
            array_push($smallArrHeader,'Problem Category Wise');
        }
        else{
            $query_end_part .= " group by f.client_id ";
            $query_start_part .= " , (select client_name from phoenix_tt_db.client_table where client_id = f.client_id) as client, ";
            //
            array_push($smallArrHeader,'Client wise');
        }
        array_push($smallArrHeader,'Responsible Holding Duration');
        array_push($smallArrHeader,'Fault Count');

        /********************************TASK KPI********************************************/
        array_push($smallArrHeader,'Average Task Holding Time');
        array_push($smallArrHeader,'Total Task Holding Duration');
        array_push($smallArrHeader,'Task Holding Percentage');



        $select_dept_wise_query = "SELECT sum(TIMESTAMPDIFF(second,t.task_start_time_db, t.task_end_time_db)/3600) as duration, GROUP_CONCAT(DISTINCT(t.fault_id)) as fault_ids,count(DISTINCT(t.fault_id)) as fault_count $query_start_part (sum(TIMESTAMPDIFF(second,t.task_start_time_db, t.task_end_time_db)/3600)/count(DISTINCT(t.fault_id))) as MTTR FROM phoenix_tt_db.task_table t,phoenix_tt_db.fault_table f , phoenix_tt_db.ticket_table tt where t.fault_id = f.fault_id and t.ticket_id = tt.ticket_id and t.task_status='Closed' and f.element_type='$element_type_temp' and t.task_end_time_db is not null ".$query_middle_part." ".$query_end_part;
        //echo $select_dept_wise_query;
        $fault_lists = \DB::select(\DB::raw($select_dept_wise_query)); 
        //return $fault_lists;
        $bigArr = array();
        $headerArr = array();
        //array_push($bigArr, $headerArr);
        array_push($bigArr, $smallArrHeader);
        $fault_id_lists = '';
        foreach ($fault_lists as $fault_list) {
            $select_total_duration_fault_query = "SELECT sum(TIMESTAMPDIFF(second,t.task_start_time_db, t.task_end_time_db)/3600) as duration from task_table t where t.fault_id in ($fault_list->fault_ids) and t.task_status='Closed' and t.task_end_time_db is not null ";
            $total_duration_fault = \DB::select(\DB::raw($select_total_duration_fault_query)); 

            // $select_total_fault_query = "SELECT sum(TIMESTAMPDIFF(second,t.task_start_time_db, t.task_end_time_db)/3600) as duration, t.task_end_time_db as t_task_end_time_db from task_table t where t.fault_id in ($fault_list->fault_ids) and t.task_status='Closed' and t.task_end_time_db is not null ";
            // $total_faults = \DB::select(\DB::raw($select_total_fault_query)); 
            $smallArr = array();
            
            if($report_list == 'dept_wise_mttr'){
                array_push($smallArr, $fault_list->department);
            }   
            else if($report_list == 'task_executor_wise_mttr'){
                array_push($smallArr, $fault_list->task_resolver);
            } 
            else if($report_list == 'task_responsible_wise_mttr'){
                array_push($smallArr, $fault_list->task_responsible);
            }
            else if($report_list == 'task_subcenter_wise_mttr'){
                array_push($smallArr, $fault_list->subcenter);
            }
            else if($report_list == 'problem_category_wise_mttr'){
                array_push($smallArr, $fault_list->problem_category);
            }
            else{
                array_push($smallArr, $fault_list->client);
            }
            $fault_id_lists .= $fault_list->fault_ids.",";
            
            //echo "<br>".$select_total_duration_fault_query;
            
            array_push($smallArr, $fault_list->duration);
            array_push($smallArr, $fault_list->fault_count);          
            array_push($smallArr, $fault_list->MTTR);
            array_push($smallArr, $total_duration_fault[0]->duration);
            array_push($smallArr, ($fault_list->duration/$total_duration_fault[0]->duration)*100);
            array_push($bigArr, $smallArr);
            
        }
        //return $bigArr;   
        if($hasSearchKpi == true){
            //return '';
            $export = fopen('../kpi_task_export/task_kpi_mttr_export.csv','w');
            foreach ($bigArr as $fields) {
                fputcsv($export, $fields);
            }
            //$path = '../Uploaded_Files/export.csv';
            //return response()->download($path); 
            //echo 'asdf';
        }
        /************************************************************TASK Raw KPI****************************************************************************/
        if($fault_id_lists !=''){
            //echo $fault_id_lists;
            $raw_small_header_arr = array();
            array_push($raw_small_header_arr,'Ticket ID');
            array_push($raw_small_header_arr,'Fault ID');            
            array_push($raw_small_header_arr,'Problem Category');
            array_push($raw_small_header_arr,'Client');
            array_push($raw_small_header_arr,'Task ID');
            array_push($raw_small_header_arr,'Task Name');
            array_push($raw_small_header_arr,'Task Description');
            array_push($raw_small_header_arr,'Task Status');
            array_push($raw_small_header_arr,'Task Assigned Dept');
            array_push($raw_small_header_arr,'Subcenter');
            array_push($raw_small_header_arr,'Task Start Time DB');
            array_push($raw_small_header_arr,'Task End Time DB');
            array_push($raw_small_header_arr,'Task Responsible');
            array_push($raw_small_header_arr,'Task Resolver');
            array_push($raw_small_header_arr,'Task Closer ID');




            $select_query_raw = "Select tt.*,(select dept_name from hr_tool_db.department_table where dept_row_id = task_assigned_dept) as department,ft.problem_category,ct.client_name
                                from phoenix_tt_db.task_table tt
                                join phoenix_tt_db.fault_table ft ON tt.fault_id = ft.fault_id
                                join phoenix_tt_db.client_table ct ON ft.client_id = ct.client_id
                                where tt.fault_id IN (".trim($fault_id_lists,',').") and task_status='Closed' and task_end_time_db is not null";

            //return $select_query_raw; 
            //echo "<br>".$select_query_raw;
            $fault_raw_lists = \DB::select(\DB::raw($select_query_raw)); 
            //return $fault_lists;
            $bigRawArr = array();
            //$raw_small_header_arr = array();
            //array_push($bigArr, $headerArr);
            array_push($bigRawArr, $raw_small_header_arr);
            foreach ($fault_raw_lists as $fault_raw_list) {
                
                $smallArr = array();
                array_push($smallArr,$fault_raw_list->ticket_id);
                array_push($smallArr,$fault_raw_list->fault_id);
                array_push($smallArr,$fault_raw_list->problem_category);
                array_push($smallArr,$fault_raw_list->client_name);
                array_push($smallArr,$fault_raw_list->task_id);
                array_push($smallArr,$fault_raw_list->task_name);
                array_push($smallArr,$fault_raw_list->task_description);
                array_push($smallArr,$fault_raw_list->task_status);
                array_push($smallArr,$fault_raw_list->department);
                array_push($smallArr,$fault_raw_list->subcenter);
                array_push($smallArr,$fault_raw_list->task_start_time_db);
                array_push($smallArr,$fault_raw_list->task_end_time_db);
                array_push($smallArr,$fault_raw_list->task_responsible);
                array_push($smallArr,$fault_raw_list->task_closer_id);
                
                array_push($bigRawArr, $smallArr);

            }
            //return $bigArr;   
            if($hasSearchKpi == true){
                //return '';
                $export = fopen('../kpi_task_export/task_kpi_raw_export.csv','w');
                foreach ($bigRawArr as $fields) {
                    fputcsv($export, $fields);
                }
                //$path = '../Uploaded_Files/export.csv';

                $pathCheck1 = '../kpi_task_export/kpi_export.zip';
           
                File::delete($pathCheck1);

                $path = '../kpi_task_export/*';
                $files = glob($path);
                $makepath = '../kpi_task_export/kpi_export.zip';
                Zipper::make($makepath)->add($files);
                // /$pathCheck = '../kpi_task_export/kpi_export.zip';

                $row_count = count($fault_raw_lists);

                $update_row_count_in_log = "UPDATE phoenix_tt_db.report_download_log SET row_count = $row_count WHERE id = $report_log_id";
                \DB::update(\DB::raw($update_row_count_in_log));


                return redirect('fileDownloadKpi?kpi_id=task');
                //return response()->download($makepath);
                //return response()->download($path); 
                //echo 'asdf';
            }

        }



        //echo $select_dept_wise_query;

        return view('kpi.kpi_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','fault_lists','fault_arr'));
    }
    public function downloadFileKpi(){
        $kpi_id = Request::get('kpi_id');
        if($kpi_id == 'task'){
            $pathCheck = '../kpi_task_export/kpi_export.zip';
        }
        if($kpi_id == 'fault' ){
            $pathCheck = '../kpi_fault_export/kpi_export.zip';
        }
        
        return response()->download($pathCheck);
    }

    public function kpi_element_view(){
        $element_type = Request::get('element_type');
        $client_id = Request::get('client_id');
        return view('kpi.kpi_element_view',compact('client_id','element_type'));
    }
    public function kpi_responsible_view(){
        $id = Request::get('id');
        return view('kpi.kpi_responsible_concern_view',compact('id'));

    }
}
