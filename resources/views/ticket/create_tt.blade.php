
@include('navigation.ticket_header')
<?php
date_default_timezone_set('Asia/Dhaka');
$current_time = date('Y-m-d H:i:s');
//$max_allowed_event_time = strtotime ( '+15 minute' , strtotime ( $current_time ) ) ;
$max_allowed_event_time = $current_time;//date('Y-m-d H:i:s',$max_allowed_event_time);

// $newdate = strtotime ( '+15 minute' , strtotime ( $date ) ) ;
// $newdate = date ( 'Y-m-j' , $newdate );

$ctime = explode($current_time,' ');
?>




<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
<!--   <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="{{asset('js/jquery-ui.js')}}"></script>
<script src="{{asset('lib/moment/moment.js')}}"></script>
<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script  src="{{asset('js/create_tt.js?v23')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/resize_ta.css')}}">

<script type="text/javascript">


document.getElementById('ticket-collapse').className = 'panel-collapse collapse in';
document.getElementById('ticket_create').className = 'active';

var client_arr = <?php echo json_encode($client_arr) ?>;
var client_js_arr = <?php echo json_encode($client_js_arr) ?>;
var reason_js_arr = <?php echo json_encode($reason_js_arr) ?>;
var issue_type_js_arr = <?php echo json_encode($issue_type_js_arr) ?>;
var problem_category_js_arr = <?php echo json_encode($problem_category_js_arr) ?>;
var problem_source_js_arr = <?php echo json_encode($problem_source_js_arr) ?>;
var link_type_js_arr = <?php echo json_encode($link_type_js_arr) ?>;
var department_list_js_arr = <?php echo json_encode($department_list_js_arr) ?>;
var department_id_list_js_arr = <?php echo json_encode($department_id_list_js_arr) ?>;
var subcenter_list_js_arr = <?php echo json_encode($subcenter_list_js_arr) ?>;
var task_name_js_arr = <?php echo json_encode($task_name_js_arr) ?>;

</script>

<style type="text/css">
	table{
		width:100%;
		border-collapse:separate; 
		border-spacing: 0px 7px;
	}	
	table td{
		text-align:center;
	}
	.col-md-3{
	padding-left: 0px;
    padding-right: 0px;
	}
	.container-fluid{
	padding-left: 0px;
    padding-right: 0px;
	}
	#wrap_div{
		padding-left: 0px;
    	padding-right: 0px;
	}
	.col-md-12{
		padding-left: 10px;
        padding-right: 10px;
	}
</style>  



<h2 class="page-title">Create Ticket <span class="fw-semi-bold"></span></h2>
<h6>Current Time: {{ $current_time }}</h6>

<input type="hidden" id="current_time" name="current_time" value="{{$current_time}}">
<input type="hidden" id="max_allowed_event_time" name="max_allowed_event_time" value="{{$max_allowed_event_time}}">
<input type="hidden" id="form_posted" name="form_posted" value="no">


<div id="tt_form_div" class="container-fluid">
	<form action="{{ url('CreateTicket') }}" id="tt_create_form" method="post" enctype="multipart/form-data">
	<input type="hidden" name="hidden_fault_ids" id="hidden_fault_ids">
	<input type="hidden" id="taskName"  name="taskName" value="">
	<input type="hidden" id="taskDescription" name="taskDescription" value="">
	<input type="hidden" id="taskAssignedDept"  name="taskAssignedDept" value="">
	<input type="hidden" id="taskSubcenter" name="taskSubcenter" value="">
	<input type="hidden" id="taskStartTime" name="taskStartTime" value="">
	<input type="hidden" id="taskResponsibleConcern" name="taskResponsibleConcern" value="">
	<input type="hidden" id="taskComment" name="taskComment" value="">

	

	<div class="col-md-12" id="static_div">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-5">
						<div class="col-md-12" id="ticket_static_table">
						
									<div class="row" id="ticket_row">
										<div class="col-md-4">
											<p>Ticket Title</p>
										</div>
										<div class="col-md-8">
											<input type="text" id="ticket_title" name="ticket_title" class="form-control input-transparent" autocomplete="off" required>
											
										</div>
									</div>
							
									<div class="row">
										<div class="col-md-4">
											<p>Ticket Status</p>
										</div>
										<div class="col-md-8">
											<span class="label label-important">New</span>
											<input type="hidden" name="ticket_status" value="New">
											<!-- <label style="float:left;">
												<select id="select_style" name="ticket_status" required>
													<option selected value="New">New</option> -->
			                                        <!-- @foreach($ticket_status_lists as $ticket_status_list) 
			                                            <option value="{{$ticket_status_list->ticket_status_name}}">{{$ticket_status_list->ticket_status_name}}</option>
			                                        @endforeach -->
			                                    <!-- </select>
			                                </label> -->
										</div>
									</div>
								

									<div class="row">
										<div class="col-md-4">
											<p>Attach file</p>
										</div>
										<div class="col-md-8">
											<input type="file" name="ticket_files[]" id="ticket_files" multiple="multiple">
										</div>
									</div>
								
									<div class="row">
										<div class="col-md-4">
											<p>Incident Title</p>
										</div>
										<div class="col-md-8">
											<input type="hidden" name="incident_id">
											<a href="Javascript:incidentScript()">
												<input type="text" id="incident_title" name="incident_title" class="form-control input-transparent keydownDisabled" autocomplete="off" required>
											</a>
										</div>
									</div>
								
									<div class="row">
										<div class="col-md-4">
											<p>Incident Description</p>
										</div>
										<div class="col-md-8">
											<textarea rows="3" class="form-control input-transparent" id="incident_description" name="incident_description" required></textarea>
										</div>
									</div>
									
							<!-- <tr>
								<td>Assigned Dept</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="assigned_dept" required>
											<option disabled selected></option>
	                                        @foreach($department_lists as $department_list) 
	                                            <option value="{{$department_list->dept_name}}">{{$department_list->dept_name}}</option>
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
							</tr> -->
<!-- 							<tr>
								<td>Ticket Time</td>
								<td>
									<div id="ticket_time" class="input-group">
	                                    <input id="datepicker2i" type="text" name="ticket_time" class="form-control input-transparent" required>
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
							</tr> -->
							<input type="submit" id="submit-button" style="display:none">
						</div>
					</div>
					<div class="col-md-7">
						<table>
							<tr>
								<td>SCL Comment</td>
								<td>Client Comment</td>
								<td>{{$_SESSION['department']}}'s Internal Comment</td>
								
							</tr>
							

							<tr>
								<td>
									<textarea rows="7" class="form-control input-transparent resize_ta" id="ticket_comment_scl" name="ticket_comment_scl" placeholder="optional"></textarea>
								</td>
								<td>
									<textarea rows="7" class="form-control input-transparent resize_ta" id="ticket_comment_client" name="ticket_comment_client" placeholder="optional"></textarea>
								</td>
								<td>
									<textarea rows="7" class="form-control input-transparent resize_ta" id="ticket_comment_noc" name="ticket_comment_noc" placeholder="optional"></textarea>
								</td>
							</tr>
							
						</table>
					</div>
				</div>
			</div>	
		</section>
	</div>
	<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="addFault()" style="color:#fff;"><i class="fa fa-plus-square" ></i></a> -->
	<br/><br/>

</div> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="btn btn-primary" onclick="tt_create_form_submit()">CREATE TICKET</div>

	</form>
@include('navigation.p_footer')