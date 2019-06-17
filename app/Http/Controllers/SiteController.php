<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\ServiceController;
use Request;
use Input;
use DB;


class SiteController extends Controller
{

    public function create_site(){

        $client_select_query = "SELECT * FROM phoenix_tt_db.client_table where flag!='Disabled' ORDER BY client_name";
        $client_lists = \DB::select(\DB::raw($client_select_query));

        $district_select_query = "SELECT * FROM phoenix_tt_db.district_table ORDER BY `district_name`";
        $district_lists = \DB::select(\DB::raw($district_select_query));

        $vendor_list_query = "SELECT * FROM phoenix_tt_db.vendor ORDER BY `vendor_name`";
        $vendor_lists = \DB::select(\DB::raw($vendor_list_query));


        $client = "";
        $site_name = "";
        $mw_site_name = "";
        $site_ip_address = "";
        $site_type = "";
        $region = "";
        $district = "";
        $sms_group = "";
        $vendor = "";
        $site_node_address = "";
        $device_type = "";
        $device_vendor = "";
        $device_model = "";
        $upazilla = "";
        $sub_center = "";

        $user_msg = "";
        $telegram_group = "";

        return view('site.create_site',compact('client_lists','district_lists','vendor_lists','client','site_name','mw_site_name','site_ip_address','site_type','region','district','sms_group','vendor','site_node_address','device_type','device_vendor','device_model','upazilla','sub_center','user_msg','telegram_group'));



        //return view('site.create_site',compact('client_lists','district_lists','vendor_lists'));


    }

    public function insert_site(){

        $client = addslashes(Request::get('client'));
        $site_name = addslashes( Request::get('site_name'));
        $mw_site_name = addslashes( Request::get('mw_site_name'));
        $site_ip_address = addslashes( Request::get('site_ip_address'));
        $site_type = addslashes( Request::get('site_type'));
        $region = addslashes( Request::get('region'));
        $district = addslashes( Request::get('district'));
        $sms_group = addslashes( Request::get('sms_group'));
        $vendor = addslashes( Request::get('vendor'));
        $site_node_address = addslashes( Request::get('site_node_address'));
        $device_type = addslashes( Request::get('device_type'));  
        $device_vendor = addslashes( Request::get('device_vendor')); 
        $device_model = addslashes( Request::get('device_model')); 
        $upazilla = addslashes( Request::get('upazilla'));
        $sub_center = addslashes( Request::get('sub_center'));
        $telegram_group = addslashes( Request::get('telegram_group'));




        // $site_insert_query = "INSERT INTO phoenix_tt_db.site_table (client,site_name,mw_site_name,site_ip_address,site_type,region,district,sms_group,vendor) VALUES ('$client','$site_name','$mw_site_name','$site_ip_address','$site_type','$region','$district','$sms_group','$vendor')";

        // $site_insert_query = "INSERT INTO phoenix_tt_db.site_table (client,site_name,mw_site_name,site_ip_address,site_type,region,district,sms_group,vendor,site_node_address,device_type,device_vendor,device_model,upazilla,sub_center) VALUES ('$client','$site_name','$mw_site_name','$site_ip_address','$site_type','$region','$district','$sms_group','$vendor','$site_node_address','$device_type','$device_vendor','$device_model','$upazilla','$sub_center')";

        // //echo $site_insert_query;


        // \DB::insert(\DB::raw($site_insert_query));

        //Insert Site
        $flag = "Pending";
        $new_site_id = DB::table('site_table')->insertGetId(
            [
                'client' => $client,
                'site_name' => $site_name,
                'mw_site_name' => $mw_site_name,
                'site_ip_address' => $site_ip_address,
                'site_type' => $site_type,
                'region' => $region,
                'district' => $district,
                'sms_group' => $sms_group,
                'vendor' => $vendor,
                'flag' => $flag,
                'site_node_address' => $site_node_address,
                'device_type' => $device_type,
                'device_vendor' => $device_vendor,
                'device_model' => $device_model,
                'upazilla' => $upazilla,
                'sub_center' => $sub_center,
                'telegram_group' => $telegram_group
            ]
            );
        
        //Insert History
        date_default_timezone_set('Asia/Dhaka');
        $time = date('Y-m-d hh:mm:ss');
        $user_id = $_SESSION['user_id'];
        $comment = "New Site Inserted";
        $insert_site_update_history = DB::table('site_history_table')->insertGetId(
            [
                'site_name_id' => $new_site_id,
                'client' => $client,
                'site_name' => $site_name,
                'mw_site_name' => $mw_site_name,
                'site_ip_address' => $site_ip_address,
                'site_type' => $site_type,
                'region' => $region,
                'district' => $district,
                'sms_group' => $sms_group,
                'vendor' => $vendor,
                'flag' => $flag,
                'site_node_address' => $site_node_address,
                'device_type' => $device_type,
                'device_vendor' => $device_vendor,
                'device_model' => $device_model,
                'upazilla' => $upazilla,
                'sub_center' => $sub_center,
                'update_by' => $user_id,
                'telegram_group' => $telegram_group,
                'comment' => $comment
            ]
            );

        //echo $site_insert_query;


        //prepare data for show create site page again

        $client_select_query = "SELECT * FROM phoenix_tt_db.client_table where flag!='Disabled' ORDER BY client_name";
        $client_lists = \DB::select(\DB::raw($client_select_query));

        $district_select_query = "SELECT * FROM phoenix_tt_db.district_table ORDER BY `district_name`";
        $district_lists = \DB::select(\DB::raw($district_select_query));

        $vendor_list_query = "SELECT * FROM phoenix_tt_db.vendor ORDER BY `vendor_name`";
        $vendor_lists = \DB::select(\DB::raw($vendor_list_query));

        $user_msg = "Successfully Saved";


        //return redirect('view_site');
        return view('site.create_site',compact('client_lists','district_lists','vendor_lists','client','site_name','mw_site_name','site_ip_address','site_type','region','district','sms_group','vendor','site_node_address','device_type','device_vendor','device_model','upazilla','sub_center','user_msg','telegram_group'));



    }

