<?php

namespace App\Http\Controllers;


use Request;
use DateTime;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\IncidentModel;

session_start();

class IncidentController extends Controller
{
    public function incident_view(){
        // $_SESSION["CURRENT_LIST"] = 'test';

        $ticket_id = addslashes(Request::get('ticket_id'));
        $ticket_title = addslashes(Request::get('ticket_title'));
        $ticket_status = addslashes(Request::get('ticket_status'));
        $incident_id = addslashes(Request::get('incident_id'));
        $incident_title = addslashes(Request::get('incident_title'));
        $incident_description = addslashes(Request::get('incident_description'));
        $incident_status = addslashes(Request::get('incident_status'));
        $incident_merger_id = addslashes(Request::get('incident_merger_id'));
        $incident_merge_time = addslashes(Request::get('incident_merge_time'));
        $ticket_comment_scl = addslashes(Request::get('ticket_comment_scl'));
        $ticket_comment_client = addslashes(Request::get('ticket_comment_client'));
        $ticket_comment_noc = addslashes(Request::get('ticket_comment_noc'));
        $assigned_dept = addslashes(Request::get('assigned_dept'));

        

        $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29";
        $department_lists = \DB::select(\DB::raw($department_query));


        $ticket_time_from_temp = Request::get('ticket_time_from');
        if($ticket_time_from_temp != ''){
           $ticket_time_from_obj = new DateTime($ticket_time_from_temp);
            $ticket_time_from = $ticket_time_from_obj->format('Y-m-d h:i:s'); 
        }
        else{
            $ticket_time_from = $ticket_time_from_temp;
        }

        $ticket_time_to_temp = Request::get('ticket_time_to');
        if($ticket_time_to_temp != ''){
           $ticket_time_to_obj = new DateTime($ticket_time_to_temp);
           $ticket_time_to = $ticket_time_to_obj->format('Y-m-d h:i:s'); 
        }
        else{
            $ticket_time_to = $ticket_time_to_temp;
        }

        $ticket_closing_time_from_temp = addslashes(Request::get('ticket_closing_time_from'));
        if($ticket_closing_time_from_temp != ''){
            $ticket_closing_time_from_obj = new DateTime($ticket_closing_time_from_temp);
            $ticket_closing_time_from = $ticket_closing_time_from_obj->format('Y-m-d h:i:s');
        }
        else{
            $ticket_closing_time_from = $ticket_closing_time_from_temp;
        }
       

        $ticket_closing_time_to_temp = addslashes(Request::get('ticket_closing_time_to'));
        if($ticket_closing_time_to_temp != ''){
            $ticket_closing_time_to_obj = new DateTime($ticket_closing_time_to_temp);
            $ticket_closing_time_to = $ticket_closing_time_to_obj->format('Y-m-d h:i:s');
        }
        else{
            $ticket_closing_time_to = $ticket_closing_time_to_temp;
        }
        $ticket_closer_id = addslashes(Request::get('ticket_closer_id'));

        $ticket_arr = array();
        $ticket_key_arr = array();

        $ticket_arr['ticket_id'] = $ticket_id;
        array_push($ticket_key_arr, 'ticket_id');
        $ticket_arr['ticket_title'] = $ticket_title;
        array_push($ticket_key_arr, 'ticket_title');
        $ticket_arr['ticket_status'] = $ticket_status;
        array_push($ticket_key_arr, 'ticket_status');
        $ticket_arr['assigned_dept'] = $assigned_dept;
        array_push($ticket_key_arr, 'assigned_dept');
        $ticket_arr['ticket_closer_id'] = $ticket_closer_id;
        array_push($ticket_key_arr, 'ticket_closer_id');

        $ticket_arr['incident_id'] = $incident_id;
        array_push($ticket_key_arr, 'incident_id');
        $ticket_arr['incident_title'] = $incident_title;
        array_push($ticket_key_arr, 'incident_title');
        $ticket_arr['incident_description'] = $incident_description;
        array_push($ticket_key_arr, 'incident_description');
        $ticket_arr['incident_status'] = $incident_status;
        array_push($ticket_key_arr, 'incident_status');
        $ticket_arr['incident_merger_id'] = $incident_merger_id;
        array_push($ticket_key_arr, 'incident_merger_id');
        $ticket_arr['incident_merge_time'] = $incident_merge_time;
        array_push($ticket_key_arr, 'incident_merge_time');

        $ticket_arr['ticket_time_from'] = $ticket_time_from;
        array_push($ticket_key_arr, 'ticket_time_from');
        $ticket_arr['ticket_time_to'] = $ticket_time_to;
        array_push($ticket_key_arr, 'ticket_time_to');
        $ticket_arr['ticket_closing_time_from'] = $ticket_closing_time_from;
        array_push($ticket_key_arr, 'ticket_closing_time_from');
        $ticket_arr['ticket_closing_time_to'] = $ticket_closing_time_to;
        array_push($ticket_key_arr, 'ticket_closing_time_to');

        $search_value_arr = array();
        $search_value_arr = $this->incident_view_search($ticket_arr,$ticket_key_arr);
        
        $total_arr_lists = array();
        $incident_arr_lists = array();
        $incident_js_arr = array();

        $whereTktID = '';
        $whereIncdntID = '';
        if($ticket_id!=''){
            $whereTktID.=" ticket_table.ticket_id in ($ticket_id)";
        }
        else $whereTktID.=" 1";
        
        if($incident_id!='')
        {
            $whereIncdntID.=" incident_table.incident_id in ($incident_id)";
        }
        else $whereIncdntID.=" 1";

        if($search_value_arr[1] == 'true'){
            $searched_lists = DB::table("phoenix_tt_db.incident_table")   
            ->selectRaw('incident_table.incident_id,incident_table.incident_title,incident_table.incident_description,incident_table.incident_status,incident_table.incident_merge_time,incident_table.incident_merger_id,incident_table.incident_row_created_date,ticket_table.ticket_id,ticket_table.ticket_status,ticket_table.ticket_title,ticket_table.ticket_initiator,ticket_table.ticket_initiator_dept,ticket_table.assigned_dept,ticket_table.ticket_row_created_date,ticket_table.ticket_closing_time,ticket_table.ticket_closer_id,ticket_table.ticket_row_update_time')
            ->join('phoenix_tt_db.ticket_table',"phoenix_tt_db.ticket_table.incident_id","=","phoenix_tt_db.incident_table.incident_id")
            ->whereRaw($search_value_arr[0].' and '.$whereIncdntID.' and '.$whereTktID)//->toSql();
            ->paginate(100);
            //return $searched_lists;
            $i = 0;
            foreach($searched_lists as $searched_list){
                
                $ticket_arr_lists = array();
                $ticket_arr_lists['ticket_id'] = $searched_list->ticket_id;
                $ticket_arr_lists['ticket_title'] = $searched_list->ticket_title;
                $ticket_arr_lists['ticket_status'] = $searched_list->ticket_status;
                $ticket_arr_lists['ticket_initiator'] = $searched_list->ticket_initiator;
                $ticket_arr_lists['ticket_initiator_dept'] = $searched_list->ticket_initiator_dept;
                
                $assigned_dept_arr = explode(',', $searched_list->assigned_dept);
                $temp_dept = '';
                for($k=0;$k<count($assigned_dept_arr);$k++){
                    foreach($department_lists as $department_list){
                        if($department_list->dept_row_id == $assigned_dept_arr[$k]){
                            $temp_dept .= $department_list->dept_name.',';
                        } 
                    }
                }
                $ticket_arr_lists['assigned_dept'] = trim($temp_dept,',');

                $ticket_arr_lists['ticket_row_created_date'] = $searched_list->ticket_row_created_date;

                $ticket_arr_lists['ticket_closing_time'] = $searched_list->ticket_closing_time;
                $ticket_arr_lists['ticket_closer_id'] = $searched_list->ticket_closer_id;
                if(array_key_exists($searched_list->incident_id,$total_arr_lists))
                {
                    array_push($total_arr_lists[$searched_list->incident_id], $ticket_arr_lists);
                    
                }
                else
                {
                    $total_arr_lists[$searched_list->incident_id][0] = $ticket_arr_lists;
                
                // print_r($total_arr_lists);
                // echo '<br><br>';
                    $incident_temp_lists = array();
                    array_push($incident_js_arr, $searched_list->incident_id);
                    $incident_temp_lists['incident_id'] = $searched_list->incident_id;
                    $incident_temp_lists['incident_title'] = $searched_list->incident_title;
                    $incident_temp_lists['incident_description'] = $searched_list->incident_description;
                    $incident_temp_lists['incident_status'] = $searched_list->incident_status;
                    $incident_temp_lists['incident_row_created_date'] = $searched_list->incident_row_created_date;
                    if($searched_list->incident_merge_time != ''){
                        $incident_temp_lists['incident_merge_time'] = $searched_list->incident_merge_time;
                    }
                    else{
                        $incident_temp_lists['incident_merge_time'] = '';
                    }
                    if($searched_list->incident_merger_id != ''){
                        $incident_temp_lists['incident_merger_id'] = $searched_list->incident_merger_id;
                    }
                    else{
                        $incident_temp_lists['incident_merger_id'] = '';
                    }
                    $total_arr_lists[$searched_list->incident_id][0] = $ticket_arr_lists;
                     $incident_arr_lists[$searched_list->incident_id] = $incident_temp_lists;

                    
                // }

                //print_r($total_arr_lists);
                // $i++;
                // if($i>50){
                //     //print_r($total_arr_lists);
                //     return '';
                }
            }
            
        }
        else{
            $searched_lists = array(); 
        }
        //return $incident_js_arr;
        //print_r($total_arr_lists);
        //return '';
        
        $search_value = array($incident_id,$incident_title,$incident_description,$incident_status,$incident_merger_id,$ticket_id,$ticket_title,$ticket_status,$assigned_dept,$ticket_time_from_temp,$ticket_time_to_temp,$ticket_closing_time_from_temp,$ticket_closing_time_to_temp);

        return view('incident.incident_view',compact('department_lists','link_type_lists','client_lists','problem_category_lists','problem_source_lists','reason_lists','issue_type_lists','searched_lists','total_arr_lists','incident_arr_lists','incident_js_arr','search_value'));
    }
    public function incident_view_single(){
        $incident_id = Request::get('incident_id');

        $ticket_query_lists = "SELECT * FROM phoenix_tt_db.ticket_table WHERE incident_id=$incident_id";
        $ticket_lists = \DB::select(\DB::raw($ticket_query_lists));

        return view('incident.incident_view_single',compact('ticket_lists','incident_id'));
    }
    public function incident_view_search($ticket_arr,$ticket_key_arr){
        //print_r($ticket_arr);
        //print_r($ticket_key_arr);
        $incident_ticket_select_query = "ticket_table.ticket_id > 0 ";

        $is_any_field_searched = 'false';

        for($i=0;$i<(count($ticket_key_arr)-10);$i++){
            $tempVal = $ticket_key_arr[$i];
            //echo 'i ='.$i.$tempVal.'<br>';
            if($ticket_arr[$tempVal] != ''){
                if($i == 0){ 
                    $is_any_field_searched = 'true'; 
                }
                else if($i == 3){
                    $incident_ticket_select_query .= " AND  (ticket_table.".$tempVal." like '%,".$ticket_arr[$tempVal]."' OR ticket_table.".$tempVal." like '%,".$ticket_arr[$tempVal].",%' OR ticket_table.".$tempVal." like '".$ticket_arr[$tempVal].",%')"; 
                    $is_any_field_searched = 'true'; 
                }
                else{
                    $incident_ticket_select_query .= " AND  ticket_table.".$tempVal." like '%".$ticket_arr[$tempVal]."%'"; 
                    $is_any_field_searched = 'true'; 
                }
                
            }       
        }

        $tempVal1 = $ticket_key_arr[11];
        $tempVal2 = $ticket_key_arr[12];
        if($ticket_arr[$tempVal1] != '' && $ticket_arr[$tempVal2] != ''){
            $incident_ticket_select_query .= " AND  ticket_table.ticket_row_created_date BETWEEN '".$ticket_arr[$tempVal1]."' AND '".$ticket_arr[$tempVal2]."'";
            $is_any_field_searched = 'true';
        }
        if($ticket_arr[$tempVal1] != '' && $ticket_arr[$tempVal2] == ''){
            $incident_ticket_select_query .= " AND  ticket_table.ticket_row_created_date > '".$ticket_arr[$tempVal1]."'";
            $is_any_field_searched = 'true';
        } 
        if($ticket_arr[$tempVal2] != '' && $ticket_arr[$tempVal1] == ''){
            $incident_ticket_select_query .= " AND  ticket_table.ticket_row_created_date > '".$ticket_arr[$tempVal2]."'";
            $is_any_field_searched = 'true';
        }
        $tempVal3 = $ticket_key_arr[13];
        $tempVal4 = $ticket_key_arr[14];
        if($ticket_arr[$tempVal3] != '' && $ticket_arr[$tempVal4] != ''){
            $incident_ticket_select_query .= " AND  ticket_table.ticket_closing_time BETWEEN '".$ticket_arr[$tempVal3]."' AND '".$ticket_arr[$tempVal4]."'";
            $is_any_field_searched = 'true';
        }
        if($ticket_arr[$tempVal3] != '' && $ticket_arr[$tempVal4] == ''){
            $incident_ticket_select_query .= " AND  ticket_table.ticket_closing_time > '".$ticket_arr[$tempVal3]."'";
            $is_any_field_searched = 'true';
        } 
        if($ticket_arr[$tempVal4] != '' && $ticket_arr[$tempVal3] == ''){
            $incident_ticket_select_query .= " AND  ticket_table.ticket_closing_time > '".$ticket_arr[$tempVal4]."'";
            $is_any_field_searched = 'true';
        }  
        for($i=4;$i<(count($ticket_key_arr)-4);$i++){
            $tempVal = $ticket_key_arr[$i];
            //echo 'i ='.$i.$tempVal.'<br>';
            if($i==5){
                $is_any_field_searched = 'true';
            }
            else if($ticket_arr[$tempVal] != ''){
                //echo $tempVal;
                $incident_ticket_select_query .= " AND  incident_table.".$tempVal." like '%".$ticket_arr[$tempVal]."%'";
                $is_any_field_searched = 'true';
            }
            
        }

        $search_query_arr = array();
        array_push($search_query_arr, $incident_ticket_select_query);
        array_push($search_query_arr,$is_any_field_searched);
        //print_r($search_query_arr);
        //dd($search_query_arr);
        //echo $incident_ticket_select_query;
        return $search_query_arr;

        
    }
    public function incident_merge(){
        $ticket_arr = array();
        $incident_id_arr = array();
        $incident_title_arr = array();
        if(isset($_SESSION["CURRENT_LIST"])){
            $incident_list_arr = explode(',',$_SESSION["CURRENT_LIST"]); 
            for($i=0;$i<count($incident_list_arr);$i++){
                $single_incident_arr = explode('|', $incident_list_arr[$i]);
                $id = $single_incident_arr[0];

                array_push($incident_id_arr, $id);
                array_push($incident_title_arr, $single_incident_arr[1]);

                $select_ticket_query = "SELECT * FROM phoenix_tt_db.ticket_table WHERE incident_id=$id";
                $ticket_lists = \DB::select(\DB::raw($select_ticket_query));

                foreach($ticket_lists as $ticket_list){
                    $ticket_temp_arr = array();
                    array_push($ticket_temp_arr, $ticket_list->ticket_id);
                    array_push($ticket_temp_arr, $ticket_list->ticket_title);
                    array_push($ticket_temp_arr, $ticket_list->assigned_dept);
                    $ticket_arr[$id] = $ticket_temp_arr;
                }
            }
        }
        //return $ticket_arr;
        return view('incident.incident_merge',compact('ticket_arr','incident_id_arr','incident_title_arr'));
    }
    public function insert_incident_cart(){
        $current_list = Request::get('added_ticket_id');

        if(isset($_SESSION["CURRENT_LIST"])){

            //if(!preg_match("/\b$current_list\b/i", $_SESSION["CURRENT_LIST"])){
                //$_SESSION["CURRENT_LIST"] .= ','.$current_list;
                //echo $_SESSION["CURRENT_LIST"];
                if (strpos($_SESSION["CURRENT_LIST"], $current_list) == false) {
                    $_SESSION["CURRENT_LIST"] .= ','.$current_list;
                }
            //}
            
        }
        else{
            $_SESSION["CURRENT_LIST"] = $current_list;
        }
        //echo $_SESSION["CURRENT_LIST"];
        //return '';
    }
    public function delete_incident_cart(Request $request){
        $current_list = Request::get('added_ticket_id');
        $current_session_list = explode(',', $_SESSION["CURRENT_LIST"]);
        $tempArr = array();

        for($i=0;$i<count($current_session_list);$i++){
            if($current_session_list[$i] != $current_list){
                array_push($tempArr, $current_session_list[$i]);
            }
        }
        if(count($tempArr) != 0){
            $tempValue = implode(",",$tempArr);
            $_SESSION["CURRENT_LIST"] = $tempValue;
        }
        else{
            $_SESSION["CURRENT_LIST"] = null;
        }
    }
    public function incident_list_api(){
        $incident_list_query = "SELECT * from phoenix_tt_db.incident_table ORDER BY incident_id DESC LIMIT 50";
        $incident_lists = \DB::select(\DB::raw($incident_list_query));

        echo json_encode(array("records"=>$incident_lists));
    }
    public function incident_list(){
        return view('ticket.incident_selection_view');
    }
    public function refresh_cart(){
        return view('navigation.p_cart');
    }
    public function refresh_incident_merge(){
        return view('incident.incident_cart');
    }
    
