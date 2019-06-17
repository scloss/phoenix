<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\ServiceController;
use Request;
use Input;
use DB;

class LinkController extends Controller
{

    public function create_link(){

    	$client_select_query = "SELECT * FROM phoenix_tt_db.client_table where flag!='Disabled' ORDER BY client_name";
    	$client_lists = \DB::select(\DB::raw($client_select_query));

    	$district_select_query = "SELECT * FROM phoenix_tt_db.`district_table` ORDER BY `district_name`";
    	$district_lists = \DB::select(\DB::raw($district_select_query));

        $vendor_list_query = "SELECT * FROM phoenix_tt_db.vendor ORDER BY `vendor_name`";
        $vendor_lists = \DB::select(\DB::raw($vendor_list_query));

        //print_r($vendor_lists);


        $link_id ="";
        $client ="";
        $vlan_id ="";
        $link_category ="";
        $link_conn_type ="";
        $region ="";
        $district ="";
        $sms_group ="";
        $vendor ="";
        $client_owner ="";
        $service_type_nttn ="";
        $service_type_gateway ="";
        $link_name_nttn ="";
        $link_name_gateway ="";
        $redundancy ="";
        $service_impact ="";
        $capacity_nttn ="";
        $capacity_gateway ="";
        $last_mile_provided_by ="";
        $last_mile_link_id ="";
        $subcenter_primary ="";
        $subcenter_secondary ="";
        $metro ="";
        $lh ="";
        $dark_core ="";
        $mobile_backhaul ="";

        $user_msg = "";
        $telegram_group = "";
        $uni_nni = "";


    	//return view('link.create_link',compact('client_lists','district_lists','vendor_lists'));

        return view('link.create_link',compact('client_lists','district_lists','vendor_lists','link_id','client','vlan_id','link_category','link_conn_type','district','region','sms_group','vendor',
            'client_owner','service_type_nttn','service_type_gateway','link_name_nttn','link_name_gateway','redundancy','service_impact','capacity_nttn','capacity_gateway','last_mile_provided_by','last_mile_link_id',
            'subcenter_primary','subcenter_secondary','metro','lh','dark_core','mobile_backhaul','user_msg','telegram_group','uni_nni'));



    }

    public function sms_group_api(){


    	$result = array();

    	$sms_group_select_query = "SELECT * FROM scl_sms_db.group_table";
    	$sms_group_lists = \DB::connection('mysql5')->select(\DB::raw($sms_group_select_query));//\DB::select(\DB::raw($sms_group_select_query));

    	foreach($sms_group_lists as $sms_group_list){


         array_push($result,
             array('group_row_id'=>$sms_group_list->group_row_id,
                 'group_name'=>$sms_group_list->group_name
             ));
     }

     echo json_encode(array("sms_group"=>$result));


 }

 public function telegram_group_api(){


    $result = array();

    $telegram_group_select_query = "SELECT * FROM scl_sms_db.telegram_group_table";
    $telegram_group_lists = \DB::connection('mysql5')->select(\DB::raw($telegram_group_select_query));//\DB::select(\DB::raw($sms_group_select_query));

    foreach($telegram_group_lists as $telegram_group_list){


     array_push($result,
         array('id'=>$telegram_group_list->id,
             'group_name'=>$telegram_group_list->group_name
         ));
 }

 echo json_encode(array("telegram_group"=>$result));


}


