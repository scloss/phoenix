<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
//use Request;
use DB;
use Input;

//session_start();

class ServiceController extends Controller
{
    public function csv_export($report_lists){
        

        $fp_report = fopen('../Uploaded_Files/export.csv','w');
        $big_array = array();

        for($i=0;$i<count($report_lists);$i++){
            $small_array =  (array) $report_lists[$i];
            array_push($big_array, $small_array);           
            
        }
        $report_keys =  array_keys($big_array[0]);
        fputcsv($fp_report, (array)$report_keys);
        for($i=0;$i<count($big_array);$i++){
            fputcsv($fp_report, (array)$big_array[$i]);
        }
        
        $path = '../Uploaded_Files/export.csv';
        date_default_timezone_set('Asia/Dhaka');
        $current_time_obj = new DateTime();
        // $current_time = $current_time_obj->format('Y-m-d H:i:s');
        $headers = array(
          'Content-Type: text/csv',
        );
        $filename = 'export.csv';
        $return_arr = array();
        array_push($return_arr, $path);
        array_push($return_arr, $filename);
        array_push($return_arr, $headers);
        return $return_arr;
    }


    public function show_priority(){
        // $link_down_count_query =    "SELECT COUNT(ft.fault_id) 
        //                             FROM `fault_table` ft
        //                             JOIN priority_element_table pet ON pet.element_type = ft.element_type AND pet.element_id = ft.element_id
        //                             WHERE pet.element_type = 'link' and ft.fault_status != 'Closed'";


        // $link_down_count_query =    "SELECT count(link_down_list.fault_id) as 'link_faults'
        //                             FROM
        //                             (SELECT ft1.fault_id 
        //                                 FROM `fault_table` ft1
        //                                 JOIN priority_element_table pet ON pet.element_type = ft1.element_type AND pet.element_id = ft1.element_id
        //                                 JOIN link_table lt ON lt.link_name_id = ft1.element_id
        //                                 JOIN client_table ct ON ft1.client_id = ct.client_id
        //                                 WHERE pet.element_type = 'link' and ft1.fault_status != 'Closed'

        //                                 UNION

        //                                 SELECT ft2.fault_id
        //                                 FROM `fault_table` ft2
        //                                 JOIN priority_client_table pct ON ft2.client_id = pct.client_id AND ft2.element_type = pct.element_type
        //                                 JOIN link_table lt2 ON lt2.link_name_id = ft2.element_id
        //                                 JOIN client_table ct2 ON ft2.client_id = ct2.client_id
        //                                 WHERE ft2.element_type = 'link' AND ft2.fault_status != 'Closed') as link_down_list";

        $link_down_count_query =    "SELECT count(link_down_list.fault_id) as 'link_faults'
                                    FROM
                                    (SELECT ft1.fault_id 
                                        FROM `fault_table` ft1
                                        JOIN priority_element_table pet ON pet.element_type = ft1.element_type AND pet.element_id = ft1.element_id
                                        JOIN link_table lt ON lt.link_name_id = ft1.element_id
                                        JOIN client_table ct ON ft1.client_id = ct.client_id
                                        WHERE pet.element_type = 'link' and ft1.fault_status != 'Closed' and ft1.problem_category = 'Link Down'
                                    ) as link_down_list";

        $link_down_lists = \DB::select(\DB::raw($link_down_count_query));



        $site_down_count_query =   "SELECT count(site_down_list.fault_id) as 'site_faults'
                                    FROM
                                    (
                                        SELECT ft1.fault_id 
                                        FROM `fault_table` ft1
                                        JOIN priority_element_table pet ON pet.element_type = ft1.element_type AND pet.element_id = ft1.element_id
                                        JOIN site_table st ON st.site_name_id = ft1.element_id
                                        JOIN client_table ct ON ft1.client_id = ct.client_id
                                        WHERE pet.element_type = 'site' and ft1.fault_status != 'Closed' and ft1.problem_category = 'Site Down'
                                    ) as site_down_list";

        $site_down_lists = \DB::select(\DB::raw($site_down_count_query));

        $link_other_count_query =    "SELECT count(link_down_list.fault_id) as 'link_faults'
                                    FROM
                                    (SELECT ft1.fault_id 
                                        FROM `fault_table` ft1
                                        JOIN priority_element_table pet ON pet.element_type = ft1.element_type AND pet.element_id = ft1.element_id
                                        JOIN link_table lt ON lt.link_name_id = ft1.element_id
                                        JOIN client_table ct ON ft1.client_id = ct.client_id
                                        WHERE pet.element_type = 'link' and ft1.fault_status != 'Closed' and ft1.problem_category != 'Link Down'
                                    ) as link_down_list";

        $link_other_lists = \DB::select(\DB::raw($link_other_count_query));



        $site_other_count_query =   "SELECT count(site_down_list.fault_id) as 'site_faults'
                                    FROM
                                    (
                                        SELECT ft1.fault_id 
                                        FROM `fault_table` ft1
                                        JOIN priority_element_table pet ON pet.element_type = ft1.element_type AND pet.element_id = ft1.element_id
                                        JOIN site_table st ON st.site_name_id = ft1.element_id
                                        JOIN client_table ct ON ft1.client_id = ct.client_id
                                        WHERE pet.element_type = 'site' and ft1.fault_status != 'Closed' and ft1.problem_category != 'Site Down'
                                    ) as site_down_list";

        $site_other_lists = \DB::select(\DB::raw($site_other_count_query));

        //return $site_down_lists[0]->site_faults; 

        return  view('priority.show_priority',compact('site_down_lists','link_down_lists','site_other_lists','link_other_lists'));
    }

