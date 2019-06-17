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
use App\Http\Controllers\TelegramNotifController;


class TicketController extends Controller
{
    public function create_tt_view(){
    
        $client_arr = array();
        $client_js_arr = array();
        $issue_type_js_arr = array();
        $problem_category_js_arr = array();
        $problem_source_js_arr = array();
        $reason_js_arr = array();
        $link_type_js_arr = array();
        $department_list_js_arr = array();
        $department_id_list_js_arr = array();
        $subcenter_list_js_arr = array();
        $task_name_js_arr = array();


        $issue_type_query = 'SELECT * FROM phoenix_tt_db.issue_type_table';
        $issue_type_lists = \DB::select(\DB::raw($issue_type_query));

        foreach($issue_type_lists as $issue_type_list){
            array_push($issue_type_js_arr, $issue_type_list->issue_type_name);
        }

        $client_list_query = 'SELECT * FROM phoenix_tt_db.client_table ORDER BY client_name';
        $client_lists = \DB::select(\DB::raw($client_list_query));

        foreach($client_lists as $client_list){
            $client_arr[$client_list->client_id] = $client_list->priority;
            array_push($client_js_arr, $client_list->client_id.'--'.$client_list->client_name);
        }

        $problem_category_query = 'SELECT * FROM phoenix_tt_db.problem_category_table  ORDER BY problem_name';
        $problem_category_lists = \DB::select(\DB::raw($problem_category_query));

        foreach($problem_category_lists as $problem_category_list){
            array_push($problem_category_js_arr,$problem_category_list->problem_name);
        }

        $problem_source_query = 'SELECT * FROM phoenix_tt_db.problem_source_table';
        $problem_source_lists = \DB::select(\DB::raw($problem_source_query));

        foreach($problem_source_lists as $problem_source_list){
            array_push($problem_source_js_arr,$problem_source_list->problem_source_name);
        }

        $reason_query = 'SELECT * FROM phoenix_tt_db.reason_table';
        $reason_lists = \DB::select(\DB::raw($reason_query));

        foreach($reason_lists as $reason_list){
            array_push($reason_js_arr,$reason_list->reason_name);
        }

        $link_type_query = 'SELECT * FROM phoenix_tt_db.link_type_table';
        $link_type_lists = \DB::select(\DB::raw($link_type_query));

        foreach($link_type_lists as $link_type_list){
            array_push($link_type_js_arr, $link_type_list->link_type_name);
        }

        $ticket_status_query = 'SELECT * FROM phoenix_tt_db.ticket_status_table';
        $ticket_status_lists = \DB::select(\DB::raw($ticket_status_query));

        $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29 AND dept_row_id IN (4,10,11,12,14,15,34,41,46,47)";
        $department_lists = \DB::select(\DB::raw($department_query));

        foreach($department_lists as $department_list){
            array_push($department_list_js_arr, $department_list->dept_name);
        }
        foreach($department_lists as $department_list){
            array_push($department_id_list_js_arr, $department_list->dept_row_id);
        }

        $subcenter_query = "SELECT * FROM phoenix_tt_db.subcenter_table WHERE status='Active' ORDER BY subcenter_name";
        $subcenter_lists = \DB::select(\DB::raw($subcenter_query));

        foreach($subcenter_lists as $subcenter_list){
            array_push($subcenter_list_js_arr, $subcenter_list->subcenter_name);
        }

        $task_title_query = "SELECT * FROM phoenix_tt_db.task_title_table";
        $task_title_lists = \DB::select(\DB::raw($task_title_query));

        foreach($task_title_lists as $task_title_list){
            array_push($task_name_js_arr, $task_title_list->title_name);
        }

        $incident_query = "SELECT * FROM phoenix_tt_db.incident_table";
        $incident_lists = \DB::select(\DB::raw($incident_query));

        $flights = AccessModel::where('user_id', 'showmen.barua')->get();

        return view('ticket.create_tt',compact('client_lists','client_arr','problem_category_lists','problem_source_lists','reason_lists','client_js_arr','department_lists','ticket_status_lists','issue_type_js_arr','problem_category_js_arr','problem_source_js_arr','link_type_js_arr','reason_js_arr','incident_lists','department_list_js_arr','department_id_list_js_arr','subcenter_list_js_arr','task_title_lists','task_name_js_arr'));
    }

    public function create_tt_view_copy(){
        $client_list_query = 'SELECT * FROM phoenix_tt_db.client_tbl';
        $client_lists = \DB::select(\DB::raw($client_list_query));

        $client_arr = array();
        $client_js_arr = array();
        foreach($client_lists as $client_list){
            $client_arr[$client_list->client_id] = $client_list->priority;
            array_push($client_js_arr, $client_list->client_id.'--'.$client_list->client_name);
        }
        $problem_category_query = 'SELECT * FROM phoenix_tt_db.problem_category_table  ORDER BY problem_name';
        $problem_category_lists = \DB::select(\DB::raw($problem_category_query));

        $problem_source_query = 'SELECT * FROM phoenix_tt_db.problem_source_table';
        $problem_source_lists = \DB::select(\DB::raw($problem_source_query));

        $reason_query = 'SELECT * FROM phoenix_tt_db.reason_table';
        $reason_lists = \DB::select(\DB::raw($reason_query));

        return view('ticket.create_tt_copy',compact('client_lists','client_arr','problem_category_lists','problem_source_lists','reason_lists','client_js_arr'));
    }

    public function element_view(){
        $element_type = Request::get('element_type');
        $client_id = Request::get('client_id');
        $problem_category = Request::get('problem_category'); 
        return view('ticket.element_view',compact('client_id','element_type','problem_category'));
    }
    public function restricted(){
        return view('errors.error_phoenix');
    }
    public function msg($msgs){
        $msg = $msgs;
        return view('errors.error_phoenix',compact('msg'));
    }
    public function element_list_api(){
        $element_type = Request::get('element_type');
        $client_id = Request::get('client_id');

        $table_name = $element_type.'_table';
        $element_name_id = $element_type.'_name_id';
        $element_name = $element_type.'_name';

        if($element_type == 'link'){
            $element_list_query = "SELECT link_table.link_name_id,link_table.link_name_nttn,link_table.link_name_gateway,link_table.client,link_table.vlan_id,link_table.link_id,link_table.district,link_table.region,link_table.sms_group,link_table.vendor,link_table.sub_center_primary,GROUP_CONCAT(outage_table.ticket_id) as 'ticket_id',GROUP_CONCAT(outage_table.problem_category) as 'problem_category'
    FROM phoenix_tt_db.link_table  
    left join phoenix_tt_db.outage_table on link_table.client = outage_table.client_id and link_table.link_name_id = outage_table.element_id and outage_table.element_type = 'link' 
    where link_table.client=$client_id and link_table.flag !='Disabled'
    GROUP BY link_table.link_name_id";

            //dd($element_list_query);
        }
        else{
            //$element_list_query = "SELECT lt.site_name_id,lt.site_name,lt.client,lt.site_ip_address,lt.district,lt.region,lt.sms_group,lt.vendor,lt.sub_center,ot.ticket_id FROM site_table lt left join outage_table ot on lt.client = ot.client_id  and lt.site_name_id = ot.element_id and ot.element_type = 'site' where lt.client=$client_id and lt.flag !='Disabled'";
            $element_list_query = "SELECT lt.site_name_id,lt.site_name,lt.client,lt.site_ip_address,lt.district,lt.region,lt.sms_group,lt.vendor,lt.sub_center,GROUP_CONCAT(ot.ticket_id) as 'ticket_id',GROUP_CONCAT(ot.problem_category) as 'problem_category' 
            FROM site_table lt 
            left join outage_table ot on lt.client = ot.client_id  and lt.site_name_id = ot.element_id and ot.element_type = 'site' 
            where lt.client=$client_id and lt.flag !='Disabled'
            GROUP BY lt.site_name_id";
        }
        
        $element_lists = \DB::select(\DB::raw($element_list_query));
        //print_r($element_list_query);
        //echo $element_list_query;
        //print_r($element_lists);
        echo json_encode(array("records"=>$element_lists));
    }

    public function link_info(){
        $link_name_id = Request::get('id');
        $element_list_query = "SELECT l.*,(select c.client_name from client_table as c where c.client_id = l.client ORDER BY client_name) as client_name        
                                FROM phoenix_tt_db.link_table l 
                                WHERE l.link_name_id=$link_name_id";
        $element_lists = \DB::select(\DB::raw($element_list_query));
        echo json_encode(array("records"=>$element_lists));
    }

    public function responsible_concern_view(){
        $responsible_concern = Request::get('responsible_concern');
        return view('ticket.responsible_concern_view',compact('responsible_concern'));
    }
    public function responsible_list_api(){
        $element_type = Request::get('element_type');
        $client_id = Request::get('client_id');

        $table_name = $element_type.'_table';
        $element_name_id = $element_type.'_name_id';
        $element_name = $element_type.'_name';

        if($element_type == 'link'){
            $element_list_query = "SELECT $element_name_id,$element_name,client,vlan_id,link_id,district,region,sms_group FROM phoenix_tt_db.link_table WHERE client=$client_id";
        }
        else{
            $element_list_query = "SELECT $element_name_id,$element_name,client,site_ip_address,district,region,sms_group FROM phoenix_tt_db.site_table WHERE client=$client_id";
        }
        
        $element_lists = \DB::select(\DB::raw($element_list_query));

        echo json_encode(array("records"=>$element_lists));
    }


    public function create_tt(Request $request){

        $ticket_title = addslashes(Request::get('ticket_title'));
        // $ticket_time = addslashes(Request::get('ticket_time'));
        $ticket_status = addslashes(Request::get('ticket_status'));
        $incident_title = addslashes(Request::get('incident_title'));
        $incident_id = addslashes(Request::get('incident_id'));
        $incident_description = addslashes(Request::get('incident_description'));
        $ticket_comment_scl = addslashes(Request::get('ticket_comment_scl'));
        $ticket_comment_client = addslashes(Request::get('ticket_comment_client'));
        $ticket_comment_noc = addslashes(Request::get('ticket_comment_noc'));
        $assigned_dept = '';
        $hidden_fault_ids = Request::get('hidden_fault_ids');
        //print_r ($hidden_fault_ids);
        $hidden_fault_arr_temp = array();
        $hidden_fault_arr_temp = explode(',', trim($hidden_fault_ids,','));
        $hidden_fault_arr = array_unique($hidden_fault_arr_temp);
        $hidden_fault_arr = array_values($hidden_fault_arr);
        sort($hidden_fault_arr);
        //return $hidden_fault_arr;
        //print_r($hidden_fault_arr);
       // $path = '../TicketFiles/'.$ticket_id;

        $ticket_arr = array();
        $fault_arr = array();
        $task_arr = array();

        $ticket_arr['ticket_title'] = $ticket_title;
        $ticket_arr['ticket_status'] = $ticket_status;
        $ticket_arr['incident_title'] = $incident_title;
        $ticket_arr['incident_id'] = $incident_id;
        $ticket_arr['incident_description'] = $incident_description;
        // $hr_dept_id_query = "SELECT dept_row_id FROM hr_tool_db.department_table where dept_name='".$assigned_dept."'";
        // $hr_dept_id_lists = \DB::connection('mysql2')->select(\DB::raw($hr_dept_id_query));
        //$ticket_arr['assigned_dept']  = $hr_dept_id_lists[0]->dept_row_id;
        $ticket_arr['assigned_dept'] = $assigned_dept;
        $ticket_arr['ticket_comment_scl'] = $ticket_comment_scl;
        $ticket_arr['ticket_comment_client'] = $ticket_comment_client;
        $ticket_arr['ticket_comment_noc'] = $ticket_comment_noc;
        
        //if(Input::hasFile('ticket_files')){
           // if(!File::exists($path)){
                // $dirPath = '../TicketFiles/'.$ticket_title.'/';
                // $result = File::makeDirectory($path);
                //$file = Request::file('ticket_files');
                
                // $originalFileName = $file->getClientOriginalName();
                // $extension = File::extension($originalFileName);
                // $filename = $originalFileName;
                // $file->move($dirPath,$filename);
            //}
        //}   
       // else{
            //$path = '';
       // }
        $file = Request::file('ticket_files');
        $ticket_arr['file_path'] = '';

        $fault_count = count($hidden_fault_arr);
        $task_counter = 0;

        for($i=0;$i<count($hidden_fault_arr);$i++){

            $tempNumber = $hidden_fault_arr[$i];

            $hidden_task_ids = Request::get('fault_'.$tempNumber.'_task_hidden_ids');
            //print_r ($hidden_fault_ids);
            $hidden_task_arr_temp = array();
            $hidden_task_arr_temp = explode(',', trim($hidden_task_ids,','));
            $hidden_task_arr = array_unique($hidden_task_arr_temp);
            $hidden_task_arr = array_values($hidden_task_arr);
            sort($hidden_task_arr);
            //print_r($hidden_task_arr);
            for($j=0;$j<count($hidden_task_arr);$j++){
                $tempTaskNumber = $hidden_task_arr[$j];
                $task_arr['fault_id_'.$task_counter] = $tempNumber;
                $task_name_temp = addslashes(Request::get('fault_'.$tempNumber.'_task_'.$tempTaskNumber.'_name'));
                $task_arr['task_name_'.$task_counter] = $task_name_temp;
                $task_description_temp = addslashes(Request::get('fault_'.$tempNumber.'_task_'.$tempTaskNumber.'_description'));
                $task_arr['task_description_'.$task_counter] = $task_description_temp;
                $task_assigned_dept_temp = Request::get('fault_'.$tempNumber.'_task_'.$tempTaskNumber.'_assigned_dept');

                if($task_assigned_dept_temp !=''){
                    $task_arr['task_assigned_dept_'.$task_counter]  = $task_assigned_dept_temp; 
                }
                else{
                    $task_arr['task_assigned_dept_'.$task_counter]  = 0;

                }

                $task_subcenter_temp = Request::get('fault_'.$tempNumber.'_task_'.$tempTaskNumber.'_subcenter_names');

                if($task_subcenter_temp !=''){
                    $task_arr['task_subcenter_'.$task_counter]  = $task_subcenter_temp; 
                }
                else{
                    $task_arr['task_subcenter_'.$task_counter]  = 0;

                }

                // $task_arr['task_assigned_dept_'.$task_counter] = $task_assigned_dept_temp;
                $task_start_time_temp = Request::get('fault_'.$tempNumber.'_task_'.$tempTaskNumber.'_start_time');
                $task_arr['task_start_time_'.$task_counter] = $task_start_time_temp;
                $task_end_time_temp = Request::get('fault_'.$tempNumber.'_task_'.$tempTaskNumber.'_end_time');
                $task_arr['task_end_time_'.$task_counter] = $task_end_time_temp;
                $task_comment_temp =addslashes(Request::get('fault_'.$tempNumber.'_task_'.$tempTaskNumber.'_comment'));
                $task_responsible_concern_temp = Request::get('fault_'.$tempNumber.'_task_'.$tempTaskNumber.'_responsible_concern');
                $task_arr['task_responsible_concern_'.$task_counter] = $task_responsible_concern_temp;
                $task_arr['task_comment_'.$task_counter] = $task_comment_temp;
                $task_resolver_temp = '';//addslashes(Request::get('fault_'.$tempNumber.'_task_'.$tempTaskNumber.'_resolver'));
                $task_arr['task_resolver_'.$task_counter] = $task_resolver_temp;
                $task_counter++;
            }          

            $client_id_temp = addslashes(Request::get('client_id_'.$tempNumber));
            $fault_arr['client_id_'.$i] = $client_id_temp;

            $element_type_temp = addslashes(Request::get('element_type_'.$tempNumber));
            $fault_arr['element_type_'.$i] = $element_type_temp;

            $element_name_temp = addslashes(Request::get('element_name_'.$tempNumber));
            $fault_arr['element_name_'.$i] = $element_name_temp;

            $element_id_temp = addslashes(Request::get('element_id_'.$tempNumber));
            $fault_arr['element_id_'.$i] = $element_id_temp;

            $vlan_id_temp = addslashes(Request::get('vlan_id_'.$tempNumber));
            $fault_arr['vlan_id_'.$i] = $vlan_id_temp;

            $link_type_temp = addslashes(Request::get('link_type_'.$tempNumber));
            $fault_arr['link_type_'.$i] = $link_type_temp;

            $link_id_temp = addslashes(Request::get('link_id_'.$tempNumber));
            $fault_arr['link_id_'.$i] = $client_id_temp;

            $site_ip_address_temp = addslashes(Request::get('site_ip_address_'.$tempNumber));
            $fault_arr['site_ip_address_'.$i] = $site_ip_address_temp;

            $district_temp = addslashes(Request::get('district_'.$tempNumber));
            $fault_arr['district_'.$i] = $district_temp;

            $region_temp = addslashes(Request::get('region_'.$tempNumber));
            $fault_arr['region_'.$i] = $region_temp;

            $sms_group_temp = addslashes(Request::get('sms_group_'.$tempNumber));
            $fault_arr['sms_group_'.$i] = $sms_group_temp;

            $client_priority_temp = addslashes(Request::get('client_priority_'.$tempNumber));
            $fault_arr['client_priority_'.$i] = $client_priority_temp;

            $client_side_impact_temp = addslashes(Request::get('client_side_impact_'.$tempNumber));
            $fault_arr['client_side_impact_'.$i] = $client_side_impact_temp;

            $responsible_field_team_temp = addslashes(Request::get('responsible_field_team_'.$tempNumber));
            $fault_arr['responsible_field_team_'.$i] = $responsible_field_team_temp;

            $provider_temp = addslashes(Request::get('provider_'.$tempNumber));
            $fault_arr['provider_'.$i] = $provider_temp;

            $reason_temp = addslashes(Request::get('reason_'.$tempNumber));
            $fault_arr['reason_'.$i] = $reason_temp;

            $fault_status_temp = addslashes(Request::get('fault_status_'.$tempNumber));
            $fault_arr['fault_status_'.$i] = $fault_status_temp;

            $issue_type_temp = addslashes(Request::get('issue_type_'.$tempNumber));
            $fault_arr['issue_type_'.$i] = $issue_type_temp;

            $problem_category_temp = addslashes(Request::get('problem_category_'.$tempNumber));
            $fault_arr['problem_category_'.$i] = $problem_category_temp;

            $problem_source_temp = addslashes(Request::get('problem_source_'.$tempNumber));
            $fault_arr['problem_source_'.$i] = $problem_source_temp;

            $responsible_vendor_temp = addslashes(Request::get('responsible_vendor_'.$tempNumber));
            $fault_arr['responsible_vendor_'.$i] = $responsible_vendor_temp;

            $escalation_time_temp = addslashes(Request::get('escalation_time_'.$tempNumber));
            $fault_arr['escalation_time_'.$i] = $escalation_time_temp;

            $responsible_concern_temp = addslashes(Request::get('responsible_concern_'.$tempNumber));
            $fault_arr['responsible_concern_'.$i] = $responsible_concern_temp;

            $event_time_temp = addslashes(Request::get('event_time_'.$tempNumber));
            $fault_arr['event_time_'.$i] = $event_time_temp;

            $provider_side_impact_temp = addslashes(Request::get('provider_side_impact_'.$tempNumber));
            $fault_arr['provider_side_impact_'.$i] = $provider_side_impact_temp;

            $remarks_temp = addslashes(Request::get('remarks_'.$tempNumber));
            $fault_arr['remarks_'.$i] = $remarks_temp;

            $fault_arr['temp_fault_id_'.$i] = $tempNumber;

            ///////////        @ Ahnaf       ///////////////
            /////////// Get unms ticket info ///////////////
            $unms_id_temp = addslashes(Request::get('unms_id_'.$tempNumber));
            $fault_arr['unms_tt_id_'.$i] = $unms_id_temp;

            $unms_tt = array();

            if($unms_id_temp != ""){
                $get_ticket_info_query = "SELECT alarm_data FROM phoenix_tt_db.unms_map_table WHERE unms_row_id=$unms_id_temp";
                $unms_tt = \DB::select(\DB::raw($get_ticket_info_query));    
            }
            
            
            if(count($unms_tt) >0 ){
                $unms_ticket_info = $unms_tt[0]->alarm_data;
            }
            else{
                $unms_ticket_info = "No ticket found in UNMS";
            }

           //dd($unms_ticket_info);            
            



            
            $fault_arr['unms_tt_info_'.$i] = $unms_ticket_info;            
            //////////////////////////////////////////////////
     
        }
        $ticket_json = json_encode($ticket_arr);
        //return $task_arr;
        //print_r($task_arr);
        //$path='';
        // if($file){
        //     $ticket_id = $this->create_tt_api($ticket_arr,$fault_arr,$fault_count,$task_counter,$task_arr,$file);  
        // }
        // else{
        $ticket_id = $this->create_tt_api($ticket_arr,$fault_arr,$fault_count,$task_counter,$task_arr);
        //}
        $path = '../TicketFiles/'.$ticket_id;
        if(Input::hasFile('ticket_files')){
            $dirPath = '../TicketFiles/'.$ticket_id;
            $result = File::makeDirectory($path);
            $files = Input::file('ticket_files');
            //$file = $files;
            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                //$extension = File::extension($originalFileName);
                //$filename = $originalFileName;
                $file->move($dirPath,$filename);
            }
            

            $update_file_ticket_table_query = "UPDATE phoenix_tt_db.ticket_table SET ticket_file_path='$path' WHERE ticket_id=$ticket_id";
            \DB::update(\DB::raw($update_file_ticket_table_query));
        }
        