    public function view_site(){

        $client = addslashes(Request::get('client'));
        $site_name = addslashes( Request::get('site_name'));
        $mw_site_name = addslashes( Request::get('mw_site_name'));
        $site_ip_address = addslashes( Request::get('site_ip_address'));
        $site_type = addslashes( Request::get('site_type'));
        $region = addslashes( Request::get('region'));
        $district = addslashes( Request::get('district'));
        $sms_group = addslashes( Request::get('sms_group'));
        $vendor = addslashes( Request::get('vendor'));
        $site_node_address = addslashes( Request::get('site_node_address'));
        $device_type = addslashes( Request::get('device_type'));  
        $device_vendor = addslashes( Request::get('device_vendor')); 
        $device_model = addslashes( Request::get('device_model')); 
        $upazilla = addslashes( Request::get('upazilla'));
        $sub_center = addslashes( Request::get('sub_center'));

        $formType = Request::get('formType'); 

        $whereQuery = "";

        if($client){

            $whereQuery.= "client = '$client' AND ";

        }
        if($site_name){

            $whereQuery.= "site_name like '%$site_name%' AND ";

        }
        if($mw_site_name){

            $whereQuery.= "mw_site_name like '%$mw_site_name%' AND ";

        }
        if($site_ip_address){

            $whereQuery.= "site_ip_address like '%$site_ip_address%' AND ";

        }
        if($site_type){

            $whereQuery.= "site_type like '%$site_type%' AND ";

        }
        if($region){

            $whereQuery.= "region like '%$region%' AND ";

        }
        if($district){

            $whereQuery.= "district like '%$district%' AND ";

        }
        if($vendor){

            $whereQuery.= "vendor like '%$vendor%' AND ";

        }
        if($site_node_address){

            $whereQuery.= "site_node_address like '%$site_node_address%' AND ";

        }
        if($device_type){

            $whereQuery.= "device_type like '%$device_type%' AND ";

        }
        if($device_vendor){

            $whereQuery.= "device_vendor like '%$device_vendor%' AND ";

        }
        if($device_model){

            $whereQuery.= "device_model like '%$device_model%' AND ";

        }
        if($upazilla){

            $whereQuery.= "upazilla like '%$upazilla%' AND ";

        }
        if($sub_center){

            $whereQuery.= "sub_center like '%$sub_center%' AND ";

        }

        if($formType == "Export"){

            //$whereQuery .= "flag!='Disabled'";


            // return $whereQuery;

            // $site_list_query = "SELECT ct.client_name,st.site_name,st.mw_site_name,st.site_ip_address,st.site_type,st.region,st.district,st.sms_group,st.vendor,st.site_node_address,st.device_type,st.device_vendor,st.device_model,st.upazilla,st.sub_center FROM site_table st INNER JOIN client_table ct ON st.client=ct.client_id where ".$whereQuery;
            // //dd($site_list_query);
            $whereQuery .= "phoenix_tt_db.site_table.flag!='Disabled'";
            $site_lists_full = DB::table('phoenix_tt_db.site_table')
            ->join('phoenix_tt_db.client_table', 'phoenix_tt_db.client_table.client_id', '=', 'phoenix_tt_db.site_table.client')
            ->selectRaw('phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.client_name')
            ->whereRaw("$whereQuery")
            ->get();

            // $site_lists = \DB::select(\DB::raw($site_list_query));

            // print_r($site_lists);

            // return "finish";

            // //$site_lists =
            $service_controller = New ServiceController();
            $return_arr = $service_controller->csv_export($site_lists_full);
            return response()->download($return_arr[0], $return_arr[1],$return_arr[2]);

        }                        


        if($whereQuery==""){

            $site_lists = DB::table('phoenix_tt_db.site_table')
            ->join('phoenix_tt_db.client_table', 'phoenix_tt_db.client_table.client_id', '=', 'phoenix_tt_db.site_table.client')
            ->selectRaw('phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.client_name')
            ->whereRaw("site_name_id<0")
            ->paginate(20);
        }

        else{

            $whereQuery .= "phoenix_tt_db.site_table.flag!='Disabled'";
            $site_lists = DB::table('phoenix_tt_db.site_table')
            ->join('phoenix_tt_db.client_table', 'phoenix_tt_db.client_table.client_id', '=', 'phoenix_tt_db.site_table.client')
            ->selectRaw('phoenix_tt_db.site_table.*,phoenix_tt_db.client_table.client_name')
            ->whereRaw("$whereQuery")
            ->paginate(20);

        }

        $client_select_query = "SELECT * FROM phoenix_tt_db.client_table where flag!='Disabled' ORDER BY client_name";
        $client_lists = \DB::select(\DB::raw($client_select_query));

        $district_select_query = "SELECT * FROM phoenix_tt_db.district_table ORDER BY `district_name`";
        $district_lists = \DB::select(\DB::raw($district_select_query));

        $vendor_list_query = "SELECT * FROM phoenix_tt_db.vendor ORDER BY `vendor_name`";
        $vendor_lists = \DB::select(\DB::raw($vendor_list_query));


        



        return view('site.view_site',compact('site_lists','client_lists','district_lists','vendor_lists','client','site_name','mw_site_name','site_ip_address','site_type','region','district','sms_group','vendor','site_node_address','device_type','device_vendor','device_model','upazilla','sub_center'));
    }

