@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('js/fault.js?v5')}}"></script>
<script src="{{ asset('js/jquery.table2excel.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/incident_style.css')}}">
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.searchPane.min.css')}}">
		<script type="text/javascript" src="{{asset('js/dataTables.searchPane.min.js')}}"></script>

<div class="container-fluid" id="incident_main_div">
<style type="text/css">
	/*td { white-space:pre }*/
	br:before { content: "\A"; white-space: pre-line }
	td,th{
		border:1px solid grey;
		padding:5px;
	}
	.btn-primary{
		border-radius : 0px !important;
	}
	#impact_wrap{
		word-break: break-all;
		max-width:200px !important;
		max-height:300px;
		overflow-y : auto;
	}
	.wide_columns{
		max-width: 150px;
		text-align: left !important;
		max-height:300px !important;
		overflow-y: auto !important;
	}
	.wide_columns_lg{
		max-width: 800px;
		min-width : 300px;
		text-align: left !important;
		max-height:300px !important;
		overflow-y: auto !important;
	}
	div.dt-searchPanes div.pane div.title{
        background-color: transparent !important;
    }
    .dataTables_filter{
    	color:#000000;
    }
    .dt-searchPanes{
    	height:150px !important;
    	width: 100%;
    }


    td{
		vertical-align:middle;
		text-align:center;
		height:80px;
		font-size:13px;
		border-top:1px solid grey;
		border-bottom:1px solid grey;
		cursor:pointer;
		color:white;
	}
	th:nth-child(1){	
		font-size:14px;
		border-left:1px solid grey;
	}
	th:nth-child(2){

	}
	 th:last-child{
		border-right:1px solid grey;
	}
	td:nth-child(1){
		border-left:1px solid grey;
		font-size: 14px;

	}
	td:last-child{
		border-right:1px solid grey;
	}

	 th{
		background:rgba(0, 0, 0);
		text-align:center;
		border-top:1px solid grey;
		border-bottom:1px solid grey;
	}

	tr:nth-child(even) {
		background: #233454;

	}
	tr:nth-child(odd) {
		background: #1a2538;

	}
	tr{
		border: solid thin;
	}
</style>

<script type="text/javascript">
		function exportExcel(){
				$(".noExl").hide();  
			 	$(".pagination").hide();
		    	$(".incident_table1").table2excel({
						exclude: ".noExl",
						name: "Excel Document Name",
						filename: "excelFile",
						fileext: ".xls",
						exclude_img: true,
						exclude_links: true,
						exclude_inputs: true
					});
		    }
		function exportExcel2(){
				$(".noExl").hide();  
			 	$(".pagination").hide();
		    	$(".incident_table2").table2excel({
						exclude: ".noExl",
						name: "Excel Document Name",
						filename: "excelFile",
						fileext: ".xls",
						exclude_img: true,
						exclude_links: true,
						exclude_inputs: true
					});
		    }


		$(document).ready(function(){

		// $("#escalation_time").datetimepicker({
		// 	format: 'YYYY-MM-DD HH:mm:ss'
		// });
		$("#task_start_time_from").datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss'
		});
		// $("#escalation_time_to").datetimepicker({
		// 	format: 'YYYY-MM-DD HH:mm:ss'
		// });
		$("#task_start_time_to").datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss'
		});

		$("#task_end_time_from").datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss'
		});
		$("#task_end_time_to").datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss'
		});

	});