    public function priority_link_down(){

        // $link_down_list_query     =     "SELECT ft1.ticket_id, lt.link_name_nttn,lt.link_name_gateway,ct.client_name,ft1.event_time,(TIMESTAMPDIFF(SECOND,ft1.event_time,now())/3600) as 'duration' 
        //                                 FROM `fault_table` ft1
        //                                 JOIN priority_element_table pet ON pet.element_type = ft1.element_type AND pet.element_id = ft1.element_id
        //                                 JOIN link_table lt ON lt.link_name_id = ft1.element_id
        //                                 JOIN client_table ct ON ft1.client_id = ct.client_id
        //                                 WHERE pet.element_type = 'link' and ft1.fault_status != 'Closed'

        //                                 UNION

        //                                 SELECT ft2.ticket_id, lt2.link_name_nttn,lt2.link_name_gateway,ct2.client_name,ft2.event_time,(TIMESTAMPDIFF(SECOND,ft2.event_time,now())/3600) as 'duration'
        //                                 FROM `fault_table` ft2
        //                                 JOIN priority_client_table pct ON ft2.client_id = pct.client_id AND ft2.element_type = pct.element_type
        //                                 JOIN link_table lt2 ON lt2.link_name_id = ft2.element_id
        //                                 JOIN client_table ct2 ON ft2.client_id = ct2.client_id
        //                                 WHERE ft2.element_type = 'link' AND ft2.fault_status != 'Closed'";


        $link_down_list_query     =     "SELECT ft1.ticket_id,ft1.problem_category,lt.link_name_nttn,lt.link_name_gateway,lt.capacity_nttn,ct.client_name,ft1.event_time,(TIMESTAMPDIFF(SECOND,ft1.event_time,now())/3600) as 'duration',pet.remark 
                                        FROM `fault_table` ft1
                                        JOIN priority_element_table pet ON pet.element_type = ft1.element_type AND pet.element_id = ft1.element_id
                                        JOIN link_table lt ON lt.link_name_id = ft1.element_id
                                        JOIN client_table ct ON ft1.client_id = ct.client_id
                                        WHERE pet.element_type = 'link' and ft1.fault_status != 'Closed' and ft1.problem_category = 'Link Down'
                                        ORDER BY event_time DESC";

        // $link_down_list_query     =     "SELECT ft.ticket_id, ct.client_name,
        //                                 (CASE
        //                                     WHEN (lt.link_name_nttn = 'NA' OR lt.link_name_nttn = 'N/A')
        //                                     THEN (SELECT LT.link_name_gateway FROM phoenix_tt_db.link_table LT WHERE LT.link_name_id = FT.element_id)
        //                                     ELSE (SELECT LT.link_name_nttn FROM phoenix_tt_db.link_table LT WHERE LT.link_name_id = FT.element_id)
        //                                     END
        //                                 )
        //                                 as 'link_name',
        //                                 (TIMESTAMPDIFF(SECOND,ft.event_time,now())/3600) as 'duration'   
        //                                 FROM `fault_table` ft
        //                                 JOIN priority_link_table plt ON ft.element_id = plt.link_name_id
        //                                 JOIN link_table lt ON lt.link_name_id = plt.link_name_id
        //                                 JOIN client_table ct ON ft.client_id = ct.client_id
        //                                 WHERE fault_status != 'Closed'";
        
        $link_down_lists = \DB::select(\DB::raw($link_down_list_query));

        return view('priority.priority_link_down' ,compact('link_down_lists'));
    }
    public function priority_site_down(){
        $site_down_list_query     =     "SELECT ft1.ticket_id, st.site_name,ct.client_name,ft1.event_time,(TIMESTAMPDIFF(SECOND,ft1.event_time,now())/3600) as 'duration',pet.remark 
                                        FROM `fault_table` ft1
                                        JOIN priority_element_table pet ON pet.element_type = ft1.element_type AND pet.element_id = ft1.element_id
                                        JOIN site_table st ON st.site_name_id = ft1.element_id
                                        JOIN client_table ct ON ft1.client_id = ct.client_id
                                        WHERE pet.element_type = 'site' and ft1.fault_status != 'Closed' and ft1.problem_category = 'Site Down'
                                        ORDER BY event_time DESC";



        $site_down_lists = \DB::select(\DB::raw($site_down_list_query));


       return view('priority.priority_site_down' ,compact('site_down_lists'));
    }