        //sleep(1000);
        //return '';
        return redirect("ViewTTSingle?ticket_id=$ticket_id");
    }
    public function create_tt_api($ticket_arr,$fault_arr,$fault_count,$task_counter,$task_arr){

        //echo $_SESSION['user_id'];
        //print_r($ticket_arr);
        /***********************TICKET TABLE INSERT QUERY******************START*************************/

        


        $insert_ticket_table_query = "INSERT INTO phoenix_tt_db.ticket_table (ticket_title,ticket_status,ticket_initiator,ticket_initiator_dept,assigned_dept) VALUES ('$ticket_arr[ticket_title]','$ticket_arr[ticket_status]','".$_SESSION['user_id']."','".$_SESSION['dept_id']."','$ticket_arr[assigned_dept]')";
        \DB::insert(\DB::raw($insert_ticket_table_query));

        /*******************************************************************************************/

        /***********************GET ADDED TICKET ID**************************START***********************/
        $select_ticket_id_query = "SELECT ticket_id FROM phoenix_tt_db.ticket_table ORDER BY ticket_id DESC LIMIT 1";
        $ticket_id_lists = \DB::select(\DB::raw($select_ticket_id_query));
        $ticket_id = $ticket_id_lists[0]->ticket_id;

        /********************************************************************************************/

        /*****************************SCL COMMENT INSERT**********************START***********************/
        if($ticket_arr['ticket_comment_scl'] != ''){
            $scl_comment_table_query = "INSERT INTO phoenix_tt_db.scl_comment_table (user_id,type,comment,dept_id,ticket_id) VALUES ('".$_SESSION['user_id']."','','$ticket_arr[ticket_comment_scl]','".$_SESSION['department']."','$ticket_id')";
            \DB::insert(\DB::raw($scl_comment_table_query));
        }
        

        /********************************************************************************************/

        /*****************************NOC COMMENT INSERT***********************START**********************/
        if($ticket_arr['ticket_comment_noc'] != ''){
            $noc_comment_table_query = "INSERT INTO phoenix_tt_db.noc_comment_table (user_id,type,comment,dept_id,ticket_id) VALUES ('".$_SESSION['user_id']."','','$ticket_arr[ticket_comment_noc]','".$_SESSION['department']."','$ticket_id')";
            \DB::insert(\DB::raw($noc_comment_table_query));
        }
        /********************************************************************************************/

        /*****************************CLIENT COMMENT INSERT*********************START************************/
        if($ticket_arr['ticket_comment_client'] != ''){
            $client_comment_table_query = "INSERT INTO phoenix_tt_db.client_comment_table (user_id,type,comment,dept_id,ticket_id) VALUES ('".$_SESSION['user_id']."','','$ticket_arr[ticket_comment_client]','".$_SESSION['department']."','$ticket_id')";
            \DB::insert(\DB::raw($client_comment_table_query));
        }
        /********************************************************************************************/
        date_default_timezone_set('Asia/Dhaka');
        $time = date('Y-m-d H:i:s');
        /*************************FAULT TABLE INSERT*****************************START*********************/
      
        for($i=0;$i<$fault_count;$i++){
            //////////////////////////////////////////////////////////////// @ahnaf ////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////Query changed for unms ticket id///////////////////////////////////////////////////////////////////////////////////////////////
            $insert_fault_table_query = "INSERT INTO phoenix_tt_db.fault_table(ticket_id,element_type,element_id,client_id,issue_type,client_priority,provider,link_type,problem_category,problem_source,reason,event_time,escalation_time,client_side_impact,provider_side_impact,remarks,responsible_concern,responsible_field_team,fault_status,unms_tt_id,unms_tt_info) VALUES";
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




            $insert_outage_table_query = "INSERT INTO phoenix_tt_db.outage_table(fault_id,ticket_id,element_type,element_id,client_id,issue_type,client_priority,provider,link_type,problem_category,problem_source,reason,event_time,escalation_time,client_side_impact,provider_side_impact,remarks,responsible_concern,responsible_field_team,fault_status,scl_comment,task_comment,assigned_dept) VALUES";

            $insert_outage_table_log_query = "INSERT INTO phoenix_tt_db.outage_table_log(fault_id,ticket_id,element_type,element_id,client_id,issue_type,client_priority,provider,link_type,problem_category,problem_source,reason,event_time,escalation_time,client_side_impact,provider_side_impact,remarks,responsible_concern,responsible_field_team,fault_status,scl_comment,task_comment,assigned_dept) VALUES";

            $element_type = $fault_arr['element_type'.'_'.$i];
            $element_id = $fault_arr['element_id'.'_'.$i];
            $client_id = $fault_arr['client_id'.'_'.$i];
            $issue_type = $fault_arr['issue_type'.'_'.$i];
            $client_priority = $fault_arr['client_priority'.'_'.$i];
            $provider = $fault_arr['provider'.'_'.$i];
            $link_type = $fault_arr['link_type'.'_'.$i];

            $event_time = $fault_arr['event_time'.'_'.$i];
            $event_time_obj = new DateTime($event_time);
            $event_time = $event_time_obj->format('Y-m-d H:i:s');

            $problem_category = $fault_arr['problem_category'.'_'.$i];
            $problem_source = $fault_arr['problem_source'.'_'.$i];
            $reason = $fault_arr['reason'.'_'.$i];

            $escalation_time = $fault_arr['escalation_time'.'_'.$i];
            $escalation_time_obj = new DateTime($escalation_time);
            $escalation_time = $escalation_time_obj->format('Y-m-d H:i:s');

            $client_side_impact = $fault_arr['client_side_impact'.'_'.$i];
            $provider_side_impact = $fault_arr['provider_side_impact'.'_'.$i];
            $remarks = $_SESSION['user_id']."(".$_SESSION['department'].")[".$time."] : ".$fault_arr['remarks'.'_'.$i];
            $responsible_concern = "NA";//$fault_arr['responsible_concern'.'_'.$i];
            $responsible_field_team = "NA";//$fault_arr['responsible_field_team'.'_'.$i];
            $fault_status = $fault_arr['fault_status'.'_'.$i];



            ///////////////////////////////////////////////////// @ahnaf //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////// unms ticket /////////////////////////////////////////////////////////////////////////////////////////////////////////
            $unms_tt_id = $fault_arr['unms_tt_id'.'_'.$i];
            $unms_tt_info = $fault_arr['unms_tt_info'.'_'.$i];

            $insert_fault_table_query .= "('$ticket_id','$element_type',".(int)$element_id.",".(int)$client_id.",'$issue_type','$client_priority',$provider,'$link_type','$problem_category','$problem_source','$reason','$event_time','$escalation_time','$client_side_impact','$provider_side_impact','$remarks','$responsible_concern','$responsible_field_team','$fault_status','$unms_tt_id','$unms_tt_info')";

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            
            //$insert_fault_table_query = trim($insert_fault_table_query,',');
            \DB::insert(\DB::raw($insert_fault_table_query));
            $fault_id_temp_lists = \DB::select(\DB::raw('SELECT fault_id FROM phoenix_tt_db.fault_table ORDER BY fault_id DESC LIMIT 1'));
            $fault_temp_id = $fault_id_temp_lists[0]->fault_id;
            $fault_view_id = (int)$fault_arr['temp_fault_id_'.$i];

            $insert_outage_table_query .= "($fault_temp_id,'$ticket_id','$element_type',".(int)$element_id.",".(int)$client_id.",'$issue_type','$client_priority',$provider,'$link_type','$problem_category','$problem_source','$reason','$event_time','$escalation_time','$client_side_impact','$provider_side_impact','$remarks','$responsible_concern','$responsible_field_team','$fault_status','','','$ticket_arr[assigned_dept]')";
            //$insert_fault_table_query = trim($insert_fault_table_query,',');
            \DB::insert(\DB::raw($insert_outage_table_query));

            $insert_outage_table_log_query .= "($fault_temp_id,'$ticket_id','$element_type',".(int)$element_id.",".(int)$client_id.",'$issue_type','$client_priority',$provider,'$link_type','$problem_category','$problem_source','$reason','$event_time','$escalation_time','$client_side_impact','$provider_side_impact','$remarks','$responsible_concern','$responsible_field_team','$fault_status','','','$ticket_arr[assigned_dept]')";
            //$insert_fault_table_query = trim($insert_fault_table_query,',');
            \DB::insert(\DB::raw($insert_outage_table_log_query));
            // /echo gettype($fault_view_id);
           //echo $fault_arr['temp_fault_id_'.$task_counter-1].'----------';
            /************************************************************************************/
            /***************************TASK TABLE INSERT**************************************/
            /************************************************************************************/
            for($k=0;$k<$task_counter;$k++){
                $task_fault_id = (int)$task_arr['fault_id_'.$k];
                if($task_fault_id == $fault_view_id){
                    //$fault_arr['temp_fault_id_'.$k];
                    $task_name_temp = $task_arr['task_name_'.$k];
                    $task_description_temp = $task_arr['task_description_'.$k];
                    $task_assigned_dept_temp = $task_arr['task_assigned_dept_'.$k];
                    $task_subcenter_temp = $task_arr['task_subcenter_'.$k];
                    $task_start_time_temp = $task_arr['task_start_time_'.$k];
                    $task_end_time_temp = $task_arr['task_end_time_'.$k];
                    $task_responsible_concern_temp = "NA";//$task_arr ['task_responsible_concern_'.$k];
                    $task_start_time_temp_obj = new DateTime($task_start_time_temp);
                    $task_start_time_temp = $task_start_time_temp_obj->format('Y-m-d H:i:s');
                    //$task_end_time_temp_obj = new DateTime($task_end_time_temp);
                    $task_end_time_temp = NULL;
                    
                    

                    //$task_comment_temp = $_SESSION['user_id']."(".$_SESSION['department'].")[".$time."] : ".$task_arr['task_comment_'.$k];
                    $task_resolver_temp = $task_arr['task_resolver_'.$k];
                    $session_dept_id = $_SESSION['dept_id'];
                    if($task_name_temp != ''){
                        $insert_task_query = "INSERT INTO phoenix_tt_db.task_table (ticket_id,fault_id,task_name,task_description,task_status,task_assigned_dept,task_start_time,task_end_time,task_resolver,subcenter,task_responsible,task_initiator_dept) VALUES ($ticket_id,$fault_temp_id,'$task_name_temp','$task_description_temp','escalated','$task_assigned_dept_temp','$task_start_time_temp',NULL,'$task_resolver_temp','$task_subcenter_temp','$task_responsible_concern_temp',$session_dept_id)";
                        \DB::insert(\DB::raw($insert_task_query));

                        ///////////////////// Task Telegram Notification ///////////////////////
                        // try {
                        //     $telegram_notif_controller = New TelegramNotifController();
                        //     $send_msg = $telegram_notif_controller->send_telegram_notification($task_subcenter_temp,$ticket_id);
                        // }
                        // catch(Exception $e) {
                            
                        // } 
                        ////////////////////////////////////////////////////////////////////////
                        $task_id_temp_lists = \DB::select(\DB::raw('SELECT task_id FROM phoenix_tt_db.task_table ORDER BY task_id DESC LIMIT 1'));
                        $task_temp_id = $task_id_temp_lists[0]->task_id;
                        $insert_task_comment_query = "INSERT INTO phoenix_tt_db.task_update_log (ticket_id,fault_id,task_id,task_comment_user_id,task_status, task_comment,dept_name) VALUES ($ticket_id,$fault_temp_id,$task_temp_id,'".$_SESSION['user_id']."','escalated','".$task_arr['task_comment_'.$k]."','".$_SESSION['department']."')";
                        \DB::insert(\DB::raw($insert_task_comment_query));
                    }

                    
                }
            }

            /***************************************************************************************************/
        }

        /*****************************Outage table Bhungchung*****************************************************************/

        $selectFaultQueryByTicket = "SELECT * FROM phoenix_tt_db.outage_table WHERE ticket_id = '$ticket_id'";
        $selectFaultsForComments = \DB::select(\DB::raw($selectFaultQueryByTicket));

        foreach($selectFaultsForComments as $selectFaultsForComment){
            $selectTop2TicketCommentsQuery = "SELECT * FROM phoenix_tt_db.scl_comment_table WHERE ticket_id=$ticket_id ORDER BY ticket_id DESC LIMIT 5";
            $selectTop2TicketComments = \DB::select(\DB::raw($selectTop2TicketCommentsQuery));
            //echo $selectTop2TicketCommentsQuery;

            $top2TicketComments = '';

            foreach($selectTop2TicketComments as $selectTop2TicketComment){
                $top2TicketComments .=  $_SESSION['user_id'].'('.$selectTop2TicketComment->comment_row_created_date.') : '.$selectTop2TicketComment->comment.'<br>';
                $top2TicketComments = addslashes($top2TicketComments);
            }

            $selectTop2TaskCommentsQuery = "SELECT * FROM phoenix_tt_db.task_update_log WHERE fault_id=$selectFaultsForComment->fault_id ORDER BY task_id DESC LIMIT 5";
            $selectTop2TaskComments = \DB::select(\DB::raw($selectTop2TaskCommentsQuery));
            //echo $selectTop2TaskCommentsQuery;

            $top2TaskComments = '';

            foreach($selectTop2TaskComments as $selectTop2TaskComment){
                $top2TaskComments .=  $_SESSION['user_id'].'('.$selectTop2TaskComment->task_comment_time.') : '.$selectTop2TaskComment->task_comment.'<br>';
                $top2TaskComments = addslashes($top2TaskComments);
            }


            $update_comments_in_outage_query = "UPDATE phoenix_tt_db.outage_table SET scl_comment='$top2TicketComments',task_comment='$top2TaskComments' WHERE fault_id=$selectFaultsForComment->fault_id";
            \DB::update(\DB::raw($update_comments_in_outage_query));

            $update_comments_in_outage_log_query = "UPDATE phoenix_tt_db.outage_table_log SET scl_comment='$top2TicketComments',task_comment='$top2TaskComments' WHERE fault_id=$selectFaultsForComment->fault_id";
            \DB::update(\DB::raw($update_comments_in_outage_query));
            //echo $update_comments_in_outage_log_query;


        }


        /**************************************************************************************************************************/
        //return '';


        // $path = '../TicketFiles/'.$ticket_id.'/';
        //     if($files !=''){
        //         $dirPath = '../TicketFiles/'.$ticket_id.'/';
        //         $result = File::makeDirectory($path);
        //         $file = $files;
                
        //         $originalFileName = $file->getClientOriginalName();
        //         $extension = File::extension($originalFileName);
        //         $filename = $originalFileName;
        //         $file->move($dirPath,$filename);

        //         $update_file_ticket_table_query = "UPDATE phoenix_tt_db.ticket_table SET ticket_file_path='$dirPath' WHERE ticket_id=$ticket_id";
        //         \DB::update(\DB::raw($update_file_ticket_table_query));
        //     }

        /*********************************************************************************************/
        $select_incident_id_query_for_existing = "SELECT incident_id FROM phoenix_tt_db.incident_table WHERE incident_id='$ticket_arr[incident_id]'";
        $incident_id_lists_for_existing = \DB::select(\DB::raw($select_incident_id_query_for_existing));

        if(count($incident_id_lists_for_existing)>0){
            $incident_id = $incident_id_lists_for_existing[0]->incident_id;

           /*************************UPDATE TICKET TABLE INCIDENT ID*****************START************************/
            $update_ticket_table_query = "UPDATE phoenix_tt_db.ticket_table SET incident_id=$incident_id WHERE ticket_id=$ticket_id";
            \DB::update(\DB::raw($update_ticket_table_query));
            /*********************************************************************************************/
        }
        else
        {
            /*************************INCIDENT TABLE INSERT *********************START********************/
        
            $insert_incident_table_query = "INSERT INTO phoenix_tt_db.incident_Table(incident_title,ticket_id,incident_description,incident_status) VALUES ('$ticket_arr[incident_title]','$ticket_id','$ticket_arr[incident_description]','open')";
            \DB::insert(\DB::raw($insert_incident_table_query));

            /**********************************************************************************************/
            // $path = '../TicketFiles/'.$ticket_id.'/';
            // if($files !=''){
            //     $dirPath = '../TicketFiles/'.$ticket_id.'/';
            //     $result = File::makeDirectory($path);
            //     $file = $files;
                
            //     $originalFileName = $file->getClientOriginalName();
            //     $extension = File::extension($originalFileName);
            //     $filename = $originalFileName;
            //     $file->move($dirPath,$filename);

            //     $update_file_ticket_table_query = "UPDATE phoenix_tt_db.ticket_table SET ticket_file_path=$dirPath WHERE ticket_id=$ticket_id";
            //     \DB::update(\DB::raw($update_ticket_table_query));
            // }
                
            /*************************UPDATE TICKET TABLE INCIDENT ID*****************START************************/

            $select_incident_id_query = "SELECT incident_id FROM phoenix_tt_db.incident_table WHERE ticket_id=$ticket_id";
            $incident_id_lists = \DB::select(\DB::raw($select_incident_id_query));
            $incident_id = $incident_id_lists[0]->incident_id;
            $update_ticket_table_query = "UPDATE phoenix_tt_db.ticket_table SET incident_id=$incident_id WHERE ticket_id=$ticket_id";
            \DB::update(\DB::raw($update_ticket_table_query));

            /*********************************************************************************************/
        }


    
        /*************************NOTIFICATION TABLE INSERT *******************START*********************/
        $session_dept_id = $_SESSION['dept_id'];

        $notification_string = "A ticket has been assigned to your department just now";
        // $insert_notification_table_query = "INSERT INTO phoenix_tt_db.notification_table(ticket_id,status,assigned_dept,notification_string,notification_flag) VALUES ('$ticket_id','$ticket_arr[ticket_status]','$ticket_arr[assigned_dept],$session_dept_id','$notification_string',0)";
        // \DB::insert(\DB::raw($insert_notification_table_query));

        /************************************************************************************************/



        /*************************************************************************************************/
        /*************************POPULATE LOG TABLE********************START**********************************/
        /*************************************************************************************************/

        /*************************TICKET LOG TABLE*********************START**********************************/

        $select_assign_dept_query = "SELECT * FROM phoenix_tt_db.task_table WHERE ticket_id=$ticket_id";
        $task_lists = \DB::select(\DB::raw($select_assign_dept_query));
        $assigned_dept = '';
        foreach($task_lists as $task_list){
            $assigned_dept .= $task_list->task_assigned_dept.',';
        }
        $assigned_dept = trim($assigned_dept,',');
        //$ticket_arr['assigned_dept']
        $assigned_dept_temp_arr = explode(',',$assigned_dept);
        $unique_arr = array_unique($assigned_dept_temp_arr);
        $assigned_dept_converted = implode(',',$unique_arr);

        $update_ticket_table_dept_query = "UPDATE phoenix_tt_db.ticket_table SET assigned_dept='$assigned_dept_converted' WHERE ticket_id=$ticket_id";
        \DB::update(\DB::raw($update_ticket_table_dept_query));
        $update_outage_table_dept_query = "UPDATE phoenix_tt_db.outage_table SET assigned_dept='$assigned_dept_converted' WHERE ticket_id=$ticket_id";
        \DB::update(\DB::raw($update_outage_table_dept_query));

        $update_outage_table_log_dept_query = "UPDATE phoenix_tt_db.outage_table_log SET assigned_dept='$assigned_dept_converted' WHERE ticket_id=$ticket_id";
        \DB::update(\DB::raw($update_outage_table_log_dept_query));


        $log_controller = New LogController();
        $log_controller->insert_all_table_log($ticket_id);

        $sms = "";
        $fault_id = "";
        $notice_type = "Link Down Notification";
        $sms_group = "";

        // $link = "<script>window.open('/scl_sms_system/public/create_sms?sms=".$sms."&notice_type=".$notice_type."&fault_id=".$ticket_id."')</script>";
            $select_fault_query = "SELECT * FROM phoenix_tt_db.fault_table WHERE ticket_id=$ticket_id";
            $fault_lists = \DB::select(\DB::raw($select_fault_query));  

            $smsIdtext = "SMS ID : ".$ticket_id."<br>";

            $sms.=$smsIdtext;
            $sms_header ="";
            $site_checker = "false";
            $smsLink = "Link Name : ";
            $smsSite = "Site Name : ";
            $vlanStr = "Vlan : ";
            $linkIDStr = "Link ID : ";
            $smsEventTime="";
            $smsImpact = "";
            $smsClient = "Client : ";

            $isLink = false;


            foreach($fault_lists as $fault_list){

                if($fault_list->problem_category!="Site Down" && $site_checker=="false"){


                    $sms_header=$fault_list->problem_category." Notification<br>";

                }

                else{

                    $sms_header="Site Down Notification"."<br>";
                    $site_checker="true";

                }



                // $sms.="Element Type : ".$fault_list->element_type."<br>";

                if($fault_list->element_type=="link"){

                    $select_link_query = "SELECT * FROM phoenix_tt_db.link_table WHERE link_name_id=$fault_list->element_id";
                    $link_lists = \DB::select(\DB::raw($select_link_query)); 

                    // $vlanStr = '';
                    // $linkIDStr = '';
                    $isLink = true;

                    foreach($link_lists as $link_list){

                        // $smsLink.=$link_list->link_name.",";
                        $sms_group.=$link_list->sms_group.","; 

                        $pos = strpos($smsLink, $link_list->link_name_nttn);
                        $str = '';
                        

                        if($pos=="0"){
                            $str .= $link_list->link_name_nttn;

                            //$smsLink.=$link_list->link_name;.",";
                        }  

                        $pos = strpos($smsLink, $link_list->link_name_gateway);

                        if($pos=="0"){
                            $str .= $link_list->link_name_gateway;
                            
                        } 
                        $vlanStr .= $link_list->vlan_id.",";
                        $linkIDStr .= $link_list->link_id.",";
                        $smsLink.=$str.",";                                  

                    }

                    $smsVlan = trim($vlanStr,",");
                    $smsLinkID = trim($linkIDStr,",");


                    $smsVlan .="<br>";
                    $smsLinkID .="<br>";
                }

                else if($fault_list->element_type=="site"){

                    $select_site_query = "SELECT * FROM phoenix_tt_db.site_table WHERE site_name_id=$fault_list->element_id";
                    $site_lists = \DB::select(\DB::raw($select_site_query)); 

                    foreach($site_lists as $site_list){

                         $smsSite.=$site_list->site_name.",";
                         $sms_group.=$site_list->sms_group.","; 
                    }                               
                }

                $select_client_query = "SELECT * FROM phoenix_tt_db.client_table WHERE client_id=$fault_list->client_id";
                $client_lists = \DB::select(\DB::raw($select_client_query)); 

                foreach($client_lists as $client_list){

                    $pos = strpos($smsClient, $client_list->client_name);

                    if($pos=="0"){

                        $smsClient.=$client_list->client_name.",";
                    }
                }    

                 $smsEventTime="Event Time : ".$fault_list->event_time."<br>";    
                 $smsImpact="Client Side Impact : ".$fault_list->client_side_impact."<br>";               

            }

        $sms_group = trim($sms_group,",");

        $smsClient = trim($smsClient,",");
        $smsLink = trim($smsLink,",");
        $smsSite = trim($smsSite,",");
        

        $smsClient.="<br>";
        $smsLink .="<br>";
        $smsSite.="<br>";
        
        if($isLink == true){
            $sms.=$smsClient.$smsLink.$smsVlan.$smsLinkID.$smsEventTime.$smsImpact."<br>"."BR//SCL NOC";
        }
        else{
            $sms.=$smsClient.$smsLink.$smsSite.$smsEventTime.$smsImpact."<br>"."BR//SCL NOC";
        }

        

        $sms=urlencode($sms);


        $link = "/scl_sms_system/public/create_sms?sms=$sms&fault_id=$ticket_id&notice_type=$notice_type&sms_group=$sms_group";

        //echo $link;

        $insert_sms_link_query = "INSERT INTO phoenix_tt_db.sms_link (ticket_id,link,sms_header,sms_body,sms_group) VALUES ('$ticket_id','".addslashes($link)."','".addslashes($sms_header)."','".addslashes($sms)."','".addslashes($sms_group)."')";
        \DB::insert(\DB::raw($insert_sms_link_query)); 

        return $ticket_id;
        
        /*************************************************************************************************/
    }
    



    public function view_tt(){

        


        $ticket_id = addslashes(Request::get('ticket_id'));
        $ticket_title = addslashes(Request::get('ticket_title'));
        $assigned_dept = addslashes(Request::get('assigned_dept'));
        $assigned_subcenter = addslashes(Request::get('assigned_subcenter'));
        $ticket_status = addslashes(Request::get('ticket_status'));
        $dashboard_value = Request::get('dashboard_value');

        $whereQuery = "1 AND ";

        if($ticket_id){

            $whereQuery.= "phoenix_tt_db.ticket_table.ticket_id='$ticket_id' AND ";

        }

        if($ticket_title){

            $whereQuery.= "ticket_title like '%$ticket_title%' AND ";
        }

        if($assigned_dept){


            $whereQuery .= "( assigned_dept='$assigned_dept,%' or assigned_dept like '%,$assigned_dept,%' or assigned_dept like '%,$assigned_dept' or assigned_dept=$assigned_dept) AND ";

        }

        if($ticket_status){
            if($ticket_status == 'not_closed'){
                $whereQuery.="ticket_status !='Closed' AND ";
            }
            else{
                $whereQuery.="ticket_status='$ticket_status' AND ";
            }
            


        }

        if($assigned_subcenter != ""){
            $whereQuery.= "(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') like '%$assigned_subcenter%' AND ";
        }

        else{
            if($whereQuery == '1 AND '){
                $whereQuery.="ticket_status !='Closed' AND ";
                $ticket_status='not_closed';
            }
            
        }

        $whereQuery = trim($whereQuery,"AND ");
        //echo $whereQuery;

        // $ticket_table_query = "SELECT * FROM phoenix_tt_db.ticket_table where '$whereQuery' ticket_status!='Closed'";
        // $ticket_lists = \DB::select(\DB::raw($ticket_table_query));


        // $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("*,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept ")->whereRaw("$whereQuery")->orderBy('ticket_id', 'desc')->paginate(20);//->toSql();//->paginate(20);
        // if($whereQuery != '1 AND '){
        //     $ticket_lists = \DB::select(\DB::raw("select * from phoenix_tt_db.ticket_table where ticket_id < 1"));
        // }

        $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("*,TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,`ticket_closing_time`) as 'closing_duration',TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,now()) as 'duration_now',(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept ")->whereRaw("$whereQuery")
        //->toSql();
        ->orderBy('ticket_id', 'desc')
        ->limit(500)
        ->paginate(20);

        //return $ticket_lists;
        // $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29 AND dept_row_id IN (4,10,11,12,15,34,35,36,40,41,43,45)";
        $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29 AND dept_row_id IN (4,10,11,12,14,15,34,35,36,40,41,43,45,46,47)";
        $department_lists = \DB::select(\DB::raw($department_query)); 

        if($dashboard_value != ''){
            if($dashboard_value == 'total_open_tickets'){
                $total_open_tickets_query = "SELECT DISTINCT ticket_id FROM phoenix_tt_db.task_table WHERE ticket_id IN (SELECT ticket_id FROM phoenix_tt_db.ticket_table WHERE ticket_status !='closed') AND task_assigned_dept='".$_SESSION['dept_id']."'";

                $total_open_ticket_lists = \DB::select(\DB::raw($total_open_tickets_query));
                $total_open_ticket_ids ='';

                foreach($total_open_ticket_lists as $total_open_ticket_list){
                    $total_open_ticket_ids .= $total_open_ticket_list->ticket_id.',';
                }

                $total_open_ticket_ids = trim($total_open_ticket_ids,',');
                
                if($whereQuery != '1 AND '){
                    $whereQueryLocal = $whereQuery;
                }
                
                $whereQueryLocal .= " AND ticket_id IN($total_open_ticket_ids)";

                if(count($total_open_ticket_lists)<1){
                    $whereQueryLocal = "ticket_id <1";
                }
                // $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQuery")->orderBy('ticket_id', 'desc')->paginate(20);
                $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,`ticket_closing_time`) as 'closing_duration',TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,now()) as 'duration_now',(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQueryLocal")->orderBy('ticket_id', 'desc')
                    ->paginate(20);
            }
            if($dashboard_value == 'my_open_tickets'){
                $my_open_tickets_query = "SELECT DISTINCT ticket_id FROM phoenix_tt_db.task_table WHERE ticket_id IN (SELECT ticket_id FROM phoenix_tt_db.ticket_table WHERE ticket_status !='closed') AND task_assigned_dept='".$_SESSION['dept_id']."' AND task_status !='closed'";
                $my_open_tickets_lists = \DB::select(\DB::raw($my_open_tickets_query));

                $my_open_ticket_ids ='';
                foreach($my_open_tickets_lists as $my_open_tickets_lists){
                    $my_open_ticket_ids .= $my_open_tickets_lists->ticket_id.',';
                }

                $my_open_ticket_ids = trim($my_open_ticket_ids,',');
                if($whereQuery != '1 AND '){
                    $whereQueryLocal = $whereQuery;
                }
                $whereQueryLocal .= " AND ticket_id IN($my_open_ticket_ids)";

                if(count($my_open_tickets_lists)<1){
                    $whereQueryLocal = "ticket_id <1";
                }
                //echo $whereQuery;
                // $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQuery")->orderBy('ticket_id', 'desc')->paginate(20);
                 $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,`ticket_closing_time`) as 'closing_duration',TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,now()) as 'duration_now',(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQueryLocal")->orderBy('ticket_id', 'desc')->paginate(20);   
            }
            if($dashboard_value =='my_inititated_open_tickets'){
                $my_inititated_open_tickets_query = "SELECT * FROM phoenix_tt_db.ticket_table WHERE ticket_status !='closed' and ticket_initiator_dept='".$_SESSION['dept_id']."'";
                $my_inititated_open_tickets_lists = \DB::select(\DB::raw($my_inititated_open_tickets_query));

                $my_inititated_open_ticket_ids ='';
                foreach($my_inititated_open_tickets_lists as $my_inititated_open_tickets_lists){
                    $my_inititated_open_ticket_ids .= $my_inititated_open_tickets_lists->ticket_id.',';
                }
                //print_r($my_inititated_open_tickets_lists);
                $my_inititated_open_ticket_ids = trim($my_inititated_open_ticket_ids,',');
                if($whereQuery != '1 AND '){
                    $whereQueryLocal = $whereQuery;
                }
                 $whereQueryLocal .= " AND ticket_id IN($my_inititated_open_ticket_ids)";
                if(count($my_inititated_open_tickets_lists)<1){
                    $whereQueryLocal = "ticket_id <1";
                }
               
                // $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQuery")->orderBy('ticket_id', 'desc')->paginate(20);
                // $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,now()) as 'duration',(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQuery")->orderBy('ticket_id', 'desc')->paginate(20); 
                $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,`ticket_closing_time`) as 'closing_duration',TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,now()) as 'duration_now',(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQueryLocal")->orderBy('ticket_id', 'desc')->paginate(20); 
            }
            if($dashboard_value =='my_notification_count'){
                $session_dept_id = $_SESSION['dept_id'];
                $my_notifications_query = "SELECT * FROM phoenix_tt_db.notification_table  WHERE notification_flag = 0 AND  (assigned_dept LIKE '$session_dept_id,%' OR assigned_dept LIKE '%,$session_dept_id' OR assigned_dept LIKE '%,$session_dept_id,%') ORDER BY notification_row_id DESC";
                $my_notifications_lists = \DB::select(\DB::raw($my_notifications_query));

                $my_notification_ids ='';
                foreach($my_notifications_lists as $my_notifications_list){
                    $my_notification_ids .= $my_notifications_list->ticket_id.',';
                }
                //print_r($my_inititated_open_tickets_lists);
                $my_notification_ids = trim($my_notification_ids,',');
                if($whereQuery != '1 AND '){
                    $whereQueryLocal = $whereQuery;
                }
                $whereQueryLocal .= " AND ticket_id IN($my_notification_ids)";
                if(count($my_notifications_lists)<1){
                    $whereQueryLocal = "ticket_id <1";
                }
               
                // $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQuery")->orderBy('ticket_id', 'desc')->paginate(20);  
                $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,`ticket_closing_time`) as 'closing_duration',TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,now()) as 'duration_now',(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQueryLocal")->orderBy('ticket_id', 'desc')->paginate(20);
            }
            /***************************Mehraj*********************************************/
            if($dashboard_value == 'client_confirmation_pending'){


                $total_client_confirmation_query = "SELECT DISTINCT(phoenix_tt_db.fault_table.fault_id),phoenix_tt_db.fault_table.*,phoenix_tt_db.task_table.*,phoenix_tt_db.ticket_table.* FROM phoenix_tt_db.task_table,phoenix_tt_db.fault_table,phoenix_tt_db.ticket_table where phoenix_tt_db.task_table.fault_id=phoenix_tt_db.fault_table.fault_id AND phoenix_tt_db.fault_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status!='Closed' AND (phoenix_tt_db.task_table.task_assigned_dept=43 OR
                    phoenix_tt_db.task_table.task_assigned_dept=45)";

                $total_client_confirmation_lists = \DB::select(\DB::raw($total_client_confirmation_query));

                // print_r($total_client_confirmation_lists);
                $total_client_confirmation_ticket_ids ='';

                foreach($total_client_confirmation_lists as $total_client_confirmation_list){
                    $total_client_confirmation_ticket_ids .= $total_client_confirmation_list->ticket_id.",";
                }

                // print_r($total_client_confirmation_ticket_ids);

                $total_client_confirmation_ticket_ids = trim($total_client_confirmation_ticket_ids,',');
                if($whereQuery != '1 AND '){
                    $whereQueryLocal = $whereQuery;
                }
                $whereQueryLocal .= " AND ticket_id IN($total_client_confirmation_ticket_ids)";
                if(count($total_client_confirmation_lists)<1){
                    $whereQueryLocal = "ticket_id <1";
                }
                                
                // $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQuery")->orderBy('ticket_id', 'desc')->paginate(20);
                $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')
                                ->selectRaw("phoenix_tt_db.ticket_table.*,TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,`ticket_closing_time`) as 'closing_duration',TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,now()) as 'duration_now',(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")
                                ->whereRaw("$whereQueryLocal")
                                ->orderBy('ticket_id', 'desc')
                                ->paginate(20);
            }         
            if($dashboard_value == 'dashboard_open_tasks'){


                $dashboard_open_tasks_query =  "SELECT * FROM phoenix_tt_db.task_table WHERE task_status!='Closed' AND task_assigned_dept=".$_SESSION['dept_id'];

                $dashboard_open_tasks_lists = \DB::select(\DB::raw($dashboard_open_tasks_query));

                // print_r($total_client_confirmation_lists);
                $dashboard_open_tasks_ticket_ids ='';

                foreach($dashboard_open_tasks_lists as $dashboard_open_tasks_list){
                    $dashboard_open_tasks_ticket_ids .= $dashboard_open_tasks_list->ticket_id.",";
                }

                // print_r($total_client_confirmation_ticket_ids);

                $dashboard_open_tasks_ticket_ids = trim($dashboard_open_tasks_ticket_ids,',');
                if($whereQuery != '1 AND '){
                    $whereQueryLocal = $whereQuery;
                }
                $whereQueryLocal .= " AND ticket_id IN($dashboard_open_tasks_ticket_ids)";
                if(count($dashboard_open_tasks_lists)<1){
                    $whereQueryLocal = "ticket_id <1";
                }   
                             
                // $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQuery")->orderBy('ticket_id', 'desc')->paginate(20);
                $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,`ticket_closing_time`) as 'closing_duration',TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,now()) as 'duration_now',(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQueryLocal")->orderBy('ticket_id', 'desc')->paginate(20);
            }
            if($dashboard_value == 'pending_task'){


                $dashboard_pending_tasks_query =  "SELECT * FROM phoenix_tt_db.task_table WHERE task_status!='Closed' AND task_assigned_dept=".$_SESSION['dept_id'];

                $dashboard_pending_tasks_lists = \DB::select(\DB::raw($dashboard_pending_tasks_query));

                // print_r($total_client_confirmation_lists);
                $dashboard_pending_tasks_ticket_ids ='';

                foreach($dashboard_pending_tasks_lists as $dashboard_pending_tasks_list){
                    $dashboard_pending_tasks_ticket_ids .= $dashboard_pending_tasks_list->ticket_id.",";
                }

                // print_r($total_client_confirmation_ticket_ids);

                $dashboard_pending_tasks_ticket_ids = trim($dashboard_pending_tasks_ticket_ids,',');
                if($whereQuery != '1 AND '){
                    $whereQueryLocal = $whereQuery;
                }
                $whereQueryLocal .= " AND ticket_id IN($dashboard_pending_tasks_ticket_ids)"; 
                if(count($dashboard_pending_tasks_lists)<1){
                    $whereQueryLocal = "ticket_id <1";
                }   
                            
                
                $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')

                                ->selectRaw("phoenix_tt_db.ticket_table.*,TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,`ticket_closing_time`) as 'closing_duration',TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,now()) as 'duration_now',(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(  DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) ,' [ ',TIMESTAMPDIFF(MINUTE,`task_start_time`,now()) ,' Min ]  ') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")
                                ->whereRaw("$whereQueryLocal")
                                ->orderBy('ticket_id', 'desc')
                                ->paginate(20);


                // $dept_id = $_SESSION['dept_id'];

                // $whereQueryLocal .= "  AND task_assigned_dept = $dept_id AND task_status != 'Closed'";
                // $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')
                //                 ->selectRaw("phoenix_tt_db.ticket_table.*,TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,`ticket_closing_time`) as 'closing_duration',TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,now()) as 'duration_now',(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,
                //                     CONCAT(dept_name,'[',TIMESTAMPDIFF(MINUTE,task_start_time,now()),' Min ]  ') as 'task_assigned_dept'")
                //                 ->join('phoenix_tt_db.task_table','phoenix_tt_db.task_table.ticket_id', '=', 'phoenix_tt_db.ticket_table.ticket_id')

                //                 // ->join('phoenix_tt_db.task_table', function($join) use ($dept_id){
                //                 //     $join->on('phoenix_tt_db.task_table.ticket_id', '=', 'phoenix_tt_db.ticket_table.ticket_id')
                //                 //          ->on('phoenix_tt_db.task_table.assigned_dept', '=', $dept_id);
                //                 // })
                //                 ->join('hr_tool_db.department_table','hr_tool_db.department_table.dept_row_id','=','phoenix_tt_db.task_table.task_assigned_dept')
                //                 ->whereRaw("$whereQueryLocal")
                //                 ->orderBy('task_id', 'asc')
                //                 //->toSql();
                //                 ->paginate(20);


                
                
            }

            if($dashboard_value == 'last_hour_closed'){

                date_default_timezone_set('Asia/Dhaka');
                $current_time_obj = new DateTime();
                $current_time = $current_time_obj->format('Y-m-d H:i:s');

                $previous_time_obj_temp = new DateTime();
                $previous_time_obj = $previous_time_obj_temp->modify("-1 hours");
                $previous_time = $previous_time_obj ->format('Y-m-d H:i:s');

                $dashboard_last_hour_closed_query = "SELECT * FROM phoenix_tt_db.ticket_table WHERE ticket_closing_time BETWEEN '$previous_time' AND '$current_time' AND ticket_initiator_dept=".$_SESSION['dept_id'];

                $dashboard_last_hour_closed_lists = \DB::select(\DB::raw($dashboard_last_hour_closed_query));

                // print_r($total_client_confirmation_lists);
                $dashboard_last_hour_closed_ticket_ids ='';

                foreach($dashboard_last_hour_closed_lists as $dashboard_last_hour_closed_list){
                    $dashboard_last_hour_closed_ticket_ids .= $dashboard_last_hour_closed_list->ticket_id.",";
                }

                // print_r($total_client_confirmation_ticket_ids);

                $dashboard_last_hour_closed_ticket_ids = trim($dashboard_last_hour_closed_ticket_ids,',');
                if($whereQuery != '1 AND '){
                    $whereQueryLocal = $whereQuery;
                }
                $whereQueryLocal .= " AND ticket_id IN($dashboard_last_hour_closed_ticket_ids)";
                if(count($dashboard_last_hour_closed_lists)<1){
                    $whereQueryLocal = "ticket_id <1";
                }    
                            
                // $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQuery")->orderBy('ticket_id', 'desc')->paginate(20);
                $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,`ticket_closing_time`) as 'closing_duration',TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,now()) as 'duration_now',(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQueryLocal")->orderBy('ticket_id', 'desc')->paginate(20);
            }

            if($dashboard_value == 'qa_tickets'){
                
                $qa_tickets_query =   "SELECT DISTINCT ft.ticket_id 
                                    FROM phoenix_tt_db.fault_table ft
                                    JOIN phoenix_tt_db.ticket_table tt ON ft.ticket_id = tt.ticket_id
                                    JOIN phoenix_tt_db.task_table tat ON ft.fault_id = tat.fault_id
                                    WHERE problem_category like 'QA-%' AND tt.ticket_status != 'Closed' AND tat.task_status != 'Closed' AND tat.task_assigned_dept =".$_SESSION['dept_id'];




                $qa_tts = \DB::select(\DB::raw($qa_tickets_query ));

                $qa_ticket_ids ='';
                foreach($qa_tts as $row){
                    $qa_ticket_ids .= $row->ticket_id.',';
                }

                $qa_ticket_ids = trim($qa_ticket_ids,',');
                if($whereQuery != '1 AND '){
                    $whereQueryLocal = $whereQuery;
                }
                $whereQueryLocal .= " AND ticket_id IN($qa_ticket_ids)";

                if(count($qa_tts)<1){
                    $whereQueryLocal = "ticket_id <1";
                }
                //echo $whereQuery;
                // $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQuery")->orderBy('ticket_id', 'desc')->paginate(20);
                 $ticket_lists = \DB::table('phoenix_tt_db.ticket_table')->selectRaw("phoenix_tt_db.ticket_table.*,TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,`ticket_closing_time`) as 'closing_duration',TIMESTAMPDIFF(MINUTE,`ticket_row_created_date`,now()) as 'duration_now',(select GROUP_CONCAT(DISTINCT(subcenter) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_subcenter,(SELECT GROUP_CONCAT(DISTINCT(SELECT dept_name FROM hr_tool_db.department_table WHERE hr_tool_db.department_table.dept_row_id=phoenix_tt_db.task_table.task_assigned_dept) SEPARATOR',') FROM phoenix_tt_db.task_table WHERE phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_status !='Closed') as task_assigned_dept")->whereRaw("$whereQueryLocal")->orderBy('ticket_id', 'desc')->paginate(20);

            }




        }

        $select_op_query = "select tt.*,(select client_name from phoenix_tt_db.client_table ct,phoenix_tt_db.fault_table ff where ff.fault_id=tt.fault_id and ff.client_id=ct.client_id) as client,(select ticket_title from phoenix_tt_db.ticket_table t where t.ticket_id=tt.ticket_id) as ticket_title,(select link_type from phoenix_tt_db.fault_table ft where tt.fault_id=ft.fault_id) as link_type,(select issue_type from phoenix_tt_db.fault_table ft where tt.fault_id=ft.fault_id) as issue_type,(select task_comment from phoenix_tt_db.task_update_log tuu where tuu.task_id=tt.task_id order by tuu.task_update_log_row_id desc limit 1) as task_comments,(select task_comment_time from phoenix_tt_db.task_update_log tuu where tuu.task_id=tt.task_id order by tuu.task_update_log_row_id desc limit 1) as task_comment_time,(select task_comment_user_id from phoenix_tt_db.task_update_log tuu where tuu.task_id=tt.task_id order by tuu.task_update_log_row_id desc limit 1) as task_comment_user_id from phoenix_tt_db.task_table tt where tt.task_id IN (select task_id from phoenix_tt_db.task_update_log where task_update_log_row_id in (SELECT MAX(task_update_log_row_id) FROM phoenix_tt_db.task_update_log group by task_id  order by task_update_log_row_id desc) and dept_name !='NOC' and task_status='escalated') and tt.task_status ='escalated'";
        $op_lists = \DB::select(\DB::raw($select_op_query));

        // $rfo_query = "select DISTINCT(tt.ticket_id),tt.fault_id,tt.task_description, (select (select c.client_name from client_table c where c.client_id = f.client_id) from fault_table f where f.fault_id=tt.fault_id) as client_name, (select issue_type from fault_table ff where ff.fault_id=tt.fault_id) as issue_type from task_table tt where task_name like '%RFO Pending%' and (select issue_type from fault_table ff where ff.fault_id=tt.fault_id) !='NTTN'";
        // $rfo_lists = \DB::select(\DB::raw($rfo_query));

        $rfo_query = "select DISTINCT(tt.ticket_id),tt.fault_id,tt.task_description, (select (select c.client_name from client_table c where c.client_id = f.client_id) from fault_table f where f.fault_id=tt.fault_id) as client_name, (select issue_type from fault_table ff where ff.fault_id=tt.fault_id) as issue_type,(select ft.event_time from fault_table ft WHERE ft.fault_id = tt.fault_id) as 'event_time',(SELECT tit.ticket_title from ticket_table tit WHERE tit.ticket_id = tt.ticket_id) as 'ticket_title',
                    (
                        SELECT
                        (
                        CASE
                        WHEN ft.element_type = 'link' THEN (SELECT CONCAT(lt.link_name_nttn, '-',lt.link_name_gateway) FROM link_table lt WHERE lt.link_name_id = ft.element_id)
                        ELSE (SELECT st.site_name FROM site_table st WHERE st.site_name_id = ft.element_id)
                        END
                        )
                        FROM fault_table ft
                        WHERE ft.fault_id = tt.fault_id
                    ) as 'element_name'
                    from task_table tt where task_name like '%RFO Pending%' and (select issue_type from fault_table ff where ff.fault_id=tt.fault_id) !='NTTN'";

        $rfo_lists = \DB::select(\DB::raw($rfo_query));

        $ticket_status_table_query =  "SELECT * FROM phoenix_tt_db.ticket_status_table";
        $ticket_status_lists = \DB::select(\DB::raw($ticket_status_table_query));  
        
        $subcenter_query = "SELECT * FROM phoenix_tt_db.subcenter_table WHERE status='Active' ORDER BY subcenter_name";
        $subcenter_lists = \DB::select(\DB::raw($subcenter_query));

        $ticket_count = count($ticket_lists);       

        return view('ticket.view_tt',compact('ticket_lists','ticket_id','ticket_title','assigned_dept','ticket_status','department_lists','dashboard_value','ticket_status_lists','ticket_count','op_lists','rfo_lists','subcenter_lists','assigned_subcenter'));
    }
    public function test_tt_phoenix(){
        $log_controller = New LogController();
        $log_controller->insert_incident_table_log('8');
    }

    public function create_tt_email(){

        $ticketId = Request::get('ticket_id');
        $clientArr = array();
        $ticketArr = array();

        $fault_table_query = "SELECT DISTINCT client_id from phoenix_tt_db.fault_table WHERE ticket_id=$ticketId";
        $fault_lists = \DB::select(\DB::raw($fault_table_query));

        foreach($fault_lists as $fault_list){


            array_push($clientArr,$fault_list->client_id);
        }

        // print_r($clientArr);

        for($i=0;$i<count($clientArr);$i++){

                $clientTemp = $clientArr[$i];
                $fault_table_query = "SELECT * from phoenix_tt_db.fault_table WHERE ticket_id=$ticketId AND client_id=$clientTemp";
                $fault_lists = \DB::select(\DB::raw($fault_table_query));

                    $ticketArr[$i]['problem_category'] ="";
                    $ticketArr[$i]['client_side_impact'] = "";
                    $ticketArr[$i]['fault_id'] = "";
                    $ticketArr[$i]['status'] = "";
                    $ticketArr[$i]['event_time'] = "";
                    $ticketArr[$i]['clear_time'] = "";
                    $ticketArr[$i]['client_type'] = "";
                    $ticketArr[$i]['reason'] = "";
                    $ticketArr[$i]['element_type'] = "";
                    $ticketArr[$i]['link_name'] = "";
                    $ticketArr[$i]['link_id'] = "";
                    $ticketArr[$i]['site_name'] = "";
                    $ticketArr[$i]['issue_type'] = "";
                    $ticketArr[$i]['duration'] = "";

                foreach($fault_lists as $fault_list){

                    $client_id_temp = $fault_list->client_id;

                    $client_id_query = "SELECT * from phoenix_tt_db.client_table where client_id=$client_id_temp";
                    $client_lists = \DB::select(\DB::raw($client_id_query));

                    foreach($client_lists as $client_list){

                        $client_id_temp = $client_list->client_name;
                    }

                    $ticketArr[$i]['client']= $client_id_temp;
                    $ticketArr[$i]['problem_category'] .=  $fault_list->problem_category.",";
                    $ticketArr[$i]['client_side_impact'] .= $fault_list->client_side_impact.",";
                    $ticketArr[$i]['fault_id'] .= $fault_list->fault_id.",";
                    $ticketArr[$i]['status'] .= $fault_list->fault_status.",";
                    $ticketArr[$i]['event_time'] .= $fault_list->event_time.",";
                    $ticketArr[$i]['clear_time'] .= $fault_list->clear_time.",";
                    $ticketArr[$i]['client_type'] .= $fault_list->link_type.",";
                    $ticketArr[$i]['reason'] .= $fault_list->reason.",";
                    $ticketArr[$i]['element_type'].= $fault_list->element_type.",";
                    $ticketArr[$i]['issue_type'].= $fault_list->issue_type.",";
                    $ticketArr[$i]['duration'].= round($fault_list->duration,2)." Hr";

                    $element_temp = $fault_list->element_id;
                    $element_id ="";

                    if($fault_list->element_type=="link"){

                                    $element_query = "SELECT * from phoenix_tt_db.link_table where link_name_id=$element_temp";
                                    $element_lists = \DB::select(\DB::raw($element_query));

                                    foreach($element_lists as $element_list){

                                        $element_temp = $element_list->link_name_nttn.','.$element_list->link_name_gateway;
                                        $element_id = $element_list->link_id;
                                    }
                    $ticketArr[$i]['link_name'].= $element_temp.",";   
                    $ticketArr[$i]['link_id'].= $element_id.",";                

                    }
                    if($fault_list->element_type=="site"){

                                    $element_query = "SELECT * from phoenix_tt_db.site_table where site_name_id=$element_temp";
                                    $element_lists = \DB::select(\DB::raw($element_query));

                                    foreach($element_lists as $element_list){

                                        $element_temp = $element_list->site_name;
                                    }
                    $ticketArr[$i]['site_name'].= $element_temp.",";                  

                    }                    
                    

                }

                    $ticketArr[$i]['problem_category'] =trim($ticketArr[$i]['problem_category'],",");
                    $ticketArr[$i]['client_side_impact'] = trim($ticketArr[$i]['client_side_impact'],",");
                    $ticketArr[$i]['status'] = trim($ticketArr[$i]['status'],",");
                    $ticketArr[$i]['event_time'] = trim($ticketArr[$i]['event_time'],",");
                    $ticketArr[$i]['clear_time'] = trim($ticketArr[$i]['clear_time'],",");
                    $ticketArr[$i]['client_type'] = trim($ticketArr[$i]['client_type'],",");
                    $ticketArr[$i]['reason'] = trim($ticketArr[$i]['reason'],",");
                    $ticketArr[$i]['element_type'] = trim($ticketArr[$i]['element_type'],",");
                    $ticketArr[$i]['link_name'] = trim($ticketArr[$i]['link_name'],",");
                    $ticketArr[$i]['link_id'] = trim($ticketArr[$i]['link_id'],",");
                    $ticketArr[$i]['site_name'] = trim($ticketArr[$i]['site_name'],",");
                    $ticketArr[$i]['issue_type'] = trim($ticketArr[$i]['issue_type'],",");



        }

        

         return view('ticket.view_tt_mail',compact('ticketArr','ticketId'));

        // print_r($ticketArr);

        // return $fault_lists;


    }

    public function view_tt_single(){
        $ticketId = Request::get('ticket_id');
        $department_list_js_arr = array();
        $ticket_table_query = "SELECT * FROM phoenix_tt_db.ticket_table WHERE ticket_id=$ticketId";
        $ticket_lists = \DB::select(\DB::raw($ticket_table_query));

        foreach($ticket_lists as $ticket_list){
            $ticketTitle=$ticket_list->ticket_title;
            $incidentId=$ticket_list->incident_id;
            $ticketStatus=$ticket_list->ticket_status;
            $assignedDept=$ticket_list->assigned_dept;
            $attachment_path=$ticket_list->ticket_file_path;
            $ticket_initiator=$ticket_list->ticket_initiator;
            $ticket_initiator_dept=$ticket_list->ticket_initiator_dept;
        }
        $assigned_dept_arr = explode(',', $assignedDept);
        if($incidentId){
            $incident_table_query ="SELECT * FROM phoenix_tt_db.incident_table WHERE incident_id=$incidentId";
            $incident_lists = \DB::select(\DB::raw($incident_table_query));
            foreach($incident_lists as $incident_list){
                $incidentTitle=$incident_list->incident_title;
                $incidentDescription = $incident_list->incident_description;
            }
        }
        else{
            $incidentTitle='';
            $incidentDescription = '';
        }
        

        $fault_table_query ="SELECT f.*,CONCAT(l.link_name_nttn,',',l.link_name_gateway) as name,l.link_id,l.vlan_id, 'N/A' as site_ip_address,l.district as district,l.region as region, l.sms_group as sms_group,(select c.client_name from phoenix_tt_db.client_table as c where c.client_id = f.client_id) as client_name,l.vendor as vendor,(select c.client_name from phoenix_tt_db.client_table as c where c.client_id = f.provider) as provider FROM phoenix_tt_db.fault_table as f, phoenix_tt_db.link_table as l
            where f.element_type = 'link' 
            and f.element_id = l.link_name_id
            and f.ticket_id = $ticketId
            union 
            SELECT f.*,s.site_name as name, 'N/A' as link_id_s, 'N/A' as vlan_id_s,s.site_ip_address as site_ip_address_s,s.district as district,s.region as region, s.sms_group as sms_group,(select c.client_name from phoenix_tt_db.client_table as c where c.client_id = f.client_id) as client_name,s.vendor as vendor,(select c.client_name from phoenix_tt_db.client_table as c where c.client_id = f.provider) as provider FROM phoenix_tt_db.fault_table as f, phoenix_tt_db.site_table as s
            where f.element_type = 'site' 
            and f.element_id = s.site_name_id
            and f.ticket_id = $ticketId";
        //echo   $fault_table_query;  
        $fault_lists = \DB::select(\DB::raw($fault_table_query));
        //echo $fault_table_query;

        // $scl_comment_table_query ="SELECT * FROM phoenix_tt_db.scl_comment_table WHERE ticket_id=$ticketId";
        // $scl_comment_lists = \DB::select(\DB::raw($scl_comment_table_query));

        // $noc_comment_table_query ="SELECT * FROM phoenix_tt_db.noc_comment_table WHERE ticket_id=$ticketId";
        // $noc_comment_lists = \DB::select(\DB::raw($noc_comment_table_query));

        // $client_comment_table_query ="SELECT * FROM phoenix_tt_db.client_comment_table WHERE ticket_id=$ticketId";
        // $client_comment_lists = \DB::select(\DB::raw($client_comment_table_query));

        $fault_count =0;


        $scl_comment_table_query ="SELECT * FROM phoenix_tt_db.scl_comment_table WHERE ticket_id=$ticketId";
        $scl_comment_lists = \DB::select(\DB::raw($scl_comment_table_query));

        $noc_comment_table_query ="SELECT * FROM phoenix_tt_db.noc_comment_table WHERE ticket_id=$ticketId";
        $noc_comment_lists = \DB::select(\DB::raw($noc_comment_table_query));

        $client_comment_table_query ="SELECT * FROM phoenix_tt_db.client_comment_table WHERE ticket_id=$ticketId";
        $client_comment_lists = \DB::select(\DB::raw($client_comment_table_query));

        $ticket_status_table_query = "SELECT * FROM phoenix_tt_db.ticket_status_table";
        $ticket_status_lists = \DB::select(\DB::raw($ticket_status_table_query));

        $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29 AND dept_row_id IN (4,10,11,12,14,15,34,35,36,41,43,45,46,47)";
        $department_lists = \DB::select(\DB::raw($department_query));

        $client_query = "SELECT * FROM phoenix_tt_db.client_table";
        $client_lists = \DB::select(\DB::raw($client_query));

        $select_link_query = "SELECT * FROM phoenix_tt_db.sms_link WHERE ticket_id=$ticketId";
        $sms_link_lists = \DB::select(\DB::raw($select_link_query));
        if(count($sms_link_lists) > 0){
            $sms_link = $sms_link_lists[0]->link;
            $sms_header = $sms_link_lists[0]->sms_header;
            $sms_body = $sms_link_lists[0]->sms_body;
            $sms_group = $sms_link_lists[0]->sms_group;
        }
        else{
            $sms_link = '';
            $sms_header = '';
            $sms_body = '';
            $sms_group = '';
        }
        

        $sms_type_table_query = "SELECT * FROM phoenix_tt_db.sms_type_table";
        $sms_type_lists = \DB::select(\DB::raw($sms_type_table_query));


        $problem_source_query = "SELECT * FROM phoenix_tt_db.problem_source_table";
        $problem_source_lists = \DB::select(\DB::raw($problem_source_query));

        $issue_type_table_query = "SELECT * FROM phoenix_tt_db.issue_type_table";
        $issue_type_lists = \DB::select(\DB::raw($issue_type_table_query));

        $reason_table_query = "SELECT * FROM phoenix_tt_db.reason_table";
        $reason_lists = \DB::select(\DB::raw($reason_table_query));

        $problem_category_table_query = "SELECT * FROM phoenix_tt_db.problem_category_table ORDER BY problem_name";
        $problem_category_lists = \DB::select(\DB::raw($problem_category_table_query));

        $link_table_query = "SELECT * FROM phoenix_tt_db.link_table";
        $link_lists = \DB::select(\DB::raw($link_table_query));

        $site_table_query = "SELECT * FROM phoenix_tt_db.site_table";
        $site_lists = \DB::select(\DB::raw($site_table_query));

        $link_type_table_query = "SELECT * FROM phoenix_tt_db.link_type_table";
        $link_type_lists = \DB::select(\DB::raw($link_type_table_query));

        $task_table_query = "SELECT *,(SELECT GROUP_CONCAT('[',tu.task_comment_user_id,']','[',tu.task_status,'] ', ' [',tu.dept_name, '] ', ' [',tu.task_comment_time,'] : ',tu.task_comment SEPARATOR ' || ') FROM phoenix_tt_db.task_update_log tu WHERE tu.task_id=t.task_id) as task_comments FROM phoenix_tt_db.task_table t WHERE ticket_id=$ticketId";
        $task_lists = \DB::select(\DB::raw($task_table_query));   

        $task_status_table_query =  "SELECT * FROM phoenix_tt_db.task_status_table";
        $task_status_lists = \DB::select(\DB::raw($task_status_table_query));   

        $task_res_big_arr = array();
        foreach($task_lists as $task_list){
            $task_find_res_query = "SELECT * FROM phoenix_tt_db.task_resolution_table WHERE task_id=".$task_list->task_id;
            $task_res_lists = \DB::select(\DB::raw($task_find_res_query));
            $task_res_arr = array();
            if(count($task_res_lists)>0){            
                foreach($task_res_lists as $task_res_list){
                    $task_res_small_arr = array();
                    array_push($task_res_small_arr, $task_res_list->task_resolution_id);
                    array_push($task_res_small_arr, $task_res_list->reason);
                    array_push($task_res_small_arr, $task_res_list->resolution_type);
                    array_push($task_res_small_arr, $task_res_list->inventory_type);
                    array_push($task_res_small_arr, $task_res_list->inventory_detail);
                    array_push($task_res_small_arr, $task_res_list->quantity);
                    array_push($task_res_small_arr, $task_res_list->remark);
                    array_push($task_res_small_arr, $task_res_list->task_resolution_create_time);
                    array_push($task_res_small_arr, $task_res_list->task_resolution_update_time);
                    array_push($task_res_small_arr, $task_res_list->task_resolution_update_time);
                    array_push($task_res_arr, $task_res_small_arr);
                }
                $task_res_big_arr[$task_list->task_id] =  $task_res_arr; 
            }           
        }

        foreach($department_lists as $department_list){
            array_push($department_list_js_arr, $department_list->dept_name);
        }
        //return $task_res_big_arr;
        return view('ticket.view_tt_single',compact('ticketTitle','ticketStatus','incidentId','incidentTitle','ticketId','fault_lists','scl_comment_lists','noc_comment_lists','client_comment_lists','ticket_status_lists','department_lists','assignedDept','client_lists','problem_source_lists','issue_type_lists','reason_lists','problem_category_lists','fault_count','link_lists','site_lists','link_type_lists','task_lists','department_list_js_arr','attachment_path','task_status_lists','incidentDescription','assigned_dept_arr','task_res_big_arr','sms_link','ticket_initiator','ticket_initiator_dept','sms_type_lists','sms_header','sms_body','sms_group'));
    }


    