 public function insert_link(){

        // $client = Request::get('client');
        // $link_name = Request::get('link_name');
        // $vlan_id = Request::get('vlan_id');
        // $capacity = Request::get('capacity');
        // $link_conn_type = Request::get('link_conn_type');
        // $link_id = Request::get('link_id');

    $link_id =addslashes( Request::get('link_id'));
    $client =addslashes( Request::get('client'));
    $vlan_id =addslashes( Request::get('vlan_id'));
    $link_category =addslashes( Request::get('link_category'));
    $link_conn_type =addslashes( Request::get('link_conn_type'));
    $region =addslashes( Request::get('region'));
    $district =addslashes( Request::get('district'));
    $sms_group =addslashes( Request::get('sms_group'));
    $vendor =addslashes( Request::get('vendor'));
    $client_owner =addslashes( Request::get('client_owner'));
    $service_type_nttn =addslashes( Request::get('service_type_nttn'));
    $service_type_gateway =addslashes( Request::get('service_type_gateway'));
    $link_name_nttn =addslashes( Request::get('link_name_nttn'));
    $link_name_gateway =addslashes( Request::get('link_name_gateway'));
    $redundancy =addslashes( Request::get('redundancy'));
    $service_impact =addslashes(  Request::get('service_impact'));
    $capacity_nttn =addslashes(  Request::get('capacity_nttn'));
    $capacity_gateway =addslashes(  Request::get('capacity_gateway'));
    $last_mile_provided_by =addslashes( Request::get('last_mile_provided_by'));
    $last_mile_link_id =addslashes( Request::get('last_mile_link_id'));
    $subcenter_primary =addslashes( Request::get('sub_center_primary'));
    $subcenter_secondary =addslashes( Request::get('sub_center_secondary'));
    $metro =addslashes( Request::get('metro'));
    $lh =addslashes( Request::get('lh'));
    $dark_core =addslashes( Request::get('dark_core'));
    $mobile_backhaul =addslashes( Request::get('mobile_backhaul'));
    $telegram_group =addslashes( Request::get('telegram_group'));
    $uni_nni =addslashes( Request::get('uni_nni'));
    //$flag =addslashes( Request::get('flag'));

    

        // $link_insert_query = "INSERT INTO phoenix_tt_db.link_table (client,link_name,vlan_id,Capacity,link_conn_type,link_id,region,district,sms_group,vendor) VALUES ('$client','$link_name','$vlan_id','$capacity','$link_conn_type','$link_id','$region','$district','$sms_group','$vendor')";

    // $link_insert_query = "INSERT INTO phoenix_tt_db.link_table (client, link_id, vlan_id, link_category, link_conn_type, district, region, sms_group, vendor, client_owner, service_type_nttn, service_type_gateway, link_name_nttn, link_name_gateway, redundancy, service_impact, capacity_nttn, capacity_gateway, last_mile_provided_by, last_mile_link_id, sub_center_primary, sub_center_secondary, metro, LH, dark_core, mobile_backhaul) VALUES ('$client','$link_id','$vlan_id','$link_category','$link_conn_type','$district','$region','$sms_group','$vendor','$client_owner','$service_type_nttn','$service_type_gateway','$link_name_nttn','$link_name_gateway','$redundancy','$service_impact','$capacity_nttn','$capacity_gateway','$last_mile_provided_by','$last_mile_link_id','$subcenter_primary','$subcenter_secondary','$metro','$lh','$dark_core','$mobile_backhaul')";


    //     //echo $link_insert_query;

    // \DB::insert(\DB::raw($link_insert_query));



    // Insert Link
    $new_link_id = DB::table('link_table')->insertGetId(
        [ 
            'client'=>$client,
            'link_id'=>$link_id,
            'vlan_id'=>$vlan_id,
            'link_category'=>$link_category,
            'link_conn_type'=>$link_conn_type,
            'district'=>$district,
            'region'=>$region,
            'sms_group'=>$sms_group,
            'vendor'=>$vendor,
            'client_owner'=>$client_owner,
            'service_type_nttn'=>$service_type_nttn,
            'service_type_gateway'=>$service_type_gateway,
            'link_name_nttn'=>$link_name_nttn,
            'link_name_gateway'=>$link_name_gateway,
            'redundancy'=>$redundancy,
            'service_impact'=>$service_impact,
            'capacity_nttn'=>$capacity_nttn,
            'capacity_gateway'=>$capacity_gateway,
            'last_mile_provided_by'=>$last_mile_provided_by,
            'last_mile_link_id'=>$last_mile_link_id,
            'sub_center_primary'=>$subcenter_primary,
            'sub_center_secondary'=>$subcenter_secondary,
            'metro'=>$metro,
            'LH'=>$lh,
            'dark_core'=>$dark_core,
            'mobile_backhaul'=>$mobile_backhaul,
            'telegram_group'=>$telegram_group,
            'uni_nni'=>$uni_nni
        ]
        );
    // Insert History

    date_default_timezone_set('Asia/Dhaka');
    $time = date('Y-m-d hh:mm:ss');
    $user_id = $_SESSION['user_id'];
    $comment = "New Link Inserted";
    
    $insert_link_chage_history = DB::table('link_history_table')->insertGetId(
        [ 
            'link_name_id'=>$new_link_id,
            'client'=>$client,
            'link_id'=>$link_id,
            'vlan_id'=>$vlan_id,
            'link_category'=>$link_category,
            'link_conn_type'=>$link_conn_type,
            'district'=>$district,
            'region'=>$region,
            'sms_group'=>$sms_group,
            'vendor'=>$vendor,
            'client_owner'=>$client_owner,
            'service_type_nttn'=>$service_type_nttn,
            'service_type_gateway'=>$service_type_gateway,
            'link_name_nttn'=>$link_name_nttn,
            'link_name_gateway'=>$link_name_gateway,
            'redundancy'=>$redundancy,
            'service_impact'=>$service_impact,
            'capacity_nttn'=>$capacity_nttn,
            'capacity_gateway'=>$capacity_gateway,
            'last_mile_provided_by'=>$last_mile_provided_by,
            'last_mile_link_id'=>$last_mile_link_id,
            'sub_center_primary'=>$subcenter_primary,
            'sub_center_secondary'=>$subcenter_secondary,
            'metro'=>$metro,
            'LH'=>$lh,
            'dark_core'=>$dark_core,
            'mobile_backhaul'=>$mobile_backhaul,
            'update_time'=> $time,
            'telegram_group'=>$telegram_group,
            'uni_nni'=>$uni_nni,
            'flag'=>'Pending',
            'update_by' => $user_id,
            'comment' => $comment
        ]
        );


    //show create link page

     $client_select_query = "SELECT * FROM phoenix_tt_db.client_table where flag!='Disabled' ORDER BY client_name";
     $client_lists = \DB::select(\DB::raw($client_select_query));

     $district_select_query = "SELECT * FROM phoenix_tt_db.`district_table` ORDER BY `district_name`";
     $district_lists = \DB::select(\DB::raw($district_select_query));

     $vendor_list_query = "SELECT * FROM phoenix_tt_db.vendor ORDER BY `vendor_name`";
     $vendor_lists = \DB::select(\DB::raw($vendor_list_query));

     $user_msg = "Successfully Saved";

     return view('link.create_link',compact('client_lists','district_lists','vendor_lists','link_id','client','vlan_id','link_category','link_conn_type','district','region','sms_group','vendor',
         'client_owner','service_type_nttn','service_type_gateway','link_name_nttn','link_name_gateway','redundancy','service_impact','capacity_nttn','capacity_gateway','last_mile_provided_by','last_mile_link_id',
         'subcenter_primary','subcenter_secondary','metro','lh','dark_core','mobile_backhaul','user_msg','telegram_group','uni_nni'));
    //return redirect('view_link');
}

public function view_link(){

    // $client = Request::get('client');
    // $link_name = Request::get('link_name');
    // $vlan_id = Request::get('vlan_id');
    // $capacity = Request::get('capacity');
    // $link_conn_type = Request::get('link_conn_type');
    // $link_id = Request::get('link_id');
    // $region = Request::get('region');
    // $district = Request::get('district');
    // $vendor = Request::get('vendor');

    $link_id =addslashes( Request::get('link_id'));
    $client =addslashes( Request::get('client'));
    $vlan_id =addslashes( Request::get('vlan_id'));
    $link_category =addslashes( Request::get('link_category'));
    $link_conn_type =addslashes( Request::get('link_conn_type'));
    $district =addslashes( Request::get('district'));
    
    $region =addslashes( Request::get('region'));
    $sms_group =addslashes( Request::get('sms_group'));
    $vendor =addslashes( Request::get('vendor'));
    $client_owner =addslashes( Request::get('client_owner'));
    $service_type_nttn =addslashes( Request::get('service_type_nttn'));
    $service_type_gateway =addslashes( Request::get('service_type_gateway'));
    $link_name_nttn =addslashes( Request::get('link_name_nttn'));
    $link_name_gateway =addslashes( Request::get('link_name_gateway'));
    $redundancy =addslashes( Request::get('redundancy'));
    $service_impact =addslashes(  Request::get('service_impact'));
    $capacity_nttn =addslashes(  Request::get('capacity_nttn'));
    $capacity_gateway =addslashes(  Request::get('capacity_gateway'));
    $last_mile_provided_by =addslashes( Request::get('last_mile_provided_by'));
    $last_mile_link_id =addslashes( Request::get('last_mile_link_id'));
    $sub_center_primary =addslashes( Request::get('sub_center_primary'));
    $sub_center_secondary =addslashes( Request::get('sub_center_secondary'));
    $metro =addslashes( Request::get('metro'));
    $lh =addslashes( Request::get('lh'));
    $dark_core =addslashes( Request::get('dark_core'));
    $mobile_backhaul =addslashes( Request::get('mobile_backhaul'));

     $formType = Request::get('formType'); 

    $whereQuery = "";
    if($link_id){

        $whereQuery.= "link_id like '%$link_id%' AND ";

    }

    if($client){

        $whereQuery.= "client = '$client' AND ";

    }
    // if($link_name){

    //     $whereQuery.= "link_name like '%$link_name%' AND ";

    // }
    if($vlan_id){

        $whereQuery.= "vlan_id like '%$vlan_id%' AND ";

    }

    if($link_category){

        $whereQuery.= "link_category like '%$link_category%' AND ";

    }
    // if($capacity){

    //     $whereQuery.= "Capacity like '%$capacity%' AND ";

    // }
    if($link_conn_type){

        $whereQuery.= "link_conn_type like '%$link_conn_type%' AND ";

    }

    if($district){

        $whereQuery.= "district like '%$district%' AND ";

    }

    if($region){

        $whereQuery.= "region like '%$region%' AND ";

    }
    

    if($vendor){

        $whereQuery.= "vendor like '%$vendor%' AND ";

    }

    if($client_owner){

        $whereQuery.= "client_owner like '%$client_owner%' AND ";

    }
    if($service_type_nttn){

        $whereQuery.= "service_type_nttn like '%$service_type_nttn%' AND ";

    }

    if($service_type_gateway){

        $whereQuery.= "service_type_gateway like '%$service_type_gateway%' AND ";

    }
    if($link_name_nttn){

        $whereQuery.= "link_name_nttn like '%$link_name_nttn%' AND ";

    }
    if($link_name_gateway){

        $whereQuery.= "link_name_gateway like '%$link_name_gateway%' AND ";

    }
    if($redundancy){

        $whereQuery.= "redundancy like '%$redundancy%' AND ";

    }
    if($service_impact){

        $whereQuery.= "service_impact like '%$service_impact%' AND ";

    }
    if($capacity_nttn){

        $whereQuery.= "capacity_nttn like '%$capacity_nttn%' AND ";

    }
    if($capacity_gateway){

        $whereQuery.= "capacity_gateway like '%$capacity_gateway%' AND ";

    }
    if($last_mile_provided_by){

        $whereQuery.= "last_mile_provided_by like '%$last_mile_provided_by%' AND ";

    }
    if($last_mile_link_id){

        $whereQuery.= "last_mile_link_id like '%$last_mile_link_id%' AND ";

    }
    if($sub_center_primary){

        $whereQuery.= "sub_center_primary like '%$sub_center_primary%' AND ";

    }
    if($sub_center_secondary){

        $whereQuery.= "sub_center_secondary like '%$sub_center_secondary%' AND ";

    }
    if($metro){

        $whereQuery.= "metro like '%$metro%' AND ";

    }
    if($lh){

        $whereQuery.= "lh like '%$lh%' AND ";

    }
    if($dark_core){

        $whereQuery.= "dark_core like '%$dark_core%' AND ";

    }
    if($mobile_backhaul){

        $whereQuery.= "mobile_backhaul like '%$mobile_backhaul%' AND ";

    }





    if($whereQuery==""){

        $link_lists = DB::table('phoenix_tt_db.link_table')
        ->selectRaw('phoenix_tt_db.link_table.*')
        ->whereRaw("link_name_id<0")
        ->paginate(20);
    }

    else{

        $whereQuery .= "phoenix_tt_db.link_table.flag!='Disabled'";
        $link_lists = DB::table('phoenix_tt_db.link_table')
        ->selectRaw('phoenix_tt_db.link_table.*')
        ->whereRaw("$whereQuery")
        ->paginate(20);

    }

    //print_r($link_lists);

    $client_select_query = "SELECT * FROM phoenix_tt_db.client_table where flag!='Disabled' ORDER BY client_name";
    $client_lists = \DB::select(\DB::raw($client_select_query));

    $district_select_query = "SELECT * FROM phoenix_tt_db.`district_table` ORDER BY `district_name`";
    $district_lists = \DB::select(\DB::raw($district_select_query));

    $vendor_list_query = "SELECT * FROM phoenix_tt_db.vendor ORDER BY `vendor_name`";
    $vendor_lists = \DB::select(\DB::raw($vendor_list_query));

    if($formType == "Export"){

            // $site_list_query = "SELECT ct.client_name,st.site_name,st.mw_site_name,st.site_ip_address,st.site_type,st.region,st.district,st.sms_group,st.vendor,st.site_node_address,st.device_type,st.device_vendor,st.device_model,st.upazilla,st.sub_center FROM site_table st INNER JOIN client_table ct ON st.client=ct.client_id where ".$whereQuery;
            // //dd($site_list_query);
            $link_lists_full = DB::table('phoenix_tt_db.link_table')
            ->join('phoenix_tt_db.client_table', 'phoenix_tt_db.client_table.client_id', '=', 'phoenix_tt_db.link_table.client')
            ->selectRaw('phoenix_tt_db.link_table.*,phoenix_tt_db.client_table.client_name')
            ->whereRaw("$whereQuery")
            ->get();

            //$site_lists = \DB::select(\DB::raw($site_list_query));



            // //$site_lists =
            $service_controller = New ServiceController();
            $return_arr = $service_controller->csv_export($link_lists_full);
            return response()->download($return_arr[0], $return_arr[1],$return_arr[2]);

        }

                   

    return view('link.view_link',compact('link_lists','client_lists','district_lists','vendor_lists','link_id','client','vlan_id','link_category','link_conn_type','district','region','sms_group','vendor','client_owner','service_type_nttn','service_type_gateway','link_name_nttn','link_name_gateway','redundancy','service_impact','capacity_nttn','capacity_gateway','last_mile_provided_by','last_mile_link_id','sub_center_primary','sub_center_secondary','metro','lh','dark_core','mobile_backhaul'));
}




public function sms_group_view(){


   return view('link.sms_group_list');
}

public function telegram_group_view(){


    return view('link.telegram_group_list');
 }

public function delete_link(){

    $link_name_id = Request::get('link_name_id');

    $link_update_query = "UPDATE phoenix_tt_db.link_table SET flag='Disabled' WHERE link_name_id='$link_name_id'";
    \DB::update(\DB::raw($link_update_query));


    // ****************** Get database Value *******************************
    $link_info_query = "SELECT * FROM phoenix_tt_db.link_table WHERE link_name_id = $link_name_id";
    $link_info = \DB::select(\DB::raw($link_info_query));

    $old_link_id =$link_info[0]->link_id ;
    $old_client =$link_info[0]->client ;
    $old_vlan_id =$link_info[0]->vlan_id ;
    $old_link_category =$link_info[0]->link_category ;
    $old_link_conn_type =$link_info[0]->link_conn_type ;
    $old_district =$link_info[0]->district ;
    $old_region =$link_info[0]->region ;
    $old_sms_group =$link_info[0]->sms_group ;
    $old_vendor =$link_info[0]->vendor ;
    $old_client_owner =$link_info[0]->client_owner ;
    $old_service_type_nttn =$link_info[0]->service_type_nttn ;
    $old_service_type_gateway =$link_info[0]->service_type_gateway ;
    $old_link_name_nttn =$link_info[0]->link_name_nttn ;
    $old_link_name_gateway =$link_info[0]->link_name_gateway ;
    $old_redundancy =$link_info[0]->redundancy ;
    $old_service_impact =$link_info[0]->service_impact ;
    $old_capacity_nttn =$link_info[0]->capacity_nttn ;
    $old_capacity_gateway =$link_info[0]->capacity_gateway ;
    $old_last_mile_provided_by =$link_info[0]->last_mile_provided_by ;
    $old_last_mile_link_id =$link_info[0]->last_mile_link_id ;
    $old_sub_center_primary =$link_info[0]->sub_center_primary ;
    $old_sub_center_secondary =$link_info[0]->sub_center_secondary ;
    $old_metro =$link_info[0]->metro ;
    $old_lh =$link_info[0]->LH ;
    $old_dark_core =$link_info[0]->dark_core ;
    $old_mobile_backhaul =$link_info[0]->mobile_backhaul ;
    $old_telegram_group =$link_info[0]->telegram_group ;
    $old_uni_nni =$link_info[0]->uni_nni ;
    $old_flag =$link_info[0]->flag ;
    $old_update_time =$link_info[0]->update_time;

    $user_id = $_SESSION['user_id'];
    $comment = "Delete";

    // ****************** Insert into history table *************************

    $insert_link_chage_history = DB::table('link_history_table')->insertGetId(
        [ 
            'link_name_id'=>$link_name_id,
            'client'=>$old_client,
            'link_id'=>$old_link_id,
            'vlan_id'=>$old_vlan_id,
            'link_category'=>$old_link_category,
            'link_conn_type'=>$old_link_conn_type,
            'district'=>$old_district,
            'region'=>$old_region,
            'sms_group'=>$old_sms_group,
            'vendor'=>$old_vendor,
            'client_owner'=>$old_client_owner,
            'service_type_nttn'=>$old_service_type_nttn,
            'service_type_gateway'=>$old_service_type_gateway,
            'link_name_nttn'=>$old_link_name_nttn,
            'link_name_gateway'=>$old_link_name_gateway,
            'redundancy'=>$old_redundancy,
            'service_impact'=>$old_service_impact,
            'capacity_nttn'=>$old_capacity_nttn,
            'capacity_gateway'=>$old_capacity_gateway,
            'last_mile_provided_by'=>$old_last_mile_provided_by,
            'last_mile_link_id'=>$old_last_mile_link_id,
            'sub_center_primary'=>$old_sub_center_primary,
            'sub_center_secondary'=>$old_sub_center_secondary,
            'metro'=>$old_metro,
            'LH'=>$old_lh,
            'dark_core'=>$old_dark_core,
            'mobile_backhaul'=>$old_mobile_backhaul,
            'telegram_group'=> $old_telegram_group,
            'uni_nni'=> $old_uni_nni,
            'update_time'=> $old_update_time,
            'flag'=>$old_flag,
            'update_by' => $user_id,
            'comment' => $comment
        ]
        );


    return redirect('view_link');
}

public function edit_link(){

    $link_name_id = Request::get('link_name_id');

    $link_select_query = "SELECT * FROM phoenix_tt_db.link_table where link_name_id='$link_name_id'";
    $link_lists = \DB::select(\DB::raw($link_select_query));

    $client_select_query = "SELECT * FROM phoenix_tt_db.client_table where flag!='Disabled' ORDER BY client_name";
    $client_lists = \DB::select(\DB::raw($client_select_query));

    $district_select_query = "SELECT * FROM phoenix_tt_db.`district_table` ORDER BY `district_name`";
    $district_lists = \DB::select(\DB::raw($district_select_query));

    $vendor_list_query = "SELECT * FROM phoenix_tt_db.vendor ORDER BY `vendor_name`";
    $vendor_lists = \DB::select(\DB::raw($vendor_list_query));

           

    return view('link.edit_link',compact('link_lists','client_lists','district_lists','vendor_lists'));

}

public function update_link(){

     //****************** Get User Value****************

    $link_name_id = Request::get('link_name_id');

    $link_id =addslashes( Request::get('link_id'));
    $client =addslashes( Request::get('client'));
    $vlan_id =addslashes( Request::get('vlan_id'));
    $link_category =addslashes( Request::get('link_category'));
    $link_conn_type =addslashes( Request::get('link_conn_type'));
    $district =addslashes( Request::get('district'));
    $region =addslashes( Request::get('region'));
    $sms_group =addslashes( Request::get('sms_group'));
    $vendor =addslashes( Request::get('vendor'));
    $client_owner =addslashes( Request::get('client_owner'));
    $service_type_nttn =addslashes( Request::get('service_type_nttn'));
    $service_type_gateway =addslashes( Request::get('service_type_gateway'));
    $link_name_nttn =addslashes( Request::get('link_name_nttn'));
    $link_name_gateway =addslashes( Request::get('link_name_gateway'));
    $redundancy =addslashes( Request::get('redundancy'));
    $service_impact =addslashes(  Request::get('service_impact'));
    $capacity_nttn =addslashes(  Request::get('capacity_nttn'));
    $capacity_gateway =addslashes(  Request::get('capacity_gateway'));
    $last_mile_provided_by =addslashes( Request::get('last_mile_provided_by'));
    $last_mile_link_id =addslashes( Request::get('last_mile_link_id'));
    $sub_center_primary =addslashes( Request::get('sub_center_primary'));
    $sub_center_secondary =addslashes( Request::get('sub_center_secondary'));
    $metro =addslashes( Request::get('metro'));
    $lh =addslashes( Request::get('lh'));
    $dark_core =addslashes( Request::get('dark_core'));
    $mobile_backhaul =addslashes( Request::get('mobile_backhaul'));
    $telegram_group =addslashes( Request::get('telegram_group'));
    $uni_nni =addslashes( Request::get('uni_nni'));

    $user_id = $_SESSION['user_id'];
    $comment = addslashes( Request::get('comment'));



    // ****************** Get database Value *******************************
    $link_info_query = "SELECT * FROM phoenix_tt_db.link_table WHERE link_name_id = $link_name_id";
    $link_info = \DB::select(\DB::raw($link_info_query));

    $old_link_id =$link_info[0]->link_id ;
    $old_client =$link_info[0]->client ;
    $old_vlan_id =$link_info[0]->vlan_id ;
    $old_link_category =$link_info[0]->link_category ;
    $old_link_conn_type =$link_info[0]->link_conn_type ;
    $old_district =$link_info[0]->district ;
    $old_region =$link_info[0]->region ;
    $old_sms_group =$link_info[0]->sms_group ;
    $old_vendor =$link_info[0]->vendor ;
    $old_client_owner =$link_info[0]->client_owner ;
    $old_service_type_nttn =$link_info[0]->service_type_nttn ;
    $old_service_type_gateway =$link_info[0]->service_type_gateway ;
    $old_link_name_nttn =$link_info[0]->link_name_nttn ;
    $old_link_name_gateway =$link_info[0]->link_name_gateway ;
    $old_redundancy =$link_info[0]->redundancy ;
    $old_service_impact =$link_info[0]->service_impact ;
    $old_capacity_nttn =$link_info[0]->capacity_nttn ;
    $old_capacity_gateway =$link_info[0]->capacity_gateway ;
    $old_last_mile_provided_by =$link_info[0]->last_mile_provided_by ;
    $old_last_mile_link_id =$link_info[0]->last_mile_link_id ;
    $old_sub_center_primary =$link_info[0]->sub_center_primary ;
    $old_sub_center_secondary =$link_info[0]->sub_center_secondary ;
    $old_metro =$link_info[0]->metro ;
    $old_lh =$link_info[0]->LH ;
    $old_dark_core =$link_info[0]->dark_core ;
    $old_mobile_backhaul =$link_info[0]->mobile_backhaul ;
    $old_telegram_group =$link_info[0]->telegram_group ;
    $old_uni_nni =$link_info[0]->uni_nni ;
    $old_flag =$link_info[0]->flag ;
    $old_update_time =$link_info[0]->update_time ;
    
    
    $pending_flag = "Pending";

    // ****************** Insert into history table *************************

    $insert_link_chage_history = DB::table('link_history_table')->insertGetId(
                                [ 
                                    'link_name_id'=>$link_name_id,
                                    'client'=>$old_client,
                                    'link_id'=>$old_link_id,
                                    'vlan_id'=>$old_vlan_id,
                                    'link_category'=>$old_link_category,
                                    'link_conn_type'=>$old_link_conn_type,
                                    'district'=>$old_district,
                                    'region'=>$old_region,
                                    'sms_group'=>$old_sms_group,
                                    'vendor'=>$old_vendor,
                                    'client_owner'=>$old_client_owner,
                                    'service_type_nttn'=>$old_service_type_nttn,
                                    'service_type_gateway'=>$old_service_type_gateway,
                                    'link_name_nttn'=>$old_link_name_nttn,
                                    'link_name_gateway'=>$old_link_name_gateway,
                                    'redundancy'=>$old_redundancy,
                                    'service_impact'=>$old_service_impact,
                                    'capacity_nttn'=>$old_capacity_nttn,
                                    'capacity_gateway'=>$old_capacity_gateway,
                                    'last_mile_provided_by'=>$old_last_mile_provided_by,
                                    'last_mile_link_id'=>$old_last_mile_link_id,
                                    'sub_center_primary'=>$old_sub_center_primary,
                                    'sub_center_secondary'=>$old_sub_center_secondary,
                                    'metro'=>$old_metro,
                                    'LH'=>$old_lh,
                                    'dark_core'=>$old_dark_core,
                                    'mobile_backhaul'=>$old_mobile_backhaul,
                                    'telegram_group'=> $old_telegram_group,
                                    'uni_nni'=> $old_uni_nni,
                                    'update_time'=> $old_update_time,
                                    'flag'=>$old_flag,
                                    'update_by' => $user_id,
                                    'comment' => $comment
                                ]
                                );



    // ****************** update existing link *************************

    $link_update_query = "UPDATE phoenix_tt_db.link_table SET 
                                client =  '$client',
                                link_id =  '$link_id',
                                vlan_id =  '$vlan_id',
                                link_category =  '$link_category',
                                link_conn_type =  '$link_conn_type',
                                district =  '$district',
                                region =  '$region',
                                sms_group =  '$sms_group',
                                vendor =  '$vendor',
                                client_owner =  '$client_owner',
                                service_type_nttn =  '$service_type_nttn',
                                service_type_gateway =  '$service_type_gateway',
                                link_name_nttn =  '$link_name_nttn',
                                link_name_gateway =  '$link_name_gateway',
                                redundancy =  '$redundancy',
                                service_impact =  '$service_impact',
                                capacity_nttn =  '$capacity_nttn',
                                capacity_gateway =  '$capacity_gateway',
                                last_mile_provided_by =  '$last_mile_provided_by',
                                last_mile_link_id =  '$last_mile_link_id',
                                sub_center_primary =  '$sub_center_primary',
                                sub_center_secondary =  '$sub_center_secondary',
                                metro =  '$metro',
                                LH =  '$lh',
                                dark_core =  '$dark_core',
                                mobile_backhaul =  '$mobile_backhaul',
                                telegram_group =  '$telegram_group',
                                uni_nni =  '$uni_nni',
                                flag = 'Pending'
                                WHERE link_name_id='$link_name_id'";


    \DB::update(\DB::raw($link_update_query));


    return redirect('view_link');   
}

// public function update_link(){

//     $link_name_id = Request::get('link_name_id');

//     $link_id =addslashes( Request::get('link_id'));
//     $client =addslashes( Request::get('client'));
//     $vlan_id =addslashes( Request::get('vlan_id'));
//     $link_category =addslashes( Request::get('link_category'));
//     $link_conn_type =addslashes( Request::get('link_conn_type'));
//     $district =addslashes( Request::get('district'));
//     $region =addslashes( Request::get('region'));
//     $sms_group =addslashes( Request::get('sms_group'));
//     $vendor =addslashes( Request::get('vendor'));
    
//     $client_owner =addslashes( Request::get('client_owner'));
//     $service_type_nttn =addslashes( Request::get('service_type_nttn'));
//     $service_type_gateway =addslashes( Request::get('service_type_gateway'));
//     $link_name_nttn =addslashes( Request::get('link_name_nttn'));
    
//     $link_name_gateway =addslashes( Request::get('link_name_gateway'));
//     $redundancy =addslashes( Request::get('redundancy'));
//     $service_impact =addslashes(  Request::get('service_impact'));
//     $capacity_nttn =addslashes(  Request::get('capacity_nttn'));
//     $capacity_gateway =addslashes(  Request::get('capacity_gateway'));
//     $last_mile_provided_by =addslashes( Request::get('last_mile_provided_by'));
//     $last_mile_link_id =addslashes( Request::get('last_mile_link_id'));
//     $sub_center_primary =addslashes( Request::get('sub_center_primary'));
//     $sub_center_secondary =addslashes( Request::get('sub_center_secondary'));
//     $metro =addslashes( Request::get('metro'));
//     $lh =addslashes( Request::get('lh'));
//     $dark_core =addslashes( Request::get('dark_core'));
//     $mobile_backhaul =addslashes( Request::get('mobile_backhaul'));   


//      //**************************************************************Making the old link disabled******************************************************************************

//      $link_update_query = "UPDATE phoenix_tt_db.link_table SET flag='Disabled' WHERE link_name_id='$link_name_id'";

//     \DB::update(\DB::raw($link_update_query));


//     //****************************************************************Inserting new item*************************************************************************
//     $new_id = DB::table('link_table')->insertGetId(
//         [
//             'client'=>$client,
//             'link_id'=>$link_id,
//             'vlan_id'=>$vlan_id,
//             'link_category'=>$link_category,
//             'link_conn_type'=>$link_conn_type,
//             'district'=>$district,
//             'region'=>$region,
//             'sms_group'=>$sms_group,
//             'vendor'=>$vendor,
//             'client_owner'=>$client_owner,
//             'service_type_nttn'=>$service_type_nttn,
//             'service_type_gateway'=>$service_type_gateway,
//             'link_name_nttn'=>$link_name_nttn,
//             'link_name_gateway'=>$link_name_gateway,
//             'redundancy'=>$redundancy,
//             'service_impact'=>$service_impact,
//             'capacity_nttn'=>$capacity_nttn,
//             'capacity_gateway'=>$capacity_gateway,
//             'last_mile_provided_by'=>$last_mile_provided_by,
//             'last_mile_link_id'=>$last_mile_link_id,
//             'sub_center_primary'=>$sub_center_primary,
//             'sub_center_secondary'=>$sub_center_secondary,
//             'metro'=>$metro,
//             'LH'=>$lh,
//             'dark_core'=>$dark_core,
//             'mobile_backhaul'=>$mobile_backhaul,
//         ]
//     );

//     //************************************************************saving tracker**********************************************************************************
//     $mother_id = $link_name_id;
//     $get_id_chain_query = "SELECT id_chain FROM phoenix_tt_db.link_table_change_tracker WHERE new_id = '$mother_id';";
//     $id_chain_array = \DB::select(\DB::raw($get_id_chain_query));

//     if (empty($id_chain_array)) {
//      // list is empty.
        
//         $id_chain = $mother_id.",".$new_id;
//         echo $id_chain;

//     }
//     else{
//         $id_chain = $id_chain_array[0]->id_chain;
//         $id_chain = $id_chain.','.(string)$new_id;
//         print_r($id_chain);
//     }   
    
    
//     $user_id = $_SESSION['user_id'];
//     $comment = addslashes( Request::get('comment'));


//     $new_id = DB::table('link_table_change_tracker')->insertGetId(
//         [
//             'mother_id'=>$mother_id,
//             'id_chain' => $id_chain,
//             'new_id'=>$new_id,
//             'user_id'=>$user_id,
//             'comment'=>$comment,
//         ]
//     );

//     return redirect('view_link');           

// }



}
