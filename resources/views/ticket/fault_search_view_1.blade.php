@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('js/fault.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/incident_style.css')}}">
<div class="container-fluid" id="incident_main_div">
<style type="text/css">
	/*td { white-space:pre }*/
	br:before { content: "\A"; white-space: pre-line }
</style>
<script type="text/javascript">
    
    document.getElementById('fault-collapse').className = 'panel-collapse collapse in';
    document.getElementById('fault_view').className = 'active';
</script>

	<!-- @if(isset($_SESSION["CURRENT_LIST"]))
	<p style="color:#fff;">{{$_SESSION["CURRENT_LIST"]}}</p>
	@endif -->
@if($dashboard_value=="")
	<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="fault_search" action="{{url('FaultView')}}" method="GET">
							<tr>
								<td colspan="10" id="section_header">Fault</td>
							</tr>
							<tr>
								<td>Client ID</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="client_id">
											<option selected></option>
											@foreach($client_lists as $client_list) 
												@if($client_list->client_id == $fault_arr['client_id']) 
	                                            	<option selected value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                            @else
	                                            	<option value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                            @endif
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
								<td>Element Type</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="element_type" required>
												<option disabled selected></option>
											@if($fault_arr['element_type']=="link")
												<option selected value="link">Link</option>
												<option value="site">Site</option>
											@elseif($fault_arr['element_type']=="site")
												<option value="link">Link</option>
												<option selected value="site">Site</option>
											@else
												<option value="link">Link</option>
												<option value="site">Site</option>	
											@endif

	                                    </select>
	                                </label>
								</td>
								<td>Element Name</td>
								<td><input type="text" name="element_name" class="form-control input-transparent" value="{{$fault_arr['element_name']}}"></td>
								<td>VLAN ID</td>
								<td><input type="text" name="vlan_id" class="form-control input-transparent" value="{{$fault_arr['vlan_id']}}"></td>
								<td>LINK ID</td>
								<td><input type="text" name="link_id" class="form-control input-transparent" value="{{$fault_arr['link_id']}}"></td>
							</tr>
							<tr>
								<td>Site IP Address</td>
								<td><input type="text" name="site_ip_address" class="form-control input-transparent" value="{{$fault_arr['site_ip_address']}}"></td>
								<td>Fault Status</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="fault_status">
											<option selected></option>
										@if($fault_arr['fault_status']=="open")	
											<option selected value="open">Open</option>
											<option value="closed">Closed</option>
										@elseif($fault_arr['fault_status']=="closed")
											<option value="open">Open</option>
											<option selected value="closed">Closed</option>											
										@else
											<option value="open">Open</option>
											<option value="closed">Closed</option>		
										@endif										
	                                    </select>
	                                </label>
								</td>
								<td>District</td>
								<td><input type="text" name="district" class="form-control input-transparent" value="{{$fault_arr['district']}}"></td>
								<td>Region</td>
								<td><input type="text" name="region" class="form-control input-transparent" value="{{$fault_arr['region']}}"></td>
								<td>SMS Group</td>
								<td><input type="text" name="sms_group" class="form-control input-transparent" value="{{$fault_arr['sms_group']}}"></td>
							</tr>
							<tr>
								<td>Client Priority</td>
								<td><input type="text" name="client_priority" class="form-control input-transparent" value="{{$fault_arr['client_priority']}}"></td>
								<td>Client Side Impact</td>
								<td><input type="text" name="client_side_impact" class="form-control input-transparent" value="{{$fault_arr['client_side_impact']}}"></td>
								<td>Link Type</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="link_type">
											<option selected></option>
											@foreach($link_type_lists as $link_type_list)
												@if($link_type_list->link_type_name == $fault_arr['link_type']) 
	                                            	<option selected value="{{$link_type_list->link_type_name}}">{{$link_type_list->link_type_name}}</option>
	                                            @else
	                                            	<option value="{{$link_type_list->link_type_name}}">{{$link_type_list->link_type_name}}</option>
	                                            @endif	
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
								<td>Responsible Field Team</td>
								<td><input type="text" name="responsible_field_team" class="form-control input-transparent" value="{{$fault_arr['responsible_field_team']}}"></td>
								<td>Provider</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="provider">
											<option selected></option>
											@foreach($client_lists as $client_list) 
												@if($client_list->client_id == $fault_arr['provider']) 
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
										<select id="select_style" name="reason">
											<option selected></option>
											@foreach($reason_lists as $reason_list) 
												@if($reason_list->reason_name == $fault_arr['reason']) 
	                                            	<option selected value="{{$reason_list->reason_name}}">{{$reason_list->reason_name}}</option>
	                                            @else
	                                            	<option value="{{$reason_list->reason_name}}">{{$reason_list->reason_name}}</option>
	                                            @endif
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
								<td>Issue Type</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="issue_type">
											<option selected></option>
											@foreach($issue_type_lists as $issue_type_list)
												@if($issue_type_list->issue_type_name == $fault_arr['issue_type']) 
	                                            	<option selected value="{{$issue_type_list->issue_type_name}}">{{$issue_type_list->issue_type_name}}</option>
	                                            @else
	                                            	<option value="{{$issue_type_list->issue_type_name}}">{{$issue_type_list->issue_type_name}}</option>
	                                            @endif		
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
								<td>Problem Category</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="problem_category">
											<option selected></option>
											@foreach($problem_category_lists as $problem_category_list)
												@if($problem_category_list->problem_name == $fault_arr['problem_category']) 
	                                            	<option selected value="{{$problem_category_list->problem_name}}">{{$problem_category_list->problem_name}}</option>
	                                            @else
	                                            	<option value="{{$problem_category_list->problem_name}}">{{$problem_category_list->problem_name}}</option>
	                                            @endif	
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
								<td>Problem Source</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="problem_source">
											<option selected></option>
											@foreach($problem_source_lists as $problem_source_list)
												@if($problem_source_list->problem_source_name == $fault_arr['problem_source']) 											 
	                                            	<option selected value="{{$problem_source_list->problem_source_name}}">{{$problem_source_list->problem_source_name}}</option>
	                                            @else
	                                            	<option value="{{$problem_source_list->problem_source_name}}">{{$problem_source_list->problem_source_name}}</option>
	                                            @endif		
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
								<td>Responsible Vendor</td>
								<td><input type="text" name="responsible_vendor" class="form-control input-transparent" value="{{$fault_arr['responsible_vendor']}}"></td>
							</tr>
							<tr>
								<td>Escalation Time</td>
								<td>
									<div id="escalation_time" class="input-group">
	                                    <input id="datepicker2i" type="text" name="escalation_time" class="form-control input-transparent" value="{{$fault_arr['escalation_time']}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
								<td>Responsible Concern</td>
								<td><input type="text" name="responsible_concern" class="form-control input-transparent" value="{{$fault_arr['responsible_concern']}}"></td>
								<td>Event Time</td>
								<td>
									<div id="event_time" class="input-group">
	                                    <input id="datepicker2i" type="text" name="event_time" class="form-control input-transparent" value="{{$fault_arr['event_time']}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
								<td>Provider Side Impact</td>
								<td><input type="text" name="provider_side_impact" class="form-control input-transparent" value="{{$fault_arr['provider_side_impact']}}"></td>
								<td>Remarks</td>
								<td><input type="text" name="remarks" class="form-control input-transparent" value="{{$fault_arr['remarks']}}"></td>
							</tr>
							<tr>
								<td colspan="10">
									<input type="submit" class="btn btn-primary" name="formType" value="Search">
									<input type="submit" class="btn btn-primary" name="formType" value="Export">
								</td>
							</tr>
							</form>
						</table>
					</div>
				</div>
			</div>
		</section>
	</div>
