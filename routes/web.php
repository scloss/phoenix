<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','LoginController@view_login');
Route::post('authenticate','LoginController@authenticate');
Route::get('logout','LoginController@logout');


Route::get('DashboardTT','DashboardController@dashboard_tt')->middleware('classC');
Route::get('DashboardGraph','DashboardController@dashboard_graph')->middleware('classC');

Route::get('TaskResolutionView','TicketController@task_resolution_view')->middleware('classB');
Route::get('CreateTT','TicketController@create_tt_view')->middleware('classA');
Route::post('CreateTicket','TicketController@create_tt')->middleware('classA');
Route::get('CreateTTCopy','TicketController@create_tt_view_copy')->middleware('classA');
Route::get('ElementView','TicketController@element_view')->middleware('classB');
Route::get('ResponsibleConcernView','TicketController@responsible_concern_view')->middleware('classB');
Route::get('ElementApi','TicketController@element_list_api');
Route::get('phoenix_get_employee_api','TicketController@phoenix_get_employee_api');
Route::post('LinkApi','TicketController@link_info');
Route::get('ViewTT','TicketController@view_tt')->middleware('classC');
Route::get('ViewTTSingle','TicketController@view_tt_single')->middleware('classC');
Route::get('EditTT','TicketController@edit_tt_view')->middleware('classB');
Route::post('EditTicket','TicketController@edit_tt')->middleware('classB');
Route::get('Test','TicketController@test_tt_phoenix')->middleware('classA');
Route::get('downloadZip','TicketController@zip_download')->middleware('classC');
Route::get('fileDownload','TicketController@downloadFile')->middleware('classC');
Route::get('fileDownloadKpi','KpiController@downloadFileKpi')->middleware('classC');
Route::post('AddResolution','TicketController@add_resolution')->middleware('classB');
Route::post('DeleteResolution','TicketController@delete_resolution')->middleware('classB');
Route::get('CreateTTEmail','TicketController@create_tt_email')->middleware('classA');

Route::get('KpiView','KpiController@kpi_view')->middleware('classSL');
Route::get('KpiResponsibleConcernView','KpiController@kpi_responsible_view')->middleware('classB');
Route::get('KpiElementView','KpiController@kpi_element_view')->middleware('classB');

Route::get('KpiViewFault','KpiController@kpi_view_fault')->middleware('classSL');


Route::get('FaultView','FaultController@fault_search_view')->middleware('classC');
Route::get('MsgView','TicketController@msg_view')->middleware('classC');
Route::get('QueryView','FaultController@query_test')->middleware('classC');

// Route::get('IncidentView','IncidentController@incident_view')->middleware('classA');
// Route::get('IncidentViewSingle','IncidentController@incident_view_single')->middleware('classA');
// Route::get('IncidentMerge','IncidentController@incident_merge')->middleware('classA');
// Route::get('IncidentList','IncidentController@incident_list');
// Route::get('IncidentListApi','IncidentController@incident_list_api');
// Route::post('IncidentCartInsert','IncidentController@insert_incident_cart')->middleware('classA');
// Route::post('IncidentCartDelete','IncidentController@delete_incident_cart')->middleware('classA');
// Route::post('IncidentMergeProcess','IncidentController@incident_merge_process')->middleware('classA');

Route::get('IncidentView','IncidentController@incident_view')->middleware('classB');
Route::get('IncidentViewSingle','IncidentController@incident_view_single')->middleware('classB');
Route::get('IncidentMerge','IncidentController@incident_merge')->middleware('classB');
Route::get('IncidentList','IncidentController@incident_list');
Route::get('IncidentListApi','IncidentController@incident_list_api');
Route::post('IncidentCartInsert','IncidentController@insert_incident_cart')->middleware('classB');
Route::post('IncidentCartDelete','IncidentController@delete_incident_cart')->middleware('classB');
Route::post('IncidentMergeProcess','IncidentController@incident_merge_process')->middleware('classB');



Route::get('refreshCart','IncidentController@refresh_cart');
Route::get('refreshIncidentMerge','IncidentController@refresh_incident_merge');


Route::get('refreshNotification','NotificationController@refresh_notification_cart');
Route::get('NotificationList','NotificationController@notification_list_api');
Route::get('NotificationAlert','NotificationController@notification_alert_api');
Route::get('NotificationView','NotificationController@notification_view');

Route::get('OPView','NotificationController@op_view');

Route::get('Reporting','ReportingController@ViewReportingPage')->middleware('classB');
Route::post('ExportReport','ReportingController@exportReport')->middleware('classB');
Route::get('ExportUGCCP','ReportingController@export_ug_ccp')->middleware('classA');