    public function delete_site(){

        $site_name_id = Request::get('site_name_id');

        $site_update_query = "UPDATE phoenix_tt_db.site_table SET flag='Disabled' WHERE site_name_id='$site_name_id'";

        \DB::update(\DB::raw($site_update_query));


        //**************** Get database Value ****************

        $site_info_query = "SELECT * FROM phoenix_tt_db.site_table WHERE site_name_id = $site_name_id";
        $site_info = \DB::select(\DB::raw($site_info_query));

        $old_site_name_id = $site_info[0]->site_name_id;
        $old_client = $site_info[0]->client;
        $old_site_name = $site_info[0]->site_name;
        $old_mw_site_name = $site_info[0]->mw_site_name;
        $old_site_ip_address = $site_info[0]->site_ip_address;
        $old_site_type = $site_info[0]->site_type;
        $old_region = $site_info[0]->region;
        $old_district = $site_info[0]->district;
        $old_sms_group = $site_info[0]->sms_group;
        $old_vendor = $site_info[0]->vendor;
        $old_flag = $site_info[0]->flag;
        $old_update_time = $site_info[0]->update_time;
        $old_site_node_address = $site_info[0]->site_node_address;
        $old_device_type = $site_info[0]->device_type;
        $old_device_vendor = $site_info[0]->device_vendor;
        $old_device_model = $site_info[0]->device_model;
        $old_upazilla = $site_info[0]->upazilla;
        $old_sub_center = $site_info[0]->sub_center;
        $old_telegram_group = $site_info[0]->telegram_group;

        $user_id = $_SESSION['user_id'];
        $comment = "Deleted";
        //*************** Insert into site history table ***************

        $insert_site_update_history = DB::table('site_history_table')->insertGetId(
                                    [
                                        'site_name_id' => $old_site_name_id,
                                        'client' => $old_client,
                                        'site_name' => $old_site_name,
                                        'mw_site_name' => $old_mw_site_name,
                                        'site_ip_address' => $old_site_ip_address,
                                        'site_type' => $old_site_type,
                                        'region' => $old_region,
                                        'district' => $old_district,
                                        'sms_group' => $old_sms_group,
                                        'vendor' => $old_vendor,
                                        'flag' => $old_flag,
                                        'site_node_address' => $old_site_node_address,
                                        'device_type' => $old_device_type,
                                        'device_vendor' => $old_device_vendor,
                                        'device_model' => $old_device_model,
                                        'upazilla' => $old_upazilla,
                                        'sub_center' => $old_sub_center,
                                        'update_by' => $user_id,
                                        'telegram_group' => $old_telegram_group,
                                        'comment' => $comment
                                    ]
                                    );

        return redirect('view_site');
    }    

