<?php

namespace App\Http\Controllers;

use Request;
use DateTime;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

session_start();
class NotificationController extends Controller
{
	public function notification_list_api(){
        $session_dept_id = $_SESSION['dept_id'];
		$get_notification_query = "SELECT * FROM phoenix_tt_db.notification_table WHERE notification_flag = 0 AND  (assigned_dept LIKE '$session_dept_id,%' OR assigned_dept LIKE '%,$session_dept_id' OR assigned_dept LIKE '%,$session_dept_id,%') ORDER BY notification_row_id DESC";
    	$notification_lists = \DB::select(\DB::raw($get_notification_query));

    	echo json_encode(array($notification_lists));
	}
	public function refresh_notification_cart(){
        return view('navigation.fb_notification');
    }

    public function notification_view(){
        $session_dept_id = $_SESSION['dept_id'];
        // $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29";
        $department_query = "SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29 AND dept_row_id IN (4,10,11,12,15,34,35,36,41,43,45,46,47)";
        $department_lists = \DB::connection('mysql3')->select(\DB::raw($department_query)); 
    	$notification_lists = \DB::table('phoenix_tt_db.notification_table')
    							->selectRaw('phoenix_tt_db.notification_table.*')
    							->whereRaw("notification_flag =0")
                                ->whereRaw("assigned_dept LIKE '$session_dept_id,%' OR assigned_dept LIKE '%,$session_dept_id' OR assigned_dept LIKE '%,$session_dept_id,%'")
    							->paginate(10);

    	return view('notification.notification_view',compact('notification_lists','department_lists'));
    }
    public function notification_alert_api(){
        $session_dept_id = $_SESSION['dept_id'];
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        $current_time = $current_time_obj->format('Y-m-d H:i:s');

        $previous_time_obj  = $current_time_obj->modify("-5 minutes");
        $previous_time = $previous_time_obj->format('Y-m-d H:i:s');

        $current_minutes =(int)$current_time_obj->format('i');
        // if($current_minutes%5 == 0){
            $get_notification_query = "SELECT * FROM phoenix_tt_db.notification_table WHERE notification_flag=0 AND (notification_creation_time BETWEEN '$previous_time' AND '$current_time') AND  (assigned_dept LIKE '$session_dept_id,%' OR assigned_dept LIKE '%,$session_dept_id' OR assigned_dept LIKE '%,$session_dept_id,%')";
            $notification_alert_lists = \DB::select(\DB::raw($get_notification_query));
        // }
        // else{
        //     $get_notification_query = "SELECT * FROM phoenix_tt_db.notification_table WHERE notification_row_id < 0";
        //     $notification_alert_lists = \DB::select(\DB::raw($get_notification_query));
        // }
        //echo $current_minutes;
        if(count($notification_alert_lists)>0){
            $notification_alert_lists;
        }
        else{
            $notification_alert_lists;
        }
        return $notification_alert_lists;
    }

    public function op_view(){
        $select_op_query = "select tt.*,(select client_name from client_table ct,fault_table ff where ff.fault_id=tt.fault_id and ff.client_id=ct.client_id) as client,(select ticket_title from ticket_table t where t.ticket_id=tt.ticket_id) as ticket_title,(select link_type from fault_table ft where tt.fault_id=ft.fault_id) as link_type,(select issue_type from fault_table ft where tt.fault_id=ft.fault_id) as issue_type,(select task_comment from task_update_log tuu where tuu.task_id=tt.task_id order by tuu.task_update_log_row_id desc limit 1) as task_comments,(select task_comment_time from task_update_log tuu where tuu.task_id=tt.task_id order by tuu.task_update_log_row_id desc limit 1) as task_comment_time,(select task_comment_user_id from task_update_log tuu where tuu.task_id=tt.task_id order by tuu.task_update_log_row_id desc limit 1) as task_comment_user_id from task_table tt where tt.task_id IN (select task_id from task_update_log where task_update_log_row_id in (SELECT MAX(task_update_log_row_id) FROM `task_update_log` group by task_id  order by task_update_log_row_id desc) and dept_name !='NOC' and task_status='escalated') and tt.task_status ='escalated'";
        $op_lists = \DB::select(\DB::raw($select_op_query));


        //return $op_lists;

        return view('notification.op_view',compact('op_lists'));
    }


}



