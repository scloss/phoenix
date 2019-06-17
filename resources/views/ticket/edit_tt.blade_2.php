@include('navigation.p_header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--   <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript" src="{{asset('js/edit_tt.js')}}"></script>
<script src="{{asset('lib/moment/moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<style type="text/css">
	table{
		
		width:100%;
		border-collapse:separate; 
		border-spacing: 0px 7px;
	}	
	table td{
		text-align:center;
	}
</style>
<script type="text/javascript">

	var department_list_js_arr = <?php echo json_encode($department_list_js_arr) ?>;
	var department_id_list_js_arr = <?php echo json_encode($department_id_list_js_arr) ?>;
	var subcenter_list_js_arr = <?php echo json_encode($subcenter_list_js_arr) ?>;
	var client_js_arr = <?php echo json_encode($client_js_arr) ?>;
	

</script>
<form id="tt_create_form" action="{{ url('EditTicket') }}" method="POST" enctype="multipart/form-data">     
<div id="tt_form_div" class="container-fluid">
	<h2 class="page-title">Edit Ticket <span class="fw-semi-bold"></span></h2>
	<div class="col-md-12" id="static_div">

		<section class="widget" id="default-widget">
			<div class="body">
				<div class="row">

					<div class="col-md-3">
						<table>
							<tr>
								<td>Ticket ID</td>
								<td><input type="text" id="ticket_id" name="ticket_id" class="form-control input-transparent" value="{{$ticketId}}" readonly></td>

							</tr>
							<tr>
								<td>Ticket Title</td>
								<td><input type="text" id="ticket_title" name="ticket_title" class="form-control input-transparent" value="{{$ticketTitle}}"> </td>
							</tr>
							<tr>
								<td>Ticket Status</td>
								<td>
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
								</td>
							</tr>
							<tr>
								<td>Attach file</td>
								<td><input type="file" name="ticket_files" ></td>
							</tr>

							<tr>
								<td>Incident Title</td>
								<td><input type="text" id="incident_title" name="incident_title" class="form-control input-transparent" value="{{$incidentTitle}}" readonly> </td>
							</tr>

							<tr>
								<td>Assigned Dept</td>
								
<!-- 									<label style="float:left;">
										<select id="select_style" name="assigned_dept">
											<option disabled selected></option>
											 @foreach($department_lists as $department_list)
	                                                @if($department_list->dept_row_id == $assignedDept) 
                                                        <option selected value="{{$department_list->dept_row_id}}">{{$department_list->dept_name}}</option>
                                                    @else
                                                        <option value="{{$department_list->dept_row_id}}">{{$department_list->dept_name}}</option>
                                                    @endif

                                             @endforeach       
	                                    </select>
	                                </label> -->
	                                <?php $dept=""; ?>
	                                @for($i=0;$i<count($assigned_dept_arr);$i++)
    									@foreach($department_lists as $department_list)
    	                                    @if($department_list->dept_row_id == $assigned_dept_arr[$i]) 
                                                <?php $dept.=$department_list->dept_name.", "; ?>
                                            @endif

                                        @endforeach  
                                    @endfor

                                    <?php $dept=trim($dept,", ") ?>
                                    <td><input type="text" id="assigned_dept_temp" name="assigned_dept_temp" class="form-control input-transparent" value="{{$dept}}" readonly> </td>
									<input type="hidden" id="assigned_dept" name="assigned_dept" class="form-control input-transparent" value="{{$assignedDept}}">

							</tr>

							<tr>
							@if($attachment_path!="")
								<td>Uploaded Files</td>
								<td><a href="{{ url('downloadZip?ticket_id=') }}{{$ticketId}}"><button type="button" class="btn btn-primary"> <span class="glyphicon glyphicon-download-alt"> Download Files</span></button></a></td>
							@endif

							</tr>
						</table>
					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>Previous SCL Comments</td></tr><tr>
								<td>
									<textarea rows="13" class="form-control input-transparent" id="previous_comments" name="previous_comments">@foreach($scl_comment_lists as $scl_comment_list){{$scl_comment_list->user_id}}({{$scl_comment_list->dept_id}}): {{$scl_comment_list->comment}}@endforeach</textarea>
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
									<textarea rows="13" class="form-control input-transparent" id="previous_comments" name="previous_comments">@foreach($client_comment_lists as $client_comment_list){{$client_comment_list->user_id}}({{$client_comment_list->dept_id}}): {{$client_comment_list->comment}}@endforeach</textarea>
								</td>
							</tr>

							
						</table>
					</div>	


					<div class="col-md-3">
						<table>
							<tr>
								<td>Previous Initiator Internal Comments</td></tr><tr>
								<td>
									<textarea rows="13" class="form-control input-transparent" id="previous_comments" name="previous_comments">@foreach($noc_comment_lists as $noc_comment_list){{$noc_comment_list->user_id}}({{$noc_comment_list->dept_id}}): {{$noc_comment_list->comment}}@endforeach</textarea>
								</td>
							</tr>

							
						</table>
					</div>					
					<div class="col-md-3"></div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>SCL Comment</td>
							</tr>
							<tr>	
								<td>
									<textarea rows="7" class="form-control input-transparent" id="ticket_comment_scl" name="ticket_comment_scl"></textarea>
								</td>
							</tr>
						</table>
					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>Client Comment</td>
							</tr>
							<tr>	
								<td>
									<textarea rows="7" class="form-control input-transparent" id="ticket_comment_client" name="ticket_comment_client"></textarea>
								</td>
							</tr>
						</table>
					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>Initiator Internal Comment</td>
							</tr>
							<tr>	
								<td>
									<textarea rows="7" class="form-control input-transparent" id="ticket_comment_noc" name="ticket_comment_noc"></textarea>
								</td>
							</tr>
						</table>
					</div>
	
				</div>
			</div>	
		</section>
	</div>

	<br/><br/>
	<div class="col-md-12" id="dynamic_div">
	@foreach($fault_lists as $fault_list)

		<?php 
				$fault_count=$fault_count+1; 
				$task_count = 0;
		?>
	<div id = "dynamic_div_{{$fault_count}}">
		<section class="widget" id="default-widget"">
			<header>
				<h5>Fault {{$fault_count}}</h5>
				<div class="widget-controls dropdown" required=""><ul class="dropdown-menu dropdown-menu-right" required=""><li class="listkAddTask_" required=""><a class="linkAddTask_" required="" href="#" onclick="addFaultTask({{$fault_count}})">ADD Task</a></li></ul><a class="dropdown-toggle" required="" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog" required=""></i></a></div>
			</header>
			<div class="body">
				<div class="row">
					<div class="col-md-3">
						<table>
							<tr>
								<td>Fault Status</td>
						
								<td><label style="float:left;">


								<select id="select_style" name="fault_status_{{$fault_count}}">


								@if($fault_list->fault_status=="open")
									<option selected value="open">open</option>
									<option value="closed">closed</option>
								@endif

								@if($fault_list->fault_status=="closed")
									<option selected value="closed">closed</option>
									<option value="open">open</option>
								@endif

								
								</select></label></td>
							</tr>

							<tr>
								<td>Client ID</td>
								<td>

									<label style="float:left;">
										<select id="select_style" name="client_id_{{$fault_count}}" onchange="onChangeClient(this.name);">
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
								</td>
							</tr>						
							<tr>
								<td>Element Type</td>
						
								<td><label style="float:left;"><select id="select_style" name="element_type_{{$fault_count}}" onchange="onChangeElement(this.name);">


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
							</tr>


							<tr>
								<td>Element Name</td>

								@if($fault_list->element_type=="link")
									@foreach($link_lists as $link_list)
										@if($fault_list->element_id==$link_list->link_name_id)
										<td><input type="text" id="element_name_{{$fault_count}}" name="element_name_{{$fault_count}}" class="form-control input-transparent" value="{{$link_list->link_name}}" onclick="elementListFunction(this.name);" readonly></td>
										@endif
									@endforeach	
								@else
									@foreach($site_lists as $site_list)
										@if($fault_list->element_id==$site_list->site_name_id)
										<td><input type="text" id="element_name_{{$fault_count}}" name="element_name_{{$fault_count}}" class="form-control input-transparent" value="{{$site_list->site_name}}" onclick="elementListFunction(this.name);" readonly></td>
										@endif
									@endforeach	
								@endif
							</tr>					


							<tr>
								<td>VLAN ID</td>
							<!-- 	<td><input type="text" id="vlan_id_{{$fault_count}}" name="vlan_id_{{$fault_count}}" class="form-control input-transparent" value=""></td> -->

								@if($fault_list->element_type=="link")
									@foreach($link_lists as $link_list)
										@if($fault_list->element_id==$link_list->link_name_id)
										<td><input type="text" id="vlan_id_{{$fault_count}}" name="vlan_id_{{$fault_count}}" class="form-control input-transparent" value="{{$link_list->vlan_id}}" readonly></td>
										@endif
									@endforeach	
								@else
										<td><input type="text" id="vlan_id_{{$fault_count}}" name="vlan_id_{{$fault_count}}" class="form-control input-transparent" value="" readonly></td>

								@endif
							</tr>
							<tr>
								<td>Link ID</td>
								@if($fault_list->element_type=="link")
									@foreach($link_lists as $link_list)
										@if($fault_list->element_id==$link_list->link_name_id)
										<td><input type="text" id="link_id_{{$fault_count}}" name="link_id_{{$fault_count}}" class="form-control input-transparent" value="{{$link_list->link_id}}" readonly></td>
										@endif
									@endforeach	
								@else
										<td><input type="text" id="link_id_{{$fault_count}}" name="link_id_{{$fault_count}}" class="form-control input-transparent" value="" readonly></td>

								@endif								
							</tr>
							<tr>
								<td>Site IP Address</td>
								@if($fault_list->element_type=="link")
									<td><input type="text" name="site_ip_address_{{$fault_count}}" class="form-control input-transparent" value="" readonly></td>
								@else
									@foreach($site_lists as $site_list)
										@if($fault_list->element_id==$site_list->site_name_id)
										<td><input type="text" name="site_ip_address_{{$fault_count}}" class="form-control input-transparent" value="{{$site_list->site_ip_address}}" readonly></td>
										@endif
									@endforeach
								@endif	
							</tr>							

						</table>
					</div>
					<div class="col-md-3">
						<table>

							<tr>
								<td>District</td>
								@if($fault_list->element_type=="link")
									@foreach($link_lists as $link_list)
										@if($fault_list->element_id==$link_list->link_name_id)
										<td><input type="text" name="district_{{$fault_count}}" class="form-control input-transparent" value="{{$link_list->district}}" readonly></td>
										@endif
									@endforeach
								@else
									@foreach($site_lists as $site_list)
										@if($fault_list->element_id==$site_list->site_name_id)
										<td><input type="text" name="district_{{$fault_count}}" class="form-control input-transparent" value="{{$site_list->district}}" readonly></td>
										@endif
									@endforeach
								@endif									
							</tr>
							<tr>
								<td>Region</td>
								@if($fault_list->element_type=="link")
									@foreach($link_lists as $link_list)
										@if($fault_list->element_id==$link_list->link_name_id)
										<td><input type="text" name="region_{{$fault_count}}" class="form-control input-transparent" value="{{$link_list->region}}" readonly></td>
										@endif
									@endforeach
								@else
									@foreach($site_lists as $site_list)
										@if($fault_list->element_id==$site_list->site_name_id)
										<td><input type="text" name="region_{{$fault_count}}" class="form-control input-transparent" value="{{$site_list->region}}" readonly></td>
										@endif
									@endforeach
								@endif	
							</tr>
							<tr>
								<td>SMS Group</td>
								@if($fault_list->element_type=="link")
									@foreach($link_lists as $link_list)
										@if($fault_list->element_id==$link_list->link_name_id)
										<td><textarea name="sms_group_{{$fault_count}}" rows="2" class="form-control input-transparent" readonly>{{$link_list->sms_group}}</textarea></td>
										@endif
									@endforeach
								@else
									@foreach($site_lists as $site_list)
										@if($fault_list->element_id==$site_list->site_name_id)
										<td><textarea name="sms_group_{{$fault_count}}" rows="2" class="form-control input-transparent" readonly>{{$site_list->sms_group}}</textarea></td>
										@endif
									@endforeach
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
								<td><input type="text" name="client_side_impact_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->client_side_impact}}"></td>
							</tr>
							<tr>
								<td>Link Type</td>
								<td>
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
								</td>
							</tr>							
							
						</table>	
					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>Responsible Field Team</td>
								<td><input type="text" name="responsible_field_team_{{$fault_count}}" id="responsible_field_team_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->responsible_field_team}}"></td>
							</tr>
							<tr>
								<td>Provider</td>
								<td>
									<label style="float:left;">
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
	                                </label>
								</td>
							</tr>
							<tr>
								<td>Reason</td>
								<td>
								<label style="float:left;">
									<select id="select_style" name="reason_{{$fault_count}}">
											<option disabled></option>
											@foreach($reason_lists as $reason_list)
	                                                @if($reason_list->reason_name == $fault_list->reason) 
                                                        <option selected value="{{$reason_list->reason_name}}">{{$reason_list->reason_name}}</option>
                                                    @else
                                                        <option value="{{$reason_list->reason_name}}">{{$reason_list->reason_name}}</option>
                                                    @endif

                                             @endforeach 
                                    </select></label>  									
								</td>
							</tr>
							<tr>
								<td>Issue Type</td>
								<td>
								<label style="float:left;">
									<select id="select_style" name="issue_type_{{$fault_count}}">
											<option disabled></option>
											@foreach($issue_type_lists as $issue_type_list)
	                                                @if($issue_type_list->issue_type_name == $fault_list->issue_type) 
                                                        <option selected value="{{$issue_type_list->issue_type_name}}">{{$issue_type_list->issue_type_name}}</option>
                                                    @else
                                                        <option value="{{$issue_type_list->issue_type_name}}">{{$issue_type_list->issue_type_name}}</option>
                                                    @endif

                                             @endforeach 
                                    </select></label>         
								</td>
							</tr>						
							<tr>
								<td>Problem Category</td>
								<td>
								<label style="float:left;">
									<select id="select_style" name="problem_category_{{$fault_count}}">
											<option disabled></option>@foreach($problem_category_lists as $problem_category_list)
	                                                @if($problem_category_list->problem_name == $fault_list->problem_category) 
                                                        <option selected value="{{$problem_category_list->problem_name}}">{{$problem_category_list->problem_name}}</option>
                                                    @else
                                                        <option value="{{$problem_category_list->problem_name}}">{{$problem_category_list->problem_name}}</option>
                                                    @endif

                                             @endforeach 
                                              </select></label> 									
								</td>
							</tr>
							<tr>
								<td>Problem Source</td>
								<td>
								<label style="float:left;">
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
	                                </label>
								</td>
							</tr>							


							<tr>
								<td>Responsible Vendor</td>
								@if($fault_list->element_type=="link")
									@foreach($link_lists as $link_list)
										@if($fault_list->element_id==$link_list->link_name_id)
										<td><input type="text" id="responsible_vendor_{{$fault_count}}" name="responsible_vendor_{{$fault_count}}" class="form-control input-transparent" value="{{$link_list->vendor}}" readonly></td>
										@endif
									@endforeach
								@else
									@foreach($site_lists as $site_list)
										@if($fault_list->element_id==$site_list->site_name_id)
										<td><input type="text" id="responsible_vendor_{{$fault_count}}" name="responsible_vendor_{{$fault_count}}" class="form-control input-transparent" value="{{$site_list->vendor}}" readonly></td>
										@endif
									@endforeach
								@endif									
							</tr>							

						</table>
					</div>
					<div class="col-md-3">
						<table>

							<tr>
								<td>Escalation Time</td>
								<td>
									<div id="escalation_time_{{$fault_count}}" class="input-group">
	                                    <input type="text" name="escalation_time_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->escalation_time}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
							</tr>						
							<tr>
								<td>Responsible Concern</td>
								<td><input type="text" id="responsible_concern_{{$fault_count}}" name="responsible_concern_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->responsible_concern}}" onclick="responsibleFieldView(this.id);"></td>
							</tr>
							<tr>
								<td>Event Time</td>
								<td>
									<div id="event_time_{{$fault_count}}" class="input-group">
	                                    <input type="text" name="event_time_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->event_time}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
							</tr>
							<tr>
							<td>Clear Time</td>
								<td>
									<div id="clear_time_{{$fault_count}}" class="input-group">
	                                    <input type="text" name="clear_time_{{$fault_count}}" class="form-control input-transparent" value="{{$fault_list->clear_time}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
							</tr>																					
							<tr>
								<td>Provider Side Impact</td>
								<td><textarea rows="4" class="form-control input-transparent" id="provider_side_impact_{{$fault_count}}" name="provider_side_impact_{{$fault_count}}">{{$fault_list->provider_side_impact}}</textarea></td>
							</tr>
							
							<tr>
								<td>Remarks</td>
								<td><textarea rows="4" class="form-control input-transparent" id="remarks_{{$fault_count}}" name="remarks_{{$fault_count}}"></textarea></td>
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
							<section class="widget" id="default-widget">
								<table>
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
										<td><input class="form-control input-transparent" required readonly type="text" name="fault_{{$fault_count}}_task_{{$task_count}}_name" id="fault_{{$fault_count}}_task_{{$task_count}}_name" value="{{$task_list->task_name}}"></td>
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

	                                    <td><div class="input-group" id="fault_{{$fault_count}}_task_{{$task_count}}_start_time" required><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_start_time" value="{{$task_list->task_start_time}}" required="" type="text"><span class="input-group-addon btn btn-info" required><span class="glyphicon glyphicon-calendar" required=""></span></span></div></td>
	                                    <td><div class="input-group" id="fault_{{$fault_count}}_task_{{$task_count}}_end_time"><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_end_time" value="{{$task_list->task_end_time}}" type="text"><span class="input-group-addon btn btn-info"><span class="glyphicon glyphicon-calendar"></span></span></div></td>
	                                    <td><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_start_time_db" value="{{$task_list->task_start_time_db}}" type="text" readonly></td>	                                    
	                                    <td><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_end_time_db" value="{{$task_list->task_end_time_db}}" type="text" readonly></td>


	                                   	@if($task_list->task_status!="Closed" && $task_list->task_assigned_dept==$_SESSION['dept_id'])
	                                    <td><select id="select_style" name="fault_{{$fault_count}}_task_{{$task_count}}_status" required onchange="checkTaskStatus(this.name,{{$fault_count}});">
											<option disabled selected></option>
											 @foreach($task_status_lists as $task_status_list)
	                                                @if($task_status_list->task_status == $task_list->task_status) 
                                                        <option selected value="{{$task_status_list->task_status}}">{{$task_status_list->task_status}}</option>
                                                    @else
                                                        <option value="{{$task_status_list->task_status}}">{{$task_status_list->task_status}}</option>
                                                    @endif

                                             @endforeach 
										</select></td>
										@else
										<td><select id="select_style" name="fault_{{$fault_count}}_task_{{$task_count}}_status" required disabled onchange="checkTaskStatus(this.name,{{$fault_count}});">
											<option disabled selected></option>
											 @foreach($task_status_lists as $task_status_list)
	                                                @if($task_status_list->task_status == $task_list->task_status) 
                                                        <option selected value="{{$task_status_list->task_status}}">{{$task_status_list->task_status}}</option>
                                                    @else
                                                        <option value="{{$task_status_list->task_status}}">{{$task_status_list->task_status}}</option>
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
	                                    <td><input class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_task_responsible" value="{{$task_list->task_responsible}}" type="text" readonly></td>
										@if($task_list->task_status!="Closed" && $task_list->task_assigned_dept==$_SESSION['dept_id'])
											<td><textarea class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_comment" id="fault_{{$fault_count}}_task_{{$task_count}}_comment"></textarea></td>
											<td><textarea class="form-control input-transparent" id="fault_{{$fault_count}}_task_{{$task_count}}_resolver" name="fault_{{$fault_count}}_task_{{$task_count}}_resolver" onclick="responsibleFieldView(this.id);">{{$task_list->task_resolver}}</textarea></td>
											@if($task_list->task_resolution_ids=="")
												<td><textarea class="form-control input-transparent" id="fault_{{$fault_count}}_task_{{$task_count}}_resolution" name="fault_{{$fault_count}}_task_{{$task_count}}_resolution" onclick="TaskResolutionView(this.id,{{$ticketId}},{{$fault_list->fault_id}});">{{$task_list->task_resolution_ids}}</textarea></td>
											@else
												<td><textarea class="form-control input-transparent" id="fault_{{$fault_count}}_task_{{$task_count}}_resolution" name="fault_{{$fault_count}}_task_{{$task_count}}_resolution" readonly>{{$task_list->task_resolution_ids}}</textarea></td>
											@endif
											<td><textarea class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_previous_comment" id="fault_{{$fault_count}}_task_{{$task_count}}_previous_comment" readonly>{{$task_list->task_comment}}</textarea></td>

										@else	
											<td><textarea class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_comment" id="fault_{{$fault_count}}_task_{{$task_count}}_comment" disabled></textarea></td>
											<td><textarea class="form-control input-transparent" id="fault_{{$fault_count}}_task_{{$task_count}}_resolver" name="fault_{{$fault_count}}_task_{{$task_count}}_resolver" disabled onclick="responsibleFieldView(this.id);">{{$task_list->task_resolver}}</textarea></td>
											@if($task_list->task_resolution_ids=="")
												<td><textarea class="form-control input-transparent" id="fault_{{$fault_count}}_task_{{$task_count}}_resolution" name="fault_{{$fault_count}}_task_{{$task_count}}_resolution" disabled onclick="TaskResolutionView(this.id,{{$ticketId}},{{$fault_list->fault_id}});">{{$task_list->task_resolution_ids}}</textarea></td>
											@else
												<td><textarea class="form-control input-transparent" id="fault_{{$fault_count}}_task_{{$task_count}}_resolution" name="fault_{{$fault_count}}_task_{{$task_count}}_resolution" disabled>{{$task_list->task_resolution_ids}}</textarea></td>
											@endif
											<td><textarea class="form-control input-transparent" name="fault_{{$fault_count}}_task_{{$task_count}}_previous_comment" id="fault_{{$fault_count}}_task_{{$task_count}}_previous_comment" readonly>{{$task_list->task_comment}}</textarea></td>
										@endif	

										@if($task_list->task_status!="Closed" && $task_list->task_assigned_dept!=$_SESSION['dept_id'] && $ticket_initiator_dept==$_SESSION['dept_id'])

											<td><input type='checkbox' name="fault_{{$fault_count}}_task_{{$task_count}}_on_behalf" id="fault_{{$fault_count}}_task_{{$task_count}}_on_behalf" class="form-control input-transparent" onchange="onBehalf(this,this.id);"></td>

										@endif
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary" onclick="tt_edit_form_submit()">EDIT TICKET</button> 
</form>
@include('navigation.p_footer')