    public function priority_site_other(){
        $site_other_list_query     =     "SELECT ft1.ticket_id, st.site_name,ct.client_name,ft1.event_time,(TIMESTAMPDIFF(SECOND,ft1.event_time,now())/3600) as 'duration',pet.remark 
                                        FROM `fault_table` ft1
                                        JOIN priority_element_table pet ON pet.element_type = ft1.element_type AND pet.element_id = ft1.element_id
                                        JOIN site_table st ON st.site_name_id = ft1.element_id
                                        JOIN client_table ct ON ft1.client_id = ct.client_id
                                        WHERE pet.element_type = 'site' and ft1.fault_status != 'Closed' and ft1.problem_category != 'Site Down'
                                        ORDER BY event_time DESC";



        $site_other_lists = \DB::select(\DB::raw($site_other_list_query));


       return view('priority.priority_site_other' ,compact('site_other_lists'));
    }

    public function priority_link_other(){
        $link_other_list_query     =     "SELECT ft1.ticket_id,ft1.problem_category, lt.link_name_nttn,lt.link_name_gateway,lt.capacity_nttn,ct.client_name,ft1.event_time,(TIMESTAMPDIFF(SECOND,ft1.event_time,now())/3600) as 'duration',pet.remark 
                                        FROM `fault_table` ft1
                                        JOIN priority_element_table pet ON pet.element_type = ft1.element_type AND pet.element_id = ft1.element_id
                                        JOIN link_table lt ON lt.link_name_id = ft1.element_id
                                        JOIN client_table ct ON ft1.client_id = ct.client_id
                                        WHERE pet.element_type = 'link' and ft1.fault_status != 'Closed' and ft1.problem_category != 'Link Down'
                                        ORDER BY event_time DESC";



        $link_other_lists = \DB::select(\DB::raw($link_other_list_query));

       return view('priority.priority_link_other' ,compact('link_other_lists'));
    }

    public function get_link_list_json(){
        $element_list_query =   "SELECT link_table.link_name_id,link_table.link_name_nttn,link_table.link_name_gateway,link_table.client,link_table.vlan_id,link_table.link_id,link_table.district,link_table.region,link_table.sms_group,link_table.vendor,link_table.sub_center_primary,client_table.client_name
                                FROM phoenix_tt_db.link_table
                                JOIN phoenix_tt_db.client_table ON client_table.client_id = link_table.client  
                                where link_table.flag !='Disabled'";
        $element_lists = \DB::select(\DB::raw($element_list_query));
        $response = json_encode(array("records"=>$element_lists));
        return $response;
        //echo json_encode(array("records"=>$element_lists));
    }

    public function get_site_list_json(){
        $element_list_query =   "SELECT site_table.site_name_id,site_table.site_name,site_table.client,site_table.site_ip_address,site_table.district,site_table.region,site_table.sms_group,site_table.vendor,site_table.sub_center,client_table.client_name 
                                FROM phoenix_tt_db.site_table 
                                JOIN phoenix_tt_db.client_table ON client_table.client_id = site_table.client  
                                where site_table.flag !='Disabled'";
        $element_lists = \DB::select(\DB::raw($element_list_query));
        $response = json_encode(array("records"=>$element_lists));
        return $response;
        //echo json_encode(array("records"=>$element_lists));
    }