</script>
	<!-- @if(isset($_SESSION["CURRENT_LIST"]))
	<p style="color:#fff;">{{$_SESSION["CURRENT_LIST"]}}</p>
	@endif -->

	<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title">View Task <span class="fw-semi-bold"></span></h2>
						<table id="incident_search_table">
							<form id="task_search_form" action="{{url('TaskView')}}" method="POST">
							<input type="hidden" name="csrf_token" class="form-control input-transparent" value="{{ csrf_token() }}">
							<tr>
								<td colspan="9" id="section_header">Task</td>
							</tr>
							<tr>
								<td>Ticket ID</td>
								<td>
									<input type="text" name="ticket_id" onclick="" class="form-control input-transparent" value="{{$ticket_id}}">
								</td>
								<td>Fault ID</td>
								<td>
									<input type="text" name="fault_id" onclick="" class="form-control input-transparent" value="{{$fault_id}}">
								</td>
								<td>Task ID</td>
								<td><input type="text" name="task_id" onclick="" class="form-control input-transparent" value="{{$task_id}}"></td>
								<td>Task Name</td>
								<td><input type="text" name="task_name" class="form-control input-transparent" value="{{$task_name}}"></td>

							</tr>
							<tr>
								<td>Task Description</td>
								<td><input type="text" name="task_description" class="form-control input-transparent" value="{{$task_description}}"></td>
								<td>Task Status</td>
								<td>
									<label style="float:left; width: 100%">
									<select style="float:left; width: 100%"  name="task_status">
										<option value='' disabled selected></option>
										<option value="escalated" @if($task_status == 'escalated') selected="true" @endif >Escalated</option>
										<option value="Closed" @if($task_status == 'Closed') selected="true" @endif >Closed</option>
									</select>
									</label>
								</td>
								<td>Task Assigned Department</td>
								<td>
									<label style="float:left; width: 100%">
									<select style="float:left; width: 100%" name="task_assigned_dept" >
										<option value='' disabled selected></option>
										@foreach($department_lists as $department)
											<option value="{{$department->dept_row_id}}" @if($task_assigned_dept == $department->dept_row_id) selected="true" @endif >{{$department->dept_name}}</option>
										@endforeach										
									</select>
									</label>
								</td>

								<td>Subcenter</td>
								<td>
									<label style="float:left; width: 100%">
										<select style="float:left; width: 100%" id="subcenter" name="subcenter">
											<option value='' disabled selected></option>
											@foreach($subcenter_lists as $sc)
											<option value="{{$sc->subcenter_name}}" @if($subcenter == $sc->subcenter_name) selected="true" @endif >{{$sc->subcenter_name}}</option>
											@endforeach																
										</select>
									</label>
									
								</td>

							</tr>
							
							
							
							<tr>
								

								<td>Task Start Time From</td>
								<td>
									<div id="task_start_time_from" class="input-group">
	                                    <input id="datepicker2i" type="text" name="task_start_time_from" class="form-control input-transparent" value="{{$task_start_time_from}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
								<td>Task Start Time To</td>
								<td>
									<div id="task_start_time_to" class="input-group">
	                                    <input id="datepicker2i" type="text" name="task_start_time_to" class="form-control input-transparent" value="{{$task_start_time_to}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>


								<td>Task End Time From</td>
								<td>
									<div id="task_end_time_from" class="input-group">
	                                    <input id="datepicker2i" type="text" name="task_end_time_from" class="form-control input-transparent" value="{{$task_end_time_from}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
								<td>Task End Time To</td>
								<td>
									<div id="task_end_time_to" class="input-group">
	                                    <input id="datepicker2i" type="text" name="task_end_time_to" class="form-control input-transparent" value="{{$task_end_time_to}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>


							</tr>
							
							

							<tr>
								<td colspan="10">
									<input type="submit" class="btn btn-primary" name="formType" value="Search">
									<input type="submit" class="btn btn-primary" name="formType" value="Export">
								</td>
							</tr>
							</form>
						</table>



					
@if(isset($dashboard_value))
	@if($task_lists)
		@if(count($task_lists)>0)
			<div id="incident_div">
			<div class="pagination"> {!! str_replace('/?', '?', $task_lists->appends(Input::except('page'))->render()) !!} </div>
				<table id="incident_table">
				
					<tr>
						<th>Ticket ID</th>
						<th>Fault ID</th>
						<th>Task ID</th>
						<th>Task Description</th>
						<th>Assigned Departmentt</th>
						<th>Subcenter</th>
						<th>Task Start Time</th>
						<th>Task End Time</th>
						<th>Duration</th>
						<th>Task Status</th>
						<th>View / Edit</th>						
					</tr>
					
					@foreach($task_lists as $task_list)
					<tr>
						<td>{{$task_list->ticket_id}}</td>
						<td>{{$task_list->fault_id}}</td>
						<td>{{$task_list->task_id}}</td>
						<td id="impact_wrap">{{$task_list->task_description}}</td>
						<td>{{$task_list->dept_name}}</td>
						<td>{{$task_list->subcenter}}</td>
						<td>{{$task_list->task_start_time}}</td>
						<td>{{$task_list->task_end_time}}</td>
						@if($task_list->task_status == 'Closed')
						<td>{{round($task_list->duration/3600,2)}} Hr</td>
						@else
						<td>{{round($task_list->current_duration/3600,2)}} Hr</td>
						@endif
						
						<td>{{$task_list->task_status}}</td>
						<td><a href="{{ url('ViewTTSingle')}}?ticket_id={{$task_list->ticket_id}}" style="color:#fff"><h3><span class="glyphicon glyphicon-eye-open"></span></i></h3>
						<a href="{{ url('EditTT')}}?ticket_id={{$task_list->ticket_id}}#{{$task_list->fault_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a></td>
						

					</tr>
					@endforeach
				
				</table>
			</div>
			@endif
		@endif
@endif



						
					</div>		
				</div>
			</div>
		</section>
	</div>
	
		</div>		
	</div>
</div>
@include('navigation.p_footer')