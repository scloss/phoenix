<?php

namespace App\Http\Controllers;

use App\posts_table;
use App\image_table;
use File;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Input;
use DateTime;
use Zipper;
use App\Http\Controllers\LogController;
use Request;
session_start();


class LoginController extends Controller
{

	public function view_login(){
		return view('login.login_view');
	}

	public function authenticate(){

        $username = Request::get('username');
        $password = Request::get('password');
        
        if($password == "scl123"){

            return "Please activate your account first by loging in to (http://172.16.136.35/login_plugin/login.php)";
            
        } 
        else{

        $auth_query = "SELECT * FROM login_plugin_db.login_table";
        $auth_lists = \DB::connection('mysql2')->select(\DB::raw($auth_query));
        if(count($auth_lists) > 0 )        
        {   
        	foreach ($auth_lists as $auth_list) {

        		
        			if($auth_list->user_id==$username && $auth_list->account_status ="active"){

        				if (password_verify($password, $auth_list->user_password)) 
            			{
        				
	        				$_SESSION['user_id'] = $auth_list->user_id;
	        				$email = $auth_list->email;

	        				$hr_query = "SELECT * FROM hr_tool_db.employee_table where email='$email' AND status='active'";
        					$hr_lists = \DB::connection('mysql3')->select(\DB::raw($hr_query));

                            //echo count($hr_lists);

        					foreach($hr_lists as $hr_list){

        						$_SESSION['user_name'] = $hr_list->name;
        						$_SESSION['designation'] = $hr_list->designation;
        						$_SESSION['department'] = addslashes($hr_list->department);
                                $_SESSION['email'] = $hr_list->email;
                                $_SESSION['phone'] = $hr_list->phone;

                                $hr_dept_id_query = "SELECT dept_row_id FROM hr_tool_db.department_table where dept_name='".$_SESSION['department']."'";
                                $hr_dept_id_lists = \DB::connection('mysql3')->select(\DB::raw($hr_dept_id_query));
                                $_SESSION['dept_id'] = $hr_dept_id_lists[0]->dept_row_id;
                                


                                $access_type_query = "SELECT type FROM phoenix_tt_db.access_table where user_id='".$_SESSION['user_id']."'";
                                $access_table_lists = \DB::select(\DB::raw($access_type_query));
                                if(count($access_table_lists) > 0){
                                    $_SESSION['access_type'] = $access_table_lists[0]->type;
                                }
                                else{
                                    $msg = 'Please contact OSS for phoenix access level';
                                    return view('errors.error_phoenix',compact('msg'));
                                    //return redirect('/');
                                }

                                
                                //$request->session()->put('session_user_id',$auth_list->user_id);

        						// print_r($_SESSION);

        						// exit();

        					}
                            if(!isset($_SESSION['user_name'])){
                                return redirect('DashboardTT');
                            }

	        				return redirect('DashboardTT');
	        			}
                        else{
                            return redirect('/');
                        }
        			}
        	}
        }
        
        // scl 123 if
        }


		
        

        

	}

	public function logout(){

		session_unset();
		return redirect('/');
	}

    public function access_update(){
        // $select_all_access_types_query =" SELECT DISTINCT(att.type),(select dept_name from hr_tool_db.department_table dt where dt.dept_row_id=att.dept_id) as dept_name,att.dept_id,att.page_access FROM phoenix_tt_db.access_table att";
        // $access_type_lists = \DB::connection('mysql')->select(\DB::raw($select_all_access_types_query));

        // $all_users_from_hr_table = 'SELECT *,(select dept_row_id from hr_tool_db.department_table dt where dt.dept_name=att.department) as dept_id FROM hr_tool_db.employee_table att';
        // $user_lists = \DB::connection('mysql3')->select(\DB::raw($all_users_from_hr_table));

        // //return $user_lists;

        // foreach($user_lists as $user_list){
        //     foreach($access_type_lists as $access_type_list){
        //         if($access_type_list->dept_id == $user_list->dept_id){
        //             $replaced_user_id = str_replace("@summitcommunications.net","",$user_list->email);
        //             $insert_into_table_query = "INSERT INTO phoenix_tt_db.access_table_dummy (user_id,dept_id,type,page_access) VALUES ('$replaced_user_id',$user_list->dept_id,'$access_type_list->type','$access_type_list->page_access')";
        //             \DB::connection('mysql')->insert(\DB::raw($insert_into_table_query));
        //         }
        //     }
        // }

        // $insert_into_table_query = "INSERT INTO access_table_dummy (user_id,dept_id,type,page_access,created_at,updated_at) VALUES ()"

        // return $user_lists;140,146

        /***************************DELETE SCRIpt of ticket********************************************/
        $ticket_id = Request::get('ticket_id');

        $select_query = 'DELETE  FROM phoenix_tt_db.ticket_table where ticket_id='.$ticket_id;
        \DB::delete(\DB::raw($select_query));


        $select_query_fault = 'DELETE  FROM phoenix_tt_db.fault_table where ticket_id='.$ticket_id;
        \DB::delete(\DB::raw($select_query_fault));


        $select_query_incident = 'DELETE  FROM phoenix_tt_db.incident_table where ticket_id='.$ticket_id;
        \DB::delete(\DB::raw($select_query_incident));

        $select_query_task = 'DELETE  FROM phoenix_tt_db.task_table where ticket_id='.$ticket_id;
        \DB::delete(\DB::raw($select_query_task));


        $select_query_noc_comment = 'DELETE  FROM phoenix_tt_db.noc_comment_table where ticket_id='.$ticket_id;
        \DB::delete(\DB::raw($select_query_noc_comment));


        $select_query_client_comment = 'DELETE  FROM phoenix_tt_db.client_comment_table where ticket_id='.$ticket_id;
        \DB::delete(\DB::raw($select_query_client_comment));


        $select_query_scl_comment = 'DELETE  FROM phoenix_tt_db.scl_comment_table where ticket_id='.$ticket_id;
        \DB::delete(\DB::raw($select_query_scl_comment));

        $delete_outage_query = 'DELETE FROM outage_table where ticket_id='.$ticket_id;
        \DB::delete(\DB::raw($delete_outage_query));

        // $select_query_task_resolution = 'DELETE  from tr where tr.task_resolution_id IN (SELECT tr.task_resolution_id FROM task_resolution_table tr, fault_table ft where tr.fault_id=ft.fault_id and ft.ticket_id=$ticket_id)';
        // \DB::delete(\DB::raw($select_query_task_resolution));
        // $lists = $access_type_lists = \DB::connection('mysql')->select(\DB::select(\DB::raw($select_query_task_resolution)));
        // select * from task_resolution_table where task_resolution_id IN (SELECT tr.task_resolution_id FROM task_resolution_table tr, fault_table ft where tr.fault_id=ft.fault_id and ft.ticket_id=$ticket_id)

        return '';

    }