Route::get('vlookup','TicketController@vlookup_is_for_losers')->middleware('classA');
Route::get('restricted','TicketController@restricted')->middleware('classC');


Route::get('create_client','ClientController@create_client')->middleware('classSL');
Route::post('insert_client','ClientController@insert_client')->middleware('classSL');
Route::get('view_client','ClientController@view_client')->middleware('classSL');
Route::get('search_client','ClientController@view_client')->middleware('classSL');
Route::post('delete_client','ClientController@delete_client')->middleware('classSL');
Route::get('edit_client','ClientController@edit_client')->middleware('classSL');
Route::post('update_client','ClientController@update_client')->middleware('classSL');

Route::get('create_link','LinkController@create_link')->middleware('classEA');
Route::get('create_reason','LinkController@create_reason')->middleware('classEA');//creating reason...
Route::post('insert_link','LinkController@insert_link')->middleware('classEA');
Route::get('view_link','LinkController@view_link')->middleware('classC');
Route::get('search_link','LinkController@view_link')->middleware('classC');
Route::post('delete_link','LinkController@delete_link')->middleware('classEA');
Route::get('edit_link','LinkController@edit_link')->middleware('classEA');
Route::post('update_link','LinkController@update_link')->middleware('classEA');

Route::get('sms_group_api','LinkController@sms_group_api')->middleware('classEA');
Route::get('telegram_group_api','LinkController@telegram_group_api')->middleware('classEA');

Route::get('sms_group_view','LinkController@sms_group_view')->middleware('classEA');
Route::get('telegram_group_view','LinkController@telegram_group_view')->middleware('classEA');

Route::get('create_site','SiteController@create_site')->middleware('classEA');
Route::post('insert_site','SiteController@insert_site')->middleware('classEA');
Route::get('view_site','SiteController@view_site')->middleware('classC');
Route::get('search_site','SiteController@view_site')->middleware('classC');
Route::post('delete_site','SiteController@delete_site')->middleware('classA');
Route::get('edit_site','SiteController@edit_site')->middleware('classEA');
Route::post('update_site','SiteController@update_site')->middleware('classEA');


Route::get('TaskView','TaskController@task_search_view')->middleware('classC');
Route::post('TaskView','TaskController@task_search')->middleware('classC');


/*********************************Bug Api***********************************************/

Route::get('access_update_secret','LoginController@access_update');
Route::get('dashboard_bug_finder','LoginController@outage_dashboard_bug_finder');


/*****************************************************************************************/
/**********************UNMS**************************************************************/
Route::post('UnmsApi','PhoenixController@unms_api');
Route::get('posttest','PhoenixController@post_test');

/********************************************************************************************/
/***********************API ONUSERVER*********************************************************/
Route::get('outage_api_all','PhoenixController@onuserver_api_outage_all');
Route::get('outage_api_summary','PhoenixController@onuserver_api_outage_summary');
Route::get('outage_api_district','PhoenixController@onuserver_api_outage_district');
Route::get('outage_api_site','PhoenixController@onuserver_api_outage_site');
Route::get('outage_api_oh_link','PhoenixController@onuserver_api_outage_oh_link');
Route::get('outage_api_power_alarm','PhoenixController@onuserver_api_outage_power_alarm');
Route::get('outage_api_iig_issue','PhoenixController@onuserver_api_outage_iig_issue');
Route::get('outage_api_icx_issue','PhoenixController@onuserver_api_outage_icx_issue');
Route::get('outage_api_itc_issue','PhoenixController@onuserver_api_outage_itc_issue');

/********************************************************************************************/
/***********************API ONUSERVER*********************************************************/

Route::get('show_priority','ServiceController@show_priority');
Route::get('priority_link_down','ServiceController@priority_link_down');
Route::get('priority_site_down','ServiceController@priority_site_down');
Route::get('priority_link_other','ServiceController@priority_link_other');
Route::get('priority_site_other','ServiceController@priority_site_other');

/***********************Link Site Info Serve API*********************************************************/
Route::get('get_link_list_json','ServiceController@get_link_list_json');
Route::get('get_site_list_json','ServiceController@get_site_list_json');

Route::get('get_link_list_api','ServiceController@get_link_list_api');
Route::get('get_site_list_api','ServiceController@get_site_list_api');

Route::get('get_link_info','ServiceController@get_link_info');
Route::get('get_site_info','ServiceController@get_site_info');

Route::get('get_district_list','ServiceController@get_district_list');
Route::get('get_subcenter_list','ServiceController@get_subcenter_list');
Route::get('get_client_list','ServiceController@get_client_list');

/************************************* Telegram Notification *********************************************/
Route::get('telegram_notification','TelegramNotifController@send_notif_test');