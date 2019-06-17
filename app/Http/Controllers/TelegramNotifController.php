<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramNotifController extends Controller
{
    //

    public function send_notif_test(Request $request){
        //$subcenter = $request->subcenter;
        $ticket_id = $request->ticket_id;

        // $this->send_telegram_notification($subcenter,$ticket_id);

        // echo $subcenter."    ".$ticket_id;
        // return "";

        $this->format_task_msg($ticket_id);
    }

    // public function send_telegram_notification($subcenter,$ticket_id){
    //     $msg = "A task is forwarded to your subcenter with Ticket ID:($ticket_id)";
        
    //     if($subcenter == "CTG_North"){
    //         $subcenter = "Chittagong";
    //     }   
    //     else if($subcenter == "CTG_South"){
    //         $subcenter = "Chittagong";
    //     }
    //     else if($subcenter == "NOC"){
    //         $msg = "A task is forwarded to NOC with Ticket ID:($ticket_id)";
    //     }
    //     else{

    //     }

    //     ////////////////// NOC e telegram pathaite razib bhai mana korse //////////////////
    //     if($subcenter != "NOC"){
    //         $get_chat_id_query = "SELECT * FROM scl_sms_db.`telegram_group_table` WHERE entity_name = '$subcenter'";
    //         $chat_id_data = \DB::connection('mysql5')->select(\DB::raw($get_chat_id_query));
    //         if(count($chat_id_data)>0){
    //             $chat_id = $chat_id_data[0]->chat_id;
    //             $this->send_telegram_msg($msg,$chat_id);
    //         }
    //     }
    // }

    public function send_telegram_notification($subcenter,$task_id){
        ////////////////// NOC e telegram pathaite razib bhai mana korse //////////////////
        if($subcenter != "NOC"){
            $msg = $this->format_task_msg($task_id,$subcenter);
            $get_chat_id_query = "SELECT * FROM scl_sms_db.`telegram_group_table` WHERE entity_name = '$subcenter'";
            $chat_id_data = \DB::connection('mysql5')->select(\DB::raw($get_chat_id_query));
            if(count($chat_id_data)>0){
                $chat_id = $chat_id_data[0]->chat_id;
                $this->send_telegram_msg($msg,$chat_id);
            }
        }
    }

    public function send_telegram_msg($msg,$chat_id){
		$telegram_message = urlencode($msg);

		$postdata = http_build_query(
		    array(
				'msg' => $telegram_message,
				'chat_id' => $chat_id
		    )
		);

		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => $postdata
		    )
		);
		$context  = stream_context_create($opts);
		$result = file_get_contents('http://172.16.136.15:8980/send_telegram/public/api/send_msg_to_group', false, $context);

		return $result;
    }
    
    public function format_task_msg($task_id,$subcenter){
        $query =    "SELECT tt.ticket_title,tt.ticket_id,ft.fault_id,tat.task_id,ft.problem_category,ft.element_type,ft.element_id,lt.link_name_nttn,lt.link_name_gateway,st.site_name,ft.event_time,ct.client_name 
                    FROM phoenix_tt_db.task_table tat 
                    JOIN phoenix_tt_db.fault_table ft ON tat.fault_id = ft.fault_id
                    JOIN phoenix_tt_db.ticket_table tt ON tat.ticket_id = tt.ticket_id
                    JOIN phoenix_tt_db.client_table ct ON ft.client_id = ct.client_id 
                    LEFT JOIN phoenix_tt_db.link_table lt ON ft.element_id = lt.link_name_id
                    LEFT JOIN phoenix_tt_db.site_table st ON ft.element_id = st.site_name_id
                    WHERE tat.task_id = $task_id";

        $task_info = \DB::select(\DB::raw($query));

        if(count($task_info)>0){
            $tt_title = $task_info[0]->ticket_title;
            $ticket_id = $task_info[0]->ticket_id;
            $fault_id = $task_info[0]->fault_id;
            $task_id = $task_info[0]->task_id;
            $problem_category = $task_info[0]->problem_category;
            $element_type = $task_info[0]->element_type;
            $event_time = $task_info[0]->event_time;
            $client_name = $task_info[0]->client_name;
            if($element_type == "link"){
                $element_name = $task_info[0]->link_name_nttn."|".$task_info[0]->link_name_gateway;
            }
            else{
                $element_name = $task_info[0]->site_name;
            }

            $msg =  "Task Notification"."\n"
                    ."A new Task is assigned to your subcenter:$subcenter"."\n"
                    ."TT Title: $tt_title"."\n"
                    ."TT ID: $ticket_id"."\n"
                    ."Fault ID: $fault_id"."\n"
                    ."Task ID: $task_id"."\n"
                    ."Problem Category: $problem_category"."\n"
                    ."Event Time: $event_time"."\n"
                    ."Client: $client_name"."\n"
                    ."Site/Link: $element_name";

            return  $msg;
        }
        else{
            return  "";
        }
    }
}
