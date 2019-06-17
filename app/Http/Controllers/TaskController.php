<?php

namespace App\Http\Controllers;

use File;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Request;
use Input;
use DateTime;
use Zipper;

class TaskController extends Controller
{
    //
	public function task_search_view(){
		$department_query ="SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29 AND dept_row_id IN (4,10,11,12,14,15,34,35,36,41,43,45,46,47)";
		$department_lists = \DB::select(\DB::raw($department_query));

		$subcenter_query = "SELECT * FROM phoenix_tt_db.subcenter_table WHERE status='Active'";
		$subcenter_lists = \DB::select(\DB::raw($subcenter_query));

		$ticket_id = "";
		$fault_id = "";
		$task_id = "";
		$task_name = "";
		$task_description = "";
		$task_status = "";
		$task_assigned_dept = "";
		$subcenter = "";
		$task_start_time_from = "";
		$task_start_time_to = "";
		$task_end_time_from = "";
		$task_end_time_to = "";



		return view('task.task_search_view',compact('department_lists','subcenter_lists','ticket_id','fault_id','task_id','task_name','task_description','task_status','task_assigned_dept','subcenter','task_start_time_from','task_start_time_to','task_end_time_from','task_end_time_to'));
	}

	public function task_search(){
		$department_query ="SELECT * FROM hr_tool_db.department_table WHERE dept_status='Active' AND dept_row_id !=29 AND dept_row_id IN (4,10,11,12,14,15,34,35,36,41,43,45,46,47)";
		$department_lists = \DB::select(\DB::raw($department_query));

		$subcenter_query = "SELECT * FROM phoenix_tt_db.subcenter_table WHERE status='Active'";
		$subcenter_lists = \DB::select(\DB::raw($subcenter_query));
        //////////////////////////////////////////////////////////////////////////////////////////
		$ticket_id = addslashes(Request::get('ticket_id'));
		$fault_id = addslashes(Request::get('fault_id'));
		$task_id = addslashes(Request::get('task_id'));
		$task_name = addslashes(Request::get('task_name'));
		$task_description = addslashes(Request::get('task_description'));
		$task_status = addslashes(Request::get('task_status'));
		$task_assigned_dept = addslashes(Request::get('task_assigned_dept'));
		$subcenter = addslashes(Request::get('subcenter'));

		//dd($subcenter);
		$task_start_time_from = addslashes(Request::get('task_start_time_from'));
		$task_start_time_to = addslashes(Request::get('task_start_time_to'));
		$task_end_time_from = addslashes(Request::get('task_end_time_from'));
		$task_end_time_to = addslashes(Request::get('task_end_time_to'));

		$formType = addslashes(Request::get('formType'));

		if($formType != ''){
			$whereQuery = "";
			if($ticket_id != ""){
				$whereQuery .= "ticket_id = $ticket_id AND ";
			}
			if($fault_id != ""){
				$whereQuery .= "fault_id = $fault_id AND ";
			}
			if($task_id != ""){
				$whereQuery = "task_id = $task_id AND ";
			}
			if($task_name != ""){
				$whereQuery .= "task_name like '%$task_name%' AND ";
			}
			if($task_description != ""){
				$whereQuery .= "task_description like '%$task_description%' AND ";
			}
			if($task_status != ""){
				$whereQuery .= "task_status = '$task_status' AND ";
			}
			if($task_assigned_dept != ""){
				$whereQuery .= "task_assigned_dept = $task_assigned_dept AND ";
			}
			if($subcenter != ""){
				$whereQuery .= "subcenter = '$subcenter' AND ";
			}
			if($task_start_time_from != ""){
				$whereQuery .= "task_start_time > '$task_start_time_from' AND ";
			}
			if($task_start_time_to != ""){
				$whereQuery .= "task_start_time < '$task_start_time_to' AND ";
			}
			if($task_end_time_from != ""){
				$whereQuery .= "task_end_time > '$task_end_time_from' AND ";
			}
			if($task_end_time_to != ""){
				$whereQuery .= "task_end_time < '$task_end_time_to' AND ";
			}

			$whereQuery = rtrim($whereQuery,"AND ");


			if($formType == 'Search'){
				$task_lists = \DB::table('phoenix_tt_db.task_table')
				->selectRaw("phoenix_tt_db.task_table.*,hr_tool_db.department_table.*,TIMESTAMPDIFF(SECOND,`task_start_time`,`task_end_time`) as 'duration',TIMESTAMPDIFF(SECOND,`task_start_time`,now()) as 'current_duration'")
				->join('hr_tool_db.department_table','phoenix_tt_db.task_table.task_assigned_dept','=','hr_tool_db.department_table.dept_row_id')
				->whereRaw("$whereQuery")
				->orderByRaw('ticket_id DESC')
				->paginate(500);

        //print_r($task_lists);

        //echo "<br>";
	        //return "if invaded";
				$dashboard_value = 'Search';

				return view('task.task_search_view',compact('department_lists','subcenter_lists','task_lists','dashboard_value','ticket_id','fault_id','task_id','task_name','task_description','task_status','task_assigned_dept','subcenter','task_start_time_from','task_start_time_to','task_end_time_from','task_end_time_to'));
			}

			if($formType == 'Export'){

				$user_id = $_SESSION['user_id'];

	            $report_log_id = DB::table('report_download_log')->insertGetId(
	                [
	                    'user_id' => $user_id,
	                    'report_type' => 'Task Export'
	                ]
	                );



				$task_list_query = "SELECT TT.*,DT1.dept_name as 'task_assigned_dept_name',DT2.dept_name as 'task_initiator_dept_name' 
				FROM phoenix_tt_db.task_table TT 
				JOIN hr_tool_db.department_table DT1 ON TT.task_assigned_dept = DT1.dept_row_id 
				JOIN hr_tool_db.department_table DT2 ON TT.task_initiator_dept = DT2.dept_row_id 
				WHERE $whereQuery";

				
				$task_lists = \DB::select(\DB::raw($task_list_query));
				$headerArr = array('ticket_id','fault_id','task_id','task_name','task_description','task_status','task_assigned_dept','subcenter','task_start_time','task_end_time','task_start_time_db','task_end_time_db','task_responsible','task_resolver','task_closer_id','task_initiator_dept');
				$bigArr = array();
				array_push($bigArr, $headerArr);

				$row_count = count($task_lists);

                $update_row_count_in_log = "UPDATE phoenix_tt_db.report_download_log SET row_count = $row_count WHERE id = $report_log_id";
                \DB::update(\DB::raw($update_row_count_in_log));

				foreach ($task_lists as $task_list) {
					$smallArr = array();
					array_push($smallArr, $task_list->ticket_id);
					array_push($smallArr, $task_list->fault_id);
					array_push($smallArr, $task_list->task_id);
					array_push($smallArr, $task_list->task_name);
					array_push($smallArr, $task_list->task_description);
					array_push($smallArr, $task_list->task_status);
					array_push($smallArr, $task_list->task_assigned_dept_name);
					array_push($smallArr, $task_list->subcenter);
					array_push($smallArr, $task_list->task_start_time);
					array_push($smallArr, $task_list->task_end_time);
					array_push($smallArr, $task_list->task_start_time_db);
					array_push($smallArr, $task_list->task_end_time_db);
					array_push($smallArr, $task_list->task_responsible);
					array_push($smallArr, $task_list->task_resolver);
					array_push($smallArr, $task_list->task_closer_id);
					array_push($smallArr, $task_list->task_initiator_dept_name);

					array_push($bigArr, $smallArr);
				}

				$export = fopen('../Uploaded_Files/export.csv','w');
				foreach ($bigArr as $fields) {
					fputcsv($export, $fields);
				}
				$path = '../Uploaded_Files/export.csv';
				return response()->download($path);





			}


			$dashboard_value = '';
			$task_lists = array();
			return view('task.task_search_view',compact('department_lists','subcenter_lists','task_lists','dashboard_value','ticket_id','fault_id','task_id','task_name','task_description','task_status','task_assigned_dept','subcenter','task_start_time_from','task_start_time_to','task_end_time_from','task_end_time_to'));
		}


	}
}