    public function get_link_list_api(Request $request){
        $element_name = urldecode($request->element_name);
        $link_id = urldecode($request->link_id);
        $district = urldecode($request->district);
        $region = urldecode($request->region);
        $subcenter = urldecode($request->subcenter);
        $client = urldecode($request->client);


        $where_clause = "";
        $where__clause_array = array();
        $search_key = "";
        if($element_name != ""){
            array_push($where__clause_array, " link_table.link_name_nttn like '%$element_name%' OR link_table.link_name_gateway like '%$element_name%' ");
            $search_key = "true";
        }
        if($link_id != ""){
            array_push($where__clause_array, " link_table.link_id like '%$link_id%' ");
            $search_key = "true";
        }
        if($district != ""){
            array_push($where__clause_array, " link_table.district like '%$district%' ");
            $search_key = "true";
        }
        if($region != ""){
            array_push($where__clause_array, " link_table.region like '%$region%' ");
            $search_key = "true";
        }
        if($subcenter != ""){
            array_push($where__clause_array, " link_table.sub_center_primary like '%$subcenter%' OR link_table.sub_center_secondary like '%$subcenter%'");
            $search_key = "true";
        }
        if($client != ""){
            array_push($where__clause_array, " link_table.client = '$client' ");
            $search_key = "true";
        }

        $where_clause = implode(" AND ",$where__clause_array);

        $element_list_query =   "SELECT link_table.link_name_id,link_table.link_name_nttn,link_table.link_name_gateway,link_table.client,link_table.vlan_id,link_table.link_id,link_table.district,link_table.region,link_table.sms_group,link_table.vendor,link_table.sub_center_primary,client_table.client_name
                                FROM phoenix_tt_db.link_table
                                JOIN phoenix_tt_db.client_table ON client_table.client_id = link_table.client  
                                where link_table.flag !='Disabled'";
        if($search_key != ""){
            $element_list_query .= " AND ($where_clause)";
        }
        else{
            $element_list_query .= " LIMIT 10";
        }

        //return $element_list_query;
        $element_lists = \DB::select(\DB::raw($element_list_query));
        $response_array = array();

        foreach($element_lists as $element){
            $row = array();
            $row["link_name_id"] = $element->link_name_id;
            $row["link_name_nttn"] = $element->link_name_nttn;
            $row["link_name_gateway"] = $element->link_name_gateway;
            $row["client"] = $element->client;
            $row["vlan_id"] = $element->vlan_id;
            $row["link_id"] = $element->link_id;
            $row["district"] = $element->district;
            $row["region"] = $element->region;
            $row["sms_group"] = $element->sms_group;
            $row["vendor"] = $element->vendor;
            $row["sub_center_primary"] = $element->sub_center_primary;
            $row["client_name"] = $element->client_name;
            array_push($response_array,$row);
        }
        $response = json_encode($response_array);
        return $response;
    }

    public function get_site_list_api(Request $request){
        //$search_key = $request->search_key;
        //return $search_key;
        $element_name = urldecode($request->element_name);
        $ip_address = urldecode($request->ip_address);
        $district = urldecode($request->district);
        $region = urldecode($request->region);
        $subcenter = urldecode($request->subcenter);
        $client = urldecode($request->client);

        $where_clause = "";
        $where__clause_array = array();
        $search_key = "";
        if($element_name != ""){
            array_push($where__clause_array, " site_table.site_name like '%$element_name%' ");
            $search_key = "true";
        }
        if($ip_address != ""){
            array_push($where__clause_array, " site_table.site_ip_address like '%$ip_address%' ");
            $search_key = "true";
        }
        if($district != ""){
            array_push($where__clause_array, " site_table.district like '%$district%' ");
            $search_key = "true";
        }
        if($region != ""){
            array_push($where__clause_array, " site_table.region like '%$region%' ");
            $search_key = "true";
        }
        if($subcenter != ""){
            array_push($where__clause_array, " site_table.sub_center like '%$subcenter%' ");
            $search_key = "true";
        }
        if($client != ""){
            array_push($where__clause_array, " site_table.client = '$client' ");
            $search_key = "true";
        }

        $where_clause = implode(" AND ",$where__clause_array);

        $element_list_query =   "SELECT site_table.site_name_id,site_table.site_name,site_table.client,site_table.site_ip_address,site_table.district,site_table.region,site_table.sms_group,site_table.vendor,site_table.sub_center,client_table.client_name 
                                FROM phoenix_tt_db.site_table 
                                JOIN phoenix_tt_db.client_table ON client_table.client_id = site_table.client  
                                where site_table.flag !='Disabled'";
        
        if($search_key != ""){
            $element_list_query .= " AND ($where_clause)";
        }
        else{
            $element_list_query .= " LIMIT 10";
        }

        //return $element_list_query;
        $element_lists = \DB::select(\DB::raw($element_list_query));
        $response_array = array();

        foreach($element_lists as $element){
            $row = array();
            $row["site_name_id"] = $element->site_name_id;
            $row["site_name"] = $element->site_name;
            $row["client"] = $element->client;
            $row["site_ip_address"] = $element->site_ip_address;
            $row["district"] = $element->district;
            $row["region"] = $element->region;
            $row["sms_group"] = $element->sms_group;
            $row["vendor"] = $element->vendor;
            $row["sub_center"] = $element->sub_center;
            $row["client_name"] = $element->client_name;
            array_push($response_array,$row);
        }
        $response = json_encode($response_array);
        return $response;
    }
    
    
    public function get_link_info(Request $request){
        $link_name_id = $request->link_name_id;
        $element_list_query =   "SELECT link_table.link_name_id,link_table.link_name_nttn,link_table.link_name_gateway,link_table.client,link_table.vlan_id,link_table.link_id,link_table.district,link_table.region,link_table.sms_group,link_table.vendor,link_table.sub_center_primary,client_table.client_name
                                FROM phoenix_tt_db.link_table
                                JOIN phoenix_tt_db.client_table ON client_table.client_id = link_table.client  
                                where link_table.flag !='Disabled' AND link_table.link_name_id = $link_name_id";

        $element_lists = \DB::select(\DB::raw($element_list_query));
        $response_array = array();

        foreach($element_lists as $element){
            $row = array();
            $row["link_name_id"] = $element->link_name_id;
            $row["link_name_nttn"] = $element->link_name_nttn;
            $row["link_name_gateway"] = $element->link_name_gateway;
            $row["client"] = $element->client;
            $row["vlan_id"] = $element->vlan_id;
            $row["link_id"] = $element->link_id;
            $row["district"] = $element->district;
            $row["region"] = $element->region;
            $row["sms_group"] = $element->sms_group;
            $row["vendor"] = $element->vendor;
            $row["sub_center_primary"] = $element->sub_center_primary;
            $row["client_name"] = $element->client_name;
            array_push($response_array,$row);
        }
        $response = json_encode($response_array);
        return $response;
    }