@endif	
	<div class="row">
		<div class="col-md-12">
@if($dashboard_value=="")
	@if($fault_lists)
		@if(count($fault_lists)>0)
			<div id="incident_div">
			<div class="pagination"> {!! str_replace('/?', '?', $fault_lists->appends(Input::except('page'))->render()) !!} </div>
				<table id="incident_table">
				
					<tr>
						<th>Fault ID</th>
						<th>Problem Category</th>
						<th>Element Type</th>
						<th>Element Name</th>
						
						<th>Link ID</th>
						<th>Client</th>
						<th>Impact</th>
						<th>Event Time</th>
						<th>Status</th>
						<th>Escalation</th>
						<th>Responsible Concern</th>
						<th>Field Team</th>
						<th>View Details</th>
						<th>Edit Details</th>
					</tr>
					
					@foreach($fault_lists as $fault_list)
					<tr>
						<td>{{$fault_list->fault_id}}</td>
						<td>{{$fault_list->problem_category}}</td>
						<td>{{$fault_list->element_type}}</td>
						
						@if($fault_list->element_type=="link")
						<td>{{$fault_list->link_name}}</td>
						<td>{{$fault_list->link_id}}</td>
						@else
						<td>{{$fault_list->site_name}}</td>
						<td></td>
						@endif
						
						
						<td>{{$fault_list->client_name}}</td>
						<td>{{$fault_list->client_side_impact}}</td>
						<td>{{$fault_list->event_time}}</td>
						<td>{{$fault_list->fault_status}}</td>
						<td>{{$fault_list->escalation_time}}</td>
						<td>{{$fault_list->responsible_concern}}</td>
						<td>{{$fault_list->responsible_field_team}}</td>
						<td><a href="{{ url('ViewTTSingle')}}?ticket_id={{$fault_list->ticket_id}}" style="color:#fff"><h3><span class="glyphicon glyphicon-eye-open"></span></i></h3></td>
						<td><a href="{{ url('EditTT')}}?ticket_id={{$fault_list->ticket_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a></td>

					</tr>
					@endforeach
				
				</table>
			</div>
			@endif
		@endif	
	@endif	
		</div>
		

	@if($dashboard_value!="")
		@if(count($fault_lists1)>0)
		<form id="dashboard_export" action="{{url('FaultView')}}" method="GET">
			<input type="hidden" name="dashboard_value" id="dashboard_value" value="{{$dashboard_value}}">
			<center><input type="submit" class="btn btn-primary" name="export_value" value="Export Dashboard Site Data"></center>
		
			<div id="incident_div">
		</form>
			<div class="pagination"> {!! str_replace('/?', '?', $fault_lists1->appends(Input::except('page'))->render()) !!} </div>
				<table id="incident_table">
				
					<tr>
						<th>Fault ID</th>
						<th>Problem Category</th>
						<th>Element Type</th>
						<th>Site Name</th>
						<th>Client</th>
						<th>Impact</th>
						<th>Event Time</th>
						<th>Status</th>
						<th>Escalation</th>
						<th>Responsible Concern</th>
						<th>Field Team</th>
						<th>Ticket Comments</th>
						<th>Task Comments</th>
						<th>View Details</th>
						<th>View Details</th>
					</tr>
					
					@foreach($fault_lists1 as $fault_list1)
					<tr>
						<td>{{$fault_list1->fault_id}}</td>
						<td>{{$fault_list1->problem_category}}</td>
						<td>{{$fault_list1->element_type}}</td>
						<td>{{$fault_list1->site_name}}</td>
									
						<td>{{$fault_list1->client_name}}</td>
						<td>{{$fault_list1->client_side_impact}}</td>
						<td>{{$fault_list1->event_time}}</td>
						<td>{{$fault_list1->fault_status}}</td>
						<td>{{$fault_list1->escalation_time}}</td>
						<td>{{$fault_list1->responsible_concern}}</td>
						<td>{{$fault_list1->responsible_field_team}}</td>
						<td><?php echo preg_replace('/<br(\s+)?\/?>/i', "<br>", $fault_list1->scl_comment); ?></td>
						<td><?php echo preg_replace('/<br(\s+)?\/?>/i', "<br>", $fault_list1->task_comment); ?></td>
						<td><a href="{{ url('ViewTTSingle')}}?ticket_id={{$fault_list1->ticket_id}}" style="color:#fff"><h3><span class="glyphicon glyphicon-eye-open"></span></i></h3></td>
						<td><a href="{{ url('EditTT')}}?ticket_id={{$fault_list1->ticket_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a></td>

					</tr>
					@endforeach
				
				</table>
			</div>
		@endif
		<br>

		@if(count($fault_lists2)>0)
		<form id="dashboard_export" action="{{url('FaultView')}}" method="GET">
				<input type="hidden" name="dashboard_value" id="dashboard_value" value="{{$dashboard_value}}">
				<center><input type="submit" class="btn btn-primary" name="export_value" value="Export Dashboard Link Data"></center>
				</form>	
			<div id="incident_div">

			<div id="incident_div">
				<div class="pagination"> {!! str_replace('/?', '?', $fault_lists2->appends(Input::except('page'))->render()) !!} </div>
				<table id="incident_table">
				
					<tr>
						<th>Fault ID</th>
						<th>Problem Category</th>
						<th>Element Type</th>
						<th>Link Name</th>
						
						<th>Link ID</th>
						<th>Client</th>
						<th>Impact</th>
						<th>Event Time</th>
						<th>Status</th>
						<th>Escalation</th>
						<th>Responsible Concern</th>
						<th>Field Team</th>
						<th>Ticket Comments</th>
						<th>Task Comments</th>
						<th>View Details</th>
						<th>View Details</th>
					</tr>
					
					@foreach($fault_lists2 as $fault_list2)
					<tr>
						<td>{{$fault_list2->fault_id}}</td>
						<td>{{$fault_list2->problem_category}}</td>
						<td>{{$fault_list2->element_type}}</td>
						<td>{{$fault_list2->link_name}}</td>
						<td>{{$fault_list2->link_id}}</td>					
						<td>{{$fault_list2->client_name}}</td>
						<td>{{$fault_list2->client_side_impact}}</td>
						<td>{{$fault_list2->event_time}}</td>
						<td>{{$fault_list2->fault_status}}</td>
						<td>{{$fault_list2->escalation_time}}</td>
						<td>{{$fault_list2->responsible_concern}}</td>
						<td>{{$fault_list2->responsible_field_team}}</td>
						<td><?php echo preg_replace('/<br(\s+)?\/?>/i', "<br>", $fault_list2->scl_comment); ?></td>
						<td><?php echo preg_replace('/<br(\s+)?\/?>/i', "<br>", $fault_list2->task_comment); ?></td>
						<td><a href="{{ url('ViewTTSingle')}}?ticket_id={{$fault_list2->ticket_id}}" style="color:#fff"><h3><span class="glyphicon glyphicon-eye-open"></span></i></h3></td>
						<td><a href="{{ url('EditTT')}}?ticket_id={{$fault_list2->ticket_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a></td>

					</tr>
					@endforeach
				
				</table>
			</div>
			@endif
			
    @endif		

		</div>		
	</div>
</div>
@include('navigation.p_footer')