



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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--   <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript" src="{{asset('js/edit_tt.js?v17')}}"></script>
<script src="{{asset('lib/moment/moment.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.anchorlink.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/resize_ta.css')}}">
<style type="text/css">
	table{
		
		width:100%;
		border-collapse:separate; 
		border-spacing: 0px 7px;
	}	
	table td{
		text-align:center;
	}
	.closed_task_status{
		background: #46CB79;
		font-weight: bold;
		color : white;
	}
	.open_task_status{
		background: #F05029;
		font-weight: bold;
		color : white;
	}
	#task_inner_div{
		margin-left:1%;
		width:98%;
	}

	.fixed-top-menu{
		top: 0;
  		position: fixed;
  		width: 100%;
  		z-index:3;
  		height: 150px;
  		background-color: rgba(51, 51, 51, 0);
  		padding: 10px;
	}
	.scrolling-div{
		top:500px;
	    z-index:2;
	}
	.anchor{
		display: block;
		height: 150px; /*same height as header*/
		margin-top: -150px; /*same height as header*/
		visibility: hidden;

		-webkit-transform: translateZ( 0 );
		transform: translateZ( 0 );
		-webkit-transition: -webkit-transform 0.6s ease-in-out;
		transition: transform 0.6s ease-in-out;
		-webkit-backface-visibility: hidden;
		backface-visibility: hidden;
	}

	.whitish_menu{
		background-color: rgb(95, 109, 119,0.8);
	}
	div.scrollmenu {
		background-color: #cbcfd3;
		border-radius: 25px;
		border: 2px solid white;
		padding: 5px;
		overflow: auto;
		white-space: nowrap;
		width: fit-content;
		max-width: 500px;
	}

	div.scrollmenu a {
		display: inline-block;
		color: #6f7884;
		text-align: center;
		padding: 14px;
		text-decoration: none;
	}

	div.scrollmenu a:hover {
		background-color: #777;
		color: white;
	}

	::-webkit-scrollbar {
    	height: 5px;
	}
	/* Track */
	::-webkit-scrollbar-track {
	    background: #f1f1f1; 
	}
	 
	/* Handle */
	::-webkit-scrollbar-thumb {
	    background: #888; 
	}

	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
	    background: #555; 
	}

	.open_fault_id_color {
		color: red !important;
	}
	.closed_fault_id_color {
		color: green !important;
	}

	
</style>
<script type="text/javascript">

	var department_list_js_arr = <?php echo json_encode($department_list_js_arr) ?>;
	var department_id_list_js_arr = <?php echo json_encode($department_id_list_js_arr) ?>;
	var subcenter_list_js_arr = <?php echo json_encode($subcenter_list_js_arr) ?>;
	var client_js_arr = <?php echo json_encode($client_js_arr) ?>;
	var task_name_js_arr = <?php echo json_encode($task_name_js_arr) ?>;

	function set_menu_css(key){
		var key = key;
		
		if(key==-1){
			document.getElementById("fixed-top-menu").classList.remove('whitish_menu');
		}
		else{
			document.getElementById("fixed-top-menu").classList.add('whitish_menu');
		}

		
	}

</script>
<form id="tt_create_form" action="{{ url('EditTicket') }}" method="POST" enctype="multipart/form-data">

<input type="hidden" id="form_posted" name="form_posted" value="no">
<input type="hidden" id="current_time" name="current_time" value="{{$current_time}}">
<input type="hidden" id="max_allowed_event_time" name="max_allowed_event_time" value="{{$max_allowed_event_time}}">

<input type="hidden" id="taskEndTime" name="taskEndTime" value="">
	<input type="hidden" id="taskResponsibleConcern" name="taskResponsibleConcern" value="">
	<input type="hidden" id="taskComment" name="taskComment" value="">  
	<input type="hidden" id="taskResolver" name="taskResolver" value="">  
	<input type="hidden" id="taskResolution" name="taskResolution" value="">
	<input type="hidden" id="taskStatusTemp" name="taskStatusTemp" value="">
	