    public function edit_site(){

        $site_name_id = Request::get('site_name_id');

        $site_select_query = "SELECT * FROM phoenix_tt_db.site_table where site_name_id='$site_name_id'";
        $site_lists = \DB::select(\DB::raw($site_select_query));

        $client_select_query = "SELECT * FROM phoenix_tt_db.client_table where flag!='Disabled' ORDER BY client_name";
        $client_lists = \DB::select(\DB::raw($client_select_query));

        $district_select_query = "SELECT * FROM phoenix_tt_db.district_table ORDER BY `district_name`";
        $district_lists = \DB::select(\DB::raw($district_select_query));

        $vendor_list_query = "SELECT * FROM phoenix_tt_db.vendor ORDER BY `vendor_name`";
        $vendor_lists = \DB::select(\DB::raw($vendor_list_query));             

        return view('site.edit_site',compact('site_lists','client_lists','district_lists','vendor_lists'));

    }

    public function update_site(){

        //****************** Get User Value****************
        $site_name_id = Request::get('site_name_id');
        
        $client = addslashes(Request::get('client'));
        $site_name = addslashes( Request::get('site_name'));
        $mw_site_name = addslashes( Request::get('mw_site_name'));
        $site_ip_address = addslashes( Request::get('site_ip_address'));
        $site_type = addslashes( Request::get('site_type'));
        $region = addslashes( Request::get('region'));
        $district = addslashes( Request::get('district'));
        $sms_group = addslashes( Request::get('sms_group'));
        $vendor = addslashes( Request::get('vendor'));
        $site_node_address = addslashes( Request::get('site_node_address'));
        $device_type = addslashes( Request::get('device_type'));  
        $device_vendor = addslashes( Request::get('device_vendor')); 
        $device_model = addslashes( Request::get('device_model')); 
        $upazilla = addslashes( Request::get('upazilla'));
        $sub_center = addslashes( Request::get('sub_center'));
        $telegram_group = addslashes( Request::get('telegram_group'));
        $user_id = $_SESSION['user_id'];
        $comment = addslashes( Request::get('comments'));

        //return $comment; 
        //**************** Get database Value ****************

        $site_info_query = "SELECT * FROM phoenix_tt_db.site_table WHERE site_name_id = $site_name_id";
        $site_info = \DB::select(\DB::raw($site_info_query));

        $old_site_name_id = $site_info[0]->site_name_id;
        $old_client = $site_info[0]->client;
        $old_site_name = $site_info[0]->site_name;
        $old_mw_site_name = $site_info[0]->mw_site_name;
        $old_site_ip_address = $site_info[0]->site_ip_address;
        $old_site_type = $site_info[0]->site_type;
        $old_region = $site_info[0]->region;
        $old_district = $site_info[0]->district;
        $old_sms_group = $site_info[0]->sms_group;
        $old_vendor = $site_info[0]->vendor;
        $old_flag = $site_info[0]->flag;
        $old_update_time = $site_info[0]->update_time;
        $old_site_node_address = $site_info[0]->site_node_address;
        $old_device_type = $site_info[0]->device_type;
        $old_device_vendor = $site_info[0]->device_vendor;
        $old_device_model = $site_info[0]->device_model;
        $old_upazilla = $site_info[0]->upazilla;
        $old_sub_center = $site_info[0]->sub_center;
        $old_telegram_group = $site_info[0]->telegram_group;
        //*************** Insert into site history table ***************

        $insert_site_update_history = DB::table('site_history_table')->insertGetId(
                                    [
                                        'site_name_id' => $old_site_name_id,
                                        'client' => $old_client,
                                        'site_name' => $old_site_name,
                                        'mw_site_name' => $old_mw_site_name,
                                        'site_ip_address' => $old_site_ip_address,
                                        'site_type' => $old_site_type,
                                        'region' => $old_region,
                                        'district' => $old_district,
                                        'sms_group' => $old_sms_group,
                                        'vendor' => $old_vendor,
                                        'flag' => $old_flag,
                                        'site_node_address' => $old_site_node_address,
                                        'device_type' => $old_device_type,
                                        'device_vendor' => $old_device_vendor,
                                        'device_model' => $old_device_model,
                                        'upazilla' => $old_upazilla,
                                        'sub_center' => $old_sub_center,
                                        'update_by' => $user_id,
                                        'telegram_group' => $old_telegram_group,
                                        'comment' => $comment
                                    ]
                                    );


        //************************** Update Site *************************

        $site_update_query = "UPDATE phoenix_tt_db.site_table SET 
                                client = '$client',
                                site_name = '$site_name',
                                mw_site_name = '$mw_site_name',
                                site_ip_address = '$site_ip_address',
                                site_type = '$site_type',
                                region = '$region',
                                district = '$district',
                                sms_group = '$sms_group',
                                vendor = '$vendor',
                                flag = 'Pending',
                                site_node_address = '$site_node_address',
                                device_type = '$device_type',
                                device_vendor = '$device_vendor',
                                device_model = '$device_model',
                                upazilla = '$upazilla',
                                sub_center = '$sub_center',
                                telegram_group = '$telegram_group'
                                WHERE site_name_id='$site_name_id'";

        \DB::update(\DB::raw($site_update_query)); 

        return redirect('view_site');


    }

