@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<!-- <script src="{{asset('js/fault.js')}}"></script> -->
<script type="text/javascript" src="{{asset('js/kpi.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/incident_style.css')}}">
<div class="container-fluid" id="incident_main_div">
	<script type="text/javascript">
    
    document.getElementById('kpi-collapse').className = 'panel-collapse collapse in';
    document.getElementById('kpi_module').className = 'active';
</script>

<style type="text/css">
	/*td { white-space:pre }*/
	br:before { content: "\A"; white-space: pre-line }
	label {
    display: inline-block;
    /*width: 5em;*/
  }
  #incident_search_table td{
    padding:10px;
    border:1px solid grey;
    text-align:center;
  }
</style>
	<!-- @if(isset($_SESSION["CURRENT_LIST"]))
	<p style="color:#fff;">{{$_SESSION["CURRENT_LIST"]}}</p>
	@endif -->
	<h2 class="page-title">KPI Report Task<span class="fw-semi-bold"></span></h2>
	<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="fault_search" action="{{url('KpiView')}}" method="GET">
								<input type="hidden" name="element_id">
							<tr>
								<td colspan="10" id="section_header">KPI Report Task</td>
							</tr>

							<tr>
								<td>Client ID</td>
								<td>Element Type</td>
								<td>Element Name</td>
								<td>District</td>
							</tr>
							<tr>
								
								<td>
									<label>
										<select id="select_style" name="client_id" class="client_id">
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
								
								<td>
									<label>
										<select id="select_style" name="element_type" class="element_type">
												<option selected></option>
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
								
								<td><input type="text" id="element_name" name="element_name" onchange="changeFunction()" onclick="elementScript()" class="form-control input-transparent" value="{{$fault_arr['element_name']}}"></td>
								<td><input type="text" name="district" class="form-control input-transparent" value="{{$fault_arr['district']}}"></td>

							</tr>
							<tr>	
								<td>Event Time From</td>
								<td>Event Time To</td>
								<td>MTTR Report List</td>
								<td>Region</td>
							</tr>
							<tr>	
				
								<td>
									<div id="event_time_from" class="input-group">
	                                    <input id="datepicker2i" type="text" name="event_time_from" class="form-control input-transparent" readonly requried value="{{$fault_arr['event_time_from']}}" >
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
								<td>
									<div id="event_time_to" class="input-group">
	                                    <input id="datepicker2i" type="text" name="event_time_to" class="form-control input-transparent" readonly requried value="{{$fault_arr['event_time_to']}}" >
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>	
								
								<td>
									<label>
										<select id="select_style" name="report_list" required>
											<option selected></option>
											<option value="dept_wise_mttr">Dept Wise</option>
											<option value="task_executor_wise_mttr">Executor Wise</option>
											<option value="task_responsible_wise_mttr">Responsible Wise</option>
											<option value="task_subcenter_wise_mttr">Subcenter Wise</option>
											<option value="problem_category_wise_mttr">Problem Category Wise</option>
											<option value="client_wise_mttr">Client Category Wise</option>
	                                    </select>
	                                </label>
								</td>
								<td><input type="text" name="region" class="form-control input-transparent" value="{{$fault_arr['region']}}"></td>
								
							</tr>
							<tr>	
								<td>Client Priority</td>
								<td>Client Side Impact</td>
								<td>Link Type</td>
								<td>Responsible Field Team</td>
							</tr>
							<tr>
								
								<td><input type="text" name="client_priority" class="form-control input-transparent" value="{{$fault_arr['client_priority']}}"></td>
								
								<td><input type="text" name="client_side_impact" class="form-control input-transparent" value="{{$fault_arr['client_side_impact']}}"></td>
								
								<td>
									<label >
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
								
								<td><input type="text" name="responsible_field_team" class="form-control input-transparent" value="{{$fault_arr['responsible_field_team']}}"></td>
							</tr>
							<tr>	
								<td>Provider</td>
								<td>Reason</td>
								<td>Issue Type</td>
								<td>Problem Category</td>
							</tr>
							<tr>	
								<td>
									<label>
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
								
								<td>
									<label>
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
								
								<td>
									<label >
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
								
								<td>
									<label>
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
							</tr>
							<tr>	
								<td>Problem Source</td>
								<td>Responsible Vendor</td>
								<td>Provider Side Impact</td>
								<td>Task Responsible</td>
							</tr>

							<tr>	
								<td>
									<label>
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
								
								<td><input type="text" name="responsible_vendor" class="form-control input-transparent" value="{{$fault_arr['responsible_vendor']}}"></td>
								<td><input type="text" name="provider_side_impact" class="form-control input-transparent" value="{{$fault_arr['provider_side_impact']}}"></td>
								
								
								<td><input type="text" name="responsible_concern" onclick="responsibleScript('responsible_concern')"  class="form-control input-transparent" value="{{$fault_arr['responsible_concern']}}"></td>
							</tr>
							<tr>
								
								<td>Remarks</td>
								<td>Department</td>
								<td>Task Resolver</td>
							</tr>
							
							<tr>	
															
								<td><input type="text" name="remarks" class="form-control input-transparent" value="{{$fault_arr['remarks']}}"></td>
								<td>
									<label>
										<select id="select_style" name="department_id">
											<option selected></option>
											@foreach($department_lists as $department_list)
												@if($department_list->dept_row_id == $fault_arr['department_id']) 											 
	                                            	<option selected value="{{$department_list->dept_row_id}}">{{$department_list->dept_name}}</option>
	                                            @else
	                                            	<option value="{{$department_list->dept_row_id}}">{{$department_list->dept_name}}</option>
	                                            @endif		
	                                        @endforeach
	                                    </select>
	                                </label>    
								</td>
								<td> <input type="text" name="task_resolver" onclick="responsibleScript('task_resolver')"  class="form-control input-transparent" value="{{$fault_arr['task_resolver']}}"></td>
							</tr>
							<tr>
								<td colspan="10">
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


</div>
@include('navigation.p_footer')