    public function incident_merge_process(){
        $incident_title = Request::get('incident_title');
        $incident_location = Request::get('incident_location');
        $full_title = $incident_location."|".$incident_title;
        $incident_description = Request::get('incident_description');

        /*************************INCIDENT TABLE INSERT *********************START********************/

        $IncidentModel = new IncidentModel();
        $IncidentModel->incident_title = $full_title;
        $IncidentModel->incident_description = $incident_description;
        $IncidentModel->incident_status = 'open';
        $IncidentModel->incident_merge_time = date("Y-m-d H:i:s");
        $IncidentModel->incident_merger_id = $_SESSION['user_id'];
        $IncidentModel->save();
        $incident_id = $IncidentModel->id;
        
        // $insert_incident_table_query = "INSERT INTO phoenix_tt_db.incident_Table(incident_title,incident_description,incident_status,incident_merge_time,incident_merger_id) VALUES ('$incident_title','$incident_description','open',NOW(),'".$_SESSION['user_id']."')";

        // /**********************************************************************************************/

        // /***********************GET ADDED INCIDENT ID**************************START***********************/
        // $select_incident_id_query = "SELECT incident_id FROM phoenix_tt_db.incident_table ORDER BY incident_id DESC LIMIT 1";
        // $incident_id_lists = \DB::select(\DB::raw($select_incident_id_query));
        // $incident_id = $incident_id_lists[0]->incident_id;

        /********************************************************************************************/

        if(isset($_SESSION["CURRENT_LIST"])){
           $incident_list_arr = explode(',',$_SESSION["CURRENT_LIST"]); 
            for($i=0;$i<count($incident_list_arr);$i++){
                $single_incident_arr = explode('|', $incident_list_arr[$i]);
                $id = $single_incident_arr[0];

                $update_incident_id_query = "UPDATE ticket_table SET incident_id=$incident_id WHERE incident_id=$id";
                \DB::update(\DB::raw($update_incident_id_query));

                $update_incident_table_query = "UPDATE incident_table SET incident_status='deactive' WHERE incident_id=$id";
                \DB::update(\DB::raw($update_incident_table_query));
            }
        } 
        $_SESSION["CURRENT_LIST"] = null;

        return redirect('IncidentView');           
    }
}