    // public function update_site(){

    //     $site_name_id = Request::get('site_name_id');
        
    //     $client = addslashes(Request::get('client'));
    //     $site_name = addslashes( Request::get('site_name'));
    //     $mw_site_name = addslashes( Request::get('mw_site_name'));
    //     $site_ip_address = addslashes( Request::get('site_ip_address'));
    //     $site_type = addslashes( Request::get('site_type'));
    //     $region = addslashes( Request::get('region'));
    //     $district = addslashes( Request::get('district'));
    //     $sms_group = addslashes( Request::get('sms_group'));
    //     $vendor = addslashes( Request::get('vendor'));
    //     $site_node_address = addslashes( Request::get('site_node_address'));
    //     $device_type = addslashes( Request::get('device_type'));  
    //     $device_vendor = addslashes( Request::get('device_vendor')); 
    //     $device_model = addslashes( Request::get('device_model')); 
    //     $upazilla = addslashes( Request::get('upazilla'));
    //     $sub_center = addslashes( Request::get('sub_center'));

    //     //**************************************************************Making the old Site disabled******************************************************************************

    //     $site_update_query = "UPDATE phoenix_tt_db.site_table SET flag='Disabled' WHERE site_name_id='$site_name_id'";

    //     \DB::update(\DB::raw($site_update_query));

    //      //****************************************************************Inserting new item*************************************************************************
    //     $new_id = DB::table('site_table')->insertGetId(
    //         [
    //             'client'=>  $client,
    //             'site_name'=>   $site_name,
    //             'mw_site_name'=>    $mw_site_name,
    //             'site_ip_address'=> $site_ip_address,
    //             'site_type'=>   $site_type,
    //             'region'=>  $region,
    //             'district'=>    $district,
    //             'sms_group'=>   $sms_group,
    //             'vendor'=>  $vendor,
    //             'site_node_address'=>   $site_node_address,
    //             'device_type'=> $device_type,
    //             'device_vendor'=>   $device_vendor,
    //             'device_model'=>    $device_model,
    //             'upazilla'=>    $upazilla,
    //             'sub_center'=>  $sub_center,

    //         ]
    //     );
    //     //************************************************************saving tracker**********************************************************************************
    //     $mother_id = $site_name_id;
    //     $get_id_chain_query = "SELECT id_chain FROM phoenix_tt_db.site_table_change_tracker WHERE new_id = '$mother_id';";
    //     $id_chain_array = \DB::select(\DB::raw($get_id_chain_query));

    //     if (empty($id_chain_array)) {
    //  // list is empty.

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


    //     $new_id = DB::table('site_table_change_tracker')->insertGetId(
    //         [
    //             'mother_id'=>$mother_id,
    //             'id_chain' => $id_chain,
    //             'new_id'=>$new_id,
    //             'user_id'=>$user_id,
    //             'comment'=>$comment,
    //         ]
    //     );

    //     return redirect('view_site');


    // }

}