/****************************************************************************************EDIT EDIT**********************************************************************************************/



 public function edit_tt_view(){

        $ticketId = Request::get('ticket_id');

        $department_list_js_arr = array();

        $department_id_list_js_arr = array();
        $client_js_arr = array();
        $subcenter_list_js_arr = array();
        $link_type_js_arr = array();
        $task_name_js_arr = array();

        $ticket_table_query = "SELECT * FROM phoenix_tt_db.ticket_table WHERE ticket_id=$ticketId";
        $ticket_lists = \DB::select(\DB::raw($ticket_table_query));


        foreach($ticket_lists as $ticket_list){


            $ticketTitle=$ticket_list->ticket_title;
            $incidentId=$ticket_list->incident_id;
            $ticketStatus=$ticket_list->ticket_status;
            $assignedDept=$ticket_list->assigned_dept;
            $attachment_path=$ticket_list->ticket_file_path;
            $ticket_initiator_dept = $ticket_list->ticket_initiator_dept;

        }

        $assigned_dept_arr = explode(',', $assignedDept);
        //print_r($assigned_dept_arr);
        if($incidentId){
            $incident_table_query ="SELECT * FROM phoenix_tt_db.incident_table WHERE incident_id=$incidentId";
            $incident_lists = \DB::select(\DB::raw($incident_table_query));

            foreach($incident_lists as $incident_list){
                $incidentTitle=$incident_list->incident_title;
            }
        }
        else{
            $incidentTitle='';
        }

        
        $fault_table_query ="SELECT f.*,CONCAT(l.link_name_nttn,',',l.link_name_gateway)  as link_name,l.link_id,l.vlan_id, 'N/A' as site_ip_address,l.district as district,l.region as region, l.sms_group as sms_group,l.vendor as vendor,(select c.client_name from client_table as c where c.client_id = f.client_id) as client_name,(select c.client_id from phoenix_tt_db.client_table as c where c.client_id = f.provider) as provider FROM phoenix_tt_db.`fault_table` as f, phoenix_tt_db.link_table as l
            where f.element_type = 'link' 
            and f.element_id = l.link_name_id
            and f.ticket_id = $ticketId
            union all
            SELECT f.*,s.site_name as site_name, 'N/A' as link_id_s, 'N/A' as vlan_id_s,s.site_ip_address as site_ip_address_s,s.district as district,s.region as region, s.sms_group as sms_group,(select c.client_name from phoenix_tt_db.client_table as c where c.client_id = f.client_id) as client_name,s.vendor as vendor,(select c.client_id from phoenix_tt_db.client_table as c where c.client_id = f.provider) as provider FROM phoenix_tt_db.`fault_table` as f, phoenix_tt_db.site_table as s
            where f.element_type = 'site' 
            and f.element_id = s.site_name_id
            and f.ticket_id = $ticketId";

        //1$fault_table_query ="SELECT * FROM phoenix_tt_db.fault_table WHERE ticket_id=$ticketId";
        $fault_lists = \DB::select(\DB::raw($fault_table_query));

        $fault_count =0;


        $scl_comment_table_query ="SELECT * FROM phoenix_tt_db.scl_comment_table WHERE ticket_id=$ticketId";
        $scl_comment_lists = \DB::select(\DB::raw($scl_comment_table_query));

        $noc_comment_table_query ="SELECT * FROM phoenix_tt_db.noc_comment_table WHERE ticket_id=$ticketId";
        $noc_comment_lists = \DB::select(\DB::raw($noc_comment_table_query));

        $client_comment_table_query ="SELECT * FROM phoenix_tt_db.client_comment_table WHERE ticket_id=$ticketId";
        $client_comment_lists = \DB::select(\DB::raw($client_comment_table_query));

        $ticket_status_table_query = "SELECT * FROM phoenix_tt_db.ticket_status_table";
        $ticket_status_lists = \DB::select(\DB::raw($ticket_status_table_query));

        // $department_query ="SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29 AND dept_row_id IN (4,10,11,12,15,34,35,36,40,41,43,45)";;
        $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29 AND dept_row_id IN (4,10,11,12,14,15,34,35,36,41,43,45,46,47) ORDER BY dept_name";
        $department_lists = \DB::select(\DB::raw($department_query));

        $client_query = "SELECT * FROM phoenix_tt_db.client_table ORDER BY client_name";
        $client_lists = \DB::select(\DB::raw($client_query));

        $problem_source_query = "SELECT * FROM phoenix_tt_db.problem_source_table";
        $problem_source_lists = \DB::select(\DB::raw($problem_source_query));

        $issue_type_table_query = "SELECT * FROM phoenix_tt_db.issue_type_table";
        $issue_type_lists = \DB::select(\DB::raw($issue_type_table_query));

        $reason_table_query = "SELECT * FROM phoenix_tt_db.reason_table";
        $reason_lists = \DB::select(\DB::raw($reason_table_query));

        $problem_category_table_query = "SELECT * FROM phoenix_tt_db.problem_category_table  ORDER BY problem_name";
        $problem_category_lists = \DB::select(\DB::raw($problem_category_table_query));

        $link_table_query = "SELECT * FROM phoenix_tt_db.link_table";
        $link_lists = \DB::select(\DB::raw($link_table_query));

        $site_table_query = "SELECT * FROM phoenix_tt_db.site_table";
        $site_lists = \DB::select(\DB::raw($site_table_query));

        $link_type_table_query = "SELECT * FROM phoenix_tt_db.link_type_table";
        $link_type_lists = \DB::select(\DB::raw($link_type_table_query));

        // $task_table_query = "SELECT *,(SELECT GROUP_CONCAT('[',tu.task_comment_user_id,']','[',tu.task_status,'] :',tu.task_comment SEPARATOR ' || ') FROM phoenix_tt_db.task_update_log tu WHERE tu.task_id=t.task_id) as task_comments FROM phoenix_tt_db.task_table t WHERE ticket_id=$ticketId";
        $task_table_query = "SELECT *,(SELECT GROUP_CONCAT('[',tu.task_comment_user_id,']','[',tu.task_status,']','[',tu.task_comment_time,']:  ',tu.task_comment SEPARATOR ' || ') FROM phoenix_tt_db.task_update_log tu WHERE tu.task_id=t.task_id) as task_comments FROM phoenix_tt_db.task_table t WHERE ticket_id=$ticketId";
        $task_lists = \DB::select(\DB::raw($task_table_query));

        //print_r($task_lists);

        // Ensure NOC will not see Return To initiator

        if($_SESSION['department'] == 'NOC')
        {
            $task_status_table_query =  "SELECT * 
                                        FROM phoenix_tt_db.task_status_table
                                        WHERE task_status != 'RTI'";
        }
        else{
            $task_status_table_query =  "SELECT * 
                                        FROM phoenix_tt_db.task_status_table
                                        WHERE task_status != 'RFO Pending'";

        }



        //$task_status_table_query =  "SELECT * FROM phoenix_tt_db.task_status_table";
        $task_status_lists = \DB::select(\DB::raw($task_status_table_query));   

        $subcenter_query = "SELECT * FROM phoenix_tt_db.subcenter_table WHERE status='Active' ORDER BY subcenter_name";
        $subcenter_lists = \DB::select(\DB::raw($subcenter_query));

        // foreach($department_lists as $department_list){
        //     array_push($department_list_js_arr, $department_list->dept_name);
        // }    
        
        // foreach($department_lists as $department_list){
        //     array_push($department_id_list_js_arr, $department_list->dept_row_id);
        // }

        /////////////////////////////////////////// Here the department list is different because some departments are discarded from the list to assign new task as they does not exists ///////////////////////
        
        $new_task_department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29 AND dept_row_id IN (4,10,11,12,14,15,34,41,43,45,46,47)";
        $new_task_department_lists = \DB::select(\DB::raw($new_task_department_query));

        foreach($new_task_department_lists as $department_list){
            array_push($department_list_js_arr, $department_list->dept_name);
        }    
        foreach($new_task_department_lists as $department_list){
            array_push($department_id_list_js_arr, $department_list->dept_row_id);
        }

        foreach($client_lists as $client_list){
            $client_arr[$client_list->client_id] = $client_list->priority;
            array_push($client_js_arr, $client_list->client_id.'--'.$client_list->client_name);
        }

        foreach($subcenter_lists as $subcenter_list){
            array_push($subcenter_list_js_arr, $subcenter_list->subcenter_name);
        }

        $task_title_query = "SELECT * FROM phoenix_tt_db.task_title_table";
        $task_title_lists = \DB::select(\DB::raw($task_title_query));

        //print_r($task_title_lists);

        foreach($task_title_lists as $task_title_list){
            array_push($task_name_js_arr, $task_title_list->title_name);
        }



        return view('ticket.edit_tt',compact('ticketTitle','ticketStatus','incidentId','incidentTitle','ticketId','fault_lists','scl_comment_lists','noc_comment_lists','client_comment_lists','ticket_status_lists','department_lists','assignedDept','client_lists','problem_source_lists','issue_type_lists','reason_lists','problem_category_lists','fault_count','link_lists','site_lists','link_type_lists','task_lists','department_list_js_arr','attachment_path','task_status_lists','department_id_list_js_arr','assigned_dept_arr','ticket_initiator_dept','client_js_arr','subcenter_list_js_arr','task_name_js_arr','task_title_lists'));


    }

    public function edit_tt(){

        $ticket_id = Request::get('ticket_id');
        $ticket_title = addslashes(Request::get('ticket_title'));
        $ticket_status = addslashes(Request::get('ticket_status'));
        $incident_title = addslashes(Request::get('incident_title'));
        $ticket_comment_scl = addslashes(Request::get('ticket_comment_scl'));
        $ticket_comment_client = addslashes(Request::get('ticket_comment_client'));
        $ticket_comment_noc = addslashes(Request::get('ticket_comment_noc'));
        $assigned_dept = Request::get('assigned_dept');
        $incident_id = Request::get('incident_id');
        $ticket_initiator_dept = Request::get('ticket_initiator_dept');
        $ticket_previous_status = Request::get('ticket_previous_status');


        $path = '../TicketFiles/'.$ticket_id;

        $ticket_arr = array();
        $fault_arr = array();
        $task_init_arr = array();
        $task_arr = array();
        $task_hidden_arr = array();

        $ticket_arr['ticket_title'] = $ticket_title;
        $ticket_arr['ticket_status'] = $ticket_status;
        $ticket_arr['incident_title'] = $incident_title;
        $ticket_arr['assigned_dept'] = $assigned_dept;
        $ticket_arr['ticket_comment_scl'] = $ticket_comment_scl;
        $ticket_arr['ticket_comment_client'] = $ticket_comment_client;
        $ticket_arr['ticket_comment_noc'] = $ticket_comment_noc;
        $ticket_arr['ticket_initiator_dept'] = $ticket_initiator_dept;
        
        if(Input::hasFile('ticket_files')){
            if(!File::exists($path)){
                $dirPath = '../TicketFiles/'.$ticket_id.'/';
                $result = File::makeDirectory($path);
                $files = Request::file('ticket_files');
                
                foreach($files as $file){
                    $filename = $file->getClientOriginalName();
                    //$extension = File::extension($originalFileName);
                    //$filename = $originalFileName;
                    $file->move($dirPath,$filename);
                }
            }
            else{
                $dirPath = '../TicketFiles/'.$ticket_id.'/';
                //$result = File::makeDirectory($path);
                $files = Request::file('ticket_files');
                
                foreach($files as $file){
                    $filename = $file->getClientOriginalName();
                    //$extension = File::extension($originalFileName);
                    //$filename = $originalFileName;
                    $file->move($dirPath,$filename);
                }
            }
        }   
        else{
            $select_path_query = 'SELECT ticket_file_path FROM phoenix_tt_db.ticket_table where ticket_id='.$ticket_id;
            $path_lists = \DB::select(\DB::raw($select_path_query));
            $path = $path_lists[0]->ticket_file_path;
        }

        $ticket_arr['file_path'] = $path;

        $fault_count = Request::get('fault_count');

        for($i=1;$i<$fault_count+1;$i++){

            $tempNumber = $i;

            $fault_id_temp = addslashes(Request::get('fault_id_'.$tempNumber));
            $fault_arr['fault_id_'.$i] = $fault_id_temp;

            $client_id_temp = addslashes(Request::get('client_id_'.$tempNumber));
            $fault_arr['client_id_'.$i] = $client_id_temp;

            $element_type_temp = addslashes(Request::get('element_type_'.$tempNumber));
            $fault_arr['element_type_'.$i] = $element_type_temp;

            $element_name_temp = addslashes(Request::get('element_name_'.$tempNumber));
            $fault_arr['element_name_'.$i] = $element_name_temp;

            $element_id_temp = addslashes(Request::get('element_id_'.$tempNumber));
            $fault_arr['element_id_'.$i] = $element_id_temp;

            $vlan_id_temp = addslashes(Request::get('vlan_id_'.$tempNumber));
            $fault_arr['vlan_id_'.$i] = $vlan_id_temp;

            $link_type_temp = addslashes(Request::get('link_type_'.$tempNumber));
            $fault_arr['link_type_'.$i] = $link_type_temp;

            $link_id_temp = addslashes(Request::get('link_id_'.$tempNumber));
            $fault_arr['link_id_'.$i] = $client_id_temp;

            $site_ip_address_temp = addslashes(Request::get('site_ip_address_'.$tempNumber));
            $fault_arr['site_ip_address_'.$i] = $site_ip_address_temp;

            $district_temp = addslashes(Request::get('district_'.$tempNumber));
            $fault_arr['district_'.$i] = $district_temp;

            $region_temp = addslashes(Request::get('region_'.$tempNumber));
            $fault_arr['region_'.$i] = $region_temp;

            $sms_group_temp = addslashes(Request::get('sms_group_'.$tempNumber));
            $fault_arr['sms_group_'.$i] = $sms_group_temp;

            $client_priority_temp = addslashes(Request::get('client_priority_'.$tempNumber));
            $fault_arr['client_priority_'.$i] = $client_priority_temp;

            $client_side_impact_temp = addslashes(Request::get('client_side_impact_'.$tempNumber));
            $fault_arr['client_side_impact_'.$i] = $client_side_impact_temp;

            $responsible_field_team_temp = addslashes(Request::get('responsible_field_team_'.$tempNumber));
            $fault_arr['responsible_field_team_'.$i] = $responsible_field_team_temp;

            $provider_temp = addslashes(Request::get('provider_name_'.$tempNumber));
            $fault_arr['provider_name_'.$i] = $provider_temp;

            $reason_temp = addslashes(Request::get('reason_'.$tempNumber));
            $fault_arr['reason_'.$i] = $reason_temp;

            $fault_status_temp = addslashes(Request::get('fault_status_'.$tempNumber));
            $fault_arr['fault_status_'.$i] = $fault_status_temp;

            $issue_type_temp = addslashes(Request::get('issue_type_'.$tempNumber));
            $fault_arr['issue_type_'.$i] = $issue_type_temp;

            $problem_category_temp = addslashes(Request::get('problem_category_'.$tempNumber));
            $fault_arr['problem_category_'.$i] = $problem_category_temp;

            $problem_source_temp = addslashes(Request::get('problem_source_'.$tempNumber));
            $fault_arr['problem_source_'.$i] = $problem_source_temp;

            $responsible_vendor_temp = addslashes(Request::get('responsible_vendor_'.$tempNumber));
            $fault_arr['responsible_vendor_'.$i] = $responsible_vendor_temp;

            $escalation_time_temp = addslashes(Request::get('escalation_time_'.$tempNumber));
            $fault_arr['escalation_time_'.$i] = $escalation_time_temp;

            $responsible_concern_temp = addslashes(Request::get('responsible_concern_'.$tempNumber));
            $fault_arr['responsible_concern_'.$i] = $responsible_concern_temp;

            $event_time_temp = addslashes(Request::get('event_time_'.$tempNumber));
            $fault_arr['event_time_'.$i] = $event_time_temp;

            $provider_side_impact_temp = addslashes(Request::get('provider_side_impact_'.$tempNumber));
            $fault_arr['provider_side_impact_'.$i] = $provider_side_impact_temp;

            $remarks_temp = addslashes(Request::get('remarks_'.$tempNumber));
            $fault_arr['remarks_'.$i] = $remarks_temp;

            $previous_remarks_temp = addslashes(Request::get('previous_remarks_'.$tempNumber));
            $fault_arr['previous_remarks_'.$i] = $previous_remarks_temp;

            $clear_time_temp = addslashes(Request::get('clear_time_'.$tempNumber));
            $fault_arr['clear_time_'.$i] = $clear_time_temp;     



            $task_init_counter_str = "fault_".$i."_init_task_counter";


            $task_init_count = Request::get($task_init_counter_str);

            $fault_arr['task_init_count_'.$i] = $task_init_count;



            for($j=1;$j<$task_init_count+1;$j++){

                $task_id_temp = addslashes(Request::get('fault_'.$i.'_task_'.$j.'_id'));
                $task_init_arr['fault_'.$i.'_task_'.$j.'_id']=$task_id_temp;

                $task_name_temp = addslashes(Request::get('fault_'.$i.'_task_'.$j.'_name'));
                $task_init_arr['fault_'.$i.'_task_'.$j.'_name']=$task_name_temp;

                $task_description_temp = addslashes(Request::get('fault_'.$i.'_task_'.$j.'_description'));
                $task_init_arr['fault_'.$i.'_task_'.$j.'_description']=$task_description_temp;

                $task_assigned_dept_temp = addslashes(Request::get('fault_'.$i.'_task_'.$j.'_assigned_dept'));
                $task_init_arr['fault_'.$i.'_task_'.$j.'_assigned_dept']=$task_assigned_dept_temp;     

                $task_start_time_temp = addslashes(Request::get('fault_'.$i.'_task_'.$j.'_start_time'));
                $task_init_arr['fault_'.$i.'_task_'.$j.'_start_time']=$task_start_time_temp;  

                $task_end_time_temp = addslashes(Request::get('fault_'.$i.'_task_'.$j.'_end_time'));
                $task_init_arr['fault_'.$i.'_task_'.$j.'_end_time']=$task_end_time_temp;  

                $task_on_behalf_temp = Request::get('fault_'.$i.'_task_'.$j.'_on_behalf_checker');
                $task_init_arr['fault_'.$i.'_task_'.$j.'_on_behalf_checker']=$task_on_behalf_temp; 

                $task_comment_temp = addslashes(Request::get('fault_'.$i.'_task_'.$j.'_comment'));

                if($task_on_behalf_temp == 1){
                    $task_init_arr['fault_'.$i.'_task_'.$j.'_comment']=' (On Behalf) '.$task_comment_temp;  
                }
                else{
                    $task_init_arr['fault_'.$i.'_task_'.$j.'_comment']=$task_comment_temp;  
                }

                
                

                $task_previous_comment_temp = addslashes(Request::get('fault_'.$i.'_task_'.$j.'_previous_comment'));
                $task_init_arr['fault_'.$i.'_task_'.$j.'_previous_comment']=$task_previous_comment_temp;                           

                $task_resolver_temp = addslashes(Request::get('fault_'.$i.'_task_'.$j.'_resolver'));
                $task_init_arr['fault_'.$i.'_task_'.$j.'_resolver']=$task_resolver_temp;       

                $task_status_temp = addslashes(Request::get('fault_'.$i.'_task_'.$j.'_status'));
                $task_init_arr['fault_'.$i.'_task_'.$j.'_status']=$task_status_temp;

                              
            }

            $task_hidden_ids_str = "fault_".$i."_task_hidden_ids";
            $task_hidden_ids = Request::get($task_hidden_ids_str);

            $task_hidden_ids=trim($task_hidden_ids,",");

            $task_hidden_arr = explode(",", $task_hidden_ids);

            $fault_arr['task_hidden_arr_'.$i] = $task_hidden_arr;

            foreach($task_hidden_arr as $task_hidden_id){

                if($task_hidden_id!=""){

                    $task_name_temp = addslashes(Request::get('fault_'.$i.'_task_'.$task_hidden_id.'_name'));
                    $task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_name']=$task_name_temp;

                    $task_description_temp = addslashes(Request::get('fault_'.$i.'_task_'.$task_hidden_id.'_description'));
                    $task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_description']=$task_description_temp;

                    $task_assigned_dept_temp = addslashes(Request::get('fault_'.$i.'_task_'.$task_hidden_id.'_assigned_dept'));
                    $task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_assigned_dept']=$task_assigned_dept_temp;     

                    $task_start_time_temp = addslashes(Request::get('fault_'.$i.'_task_'.$task_hidden_id.'_start_time'));
                    $task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_start_time']=$task_start_time_temp;  

                    $task_comment_temp = addslashes(Request::get('fault_'.$i.'_task_'.$task_hidden_id.'_comment'));
                    $task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_comment']=$task_comment_temp; 

                    $task_subcenter_temp = addslashes(Request::get('fault_'.$i.'_task_'.$task_hidden_id.'_subcenter_names'));
                    $task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_subcenter_names']=$task_subcenter_temp;                     

                    $task_responsible_concern_temp = addslashes(Request::get('fault_'.$i.'_task_'.$task_hidden_id.'_responsible_concern'));
                    $task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_responsible_concern']=$task_responsible_concern_temp;       
                }      
            }
            
        }
        $ticket_json = json_encode($fault_arr);

        $properlyDone = $this->edit_tt_api($ticket_arr,$fault_arr,$fault_count,$ticket_id,$task_init_arr,$task_arr,$ticket_id,$incident_id);  
        //echo $ticket_status.'<br/>';
        //echo $ticket_previous_status;

        if($properlyDone !=true){
            $msg = "Please close all tasks before closing fault";
            $url =  "/phoenix/public/EditTT?ticket_id=$ticket_id";
            return view('errors.msg_phoenix',compact('msg','url'));
        }
        else{
            if($ticket_status == 'Closed'){
                $ticket_fault_check_query = "SELECT * FROM phoenix_tt_db.fault_table WHERE fault_status='open' and ticket_id=$ticket_id";
                $ticket_fault_check_results = \DB::select(\DB::raw($ticket_fault_check_query));
                if(count($ticket_fault_check_results) > 0){
                    $update_ticket_table_query = "UPDATE phoenix_tt_db.ticket_table SET ticket_status='Ongoing' where ticket_id='$ticket_id'";
                    \DB::update(\DB::raw($update_ticket_table_query));
                    $msg = "Please close all faults before closing ticket";
                    $url =  "/phoenix/public/EditTT?ticket_id=$ticket_id";
                    //return $msg;
                    return view('errors.msg_phoenix',compact('msg','url'));
                }
                else{

                    // Ensure Only NOC wiil be able to close the ticket

                    if($_SESSION['department'] == 'NOC'){
                        $update_ticket_table_query = "UPDATE phoenix_tt_db.ticket_table SET ticket_status='Closed',ticket_closing_time=NOW(),ticket_closer_id='".$_SESSION['user_id']."' where ticket_id='$ticket_id'";
                        \DB::update(\DB::raw($update_ticket_table_query));
                        return redirect("EditTT?ticket_id=$ticket_id");

                    }
                    else{
                        $msg = "Sorry !!! ..Only NOC users can close the ticket";
                        $url =  "/phoenix/public/EditTT?ticket_id=$ticket_id";
                        return view('errors.msg_phoenix',compact('msg','url'));

                    }
                }
            }
            else{
                return redirect("EditTT?ticket_id=$ticket_id");
            }
            
        } 



        
    }


    public function edit_tt_api($ticket_arr,$fault_arr,$fault_count,$ticket_id,$task_init_arr,$task_arr,$ticket_id,$incident_id){


        date_default_timezone_set('Asia/Dhaka');

        /***********************TICKET TABLE INSERT QUERY*******************************************/

        $user_id = $_SESSION['user_name'];
        $user_dept = $_SESSION['department'];
        $user_dept_id = $_SESSION['dept_id'];
        $assigned_dept_str = $ticket_arr['assigned_dept'];
        $assigned_dept_str_arr = explode(',', $assigned_dept_str);
        $ticket_op_flag = 0;
        $outage_current_dept_arr = array();

        /*******************************************************************************************/

        if($ticket_arr['ticket_initiator_dept']!=$user_dept_id){

            $ticket_op_flag = 1;
        }

        /********************************************************************************************/

        /*****************************SCL COMMENT INSERT*********************************************/

        if($ticket_arr['ticket_comment_scl']!=""){

            $scl_comment_table_query = "INSERT INTO phoenix_tt_db.scl_comment_table (user_id,type,comment,dept_id,ticket_id) VALUES ('$user_id','','$ticket_arr[ticket_comment_scl]','$user_dept','$ticket_id')";
            \DB::insert(\DB::raw($scl_comment_table_query));
        }

        /********************************************************************************************/

        /*****************************NOC COMMENT INSERT*********************************************/
        if($ticket_arr['ticket_comment_noc']!=""){
            $noc_comment_table_query = "INSERT INTO phoenix_tt_db.noc_comment_table (user_id,type,comment,dept_id,ticket_id) VALUES ('$user_id','','$ticket_arr[ticket_comment_noc]','$user_dept','$ticket_id')";
            \DB::insert(\DB::raw($noc_comment_table_query));
        }
        
        /********************************************************************************************/

        /*****************************CLIENT COMMENT INSERT*********************************************/

        if($ticket_arr['ticket_comment_client']!=""){
            $client_comment_table_query = "INSERT INTO phoenix_tt_db.client_comment_table (user_id,type,comment,dept_id,ticket_id) VALUES ('$user_id','','$ticket_arr[ticket_comment_client]','$user_dept','$ticket_id')";
            \DB::insert(\DB::raw($client_comment_table_query));
        }
        /********************************************************************************************/

        /*************************FAULT TABLE INSERT**************************************************/
        
        for($i=1;$i<$fault_count+1;$i++){






            $fault_id = $fault_arr['fault_id'.'_'.$i];
            $element_type = $fault_arr['element_type'.'_'.$i];
            $element_id = $fault_arr['element_id'.'_'.$i];
            $client_id = $fault_arr['client_id'.'_'.$i];
            $issue_type = $fault_arr['issue_type'.'_'.$i];
            $client_priority = $fault_arr['client_priority'.'_'.$i];
            $provider = $fault_arr['provider_name'.'_'.$i];
            $link_type = $fault_arr['link_type'.'_'.$i];

            $event_time = $fault_arr['event_time'.'_'.$i];
            $event_time_obj = new DateTime($event_time);
            $event_time = $event_time_obj->format('Y-m-d H:i:s');

            $problem_category = $fault_arr['problem_category'.'_'.$i];
            $problem_source = $fault_arr['problem_source'.'_'.$i];
            $reason = $fault_arr['reason'.'_'.$i];

            $escalation_time = $fault_arr['escalation_time'.'_'.$i];
            $escalation_time_obj = new DateTime($escalation_time);
            $escalation_time = $escalation_time_obj->format('Y-m-d H:i:s');

            $clear_time = $fault_arr['clear_time'.'_'.$i];
            if($clear_time!=""){
                $clear_time_obj = new DateTime($clear_time);
                $clear_time_obj = $clear_time_obj->format('Y-m-d H:i:s');
                $clear_time = "'".$clear_time_obj."'";
            }
            else{
                $clear_time = 'null';
            }

            $client_side_impact = $fault_arr['client_side_impact'.'_'.$i];
            $provider_side_impact = $fault_arr['provider_side_impact'.'_'.$i];

            $remarks = $fault_arr['remarks'.'_'.$i];

            $previous_remarks=$fault_arr['previous_remarks'.'_'.$i]; 
                date_default_timezone_set('Asia/Dhaka');
                $time = date('Y-m-d H:i:s');


                if($remarks!=""){

                    $remarks = $previous_remarks."\r\n".$_SESSION['user_name']."(".$_SESSION['department'].")[".$time."] : ".$remarks;

                }

                else{

                    $remarks = $previous_remarks;
                }

            $responsible_concern = $fault_arr['responsible_concern'.'_'.$i];
            $responsible_field_team = $fault_arr['responsible_field_team'.'_'.$i];
            $fault_status = $fault_arr['fault_status'.'_'.$i];

            $insert_outage_log_query = '';
            $log_arr = array();
            if($fault_status=="open"){    
                $check_prev_fault_status = "SELECT * FROM phoenix_tt_db.fault_table WHERE fault_id=".$fault_id;
                $check_fault_lists = \DB::select(\DB::raw($check_prev_fault_status));
                if($check_fault_lists[0]->fault_status == 'closed'){
                    array_push($log_arr, $fault_id);
                    
                }
            }


            //provider_problem
            $update_fault_table_query = "UPDATE phoenix_tt_db.fault_table SET ticket_id='$ticket_id',element_type='$element_type',element_id='$element_id',client_id='$client_id',issue_type='$issue_type',client_priority='$client_priority',link_type='$link_type',problem_category='$problem_category',problem_source='$problem_source',reason='$reason',event_time='$event_time',escalation_time='$escalation_time',clear_time=$clear_time,client_side_impact='$client_side_impact',provider=$provider,provider_side_impact='$provider_side_impact',remarks='$remarks',responsible_concern='$responsible_concern',responsible_field_team='$responsible_field_team',fault_status='$fault_status' where fault_id='$fault_id'";
            $update_outage_table_query = "UPDATE phoenix_tt_db.outage_table SET ticket_id='$ticket_id',element_type='$element_type',element_id='$element_id',client_id='$client_id',issue_type='$issue_type',client_priority='$client_priority',link_type='$link_type',problem_category='$problem_category',problem_source='$problem_source',reason='$reason',event_time='$event_time',escalation_time='$escalation_time',clear_time=$clear_time,client_side_impact='$client_side_impact',provider=$provider,provider_side_impact='$provider_side_impact',remarks='$remarks',responsible_concern='$responsible_concern',responsible_field_team='$responsible_field_team',fault_status='$fault_status' where fault_id='$fault_id'";

            $update_outage_table_log_query = "UPDATE phoenix_tt_db.outage_table_log SET ticket_id='$ticket_id',element_type='$element_type',element_id='$element_id',client_id='$client_id',issue_type='$issue_type',client_priority='$client_priority',link_type='$link_type',problem_category='$problem_category',problem_source='$problem_source',reason='$reason',event_time='$event_time',escalation_time='$escalation_time',clear_time=$clear_time,client_side_impact='$client_side_impact',provider=$provider,provider_side_impact='$provider_side_impact',remarks='$remarks',responsible_concern='$responsible_concern',responsible_field_team='$responsible_field_team',fault_status='$fault_status' where fault_id='$fault_id'";

            \DB::update(\DB::raw($update_fault_table_query));
            \DB::update(\DB::raw($update_outage_table_query));
            \DB::update(\DB::raw($update_outage_table_log_query));
            
            $selectFaultQueryByTicket = "SELECT * FROM phoenix_tt_db.outage_table WHERE ticket_id = '$ticket_id'";
            $selectFaultsForComments = \DB::select(\DB::raw($selectFaultQueryByTicket));

            foreach($selectFaultsForComments as $selectFaultsForComment){
                $selectTop2TicketCommentsQuery = "SELECT * FROM phoenix_tt_db.scl_comment_table WHERE ticket_id=$ticket_id ORDER BY ticket_id DESC";
                $selectTop2TicketComments = \DB::select(\DB::raw($selectTop2TicketCommentsQuery));
                //echo $selectTop2TicketCommentsQuery;

                $top2TicketComments = '';

                foreach($selectTop2TicketComments as $selectTop2TicketComment){
                    $top2TicketComments .=  addslashes("<b>".$selectTop2TicketComment->user_id."</b> [".$selectTop2TicketComment->dept_id.']['.$selectTop2TicketComment->comment_row_created_date.'] : <i><span style="color : #7cff48;font-size:13px">'.$selectTop2TicketComment->comment.'</span></i><br>');
                }

                $selectTop2TaskCommentsQuery = "SELECT * FROM phoenix_tt_db.task_update_log WHERE fault_id=$selectFaultsForComment->fault_id ORDER BY task_id DESC";
                $selectTop2TaskComments = \DB::select(\DB::raw($selectTop2TaskCommentsQuery));
                //echo $selectTop2TaskCommentsQuery;

                $top2TaskComments = '';

                foreach($selectTop2TaskComments as $selectTop2TaskComment){
                    $top2TaskComments .=  "<b>".$selectTop2TaskComment->task_comment_user_id."</b>"."[".$selectTop2TaskComment->dept_name."]"."[".$selectTop2TaskComment->task_status."]".'['.$selectTop2TaskComment->task_comment_time.'] : <i><span style="color : #7cff48;font-size:13px">'.$selectTop2TaskComment->task_comment.'</span></i><br>';
                }

                $top2TaskComments = addslashes($top2TaskComments);
                $update_comments_in_outage_query = "UPDATE phoenix_tt_db.outage_table SET scl_comment='$top2TicketComments',task_comment='$top2TaskComments' WHERE fault_id=$selectFaultsForComment->fault_id";
                \DB::update(\DB::raw($update_comments_in_outage_query));

                $update_comments_in_outage_log_query = "UPDATE phoenix_tt_db.outage_table_log SET scl_comment='$top2TicketComments',task_comment='$top2TaskComments' WHERE fault_id=$selectFaultsForComment->fault_id";
                \DB::update(\DB::raw($update_comments_in_outage_log_query));
                //echo $update_comments_in_outage_query;


            }



            for($j=1;$j<$fault_arr['task_init_count_'.$i]+1;$j++){


                $task_id_temp=$task_init_arr['fault_'.$i.'_task_'.$j.'_id'];
                $task_name_temp=$task_init_arr['fault_'.$i.'_task_'.$j.'_name'];
                
                // Ahnaf's bug fix due to multiple slashes in task description
                $task_description_temp=addslashes($task_init_arr['fault_'.$i.'_task_'.$j.'_description']);
                $task_description_temp = str_replace("\\", "",$task_description_temp);
                $task_description_temp = addslashes($task_description_temp);

                $task_assigned_dept_temp=$task_init_arr['fault_'.$i.'_task_'.$j.'_assigned_dept'];                   
                $task_start_time_temp=$task_init_arr['fault_'.$i.'_task_'.$j.'_start_time'];  
                $task_start_time_temp_obj = new DateTime($task_start_time_temp);
                $task_start_time_temp = $task_start_time_temp_obj->format('Y-m-d H:i:s');                  
                $task_end_time_temp=$task_init_arr['fault_'.$i.'_task_'.$j.'_end_time'];

                
                // exit();
                if($task_end_time_temp==""){
                    $task_end_time_temp="";

                }  
                else{
                    $task_end_time_temp_obj = new DateTime($task_end_time_temp);
                    $task_end_time_temp = $task_end_time_temp_obj->format('Y-m-d H:i:s');
                    // echo $task_end_time_temp;
                    // exit();
                }                  
                $task_comment_temp=addslashes($task_init_arr['fault_'.$i.'_task_'.$j.'_comment']);
                $task_previous_comment_temp=$task_init_arr['fault_'.$i.'_task_'.$j.'_previous_comment']; 
                $task_status_temp=$task_init_arr['fault_'.$i.'_task_'.$j.'_status'];    
                $task_on_behalf_temp =$task_init_arr['fault_'.$i.'_task_'.$j.'_on_behalf_checker'];   
                //echo 'fault_'.$i.'_task_'.$j.'_status'; 
                
                $time = date('Y-m-d H:i:s');

                if($task_on_behalf_temp==1){

                    $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_on_behalf_flag=1 where task_id='$task_id_temp'";     

                }
                $task_comment_temp_for_update_log = $task_comment_temp;

                if($task_comment_temp!=""){

                    $task_updated_log_comment = $_SESSION['user_name']."(".$_SESSION['department'].")[".$time."] (".$task_status_temp. "): ".$task_comment_temp;
                    $insert_task_comment_query = "INSERT INTO phoenix_tt_db.task_update_log (ticket_id,fault_id,task_id,task_comment_user_id,task_status, task_comment,dept_name) VALUES ($ticket_id,$fault_id,$task_id_temp,'".$_SESSION['user_id']."','$task_status_temp','$task_comment_temp','".$_SESSION['department']."')";
                    \DB::insert(\DB::raw($insert_task_comment_query));


                    $task_comment_temp = $task_previous_comment_temp."\r\n".$_SESSION['user_name']."(".$_SESSION['department'].")[".$time."] (".$task_status_temp. "): ".$task_comment_temp;

                }

                else{ 

                    $task_comment_temp = $task_previous_comment_temp;
                }   
                $task_resolver_temp=$task_init_arr['fault_'.$i.'_task_'.$j.'_resolver'];


                //                     echo $task_end_time_temp;
                // echo $task_status_temp;
                //     exit();


                if($task_end_time_temp!="" && ($task_status_temp=="Closed" )){
                    // echo "hello";
                    $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_name='$task_name_temp',task_description='$task_description_temp',task_assigned_dept='$task_assigned_dept_temp',task_start_time='$task_start_time_temp',task_end_time='$task_end_time_temp',task_end_time_db='$time',task_resolver='$task_resolver_temp',task_status='$task_status_temp',task_closer_id='$user_id' where task_id='$task_id_temp'";

                    // echo $update_task_table_query;
                    // $update_notification_table_query = "UPDATE phoenix_tt_db.notification_table SET notification_flag=1 where task_id='$task_id_temp'";      
                    // \DB::update(\DB::raw($update_notification_table_query));

                    // $insert_task_comment_query = "INSERT INTO phoenix_tt_db.task_update_log (ticket_id,fault_id,task_id,task_comment_user_id,task_status, task_comment) VALUES ($ticket_id,$fault_id,$task_id_temp,'".$_SESSION['user_id']."','$task_status_temp','$task_comment_temp_for_update_log')";
                    // \DB::insert(\DB::raw($insert_task_comment_query));


                }
                else if($task_status_temp==""){
                    $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_name='$task_name_temp',task_description='$task_description_temp',task_assigned_dept='$task_assigned_dept_temp',task_start_time='$task_start_time_temp',task_resolver='$task_resolver_temp' where task_id='$task_id_temp'";

                    // $insert_task_comment_query = "INSERT INTO phoenix_tt_db.task_update_log (ticket_id,fault_id,task_id,task_comment_user_id,task_status, task_comment) VALUES ($ticket_id,$fault_id,$task_id_temp,'".$_SESSION['user_id']."','$task_status_temp','$task_comment_temp_for_update_log')";
                    // \DB::insert(\DB::raw($insert_task_comment_query));

                } 
                else{
                    $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_name='$task_name_temp',task_description='$task_description_temp',task_assigned_dept='$task_assigned_dept_temp',task_start_time='$task_start_time_temp',task_resolver='$task_resolver_temp',task_status='$task_status_temp' where task_id='$task_id_temp'";

                    // $insert_task_comment_query = "INSERT INTO phoenix_tt_db.task_update_log (ticket_id,fault_id,task_id,task_comment_user_id,task_status, task_comment) VALUES ($ticket_id,$fault_id,$task_id_temp,'".$_SESSION['user_id']."','$task_status_temp','$task_comment_temp_for_update_log')";
                    // \DB::insert(\DB::raw($insert_task_comment_query));
                }                
                \DB::update(\DB::raw($update_task_table_query));

                // if($task_status_temp=="Client Confirmation Pending"){

                //     // $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_status='Closed',task_end_time='$task_end_time_temp',task_end_time_db='$time',task_closer_id='$user_id' where task_id='$task_id_temp'";
                //     // \DB::update(\DB::raw($update_task_table_query));

                //     $task_name = "Returned Task";
                //     $task_description = "Returned To Initiator (".$task_id_temp.")";
                //     date_default_timezone_set('Asia/Dhaka');
                //     $task_start_time = date('Y-m-d H:i:s');

                //     $join_table_query = "SELECT * from phoenix_tt_db.task_table,phoenix_tt_db.ticket_table where phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_id='$task_id_temp'";
                //     $joined_lists = \DB::select(\DB::raw($join_table_query));

                //     foreach($joined_lists as $joined_list){

                //         $assigned_dept = $joined_list->ticket_initiator_dept;
                //         $fault_id = $joined_list->fault_id;
                //         $ticket_id = $joined_list->ticket_id;

                //     }

                //     $task_table_query = "INSERT INTO phoenix_tt_db.task_table (task_name,task_description,task_assigned_dept,task_start_time,task_resolver,ticket_id,fault_id,task_status,task_resolution_ids,task_initiator_dept) VALUES ('$task_name','$task_description','$assigned_dept','$task_start_time','','$ticket_id','$fault_id','escalated','','$user_dept_id')";
                //     \DB::insert(\DB::raw($task_table_query)); 

                //     // $insert_task_comment_query = "INSERT INTO phoenix_tt_db.task_update_log (ticket_id,fault_id,task_id,task_comment_user_id,task_status, task_comment) VALUES ($ticket_id,$fault_id,$task_id_temp,'".$_SESSION['user_id']."','$task_status_temp','$task_comment_temp_for_update_log')";
                //     // \DB::insert(\DB::raw($insert_task_comment_query));                  

                // }
                if($task_status_temp=="Client Confirmation Pending"){
                    $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_status='Closed',task_end_time='$task_end_time_temp',task_end_time_db='$time',task_closer_id='$user_id' where task_id='$task_id_temp'";
                    \DB::update(\DB::raw($update_task_table_query));

                    $task_name = "Returned Task";
                    $task_description = "Returned To Initiator (".$task_id_temp.")";
                    date_default_timezone_set('Asia/Dhaka');
                    $task_start_time = date('Y-m-d H:i:s');

                    $join_table_query = "SELECT * from phoenix_tt_db.task_table,phoenix_tt_db.ticket_table where phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_id='$task_id_temp'";
                    $joined_lists = \DB::select(\DB::raw($join_table_query));

                    foreach($joined_lists as $joined_list){

                        $assigned_dept = $joined_list->ticket_initiator_dept;
                        $fault_id = $joined_list->fault_id;
                        $ticket_id = $joined_list->ticket_id;

                    }

                    $task_table_query = "INSERT INTO phoenix_tt_db.task_table (task_name,task_description,task_assigned_dept,task_start_time,task_resolver,ticket_id,fault_id,task_status,task_resolution_ids,task_initiator_dept) VALUES ('$task_name','$task_description','43','$task_start_time','','$ticket_id','$fault_id','escalated','','$user_dept_id')";
                    \DB::insert(\DB::raw($task_table_query)); 

                    if(!(in_array("43",$assigned_dept_str_arr))){
                        array_push($assigned_dept_str_arr, "43");
                        $assigned_dept_str = implode(",",$assigned_dept_str_arr);
                    }
                    

                    // $insert_task_comment_query = "INSERT INTO phoenix_tt_db.task_update_log (ticket_id,fault_id,task_id,task_comment_user_id,task_status, task_comment) VALUES ($ticket_id,$fault_id,$task_id_temp,'".$_SESSION['user_id']."','$task_status_temp','$task_comment_temp_for_update_log')";
                    // \DB::insert(\DB::raw($insert_task_comment_query));                  

                }


                if($task_status_temp=="RTI"){
                    $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_status='Closed',task_end_time='$task_end_time_temp',task_end_time_db='$time',task_closer_id='$user_id' where task_id='$task_id_temp'";
                    \DB::update(\DB::raw($update_task_table_query));

                    $task_name = "Returned Task";
                    $task_description = "Returned To Initiator (".$task_id_temp.")";
                    date_default_timezone_set('Asia/Dhaka');
                    $task_start_time = date('Y-m-d H:i:s');

                    $join_table_query = "SELECT * from phoenix_tt_db.task_table,phoenix_tt_db.ticket_table where phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_id='$task_id_temp'";
                    $joined_lists = \DB::select(\DB::raw($join_table_query));

                    foreach($joined_lists as $joined_list){

                        $assigned_dept = $joined_list->ticket_initiator_dept;
                        $fault_id = $joined_list->fault_id;
                        $ticket_id = $joined_list->ticket_id;
                        $task_ass_dept = $joined_list->task_assigned_dept;
                        $task_init_dept = $joined_list->task_initiator_dept;
                    }

                    /***********************************IN CASE OF EMERGENCY (ICE): RTI IS DEAD COMMENT OUT THIS BLOCK OF CODE *********************************/
                    if($task_ass_dept == '10'){
                        // $task_table_query = "INSERT INTO phoenix_tt_db.task_table (task_name,task_description,task_assigned_dept,task_start_time,task_resolver,ticket_id,fault_id,task_status,task_resolution_ids,task_initiator_dept) VALUES ('$task_name','$task_description','$task_init_dept','$task_start_time','','$ticket_id','$fault_id','escalated','','$task_ass_dept')";
                        // \DB::insert(\DB::raw($task_table_query)); 

                        $new_task_id = DB::table('phoenix_tt_db.task_table')->insertGetId(
                            [
                            'task_name' => $task_name, 
                            'task_description' => $task_description,
                            'task_assigned_dept' => $task_init_dept,
                            'task_start_time' => $task_start_time,
                            'task_resolver' => '',
                            'ticket_id' => $ticket_id,
                            'fault_id' => $fault_id,
                            'task_status' => 'escalated',
                            'task_resolution_ids' => '',
                            'task_initiator_dept' => $task_ass_dept
                            ]
                        );

                        if(!(in_array($task_init_dept,$assigned_dept_str_arr))){
                            array_push($assigned_dept_str_arr, $task_init_dept);
                            $assigned_dept_str = implode(",",$assigned_dept_str_arr);
                        }
                        array_push($outage_current_dept_arr, $task_init_dept);

                        ///////////////////// Task Telegram Notification ///////////////////////
                        try {
                            $telegram_notif_controller = New TelegramNotifController();
                            $send_msg = $telegram_notif_controller->send_telegram_notification("NOC",$new_task_id);
                        }
                        catch(Exception $e) {
                            
                        } 
                        ////////////////////////////////////////////////////////////////////////
                    }
                    else{
                        // $task_table_query = "INSERT INTO phoenix_tt_db.task_table (task_name,task_description,task_assigned_dept,task_start_time,task_resolver,ticket_id,fault_id,task_status,task_resolution_ids,task_initiator_dept) VALUES ('$task_name','$task_description','10','$task_start_time','','$ticket_id','$fault_id','escalated','','$task_ass_dept')";
                        // \DB::insert(\DB::raw($task_table_query)); 

                        $new_task_id = DB::table('phoenix_tt_db.task_table')->insertGetId(
                            [
                            'task_name' => $task_name, 
                            'task_description' => $task_description,
                            'task_assigned_dept' => '10',
                            'task_start_time' => $task_start_time,
                            'task_resolver' => '',
                            'ticket_id' => $ticket_id,
                            'fault_id' => $fault_id,
                            'task_status' => 'escalated',
                            'task_resolution_ids' => '',
                            'task_initiator_dept' => $task_ass_dept
                            ]
                        );


                        if(!(in_array('10',$assigned_dept_str_arr))){
                            array_push($assigned_dept_str_arr, '10');
                            $assigned_dept_str = implode(",",$assigned_dept_str_arr);
                        }
                        array_push($outage_current_dept_arr, '10');

                        ///////////////////// Task Telegram Notification ///////////////////////
                        try {
                            $telegram_notif_controller = New TelegramNotifController();
                            $send_msg = $telegram_notif_controller->send_telegram_notification("NOC",$new_task_id);
                        }
                        catch(Exception $e) {
                            
                        } 
                        ////////////////////////////////////////////////////////////////////////
                    }
                    /***********************************************************************************************************************************/

                    /*************IN CASE OF EMERGENCY (ICE) : RTI CAME BACK TO LIFE UNCOMMENT THIS CODE************************************/

                    // foreach($joined_lists as $joined_list){

                    //     $assigned_dept = $joined_list->ticket_initiator_dept;
                    //     $fault_id = $joined_list->fault_id;
                    //     $ticket_id = $joined_list->ticket_id;

                    // }

                    // $task_table_query = "INSERT INTO phoenix_tt_db.task_table (task_name,task_description,task_assigned_dept,task_start_time,task_resolver,ticket_id,fault_id,task_status,task_resolution_ids,task_initiator_dept) VALUES ('$task_name','$task_description','$assigned_dept','$task_start_time','','$ticket_id','$fault_id','escalated','','$user_dept_id')";
                    // \DB::insert(\DB::raw($task_table_query)); 

                    // if(!(in_array("10",$assigned_dept_str_arr))){
                    //     array_push($assigned_dept_str_arr, "10");
                    //     $assigned_dept_str = implode(",",$assigned_dept_str_arr);
                    // }
                    // array_push($outage_current_dept_arr, '10');

                    /*************************************************************************************/
                    // $insert_task_comment_query = "INSERT INTO phoenix_tt_db.task_update_log (ticket_id,fault_id,task_id,task_comment_user_id,task_status, task_comment) VALUES ($ticket_id,$fault_id,$task_id_temp,'".$_SESSION['user_id']."','$task_status_temp','$task_comment_temp_for_update_log')";
                    // \DB::insert(\DB::raw($insert_task_comment_query));                  

                }

                if($task_status_temp=="RFO Pending"){
                    $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_status='Closed',task_end_time='$task_end_time_temp',task_end_time_db='$time',task_closer_id='$user_id' where task_id='$task_id_temp'";
                    \DB::update(\DB::raw($update_task_table_query));

                    $task_name = "Returned Task";
                    $task_description = "Returned To Initiator (".$task_id_temp.")";
                    date_default_timezone_set('Asia/Dhaka');
                    $task_start_time = date('Y-m-d H:i:s');

                    $join_table_query = "SELECT * from phoenix_tt_db.task_table,phoenix_tt_db.ticket_table where phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_id='$task_id_temp'";
                    $joined_lists = \DB::select(\DB::raw($join_table_query));

                    foreach($joined_lists as $joined_list){

                        $assigned_dept = $joined_list->ticket_initiator_dept;
                        $fault_id = $joined_list->fault_id;
                        $ticket_id = $joined_list->ticket_id;

                    }



                    $task_table_query = "INSERT INTO phoenix_tt_db.task_table (task_name,task_description,task_assigned_dept,task_start_time,task_resolver,ticket_id,fault_id,task_status,task_resolution_ids,task_initiator_dept) VALUES ('$task_name','$task_description','45','$task_start_time','','$ticket_id','$fault_id','escalated','','$user_dept_id')";
                    \DB::insert(\DB::raw($task_table_query));

                    if(!(in_array("45",$assigned_dept_str_arr))){
                        array_push($assigned_dept_str_arr, "45");
                        $assigned_dept_str = implode(",",$assigned_dept_str_arr);
                    }
                    array_push($outage_current_dept_arr, '45');

                    // $insert_task_comment_query = "INSERT INTO phoenix_tt_db.task_update_log (ticket_id,fault_id,task_id,task_comment_user_id,task_status, task_comment) VALUES ($ticket_id,$fault_id,$task_id_temp,'".$_SESSION['user_id']."','$task_status_temp','$task_comment_temp_for_update_log')";
                    // \DB::insert(\DB::raw($insert_task_comment_query));                  

                }

                if($task_status_temp=="NMI"){
                    $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_status='Closed',task_end_time='$task_end_time_temp',task_end_time_db='$time',task_closer_id='$user_id' where task_id='$task_id_temp'";
                    \DB::update(\DB::raw($update_task_table_query));

                    $task_name = "Returned Task";
                    $task_description = "Returned Task (".$task_id_temp.") NMI";
                    date_default_timezone_set('Asia/Dhaka');
                    $task_start_time = date('Y-m-d H:i:s');


                    $select_last_dept_query = "SELECT * FROM phoenix_tt_db.task_table where task_id='$task_id_temp'";
                    $last_dept_query_lists = \DB::select(\DB::raw($select_last_dept_query));

                    // print_r($last_dept_query_lists);
                    // exit();  
                    foreach($last_dept_query_lists as $last_dept_query_list){

                        $last_dept = $last_dept_query_list->task_initiator_dept;
                        $fault_id = $last_dept_query_list->fault_id;
                        $ticket_id = $last_dept_query_list->ticket_id;
                        $subcenter = $last_dept_query_list->subcenter;
                        $task_responsible = $last_dept_query_list->task_responsible;
                    }

                    // $task_table_query = "INSERT INTO phoenix_tt_db.task_table (task_name,task_description,task_assigned_dept,task_start_time,task_resolver,ticket_id,fault_id,task_status,task_resolution_ids,subcenter,task_responsible,task_initiator_dept) VALUES ('$task_name','$task_description','$last_dept','$task_start_time','','$ticket_id','$fault_id','escalated','','$subcenter','$task_responsible','$user_dept_id')";
                    $task_table_query = "INSERT INTO phoenix_tt_db.task_table (task_name,task_description,task_assigned_dept,task_start_time,task_resolver,ticket_id,fault_id,task_status,task_resolution_ids,task_initiator_dept) VALUES ('$task_name','$task_description','$last_dept','$task_start_time','','$ticket_id','$fault_id','escalated','','$user_dept_id')";
                    \DB::insert(\DB::raw($task_table_query)); 

                    if(!(in_array("43",$assigned_dept_str_arr))){
                        array_push($assigned_dept_str_arr, "43");
                        $assigned_dept_str = implode(",",$assigned_dept_str_arr);
                    }
                    array_push($outage_current_dept_arr, '43');


                    // $insert_task_comment_query = "INSERT INTO phoenix_tt_db.task_update_log (ticket_id,fault_id,task_id,task_comment_user_id,task_status, task_comment) VALUES ($ticket_id,$fault_id,$task_id_temp,'".$_SESSION['user_id']."','$task_status_temp','$task_comment_temp_for_update_log')";
                    // \DB::insert(\DB::raw($insert_task_comment_query));   

                }

                if($task_status_temp=="FWD"){

                    $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_status='Closed',task_end_time='$task_end_time_temp',task_end_time_db='$time',task_closer_id='$user_id' where task_id='$task_id_temp'";
                    \DB::update(\DB::raw($update_task_table_query));

                    $task_name = "Forwarded Task";
                    $task_description = "Forwarded Task (".$task_id_temp.")";
                    date_default_timezone_set('Asia/Dhaka');
                    $task_start_time = date('Y-m-d H:i:s');

                    $select_task_table_query = "SELECT * FROM phoenix_tt_db.task_table where task_id='$task_id_temp'";
                    $task_lists = \DB::select($select_task_table_query);




                    //  $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_status='Closed',task_closer_id='$user_id' where task_id='$task_id_temp'";
                    // \DB::update(\DB::raw($update_task_table_query));

                    // $task_name = "Forwarded Task";
                    // $task_description = "Forwarded Task (".$task_id_temp.")";
                    // date_default_timezone_set('Asia/Dhaka');
                    // $task_start_time = date('Y-m-d H:i:s');

                    // $join_table_query = "SELECT * from phoenix_tt_db.task_table,phoenix_tt_db.ticket_table where phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.task_id='$task_id_temp'";
                    // $joined_lists = \DB::select(\DB::raw($join_table_query));

                    // foreach($joined_lists as $joined_list){

                    //     $assigned_dept = $joined_list->ticket_initiator_dept;
                    //     $fault_id = $joined_list->fault_id;
                    //     $ticket_id = $joined_list->ticket_id;

                    // }

                    // $task_table_query = "INSERT INTO phoenix_tt_db.task_table (task_name,task_description,task_assigned_dept,task_start_time,task_comment,task_resolver,ticket_id,fault_id,task_status,task_resolution_ids) VALUES ('$task_name','$task_description','$assigned_dept','$task_start_time','','','$ticket_id','$fault_id','escalated','')";
                    //                  \DB::insert(\DB::raw($task_table_query));



                }
                //echo $task_status_temp;
                if($task_status_temp=="escalated"){

                    array_push($outage_current_dept_arr, $task_assigned_dept_temp);
                }

            }  


            if($fault_arr['task_hidden_arr_'.$i]!=""){

                $task_hidden_arr = $fault_arr['task_hidden_arr_'.$i];


                foreach($task_hidden_arr as $task_hidden_id){

                    if($task_hidden_id!=""){

                        $task_name_temp=$task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_name'];

                            if($task_name_temp!=""){

                                    $task_description_temp=$task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_description'];
                                    $task_assigned_dept_temp=$task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_assigned_dept'];     
                                    $task_start_time_temp=$task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_start_time']; 
                                    $task_start_time_temp_obj = new DateTime($task_start_time_temp);
                                    $task_start_time_temp = $task_start_time_temp_obj->format('Y-m-d H:i:s');                                   
                                    $task_comment_temp=$task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_comment']; 
                                    $task_subcenter_temp=$task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_subcenter_names'];  
                                    $task_responsible_concern_temp=$task_arr['fault_'.$i.'_task_'.$task_hidden_id.'_responsible_concern'];      
                                    $task_resolver_temp="";
                                        
                                    array_push($outage_current_dept_arr, $task_assigned_dept_temp);

                                    preg_match("/\b".$task_assigned_dept_temp."\b/i", $assigned_dept_str, $match);

                                    if(count($match)<1){
                                        $assigned_dept_str.=",".$task_assigned_dept_temp;
                                    }

                                    $dept_temp = $_SESSION['dept_id'];

                                    // $task_table_query = "INSERT INTO phoenix_tt_db.task_table (task_name,task_description,task_assigned_dept,task_start_time,task_resolver,ticket_id,fault_id,task_status,task_resolution_ids,subcenter,task_responsible,task_initiator_dept) VALUES ('$task_name_temp','$task_description_temp','$task_assigned_dept_temp','$task_start_time_temp','$task_resolver_temp','$ticket_id','$fault_id','escalated','','$task_subcenter_temp','$task_responsible_concern_temp','$dept_temp')";
                                    //  \DB::insert(\DB::raw($task_table_query));

                                     $new_task_id = DB::table('phoenix_tt_db.task_table')->insertGetId(
                                        [
                                        'task_name' => $task_name_temp, 
                                        'task_description' => $task_description_temp,
                                        'task_assigned_dept' => $task_assigned_dept_temp,
                                        'task_start_time' => $task_start_time_temp,
                                        'task_resolver' => $task_resolver_temp,
                                        'ticket_id' => $ticket_id,
                                        'fault_id' => $fault_id,
                                        'task_status' => 'escalated',
                                        'task_resolution_ids' => '',
                                        'subcenter' => $task_subcenter_temp,
                                        'task_responsible' => $task_responsible_concern_temp,
                                        'task_initiator_dept' => $dept_temp
                                        ]
                                    );

                                    ///////////////////// Task Telegram Notification ///////////////////////
                                    try {
                                        $telegram_notif_controller = New TelegramNotifController();
                                        $send_msg = $telegram_notif_controller->send_telegram_notification($task_subcenter_temp,$new_task_id);
                                    }
                                    catch(Exception $e) {
                                        
                                    } 
                                    ////////////////////////////////////////////////////////////////////////


                                     $insert_task_comment_query = "INSERT INTO phoenix_tt_db.task_update_log (ticket_id,fault_id,task_id,task_comment_user_id,task_status, task_comment,dept_name) VALUES ($ticket_id,$fault_id,$task_id_temp,'".$_SESSION['user_id']."','$task_status_temp','$task_comment_temp','".$_SESSION['department']."')";
                                    \DB::insert(\DB::raw($insert_task_comment_query));
                                     // $task_select_query = "SELECT * from phoenix_tt_db.task_table order by task_id desc limit 1";
                                     // $task_select_lists = \DB::select(\DB::raw($task_select_query));
                                     // $task_id = 0;

                                     // foreach($task_select_lists as $task_select_list){

                                     //    $task_id = $task_select_list->task_id;
                                     // }

                                    $time = date('Y-m-d H:i:s');
                                    // $notification_string = "A task has been assigned to you. Ticket ID:".$ticket_id." (".$time.")";
                                    //     $insert_notification_table_query = "INSERT INTO phoenix_tt_db.notification_table(ticket_id,status,assigned_dept,notification_string,notification_flag) VALUES ('$ticket_id','$ticket_arr[ticket_status]','$task_assigned_dept_temp','$notification_string',0)";
                                    //     \DB::insert(\DB::raw($insert_notification_table_query));                                     
            

                            }           
                        }

                }


            }
            //$is_try_fault_closed = false;
            
            if($fault_status=="closed"){
                //$is_try_fault_closed = true;
                $client_duration = 0;
                $scl_duration = 0;
                $initiator_duration = 0;
                

                $delete_outage_table_query = "DELETE FROM phoenix_tt_db.outage_table where fault_id='$fault_id'";
                \DB::delete(\DB::raw($delete_outage_table_query));

                $fault_task_query = "SELECT phoenix_tt_db.task_table.*,phoenix_tt_db.ticket_table.ticket_id,phoenix_tt_db.ticket_table.ticket_initiator_dept,timestampdiff(second,task_start_time_db,task_end_time_db) as duration_temp FROM phoenix_tt_db.ticket_table,phoenix_tt_db.task_table where phoenix_tt_db.task_table.ticket_id=phoenix_tt_db.ticket_table.ticket_id AND phoenix_tt_db.task_table.fault_id='$fault_id'";
                $fault_task_lists = \DB::select(\DB::raw($fault_task_query));

                // print_r($fault_task_lists);
                // exit();
                $initiator_duration = 0;
                $client_duration = 0;
                $scl_duration = 0;
               
                foreach($fault_task_lists as $fault_task_list){

                     // echo($fault_task_list->duration_temp); echo "<br>";
                     // echo "<br>Duration INIT<br>";

                    if($fault_task_list->task_assigned_dept==$fault_task_list->ticket_initiator_dept){

                        // echo $fault_task_list->duration_temp;

                        // $str_time = $fault_task_list->duration_temp;
                        
                        // if($str_time!=0){
                        // // echo $str_time;
                        // sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                        // $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                        // echo "<br>";
                        $initiator_duration += $fault_task_list->duration_temp;

                        // echo $initiator_duration; echo "<br>";
                        // echo $initiator_duration;
                        // echo "<br>";
                        //}

                    }

                    else if($fault_task_list->task_assigned_dept==43){

                        $client_duration += $fault_task_list->duration_temp;
                        // $str_time = $fault_task_list->duration_temp;

                        // if($str_time!=0){
                        // // echo $str_time;
                        // sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                        // $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                        // // echo "<br>";
                        // $client_duration = $client_duration+$time_seconds;

                        // // echo $client_duration; echo "<br>";
                        // // echo $initiator_duration;
                        // // echo "<br>";
                        // }
                    }

                    else{

                        $scl_duration += $fault_task_list->duration_temp;
                        // $str_time = $fault_task_list->duration_temp;

                        // if($str_time!=0){
                        // // echo $str_time;
                        // sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                        // $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                        // // echo "<br>";
                        // $scl_duration = $scl_duration+$time_seconds;

                        // // echo $scl_duration; echo "<br>";
                        // // echo $initiator_duration;
                        // // echo "<br>";
                        // }
                    }

                }

                
                // echo $initiator_duration;
                // echo "<br>";
                // print_r($scl_duration);
                // print_r($client_duration);

                // exit();

                // $initiator_duration = gmdate("H:i:s", $initiator_duration);
                // $client_duration = gmdate("H:i:s", $client_duration);
                // $scl_duration = gmdate("H:i:s", $scl_duration);
                  // $seconds=0;

                  $initiator_duration = $initiator_duration / 3600;
                  // $minutes = floor(($initiator_duration / 60) % 60);
                  // $seconds = $initiator_duration % 60;
                  // $initiator_duration = "$hours:$minutes:$seconds";

                  $client_duration = $client_duration / 3600;
                  // $minutes = floor(($client_duration / 60) % 60);
                  // $seconds = $client_duration % 60;
                  // $client_duration = "$hours:$minutes:$seconds";    


                  $scl_duration = $scl_duration / 3600;
                  // $minutes = floor(($scl_duration / 60) % 60);
                  // $seconds = $scl_duration % 60;
                  // $scl_duration = "$hours:$minutes:$seconds";                                    

                // echo $initiator_duration."<br>";
                // echo $client_duration."<br>";
                // echo $scl_duration."<br>";

                // exit();


                $update_fault_query = "UPDATE phoenix_tt_db.fault_table SET initiator_duration='$initiator_duration',client_duration='$client_duration',scl_duration='$scl_duration',fault_closer_id='".$_SESSION['user_id']."' where fault_id=$fault_id";
                \DB::update(\DB::raw($update_fault_query));
                

            }

            if($clear_time!="" && $clear_time!== NULL){
                // echo $fault_id;
                // echo "sss";
                $update_fault_query = "UPDATE phoenix_tt_db.fault_table SET duration=timestampdiff(second,event_time,clear_time)/3600 where fault_id=$fault_id";

                //echo $update_fault_query;
                \DB::update(\DB::raw($update_fault_query));
            } 

        }

        

        $exploded_assigned_dept_arr = explode(',', trim($assigned_dept_str));
        $unique_assigned_dept_arr = array_unique($exploded_assigned_dept_arr);
        $assigned_dept_str = implode(',', $unique_assigned_dept_arr);
        
        
        $update_ticket_table_query = "UPDATE phoenix_tt_db.ticket_table SET ticket_title='$ticket_arr[ticket_title]',ticket_status='".$ticket_arr['ticket_status']."',assigned_dept='".trim($assigned_dept_str,',')."',ticket_file_path='$ticket_arr[file_path]',ticket_op_flag=$ticket_op_flag where ticket_id='$ticket_id'";
        \DB::update(\DB::raw($update_ticket_table_query));

        $outage_current_dept_arr = array_unique($outage_current_dept_arr);
        $outage_current_dept_str = implode(',', $outage_current_dept_arr); 
        if(count($outage_current_dept_arr)==1){
            $outage_current_dept_str = $outage_current_dept_arr[0]; 
        }

        /******************For REvert to previous******************************************/

       //  $update_outage_table_dept_query = "UPDATE phoenix_tt_db.outage_table SET assigned_dept='$outage_current_dept_str' WHERE ticket_id=$ticket_id";
       // //echo $update_outage_table_dept_query;
       //  // /print_r ($outage_current_dept_arr);
       //  //exit();
       //  \DB::update(\DB::raw($update_outage_table_dept_query));

       //  $update_outage_table_log_dept_query = "UPDATE phoenix_tt_db.outage_table_log SET assigned_dept='$outage_current_dept_str' WHERE ticket_id=$ticket_id";
       //  // /print_r ($outage_current_dept_arr);
       //  //exit();
       //  \DB::update(\DB::raw($update_outage_table_log_dept_query));
        //////////////////////////////////////////////////////////////////////////////////////////

        if($outage_current_dept_str !=''){
            $update_outage_table_dept_query = "UPDATE phoenix_tt_db.outage_table SET assigned_dept='$outage_current_dept_str' WHERE ticket_id=$ticket_id";
            // /print_r ($outage_current_dept_arr);
            //exit();
            \DB::update(\DB::raw($update_outage_table_dept_query));

            $update_outage_table_log_dept_query = "UPDATE phoenix_tt_db.outage_table_log SET assigned_dept='$outage_current_dept_str' WHERE ticket_id=$ticket_id";
            // /print_r ($outage_current_dept_arr);
            //exit();
            \DB::update(\DB::raw($update_outage_table_log_dept_query));

        }
        else{
            $select_assign_dept_query = "SELECT * FROM phoenix_tt_db.task_table WHERE ticket_id=$ticket_id and task_status='escalated'";
            $task_lists = \DB::select(\DB::raw($select_assign_dept_query));
            $assigned_dept = '';
            foreach($task_lists as $task_list){
                $assigned_dept .= $task_list->task_assigned_dept.',';
            }
            if($assigned_dept != ''){
                $assigned_dept = trim($assigned_dept,',');
                //$ticket_arr['assigned_dept']
                $assigned_dept_temp_arr = explode(',',$assigned_dept);
                $unique_arr = array_unique($assigned_dept_temp_arr);
                $assigned_dept_converted = implode(',',$unique_arr);
            }
            else{
                $assigned_dept_converted = '';
            }
            

            $update_ticket_table_dept_query = "UPDATE phoenix_tt_db.ticket_table SET assigned_dept='$assigned_dept_converted' WHERE ticket_id=$ticket_id";
            \DB::update(\DB::raw($update_ticket_table_dept_query));
            $update_outage_table_dept_query = "UPDATE phoenix_tt_db.outage_table SET assigned_dept='$assigned_dept_converted' WHERE ticket_id=$ticket_id";
            \DB::update(\DB::raw($update_outage_table_dept_query));

            $update_outage_table_log_dept_query = "UPDATE phoenix_tt_db.outage_table_log SET assigned_dept='$assigned_dept_converted' WHERE ticket_id=$ticket_id";
            \DB::update(\DB::raw($update_outage_table_log_dept_query));
        }
    
        /*************************NOTIFICATION TABLE INSERT ****************************************/

        $notification_string = "A ticket assigned to you has been updated";

        // $insert_notification_table_query = "INSERT INTO phoenix_tt_db.notification_table(ticket_id,status,assigned_dept,notification_string,notification_flag) VALUES ('$ticket_id','$ticket_arr[ticket_status]','$ticket_arr[assigned_dept]','$notification_string',0)";
        // \DB::insert(\DB::raw($insert_notification_table_query));



        /************************************************************************************************/
        /*************************************Close Incident************************************************/

        $incident_flag = 0;
        $ticket_checker_query = "SELECT * from phoenix_tt_db.ticket_table where incident_id='$incident_id' order by ticket_row_created_date";
        $ticket_checker_lists = \DB::select(\DB::raw($ticket_checker_query));
        $initial_incident_creation_time=$ticket_checker_lists[0]->ticket_row_created_date;

        foreach($ticket_checker_lists as $ticket_checker_list){



            if($ticket_checker_list->ticket_status!="Closed"){

                $incident_flag = 1;
            }

        }

        if($incident_flag==0){

            $update_incident_table_query = "UPDATE phoenix_tt_db.incident_table SET incident_status='Closed',initial_incident_creation_time='$initial_incident_creation_time' where incident_id='$incident_id'";
            \DB::update(\DB::raw($update_incident_table_query));  

            // $update_notification_table_query = "UPDATE phoenix_tt_db.notification_table SET notification_flag=1 WHERE ticket_id = '$ticket_id'";
            // \DB::update(\DB::raw($update_notification_table_query));           
        }
        /****************************************************************/ 

        /************************************Fault Status Validation*********************************/
        //if($is_try_fault_closed == true){
            //echo 'dhukse';

            $selectFaultIdQuery = "SELECT DISTINCT(fault_id) FROM phoenix_tt_db.task_table WHERE ticket_id=$ticket_id and task_status !='Closed'";
            $NonClosedFaultLists = \DB::select(\DB::raw($selectFaultIdQuery));

            if(count($NonClosedFaultLists) > 0){
                foreach($NonClosedFaultLists as $NonClosedFaultList){
                    //print_r($NonClosedFaultLists);

                    $selectFaultIdQueryCheck = "SELECT * FROM phoenix_tt_db.fault_table WHERE fault_id=".$NonClosedFaultList->fault_id;
                    $selectFaultIdQueryCheckLists = \DB::select(\DB::raw($selectFaultIdQueryCheck));
                    $count = 0;
                    $faults = '';
                    if($selectFaultIdQueryCheckLists[0]->fault_status =='closed'){
                        //echo $selectFaultIdQueryCheckLists[0]->fault_id;
                        $faults .= $selectFaultIdQueryCheckLists[0]->fault_id.',';
                        $time_val = 'null';
                        $updateFaultStatusQuery = "UPDATE phoenix_tt_db.fault_table SET fault_status='open', clear_time=$time_val WHERE fault_id=".$NonClosedFaultList->fault_id;
                        \DB::update(\DB::raw($updateFaultStatusQuery)); 
                        //echo $updateFaultStatusQuery;

                        $updateOutageFaultStatusQuery = "UPDATE phoenix_tt_db.outage_table SET fault_status='open', clear_time=$time_val  WHERE fault_id=".$NonClosedFaultList->fault_id;
                        \DB::update(\DB::raw($updateOutageFaultStatusQuery)); 

                        $updateOutageFaultStatusQuer_log = "UPDATE phoenix_tt_db.outage_table_log SET fault_status='open', clear_time=$time_val  WHERE fault_id=".$NonClosedFaultList->fault_id;
                        \DB::update(\DB::raw($updateOutageFaultStatusQuer_log)); 
                        $count++;

                        // $updateTicketStatusQuery = "UPDATE phoenix_tt_db.ticket_Table SET ticket_status='".$ticket_arr['ticket_status']."' WHERE ticket_id=".$ticket_id;
                        // \DB::update(\DB::raw($updateTicketStatusQuery)); 
                        //return false;

                    }
                }
                if($count>0){
                    // $msg = "Please close all tasks before closing fault. Fault IDs are ".$faults;
                    // return view('errors.msg_phoenix',compact('msg'));
                    return false;
                }
                else{
                    $log_controller = New LogController();
                    $log_controller->insert_all_table_log($ticket_id);
                    return true;
                }
                

            }
            else{
                $delete_outage_table_query = "DELETE FROM phoenix_tt_db.outage_table where ticket_id='$ticket_id'";
                \DB::delete(\DB::raw($delete_outage_table_query));


                if(count($log_arr)>0){
                    for($j=0;$j < count($log_arr);$j++){
                        $insert_outage_log_query = 'insert into phoenix_tt_db.outage_table (SELECT ot.* from phoenix_tt_db.outage_table_log ot where ot.fault_id='.$log_arr[$j].');';
                        \DB::insert(\DB::raw($insert_outage_log_query)); 
                        //DB::unprepared($insert_outage_log_query);
                    }

                }

                $log_controller = New LogController();
                $log_controller->insert_all_table_log($ticket_id);
                return true;
            }
        // }
        // else{
        //     $log_controller = New LogController();
        //     $log_controller->insert_all_table_log($ticket_id);
        //     return true;
        // }



        



        /*********************************************************************************************/

        /*************************************************************************************************/
        /*************************POPULATE LOG TABLE******************************************************/
        /*************************************************************************************************/

        /*************************TICKET LOG TABLE*******************************************************/

        

        /*************************************************************************************************/
    }

    public function zip_download(){

        $ticket_id = Request::get('ticket_id');
        $path = '../TicketFiles/'.$ticket_id.'/';

        $is_file = false;

        $filesss = File::allFiles($path);
        foreach ($filesss as $filess)
        {

            $is_file = true;
        }
        if($is_file == true )
        {

            $pathCheck1 = '../TicketFiles/'.$ticket_id.'/'.$ticket_id.'.zip';
           
            File::delete($pathCheck1);
            $pathCheck = '../TicketFiles/'.$ticket_id.'/'.$ticket_id.'.zip';
            $meeting_files = $pathCheck."/";
            if(!File::exists($pathCheck)) 
            {
                $path = '../TicketFiles/'.$ticket_id.'/*';
                $files = glob($path);
                $makepath = '../TicketFiles/'.$ticket_id.'/'.$ticket_id.'.zip';
                Zipper::make($makepath)->add($files);
            }
            $url_path = 'fileDownload?ticket_id='.$ticket_id;
            return redirect('fileDownload?ticket_id='.$ticket_id);
        }

    } 

    public function downloadFile(){
        $ticket_id = Request::get('ticket_id');
        $pathCheck = '../TicketFiles/'.$ticket_id.'/'.$ticket_id.'.zip';
        return response()->download($pathCheck);
    }

    public function task_resolution_view(){

        $task_id = Request::get('task_id');
        $ticket_id = Request::get('ticket_id');
        $fault_id = Request::get('fault_id');

        $task_resolution_reason_js_arr = array();
        $task_resolution_type_js_arr = array();
        $task_resolution_inventory_type_js_arr = array();
        $task_resolution_inventory_detail_js_arr = array();

        $previous_task_resolutions = "SELECT * FROM phoenix_tt_db.task_resolution_table WHERE task_id=$task_id";
        $previous_task_resolutions_lists = \DB::select(\DB::raw($previous_task_resolutions));

        $task_resolution_reason_table_query =  "SELECT * FROM phoenix_tt_db.task_resolution_reason_table";
        $task_resolution_reason_lists = \DB::select(\DB::raw($task_resolution_reason_table_query));  

        $task_resolution_type_table_query =  "SELECT * FROM phoenix_tt_db.task_resolution_type_table";
        $task_resolution_type_lists = \DB::select(\DB::raw($task_resolution_type_table_query));  

        $task_resolution_inventory_type_table_query =  "SELECT * FROM phoenix_tt_db.task_resolution_inventory_type_table";
        $task_resolution_inventory_type_lists = \DB::select(\DB::raw($task_resolution_inventory_type_table_query));  

        $task_resolution_inventory_detail_table_query =  "SELECT * FROM phoenix_tt_db.task_resolution_inventory_detail_table";
        $task_resolution_inventory_detail_lists = \DB::select(\DB::raw($task_resolution_inventory_detail_table_query));  


        foreach($task_resolution_reason_lists as $task_resolution_reason_list){
            array_push($task_resolution_reason_js_arr, $task_resolution_reason_list->task_resolution_reason);
        }
        foreach($task_resolution_type_lists as $task_resolution_type_list){
            array_push($task_resolution_type_js_arr, $task_resolution_type_list->task_resolution_type);
        }      
        foreach($task_resolution_inventory_type_lists as $task_resolution_inventory_type_list){
            array_push($task_resolution_inventory_type_js_arr, $task_resolution_inventory_type_list->task_resolution_inventory_type);
        }    
        foreach($task_resolution_inventory_detail_lists as $task_resolution_inventory_detail_list){
            array_push($task_resolution_inventory_detail_js_arr, $task_resolution_inventory_detail_list->task_resolution_inventory_detail);
        }                      


        return view('ticket.task_resolution',compact('task_resolution_reason_lists','task_resolution_type_lists','task_resolution_inventory_type_lists','task_resolution_inventory_detail_lists','task_resolution_reason_js_arr','task_resolution_type_js_arr','task_resolution_inventory_type_js_arr','task_resolution_inventory_detail_js_arr','task_id','ticket_id','previous_task_resolutions_lists','fault_id'));


    }

    public function delete_resolution(){
        $task_id = Request::get('task_id');
        $ticket_id = Request::get('ticket_id');
        $fault_id = Request::get('fault_id');
        $resolution_id = Request::get('resolution_id');
        $is_force_majeure = Request::get('is_force_majeure');

        $delete_from_resolution_table_query =  "DELETE FROM phoenix_tt_db.task_resolution_table where task_resolution_id='$resolution_id'";
        \DB::delete(\DB::raw($delete_from_resolution_table_query));  

        $select_from_task_table_query = "SELECT * FROM phoenix_tt_db.task_table WHERE task_id=$task_id";
        $task_lists = \DB::select(\DB::raw($select_from_task_table_query));  

        $task_resolution_value = $task_lists[0]->task_resolution_ids;

        $new_temp_arr = array();
        $exploded_arr = explode(",",$task_resolution_value);
        if(count($exploded_arr) > 1){
            for($i=0;$i < count($exploded_arr);$i++){
                if($exploded_arr[$i] != $resolution_id){
                    array_push($new_temp_arr, $exploded_arr[$i]);
                }
            }
            $imploded_resolution_ids = implode(',', $new_temp_arr);
        }
        else{
            if($task_resolution_value == $resolution_id){
                $imploded_resolution_ids = '';
            }
            else{
                $imploded_resolution_ids = $task_resolution_value;
            }
        }
        

        $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_resolution_ids='$imploded_resolution_ids' WHERE task_id=$task_id";
        \DB::update(\DB::raw($update_task_table_query));

        if($is_force_majeure == 'Force Majeure'){
            $update_fault_table_query = "UPDATE phoenix_tt_db.fault_table SET force_majeure='false' WHERE fault_id=$fault_id";
            \DB::update(\DB::raw($update_fault_table_query));

        }

        return redirect('EditTT?ticket_id='.$ticket_id);
    }

    public function add_resolution(){

        $task_id = Request::get('task_id');
        $ticket_id = Request::get('ticket_id');
        $fault_id = Request::get('fault_id');
        
        $resolution_ids = "";
        

        $resolution_counter = Request::get('resolution_counter');


        for($i=1;$i<$resolution_counter+1;$i++){

            $reason_temp = addslashes(Request::get('task_resolution_reason_'.$i));
            $fm_temp = addslashes(Request::get('task_resolution_fm_'.$i));
            $resolution_type_temp = addslashes(Request::get('task_resolution_type_'.$i));
            $inventory_type_temp = addslashes(Request::get('task_resolution_inventory_type_'.$i));
            $inventory_detail_temp = addslashes(Request::get('task_resolution_inventory_detail_'.$i));
            $quantity_temp = addslashes(Request::get('task_resolution_quantity_'.$i));
            $remark_temp = addslashes(Request::get('task_resolution_remarks_'.$i));
            $lat= addslashes(Request::get('task_resolution_lat_' . $i));
            $lon = addslashes(Request::get('task_resolution_lon_' . $i));

            // return $reason_temp;
            //echo $reason_temp. $i.'<br>';
            $insert_resolution_table_query = "INSERT INTO phoenix_tt_db.task_resolution_table
            (task_id,fault_id,reason,resolution_type,inventory_type,inventory_detail,quantity,remark,is_force_majeure,lat,lon)
             VALUES ('$task_id','$fault_id','$reason_temp','$resolution_type_temp','$inventory_type_temp','$inventory_detail_temp',
             '$quantity_temp','$remark_temp','$fm_temp','$lat','$lon')";

            //echo  $insert_resolution_table_query.'<br>';
            \DB::insert(\DB::raw($insert_resolution_table_query));

            if($fm_temp == 'yes'){
                $update_fault_table_query = "UPDATE phoenix_tt_db.fault_table SET force_majeure='true' WHERE fault_id=$fault_id";
                \DB::update(\DB::raw($update_fault_table_query));
            }


        }
        //return '';

        $task_resolution_table_query =  "SELECT * FROM phoenix_tt_db.task_resolution_table where task_id='$task_id'";
        $task_resolution_lists = \DB::select(\DB::raw($task_resolution_table_query));   


        foreach($task_resolution_lists as $task_resolution_list){

           $resolution_ids.=$task_resolution_list->task_resolution_id.",";
        }

        $resolution_ids = trim($resolution_ids,",");

        $update_task_table_query = "UPDATE phoenix_tt_db.task_table SET task_resolution_ids='$resolution_ids' where task_id='$task_id'";
        \DB::update(\DB::raw($update_task_table_query));




        return redirect('EditTT?ticket_id='.$ticket_id);
        
    }
    public function phoenix_get_employee_api(){


        $sql_emp = "SELECT * from hr_tool_db.employee_table WHERE status='Active' AND department IN('Gateway Operations','NOC','Regional Implementation & Operations 1','Regional Implementation & Operations 2','Central Power','I&C- Implementation','OH- Implementation','UG- Implementation','Regional Implementation & Operations 3','Regional Implementation & Operations 4','COS','RSL') ORDER BY name";
        $emp_lists =  \DB::connection('mysql3')->select(\DB::raw($sql_emp));

        echo json_encode(array("emp_list"=>$emp_lists));
    }
    public function vlookup_is_for_losers(){
        for($i=1;$i<41;$i++){
            $select_query = "select * from phoenix_tt_db.notification_table where notification_row_id=$i";
            $select_lists = \DB::select(\DB::raw($select_query));
            if(count($select_lists)>0){
                foreach($select_lists as $select_list){
                    //$col_value1 = addslashes($select_list->ticket_initiator_dept);
                    $col_value2 = addslashes($select_list->assigned_dept);

                    $select_from_another_query = "select dept_row_id from hr_tool_db.department_table where dept_name='".$col_value2."'";
                    $select_another_lists = \DB::select(\DB::raw($select_from_another_query)); 
                    if(count($select_another_lists)>0){
                        $updated_value = $select_another_lists[0]->dept_row_id; 
                        $update_query = "update phoenix_tt_db.notification_table set assigned_dept=".$updated_value." where notification_row_id=".$select_list->notification_row_id;
                        \DB::update(\DB::raw($update_query)); 
                    }
                    
                }   
            }            
        }
    }
}