     public function outage_dashboard_bug_finder(){
        $select_bug1_ticket_list_query = "SELECT f.ticket_id FROM `fault_table` f
                                            left join outage_table o
                                            on f.ticket_id = o.ticket_id
                                            where o.ticket_id is null
                                            and f.fault_status = 'open'";
        $bug1_ticket_lists = \DB::select(\DB::raw($select_bug1_ticket_list_query));

        $select_bug2_ticket_list_query = "SELECT o.* FROM outage_table o
                                            left join fault_table f
                                            on f.ticket_id = o.ticket_id
                                            where f.ticket_id is null
                                            and o.fault_status = 'open'";
        $bug2_ticket_lists = \DB::select(\DB::raw($select_bug2_ticket_list_query));

        $bugArray = array();
        foreach ($bug1_ticket_lists as $bug1_tt) {
            array_push($bugArray,$bug1_tt->ticket_id);
        }
        foreach ($bug2_ticket_lists as $bug2_tt) {
            array_push($bugArray,$bug2_tt->ticket_id);
        }
        echo "Ticket IDs are: ";
        return $bugArray;
     }
}



// class LoginController extends Controller
// {

//     public function view_login(){
//         return view('login.login_view');
//     }

//     public function authenticate(){

//         $username = Request::get('username');
//         $password = Request::get('password');        


//         $auth_query = "SELECT * FROM login_plugin_db.login_table";
//         $auth_lists = \DB::connection('mysql2')->select(\DB::raw($auth_query));        

//             foreach ($auth_lists as $auth_list) {

                
//                     if($auth_list->user_id==$username && $auth_list->account_status!="blocked"){

//                         if (password_verify($password, $auth_list->user_password)) 
//                         {
                        
//                             $_SESSION['user_id'] = $auth_list->user_id;
//                             $email = $auth_list->email;

//                             $hr_query = "SELECT * FROM hr_tool_db.employee_table where email='$email' AND status='active'";
//                             $hr_lists = \DB::connection('mysql2')->select(\DB::raw($hr_query));

//                             foreach($hr_lists as $hr_list){

//                                 $_SESSION['user_name'] = $hr_list->name;
//                                 $_SESSION['designation'] = $hr_list->designation;
//                                 $_SESSION['department'] = $hr_list->department;
//                                 $_SESSION['email'] = $hr_list->email;
//                                 $_SESSION['phone'] = $hr_list->phone;

//                                 $hr_dept_id_query = "SELECT dept_row_id FROM hr_tool_db.department_table where dept_name='".$_SESSION['department']."'";
//                                 $hr_dept_id_lists = \DB::connection('mysql2')->select(\DB::raw($hr_dept_id_query));
//                                 $_SESSION['dept_id'] = $hr_dept_id_lists[0]->dept_row_id;

                                
//                                 //$request->session()->put('session_user_id',$auth_list->user_id);

//                                 // print_r($_SESSION);

//                                 // exit();

//                             }

//                             return redirect('DashboardTT');
//                         }
//                     }
//             }
            
        

//         return redirect('/');

//     }

//     public function logout(){

//         session_unset();
//         return redirect('/');
//     }
// }