    public function get_site_info(Request $request){
        $site_name_id = $request->site_name_id;
        //return $search_key;
        $element_list_query =   "SELECT site_table.site_name_id,site_table.site_name,site_table.client,site_table.site_ip_address,site_table.district,site_table.region,site_table.sms_group,site_table.vendor,site_table.sub_center,client_table.client_name 
                                FROM phoenix_tt_db.site_table 
                                JOIN phoenix_tt_db.client_table ON client_table.client_id = site_table.client  
                                where site_table.flag !='Disabled' AND site_table.site_name_id = $site_name_id";
        
        $element_lists = \DB::select(\DB::raw($element_list_query));
        $response_array = array();

        foreach($element_lists as $element){
            $row = array();
            $row["site_name_id"] = $element->site_name_id;
            $row["site_name"] = $element->site_name;
            $row["client"] = $element->client;
            $row["site_ip_address"] = $element->site_ip_address;
            $row["district"] = $element->district;
            $row["region"] = $element->region;
            $row["sms_group"] = $element->sms_group;
            $row["vendor"] = $element->vendor;
            $row["sub_center"] = $element->sub_center;
            $row["client_name"] = $element->client_name;
            array_push($response_array,$row);
        }
        $response = json_encode($response_array);
        return $response;
    }

    public function get_district_list(){
        $query = "SELECT * FROM phoenix_tt_db.district_table";
        $district_lists = \DB::select(\DB::raw($query));
        $response_array = array();

        foreach($district_lists as $element){
            $row = array();
            $row["district_row_id"] = $element->district_row_id;
            $row["district_name"] = $element->district_name;
            array_push($response_array,$row);
        }
        $response = json_encode($response_array);
        return $response;
    }

    public function get_subcenter_list(){
        $query = "SELECT * FROM phoenix_tt_db.subcenter_table";
        $subcenter_list = \DB::select(\DB::raw($query));
        $response_array = array();

        foreach($subcenter_list as $element){
            $row = array();
            $row["row_id"] = $element->row_id;
            $row["subcenter_name"] = $element->subcenter_name;
            array_push($response_array,$row);
        }
        $response = json_encode($response_array);
        return $response;
    }

    public function get_client_list(){
        $query = "SELECT * FROM phoenix_tt_db.client_table ORDER BY client_name";
        $client_list = \DB::select(\DB::raw($query));
        $response_array = array();

        foreach($client_list as $element){
            $row = array();
            $row["client_id"] = $element->client_id;
            $row["client_name"] = $element->client_name;
            array_push($response_array,$row);
        }
        $response = json_encode($response_array);
        return $response;
    }
}