<div id="tt_form_div" class="container-fluid ">
	<span id="top"></span>
	<div id="fixed-top-menu" class="fixed-top-menu">
		
		<span>
		<h2 class="page-title">
			Edit Ticket 
			<a href="{{ url('ViewTTSingle')}}?ticket_id={{$ticketId}}" style="color:#fff"> &nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open"></span></i></a>			
		</h2>
		<span>
			
			<div class="scrollmenu">		
			
			
			<span style="color: black">Fault IDs ({{count($fault_lists)}}) :</span>
			@foreach($fault_lists as $key=>$value)
				<a href="#{{$value->fault_id}}" 
					title=
						@if($value->element_type=="link")
							"{{$value->link_name}}"

						@else
							"{{$value->link_name}}"

						@endif

						@if($value->fault_status != 'closed')
					  		class="open_fault_id_color"
						@else
							class="closed_fault_id_color"
						@endif

					 >{{$value->fault_id}}</a>||
			@endforeach
			<a href="#top" onclick="set_menu_css(-1)"><span class="glyphicon glyphicon-circle-arrow-up"></span></a>
			||
			<a href="#bottom" onclick="set_menu_css(0)"><span class="glyphicon glyphicon-circle-arrow-down"></span></a>
			</div>				
		</span>
		

		

		<input type="hidden" id="session_dept_id" name="session_dept_id" value="{{$_SESSION['dept_id']}}">
		
		

	</div>


	<div class ="scrolling-div">
	<div class="col-md-12" id="static_div">

		<section class="widget" id="default-widget" style="margin-top: 100px">
			<div class="body">
				<div class="row">

					<div class="col-md-3">

						<div class="row" id="ticket_row">
										<div class="col-md-4">
											<p>Ticket ID</p>
										</div>
										<div class="col-md-8">
											<input type="text" id="ticket_id" name="ticket_id" class="form-control input-transparent" value="{{$ticketId}}" readonly>
										</div>
						</div>
						<div class="row" id="ticket_row">
										<div class="col-md-4">
											<p>Ticket Title</p>
										</div>
										<div class="col-md-8">
											<input type="text" id="ticket_title" name="ticket_title" class="form-control input-transparent" value="{{$ticketTitle}}" required>
										</div>
						</div>
						<div class="row" id="ticket_row">
										<div class="col-md-4">
											<p>Ticket Status</p>
										</div>
										<div class="col-md-8">
											<input type="hidden" name="ticket_previous_status"  value="{{$ticketStatus}}">
											@if($ticket_initiator_dept==$_SESSION['dept_id'] && $ticketStatus!='Closed' || $_SESSION['access_type'] =='SL')
												<label style="float:left;">



													<select id="select_style" name="ticket_status">
			                                                <option disabled selected></option>
			                                                @foreach($ticket_status_lists as $ticket_status_list)
			                                                    @if($ticket_status_list->ticket_status_name == $ticketStatus) 
			                                                        <option selected value="{{$ticket_status_list->ticket_status_name}}">{{$ticket_status_list->ticket_status_name}}</option>
			                                                    @else
			                                                        <option value="{{$ticket_status_list->ticket_status_name}}">{{$ticket_status_list->ticket_status_name}}</option>
			                                                    @endif
			                                                @endforeach 
				                                    </select>
				                                </label>
				                                @else
				                                	<input type="text" id="ticket_status" name="ticket_status" class="form-control input-transparent" readonly value="{{$ticketStatus}}"> 
				                                @endif
										</div>
						</div>
						<div class="row" id="ticket_row">
										<div class="col-md-4">
											<p>Attach file</p>
										</div>
										<div class="col-md-8">
											<input type="file" name="ticket_files[]" multiple >
										</div>
						</div>
						<div class="row" id="ticket_row">
										<div class="col-md-4">
											<p>Incident Title</p>
										</div>
										<div class="col-md-8">
											<input type="text" id="incident_title" name="incident_title" class="form-control input-transparent" value="{{$incidentTitle}}" readonly> 
										</div>
						</div>
						<div class="row" id="ticket_row">
										<div class="col-md-4">
											<p>Assigned Dept</p>
										</div>
									    <?php $dept=""; ?>
		                                @for($i=0;$i<count($assigned_dept_arr);$i++)
	    									@foreach($department_lists as $department_list)
	    	                                    @if($department_list->dept_row_id == $assigned_dept_arr[$i]) 
	                                                <?php $dept.=$department_list->dept_name.", "; ?>
	                                            @endif

	                                        @endforeach  
	                                    @endfor

                                   		<?php $dept=trim($dept,", ") ?>
										<div class="col-md-8">
											<input type="text" id="assigned_dept_temp" name="assigned_dept_temp" class="form-control input-transparent" value="{{$dept}}" readonly>
											<input type="hidden" id="assigned_dept" name="assigned_dept" class="form-control input-transparent" value="{{$assignedDept}}">

										</div>
						@if($attachment_path!="")
							<div class="col-md-4">
											<p>Uploaded Files</p>
							</div>
							<div class="col-md-8">
								<a href="{{ url('downloadZip?ticket_id=') }}{{$ticketId}}"><button type="button" class="btn btn-primary"> <span class="glyphicon glyphicon-download-alt"> Download Files</span></button></a>
							</div>

						@endif
						</div>

					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>Previous SCL Comments</td></tr><tr>
								<td>
									<textarea rows="13" class="form-control input-transparent resize_ta" id="previous_comments" name="previous_comments" readonly>
										@foreach($scl_comment_lists as $scl_comment_list)
											{{$scl_comment_list->user_id}}({{$scl_comment_list->dept_id}}): {{$scl_comment_list->comment}}
										@endforeach</textarea>
								</td>
							</tr>

							
						</table>
					</div>

					<div class="col-md-3">
						<table>
							<tr>
								<td>Previous Client Comments</td>
							</tr>
							<tr>
								<td>
									<textarea rows="13" class="form-control input-transparent resize_ta" id="previous_comments" name="previous_comments" readonly>
										@foreach($client_comment_lists as $client_comment_list)
											{{$client_comment_list->user_id}}({{$client_comment_list->dept_id}}): {{$client_comment_list->comment}}
										@endforeach</textarea>
								</td>
							</tr>

							
						</table>
					</div>	

					@if($ticket_initiator_dept==$_SESSION['dept_id'] && $ticketStatus!='Closed')
					<div class="col-md-3">
						<table>
							<tr>
								<td>Previous Initiator Internal Comments</td></tr><tr>
								<td>
									<textarea rows="13" class="form-control input-transparent resize_ta" id="previous_comments" name="previous_comments" readonly>
									@foreach($noc_comment_lists as $noc_comment_list)
										{{$noc_comment_list->user_id}}({{$noc_comment_list->dept_id}}): {{$noc_comment_list->comment}}
									@endforeach</textarea>
								</td>
							</tr>

							
						</table>
					</div>		
					@endif			
					<input type="hidden" id="ticket_initiator_dept" name="ticket_initiator_dept" class="form-control input-transparent" value="{{$ticket_initiator_dept}}">
					
					<div class="col-md-3">
						<table>
							<tr>
								<td>SCL Comment</td>
							</tr>
							<tr>	
								<td>
									<textarea rows="7" class="form-control input-transparent resize_ta" id="ticket_comment_scl" name="ticket_comment_scl" placeholder="optional"></textarea>
								</td>
							</tr>
						</table>
					</div>
					@if($_SESSION['dept_id'] == 10)
					<div class="col-md-3">
						<table>
							<tr>
								<td>Client Comment</td>
							</tr>
							<tr>	
								<td>
									<textarea rows="7" class="form-control input-transparent resize_ta" id="ticket_comment_client" name="ticket_comment_client" placeholder="optional"></textarea>
								</td>
							</tr>
						</table>
					</div>
					@else
					<input type="hidden" name="ticket_comment_client" value="">
					@endif

					@if($ticket_initiator_dept==$_SESSION['dept_id'] && $ticketStatus!='Closed')
					<div class="col-md-3">
						<table>
							<tr>
								<td>Initiator Internal Comment</td>
							</tr>
							<tr>	
								<td>
									<textarea rows="7" class="form-control input-transparent resize_ta" id="ticket_comment_noc" name="ticket_comment_noc" placeholder="optional"></textarea>
								</td>
							</tr>
						</table>
					</div>
					@endif
			
				</div>
			</div>	
		</section>
	</div>

	<br/><br/>
	<div class="col-md-12" id="dynamic_div">
	@foreach($fault_lists as $fault_list)
		<span class="anchor" id="{{$fault_list->fault_id}}"></span>	
		<?php 
				$fault_count=$fault_count+1; 
				$task_count = 0;
				//Fault {{$fault_count}}
		?>
	<div id = "dynamic_div_{{$fault_count}}">
		<section class="widget" id="default-widget"">
			<header>
				<h5> Fault ID : {{$fault_list->fault_id}}</h5>
				@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
				<div class="widget-controls dropdown" required=""><ul class="dropdown-menu dropdown-menu-right" required=""><li class="listkAddTask_" required=""><a class="linkAddTask_" required="" href="#" onclick="addFaultTask({{$fault_count}})">ADD Task</a></li></ul><a class="dropdown-toggle" required="" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog" required=""></i></a></div>@endif
			</header>
			<div class="body">
				<div class="row">
					<div class="col-md-3">
						<table>
							<tr>
								<td>Fault Status</td>
						
								<td>
								@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed'  || $_SESSION['access_type'] =='SL')
									<label style="float:left;">


								<select id="select_style" name="fault_status_{{$fault_count}}" onchange="checkFaultStatus(this.name,{{$fault_count}});">


								@if($fault_list->fault_status=="open")
									<option selected value="open">open</option>
									<option value="closed">closed</option>
								@endif

								@if($fault_list->fault_status=="closed")
									<option selected value="closed">closed</option>
									<option value="open">open</option>
								@endif

								
								</select></label>
								@else
									<input type="text" id="fault_status_{{$fault_count}}" name="fault_status_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->fault_status}}" readonly>
								@endif
								</td>
							</tr>

							<tr>
								<td>Client ID</td>
								<td>
									@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
									<label style="float:left;">
										<input type="hidden" name="client_id_{{$fault_count}}" value="{{$fault_list->client_id}}">
										<select id="select_style" >
											<option disabled></option>
											 @foreach($client_lists as $client_list)
	                                                @if($client_list->client_id == $fault_list->client_id) 
                                                        <option selected value="{{$client_list->client_id}}">{{$client_list->client_name}}--{{$client_list->priority}}</option>
                                                    @else
                                                        <option value="{{$client_list->client_id}}">{{$client_list->client_name}}--{{$client_list->priority}}</option>
                                                    @endif

                                             @endforeach       
	                                    </select>
	                                </label>	


	                                @else 
									<label style="float:left;">
										<input type="hidden" name="client_id_{{$fault_count}}" value="{{$fault_list->client_id}}">
										<select id="select_style" >
											<option disabled></option>
											 @foreach($client_lists as $client_list)
	                                                @if($client_list->client_id == $fault_list->client_id) 
                                                        <option selected value="{{$client_list->client_id}}">{{$client_list->client_name}}--{{$client_list->priority}}</option>
                                                    @endif
                                             @endforeach       
	                                    </select>
	                                </label>
	                                @endif

								</td>
							</tr>						
							<tr>
								<td>Element Type</td>
								
								@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
								<input type="hidden" name="element_type_{{$fault_count}}" value="{{$fault_list->element_type}}">
								<td><label style="float:left;"><select id="select_style">

									
								@if($fault_list->element_type=="link")
									<option selected value="link">Link</option>
								@else
									<option value="link">Link</option>
								@endif

								@if($fault_list->element_type=="site")
									<option selected value="site">Site</option>
								@else
									<option value="site">Site</option>
								@endif

								
								</select></label></td>
								@else
								<td><input type="text" id="element_type_{{$fault_count}}" name="element_type_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->element_type}}" readonly></td>
								@endif

							</tr>


							<tr>
								<td>Element Name</td>
								@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')

									@if($fault_list->element_type=="link")
										
											<td><input type="text" id="element_name_{{$fault_count}}" name="element_name_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->link_name}}" onclick="elementListFunction(this.name);" readonly></td>

									@else
										
											<td><input type="text" id="element_name_{{$fault_count}}" name="element_name_{{$fault_count}}" class="form-control input-transparent" value="<?php echo $fault_list->link_name ?>" onclick="elementListFunction(this.name);" readonly></td>

									@endif
								@else
									@if($fault_list->element_type=="link")

											<td><input type="text" id="element_name_{{$fault_count}}" name="element_name_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->link_name}}" readonly></td>

									@else

											<td><input type="text" id="element_name_{{$fault_count}}" name="element_name_{{$fault_count}}" class="form-control input-transparent" value="<?php echo $fault_list->link_name ?>" readonly></td>

									@endif									
								@endif

							</tr>					


							<tr>
								<td>VLAN ID</td>
							<!-- 	<td><input type="text" id="vlan_id_{{$fault_count}}" name="vlan_id_{{$fault_count}}" class="form-control input-transparent" value=""></td> -->

								@if($fault_list->element_type=="link")
									
										<td><input type="text" id="vlan_id_{{$fault_count}}" name="vlan_id_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->vlan_id}}" readonly></td>

								@else
										<td><input type="text" id="vlan_id_{{$fault_count}}" name="vlan_id_{{$fault_count}}" class="form-control input-transparent" value="" readonly></td>

								@endif
							</tr>
							<tr>
								<td>Link ID</td>
								@if($fault_list->element_type=="link")
									
										<td><input type="text" id="link_id_{{$fault_count}}" name="link_id_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->link_id}}" readonly></td>

								@else
										<td><input type="text" id="link_id_{{$fault_count}}" name="link_id_{{$fault_count}}" class="form-control input-transparent" value="" readonly></td>

								@endif								
							</tr>
							<tr>
								<td>Site IP Address</td>
								@if($fault_list->element_type=="link")
									<td><input type="text" name="site_ip_address_{{$fault_count}}" class="form-control input-transparent" value="" readonly></td>
								@else
								
										<td><input type="text" name="site_ip_address_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->site_ip_address}}" readonly></td>

								@endif	
							</tr>							

						</table>
					</div>
					<div class="col-md-3">
						<table>

							<tr>
								<td>District</td>
								@if($fault_list->element_type=="link")
									
										<td><input type="text" name="district_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->district}}" readonly></td>
									
								@else
									
										<td><input type="text" name="district_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->district}}" readonly></td>

								@endif									
							</tr>
							<tr>
								<td>Region</td>
								@if($fault_list->element_type=="link")

										<td><input type="text" name="region_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->region}}" readonly></td>

								@else

										<td><input type="text" name="region_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->region}}" readonly></td>

								@endif	
							</tr>
							<tr>
								<td>SMS Group</td>
								@if($fault_list->element_type=="link")

										<td><textarea name="sms_group_{{$fault_count}}" rows="2" class="form-control input-transparent" readonly>{{$fault_list->sms_group}}</textarea></td>

								@else

										<td><textarea name="sms_group_{{$fault_count}}" rows="2" class="form-control input-transparent" readonly>{{$fault_list->sms_group}}</textarea></td>

								@endif									
								
							</tr>
							<tr>
								<td>Client Priority</td>
								<td>@foreach($client_lists as $client_list)
	                                                @if($client_list->client_id == $fault_list->client_id) 
                                                       <input type="text" id="client_priority_{{$fault_count}}" name="client_priority_{{$fault_count}}" class="form-control input-transparent" value="{{$client_list->priority}}" readonly>
                                                    @endif

                                       @endforeach 
                                </td> 
								
							</tr>														
							<tr>
								<td>Client Side Impact</td>
								@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
								<td><input type="text" name="client_side_impact_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->client_side_impact}}"></td>
								@else
								<td><input type="text" name="client_side_impact_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->client_side_impact}}" readonly></td>
								@endif
							</tr>
							<tr>
								<td>Link Type</td>
								<td>
								@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
								<label style="float:left;">
									<select id="select_style" name="link_type_{{$fault_count}}">
											<option disabled></option>
											@foreach($link_type_lists as $link_type_list)
	                                                @if($link_type_list->link_type_name == $fault_list->link_type) 
                                                        <option selected value="{{$link_type_list->link_type_name}}">{{$link_type_list->link_type_name}}</option>
                                                    @else 
                                                        <option value="{{$link_type_list->link_type_name}}">{{$link_type_list->link_type_name}}</option>
                                                    @endif

                                             @endforeach 
                                    </select></label>  									
								
								@else
								<label style="float:left;">
									<select id="select_style" name="link_type_{{$fault_count}}">
											<option disabled></option>
											@foreach($link_type_lists as $link_type_list)
	                                                @if($link_type_list->link_type_name == $fault_list->link_type) 
                                                        <option selected value="{{$link_type_list->link_type_name}}">{{$link_type_list->link_type_name}}</option>
                                                    @else 
                                                        
                                                    @endif

                                             @endforeach 
                                    </select></label>  	
								@endif
								</td>
							</tr>							
							
						</table>	
					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>Resolver Team</td>
								<td>
								<select id="select_style" name="responsible_field_team_{{$fault_count}}" id="responsible_field_team_{{$fault_count}}">
									<option disabled></option>
									@if($fault_list->responsible_field_team == "NA")
										<option selected value="NA">NA</option>
										@foreach($department_lists as $department_list)
											<option value="{{$department_list->dept_row_id}}">{{$department_list->dept_name}}</option>
										@endforeach
									@else
										@foreach($department_lists as $department_list)
											@if($fault_list->responsible_field_team == $department_list->dept_row_id)
												<option selected value="{{$department_list->dept_row_id}}">{{$department_list->dept_name}}</option>
											@else
												<option value="{{$department_list->dept_row_id}}">{{$department_list->dept_name}}</option>
											@endif
										@endforeach
									@endif

									
                                </select>
								</td>
							</tr>
							<tr>
								<td>Provider</td>
								<td>

									<label style="float:left;">
										@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
										<select id="select_style" name="provider_name_{{$fault_count}}">
											<option disabled></option>
											 @foreach($client_lists as $client_list)
	                                                @if($client_list->client_id == $fault_list->provider) 
                                                        <option selected value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
                                                    @else
                                                        <option value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
                                                    @endif

                                             @endforeach       
	                                    </select>
	                                    @else
	                                  	<select id="select_style" name="provider_name_{{$fault_count}}">
											<option disabled></option>
											 @foreach($client_lists as $client_list)
	                                                @if($client_list->client_id == $fault_list->provider) 
                                                        <option selected value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
                                                    @else
                                                       
                                                    @endif

                                             @endforeach       
	                                    </select>
	                                    @endif 
	                                </label>
								</td>
							</tr>
							<tr>
								<td>Reason</td>
								<td>
								<label style="float:left;">
									@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
									<select id="select_style" name="reason_{{$fault_count}}">
											<option disabled></option>
											@foreach($reason_lists as $reason_list)
	                                                @if($reason_list->reason_name == $fault_list->reason) 
                                                        <option selected value="{{$reason_list->reason_name}}">{{$reason_list->reason_name}}</option>
                                                    @else
                                                        <option value="{{$reason_list->reason_name}}">{{$reason_list->reason_name}}</option>
                                                    @endif

                                             @endforeach 
                                    </select>
                                    @else
									<select id="select_style" name="reason_{{$fault_count}}">
											<option disabled></option>
											@foreach($reason_lists as $reason_list)
	                                                @if($reason_list->reason_name == $fault_list->reason) 
                                                        <option selected value="{{$reason_list->reason_name}}">{{$reason_list->reason_name}}</option>
                                                    @else
                                                        
                                                    @endif

                                             @endforeach 
                                    </select>
                                    @endif
                                </label>  									
								</td>
							</tr>
							<tr>
								<td>Issue Type</td>
								<td>
								<label style="float:left;">
									@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
									<select id="select_style" name="issue_type_{{$fault_count}}">
											<option disabled></option>
											@foreach($issue_type_lists as $issue_type_list)
	                                                @if($issue_type_list->issue_type_name == $fault_list->issue_type) 
                                                        <option selected value="{{$issue_type_list->issue_type_name}}">{{$issue_type_list->issue_type_name}}</option>
                                                    @else
                                                        <option value="{{$issue_type_list->issue_type_name}}">{{$issue_type_list->issue_type_name}}</option>
                                                    @endif

                                             @endforeach 
                                    </select>
                                    @else
									<select id="select_style" name="issue_type_{{$fault_count}}">
											<option disabled></option>
											@foreach($issue_type_lists as $issue_type_list)
	                                                @if($issue_type_list->issue_type_name == $fault_list->issue_type) 
                                                        <option selected value="{{$issue_type_list->issue_type_name}}">{{$issue_type_list->issue_type_name}}</option>
                                                    @else
                                                        
                                                    @endif

                                             @endforeach 
                                    </select>
                                    @endif
                                	</label>         
								</td>
							</tr>						
							<tr>
								<td>Problem Category</td>
								<td>
								<label style="float:left;">
									@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
									<select id="select_style" name="problem_category_{{$fault_count}}">
											<option disabled></option>@foreach($problem_category_lists as $problem_category_list)
	                                                @if($problem_category_list->problem_name == $fault_list->problem_category) 
                                                        <option selected value="{{$problem_category_list->problem_name}}">{{$problem_category_list->problem_name}}</option>
                                                    @else
                                                        <option value="{{$problem_category_list->problem_name}}">{{$problem_category_list->problem_name}}</option>
                                                    @endif

                                             @endforeach 
                                              </select>
                                    @else
 									<select id="select_style" name="problem_category_{{$fault_count}}">
											<option disabled></option>@foreach($problem_category_lists as $problem_category_list)
	                                                @if($problem_category_list->problem_name == $fault_list->problem_category) 
                                                        <option selected value="{{$problem_category_list->problem_name}}">{{$problem_category_list->problem_name}}</option>
                                                    @else
                                                        
                                                    @endif

                                             @endforeach 
                                              </select>                                   
                                    @endif          
                                          </label> 									
								</td>
							</tr>
							<tr>
								<td>Problem Source</td>
								<td>
								<label style="float:left;">
									@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
										<select id="select_style" name="problem_source_{{$fault_count}}">
											<option disabled></option>
											 @foreach($problem_source_lists as $problem_source_list)
	                                                @if($problem_source_list->problem_source_name == $fault_list->problem_source) 
                                                        <option selected value="{{$problem_source_list->problem_source_name}}">{{$problem_source_list->problem_source_name}}</option>
                                                    @else
                                                        <option value="{{$problem_source_list->problem_source_name}}">{{$problem_source_list->problem_source_name}}</option>
                                                    @endif

                                             @endforeach       
	                                    </select>
	                                    @else
										<select id="select_style" name="problem_source_{{$fault_count}}">
											<option disabled></option>
											 @foreach($problem_source_lists as $problem_source_list)
	                                                @if($problem_source_list->problem_source_name == $fault_list->problem_source) 
                                                        <option selected value="{{$problem_source_list->problem_source_name}}">{{$problem_source_list->problem_source_name}}</option>
                                                    @else
                                                        
                                                    @endif

                                             @endforeach       
	                                    </select>
	                                    @endif
	                                </label>
								</td>
							</tr>							


							<tr>
								<td>Responsible Vendor</td>
								@if($fault_list->element_type=="link")
									
										<td><input type="text" id="responsible_vendor_{{$fault_count}}" name="responsible_vendor_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->vendor}}" readonly></td>

								@else

										<td><input type="text" id="responsible_vendor_{{$fault_count}}" name="responsible_vendor_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->vendor}}" readonly></td>

								@endif									
							</tr>							

						</table>
					</div>
					<div class="col-md-3">
						<table>

							<tr>
								<td>Escalation Time</td>
								<td>
									@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
									<div id="escalation_time_{{$fault_count}}" class="input-group">
	                                    <input type="text" name="escalation_time_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->escalation_time}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
	                                @else
	                                	<input type="text" name="escalation_time_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->escalation_time}}" readonly>
	                                @endif
								</td>
							</tr>						
							<tr>
								<td>Resolver Concern</td>
								<td>
									@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
									<input type="text" id="responsible_concern_{{$fault_count}}" name="responsible_concern_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->responsible_concern}}" onclick="responsibleFieldView(this.id);">
									@else
									<input type="text" id="responsible_concern_{{$fault_count}}" name="responsible_concern_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->responsible_concern}}" readonly>
									@endif
								</td>

							</tr>
							<tr>
								<td>Event Time</td>
								<td>
									@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
									<div id="event_time_{{$fault_count}}" class="input-group">
	                                    <input type="text" name="event_time_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->event_time}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div>
	                                @else 
	                                <input type="text" name="event_time_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->event_time}}" readonly>
	                                @endif
								</td>
							</tr>
							<tr>
							<td>Clear Time</td>
								<td>
									@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
									<div id="clear_time_{{$fault_count}}" class="input-group">
	                                    <input type="text" name="clear_time_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->clear_time}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
	                                @else
	                                <input type="text" name="clear_time_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->clear_time}}" readonly>
	                                @endif
								</td>
							</tr>																					
							<tr>
								<td>Provider Side Impact</td>
								@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
								<td><textarea rows="4" class="form-control input-transparent" id="provider_side_impact_{{$fault_count}}" name="provider_side_impact_{{$fault_count}}">{{$fault_list->provider_side_impact}}</textarea></td>
								@else
								<td><textarea rows="4" class="form-control input-transparent" id="provider_side_impact_{{$fault_count}}" name="provider_side_impact_{{$fault_count}}" readonly>{{$fault_list->provider_side_impact}}</textarea></td>
								@endif
							</tr>
							
							<tr>
								<td>Remarks</td>
								@if($ticket_initiator_dept==$_SESSION['dept_id'] && $fault_list->fault_status!='closed')
								<td><textarea rows="4" class="form-control input-transparent" id="remarks_{{$fault_count}}" name="remarks_{{$fault_count}}"></textarea></td>
								@else
								<td><textarea rows="4" class="form-control input-transparent" id="remarks_{{$fault_count}}" name="remarks_{{$fault_count}}" readonly></textarea></td>
								@endif
							</tr>
							<tr>
								<td>Previous Remarks</td>
								<td><textarea rows="4" class="form-control input-transparent" id="previous_remarks_{{$fault_count}}" name="previous_remarks_{{$fault_count}}" readonly>{{$fault_list->remarks}}</textarea></td>
							</tr>							
							<input type="hidden" name="element_id_{{$fault_count}}" id="element_id_{{$fault_count}}" value="{{$fault_list->element_id}}">
							<input type="hidden" name="fault_id_{{$fault_count}}" id="fault_id_{{$fault_count}}" value="{{$fault_list->fault_id}}">
						</table>
					</div>
				</div>

			</div>

		</section>
			@foreach($task_lists as $task_list)
				@if($task_list->fault_id==$fault_list->fault_id)
				<?php
					$task_count = $task_count+1;
				?>
				<div class="row">
						<div class="col-md-1">
						</div>
						<div class="col-md-10">
							<section class="widget" id="default-widget"
								@foreach($department_lists as $department_list)
	                        		@if($department_list->dept_row_id == $task_list->task_assigned_dept)
	                        			@if($department_list->dept_name == $_SESSION['department'] ) 
                                		style="border: 2px solid #E6F7BF;"
                                		@endif

                                	@endif
                            	 @endforeach

							>
							<header>

							<div class="widget-controls dropdown" required="">
								<ul class="dropdown-menu dropdown-menu-right" required="">
									<li class="copyTask" required="">
										<a class="linkAddTask_" required="" href="javascript:void();" onclick="copyFaultTask({{$fault_count}},{{$task_count}})">Copy
										</a>
									</li>

									@if($task_list->task_assigned_dept == $_SESSION['dept_id'])
									<li class="pasteTask" required="">
										<a class="linkAddTask_" required="" href="javascript:void();" onclick="pasteFaultTask({{$fault_count}},{{$task_count}})">Paste
										</a>
									</li>
									@endif

									@if($task_list->task_assigned_dept == $_SESSION['dept_id'] && $task_list->task_status!="Closed")
									<li class="pasteTask" required="">
										<a class="linkAddTask_" required="" href="javascript:void();" onclick="CopyToTaskStartTime({{$fault_count}},{{$task_count}})">
											Choose task start time as fault event time 
										</a>
									</li>
									@endif

									@if($_SESSION['dept_id'] == '10' && $task_list->task_status=="Closed")
									<li class="pasteTask" required="">
										<a class="linkAddTask_" required="" href="javascript:void();" onclick="selectFaultClearTime({{$fault_count}},{{$task_count}})">Select Fault Clear Time</a>
									</li>	
									@endif
								</ul><a class="dropdown-toggle" required="" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog" required=""></i></a>
							</div>
						</header>
								<table>
									<tr>
										<td colspan="8"> *** PLease add Resolution first while Closing/ Return to Initiator / Forward task. Otherwise just for acknowledgement no need to add task resolution. Just Comment. ***</td>
									</tr>
									<tr>
										<th>Task Title</th>
										<th>Task Description</th>
										<th>Assigned Department</th>
										<th>Task Start Time</th>
										<th>Task End Time</th>
										<th>Task Start (System Time)</th>
										<th>Task End (System Time)</th>
										<th>Task Status</th>
									
									</tr>
									<tr>
										<td>
											@if($ticket_initiator_dept==$_SESSION['dept_id'] && $ticketStatus!='Closed')
												<input class="form-control input-transparent" required readonly type="text"  value="{{$task_list->task_name}}">
												<label style="float:left;">
													<select id="select_style" required name="fault_{{$fault_count}}_task_{{$task_count}}_name">
			                                                <option disabled selected></option>
			                                                @foreach($task_title_lists as $task_title_list)
			                                                    @if($task_title_list->title_name == $task_list->task_name) 
			                                                        <option selected value="{{$task_title_list->title_name}}">{{$task_title_list->title_name}}</option>
			                                                    @else
			                                                        <option value="{{$task_title_list->title_name}}">{{$task_title_list->title_name}}</option>
			                                                    @endif
			                                                @endforeach 
				                                    </select>
				                                </label>
				                            @else
				                            	<input class="form-control input-transparent" required readonly type="text" name="fault_{{$fault_count}}_task_{{$task_count}}_name" id="fault_{{$fault_count}}_task_{{$task_count}}_name" value="{{$task_list->task_name}}">
				                            @endif
										</td>
										<td><textarea class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_description" id="fault_{{$fault_count}}_task_{{$task_count}}_description" required readonly>{{$task_list->task_description}}</textarea></td>
										<td><select id="select_style" name="fault_{{$fault_count}}_task_{{$task_count}}_assigned_dept" required>
											<option disabled selected></option>
											 @foreach($department_lists as $department_list)
	                                                @if($department_list->dept_row_id == $task_list->task_assigned_dept) 
                                                        <option selected value="{{$department_list->dept_row_id}}">{{$department_list->dept_name}}</option>

                                                    @endif
                                                    @if($task_list->task_assigned_dept==$_SESSION['dept_id'])
                                                    		@if($department_list->dept_row_id==42)
                                                        		<option value="{{$department_list->dept_row_id}}">{{$department_list->dept_name}}</option>
                                                        	@endif
                                                    @endif

                                                   

                                             @endforeach 

										</select></td>

										@if($ticket_initiator_dept==$_SESSION['dept_id'] && $task_list->task_status!="Closed")
										<td><div class="input-group" id="fault_{{$fault_count}}_task_{{$task_count}}_start_time"><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_start_time" value="{{$task_list->task_start_time}}" type="text"><span class="input-group-addon btn btn-info"><span class="glyphicon glyphicon-calendar"></span></span></div></td>
										@else
										<td><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_start_time" value="{{$task_list->task_start_time}}" required readonly type="text"></td>
										@endif
<!-- 	                                    <td>
	                                    	<div class="input-group" id="fault_{{$fault_count}}_task_{{$task_count}}_start_time" required><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_start_time" value="{{$task_list->task_start_time}}" required="" type="text"><span class="input-group-addon btn btn-info" required><span class="glyphicon glyphicon-calendar" required=""></span></span></div>
	                                    </td> -->
	                                    @if($task_list->task_end_time=="" && ($task_list->task_assigned_dept==$_SESSION['dept_id'] || $ticket_initiator_dept==$_SESSION['dept_id']))
	                                    <td><div class="input-group" id="fault_{{$fault_count}}_task_{{$task_count}}_end_time"><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_end_time" value="{{$task_list->task_end_time}}" type="text"><span class="input-group-addon btn btn-info"><span class="glyphicon glyphicon-calendar"></span></span></div></td>
	                                    @else
	                                    <td><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_end_time" value="{{$task_list->task_end_time}}" type="text" readonly=""></td>
	                                    @endif
	                                    <td><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_start_time_db" value="{{$task_list->task_start_time_db}}" type="text" readonly></td>	                                    
	                                    <td><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_end_time_db" value="{{$task_list->task_end_time_db}}" type="text" readonly></td>


	                                   	@if($task_list->task_status!="Closed" && $task_list->task_assigned_dept==$_SESSION['dept_id'])
	                                    <td><select  id="select_style" name="fault_{{$fault_count}}_task_{{$task_count}}_status" required onchange="checkTaskStatus(this.name,{{$fault_count}});">
											<option disabled selected></option>
											 @foreach($task_status_lists as $task_status_list)
											 		<!-- THIS IS THE MAIN CODE PORTION -->
													 @if($task_status_list->task_status == $task_list->task_status) 
																<option selected value="{{$task_status_list->task_status}}">{{$task_status_list->task_status_full_form}}</option>
													 @else
																@if($ticket_initiator_dept==$_SESSION['dept_id'])
																	<option value="{{$task_status_list->task_status}}">{{$task_status_list->task_status_full_form}}</option>
																@else
																	@if($task_status_list->task_status!='Closed' && $task_status_list->task_status!='Client Confirmation Pending')
																		<option value="{{$task_status_list->task_status}}">{{$task_status_list->task_status_full_form}}</option>
																	@endif
																@endif
													@endif
													<!-- END OF CODE PART -->
                                             @endforeach 
										</select></td>
										@else
											@if($task_list->task_status =="Closed") 
											<td><select  class="closed_task_status" id="select_style" name="fault_{{$fault_count}}_task_{{$task_count}}_status" required disabled onchange="checkTaskStatus(this.name,{{$fault_count}});">
											@else
											<td><select class="open_task_status" id="select_style" name="fault_{{$fault_count}}_task_{{$task_count}}_status" required disabled onchange="checkTaskStatus(this.name,{{$fault_count}});">
											@endif	
											<option disabled selected></option>
											 @foreach($task_status_lists as $task_status_list)
	                                                @if($task_status_list->task_status == $task_list->task_status) 
                                                        <option selected value="{{$task_status_list->task_status}}">{{$task_status_list->task_status_full_form}}</option>
                                                    @else
                                                        <option value="{{$task_status_list->task_status}}">{{$task_status_list->task_status_full_form}}</option>
                                                    @endif

                                             @endforeach 
										</select></td>
										@endif


									</tr>
								</table>
								<table>
									<tr>
										<th>Subcenter</th>
										<th>Responsible Concern</th>
										<th>Task Comment</th>
										<th>Task Resolver</th>
										<th>Task Resolution</th>
										<th>Previous Comments</th>
										@if($task_list->task_status!="Closed" && $task_list->task_assigned_dept!=$_SESSION['dept_id'] && $ticket_initiator_dept==$_SESSION['dept_id'])
										<th>On Behalf</th>
										@endif
									</tr>
									<tr>
	                                   	<td><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_subcenter" value="{{$task_list->subcenter}}" type="text" readonly></td>
	                                   	@if($task_list->task_status!="Closed" && $ticket_initiator_dept==$_SESSION['dept_id'])
	                                    <td><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_task_responsible" id="fault_{{$fault_count}}_task_{{$task_count}}_task_responsible" value="{{$task_list->task_responsible}}" type="text" onclick="responsibleFieldView(this.id);" readonly></td>
	                                    @else
	                                    <td><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_task_responsible" id="fault_{{$fault_count}}_task_{{$task_count}}_task_responsible" value="{{$task_list->task_responsible}}" type="text" readonly></td>
	                                    @endif
										@if($task_list->task_status!="Closed" && $task_list->task_assigned_dept==$_SESSION['dept_id'])
											<td><textarea class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_comment" id="fault_{{$fault_count}}_task_{{$task_count}}_comment"></textarea></td>

											@if($task_list->task_resolver=="")
												@if($_SESSION['dept_id'] == 10)
												<td><textarea class="form-control input-transparent keydownDisabled" id="fault_{{$fault_count}}_task_{{$task_count}}_resolver" name="fault_{{$fault_count}}_task_{{$task_count}}_resolver" onclick="responsibleFieldView(this.id);">{{$_SESSION['email']}}</textarea></td>
												@else
												<td><textarea class="form-control input-transparent keydownDisabled" id="fault_{{$fault_count}}_task_{{$task_count}}_resolver" name="fault_{{$fault_count}}_task_{{$task_count}}_resolver" onclick="responsibleFieldView(this.id);">{{$task_list->task_resolver}}</textarea></td>
												@endif
											@else
											<td><textarea class="form-control input-transparent keydownDisabled" id="fault_{{$fault_count}}_task_{{$task_count}}_resolver" name="fault_{{$fault_count}}_task_{{$task_count}}_resolver" >{{$task_list->task_resolver}}</textarea></td>
											@endif
												<td><textarea class="form-control input-transparent keydownDisabled" id="fault_{{$fault_count}}_task_{{$task_count}}_resolution" name="fault_{{$fault_count}}_task_{{$task_count}}_resolution" onclick="TaskResolutionView(this.id,{{$ticketId}},{{$fault_list->fault_id}});">{{$task_list->task_resolution_ids}}</textarea></td>
											
											<td><textarea class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_previous_comment" id="fault_{{$fault_count}}_task_{{$task_count}}_previous_comment" readonly><?php echo str_replace(" || ","\r\n",$task_list->task_comments); ?></textarea></td>

										@else	

											<td><textarea class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_comment" id="fault_{{$fault_count}}_task_{{$task_count}}_comment" disabled></textarea></td>

											@if($task_list->task_resolver=="")
											<td><textarea class="form-control input-transparent" id="fault_{{$fault_count}}_task_{{$task_count}}_resolver" name="fault_{{$fault_count}}_task_{{$task_count}}_resolver" onclick="responsibleFieldView(this.id);" disabled>{{$task_list->task_resolver}}</textarea></td>
											@else
											<td><textarea class="form-control input-transparent" id="fault_{{$fault_count}}_task_{{$task_count}}_resolver" name="fault_{{$fault_count}}_task_{{$task_count}}_resolver" onclick="responsibleFieldView(this.id);" disabled>{{$task_list->task_resolver}}</textarea></td>
											@endif
										<!-- 	<td><textarea class="form-control input-transparent" id="fault_{{$fault_count}}_task_{{$task_count}}_resolver" name="fault_{{$fault_count}}_task_{{$task_count}}_resolver" disabled onclick="responsibleFieldView(this.id);">{{$task_list->task_resolver}}</textarea></td> -->
											@if($task_list->task_resolution_ids=="")
												<td><textarea class="form-control input-transparent" id="fault_{{$fault_count}}_task_{{$task_count}}_resolution" name="fault_{{$fault_count}}_task_{{$task_count}}_resolution" disabled onclick="TaskResolutionView(this.id,{{$ticketId}},{{$fault_list->fault_id}});">{{$task_list->task_resolution_ids}}</textarea></td>
											@else
												<td><textarea class="form-control input-transparent" id="fault_{{$fault_count}}_task_{{$task_count}}_resolution" name="fault_{{$fault_count}}_task_{{$task_count}}_resolution" disabled onclick="TaskResolutionView(this.id,{{$ticketId}},{{$fault_list->fault_id}});">{{$task_list->task_resolution_ids}}</textarea></td>
											@endif
											<td><textarea class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_previous_comment" id="fault_{{$fault_count}}_task_{{$task_count}}_previous_comment" readonly><?php echo str_replace(" || ","\r\n",$task_list->task_comments); ?></textarea></td>
										@endif	

										@if($task_list->task_status!="Closed" && $ticket_initiator_dept==$_SESSION['dept_id'])

											<td><input type='checkbox' name="fault_{{$fault_count}}_task_{{$task_count}}_on_behalf" id="fault_{{$fault_count}}_task_{{$task_count}}_on_behalf" class="form-control input-transparent" onchange="onBehalf(this,this.id);"></td>
										@else
											@if($task_list->task_name == 'RFO Pending' && $ticket_initiator_dept==$_SESSION['dept_id'])
												<td><input type='checkbox' name="fault_{{$fault_count}}_task_{{$task_count}}_on_behalf" id="fault_{{$fault_count}}_task_{{$task_count}}_on_behalf" class="form-control input-transparent" onchange="onBehalf(this,this.id);"></td>
											@endif

										@endif
										<input type="hidden" name="fault_{{$fault_count}}_task_{{$task_count}}_previous_status" id="fault_{{$fault_count}}_task_{{$task_count}}_previous_status" value="{{$task_list->task_status}}">
										<input type="hidden" name="fault_{{$fault_count}}_task_{{$task_count}}_id" id="fault_{{$fault_count}}_task_{{$task_count}}_id" value="{{$task_list->task_id}}">
										<input type="hidden" name="fault_{{$fault_count}}_task_{{$task_count}}_on_behalf_checker" id="fault_{{$fault_count}}_task_{{$task_count}}_on_behalf_checker" value="0">
									</tr>	
								</table>
							</section>	
						</div>
						<div class="col-md-1">
						</div>
				</div>
				@endif


			@endforeach
			<input type="hidden" name="fault_{{$fault_count}}_init_task_counter" id="fault_{{$fault_count}}_init_task_counter" value="{{$task_count}}">
			<input type="hidden" name="fault_{{$fault_count}}_task_counter" id="fault_{{$fault_count}}_task_counter" value="{{$task_count}}">
			<input type="hidden" name="fault_{{$fault_count}}_task_hidden_ids" id="fault_{{$fault_count}}_task_hidden_ids" value="">
		</div>
		@endforeach

		
	</div>


	<input type="hidden" name="fault_count" id="fault_count" value="{{$fault_count}}">
	<input type="hidden" name="incident_id" id="incident_id" value="{{$incidentId}}">
	
</div>
<center><button class="btn btn-primary" id="edit_button">SAVE</button></center><hr/>
<span id="bottom"></span>
</div>
</form>
 <script>
$('a[href^="#"][href!="#"][href!="#dashboard-collapse"][href!="#ticket-collapse"][href!="#fault-collapse"][href!="#task-collapse"][href!="#kpi-collapse"][href!="#link-collapse"][href!="#site-collapse"][href!="#client-collapse"][href!="#incident-collapse"]').anchorlink({
  timer : 500,
  scrollOnLoad : true,
  offsetTop : 0,
  focusClass : 'js-focus',
  beforeScroll: function() {},
  afterScroll : function() {}
});

$(window).on("scroll", function(){
		if($(document).scrollTop() != '0'){
			document.getElementById("fixed-top-menu").classList.add('whitish_menu');
		}
		else{
			
			document.getElementById("fixed-top-menu").classList.remove('whitish_menu');
		}
});

$( function() {
    $( document ).tooltip();
  } );
</script>
@include('navigation.p_footer')
