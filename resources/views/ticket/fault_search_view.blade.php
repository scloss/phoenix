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
						<h2 class="page-title">View Fault <span class="fw-semi-bold"></span></h2>
						<table id="incident_search_table">
							<form id="fault_search_form" action="{{url('FaultView')}}" method="GET">
							<tr>
								<td colspan="9" id="section_header">Fault</td>
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
								<td><input type="text" name="element_name" onclick="" class="form-control input-transparent" value="{{$fault_arr['element_name']}}"></td>
								<td>VLAN ID</td>
								<td><input type="text" name="vlan_id" class="form-control input-transparent" value="{{$fault_arr['vlan_id']}}"></td>

							</tr>
							<tr>
								<td>LINK ID</td>
								<td><input type="text" name="link_id" class="form-control input-transparent" value="{{$fault_arr['link_id']}}"></td>
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
								<td>
									<label style="float:left;">
										<select id="select_style" name="district" >
											<option value='' disabled selected></option>
											@foreach($district_lists as $district_list)
											 @if($district_list->district_name == $fault_arr['district'])
											 	<option selected value="{{$district_list->district_name}}">{{$district_list->district_name}}</option>
											 @else
											 	<option value="{{$district_list->district_name}}">{{$district_list->district_name}}</option>
											 @endif
											
											@endforeach																	
										</select>
									</label>
									<!-- <input type="text" name="district" class="form-control input-transparent" value="{{$fault_arr['district']}}"> -->
								</td>

							</tr>
							<tr>
								<td>Region</td>
								<td>
									<label style="float:left;">
									
									<select  name="region" style="width: 200px">
										<option value='' disabled selected></option>
										<option value="Gateway Operations">Gateway Operations</option>
										<option value="Regional Implementation & Operations 1">Regional Implementation & Operations 1</option>
										<option value="Regional Implementation & Operations 1, Regional Implementation & Operations 2">Regional Implementation & Operations 1, Regional Implementation & Operations 2</option>
										<option value="Regional Implementation & Operations 1, Regional Implementation & Operations 2, Regional Implementation & Operations 3">Regional Implementation & Operations 1, Regional Implementation & Operations 2, Regional Implementation & Operations 3</option>
										<option value="Regional Implementation & Operations 2">Regional Implementation & Operations 2</option>
										<option value="Regional Implementation & Operations 2, Regional Implementation & Operations 3">Regional Implementation & Operations 2, Regional Implementation & Operations 3</option>
										<option value="Regional Implementation & Operations 3">Regional Implementation & Operations 3</option>
										<option value="Regional Implementation & Operations 3, Regional Implementation & Operations 1">Regional Implementation & Operations 3, Regional Implementation & Operations 1</option>
										<option value="Regional Implementation & Operations 4">Regional Implementation & Operations 4</option>
										<option value="Regional Implementation & Operations 1, Regional Implementation & Operations 4">Regional Implementation & Operations 1, Regional Implementation & Operations 4</option>
										<option value="Regional Implementation & Operations 2, Regional Implementation & Operations 4">Regional Implementation & Operations 2, Regional Implementation & Operations 4</option>
										<option value="Regional Implementation & Operations 3, Regional Implementation & Operations 4">Regional Implementation & Operations 3, Regional Implementation & Operations 4</option>									
									</select>
								</label>
									
								</td>
								<td>SMS Group</td>
								<td><input type="text" name="sms_group" class="form-control input-transparent" value="{{$fault_arr['sms_group']}}"></td>
								<td>Client Priority</td>
								<td><input type="text" name="client_priority" class="form-control input-transparent" value="{{$fault_arr['client_priority']}}"></td>
								<td>Client Side Impact</td>
								<td><input type="text" name="client_side_impact" class="form-control input-transparent" value="{{$fault_arr['client_side_impact']}}"></td>

							</tr>
							<tr>
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

							</tr>
							<tr>
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
								

								<td>Event Time From</td>
								<td>
									<div id="event_time" class="input-group">
	                                    <input id="datepicker2i" type="text" name="event_time" class="form-control input-transparent" value="{{$fault_arr['event_time']}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
								<td>Event Time To</td>
								<td>
									<div id="event_time_to" class="input-group">
	                                    <input id="datepicker2i" type="text" name="event_time_to" class="form-control input-transparent" value="{{$fault_arr['event_time_to']}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>


								<td>Clear Time From</td>
								<td>
									<div id="clear_time" class="input-group">
	                                    <input id="datepicker2i" type="text" name="clear_time" class="form-control input-transparent" value="{{$fault_arr['clear_time']}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
								<td>Clear Time To</td>
								<td>
									<div id="clear_time_to" class="input-group">
	                                    <input id="datepicker2i" type="text" name="clear_time_to" class="form-control input-transparent" value="{{$fault_arr['clear_time_to']}}">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>


							</tr>
							<tr>
								<td>Provider Side Impact</td>
								<td><input type="text" name="provider_side_impact" class="form-control input-transparent" value="{{$fault_arr['provider_side_impact']}}"></td>
								<td>Responsible Concern</td>
								<td><input type="text" name="responsible_concern" class="form-control input-transparent" value="{{$fault_arr['responsible_concern']}}"></td>
								<td>Remarks</td>
								<td><input type="text" name="remarks" class="form-control input-transparent" value="{{$fault_arr['remarks']}}"></td>
								<td></td>
								<td></td>



								
							</tr>

							<tr>
								<td colspan="8">
								<center>Special Filters</center>
								<center>
								<table>
									<tr>	
										<td>Assigned To Me</td>
										<td>
											<select id="select_style" name="assigned_to_me">
													<option selected></option>
													<option value="yes">Yes</option>
													<option value="no">No</option>
			                                </select>
										</td>
										<td>Minimum Occurence Of Same Element</td>
										<td>
										<input type="number" name="min_oc" class="form-control input-transparent" style="max-width: 300px">			
										</td>
									</tr>
								</table>

								</center>
								<center> *** Special filters are applicable for export only *** </center>
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
						<th>Element Name</th>

						<th>Client</th>
						<th>Impact</th>
						<th>Reason</th>
						<th>Event Time</th>
						<th>Duration</th>
						<th>Clear Time</th>
						<th>Responsible Concern</th>
						<th>View / Edit</th>
					</tr>
					
					@foreach($fault_lists as $fault_list)
					<tr>
						<td>{{$fault_list->fault_id}} (TT ID : {{$fault_list->ticket_id}})</td>
						<td>{{$fault_list->problem_category}}</td>
						@if($fault_list->element_type=='link')
						<td id="impact_wrap">{{$fault_list->link_name_nttn}},{{$fault_list->link_name_gateway}}</td>
						@endif
						@if($fault_list->element_type=='site')
						<td id="impact_wrap">{{$fault_list->site_name}}</td>
						@endif
						
						
						<td>{{$fault_list->client_name}}</td>
						<td id="impact_wrap">{{$fault_list->client_side_impact}}</td>
						<td>{{$fault_list->reason}}</td>
						<td>{{$fault_list->event_time}}</td>
						<td>
							<?php
							    if(is_null($fault_list->clear_time)){
			                    echo round($fault_list->current_time_duration/60,2)." Hr";
			                	}
			                	else{
			                	echo $fault_list->duration." Hr";
			                	}
							?>

						</td>
						<td>
							{{$fault_list->clear_time}}
						</td>
						<td><?php echo(str_replace("@summitcommunications.net","",$fault_list->responsible_concern)); ?></td>
						<td><a href="{{ url('ViewTTSingle')}}?ticket_id={{$fault_list->ticket_id}}" style="color:#fff"><h3><span class="glyphicon glyphicon-eye-open"></span></i></h3>
						<a href="{{ url('EditTT')}}?ticket_id={{$fault_list->ticket_id}}#{{$fault_list->fault_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a></td>

					</tr>
					@endforeach
				
				</table>
			</div>
			@endif
		@endif	
	@endif	
		</div>
		

	@if($dashboard_value!="")			
			@if($dashboard_value =="site_down")
				<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
			<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.searchPane.min.css')}}">
			<script type="text/javascript" src="{{asset('js/dataTables.searchPane.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('js/jquery.dataTables.yadcf.js')}}"></script>
	        <script type="text/javascript">
	            $(document).ready(function(){
	            
		            var table = $('#incident_table1').DataTable({
		                searchPane: true,
		                sort:false,
		                paging: false,
		                bStateSave: true
		            });
		            $('.pane').each(function(i, obj) {
		                if(i != 1 && i != 2 && i != 9){
		                    $(obj).hide();
		                }
		            });
		            $('.dt-searchPanes').each(function(i,obj){
		            	if(i !=0){
		            		$(obj).hide();
		            	}
		            })

		        });
			</script>
			@elseif($dashboard_value =="oh_link_down")
				<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
			<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.searchPane.min.css')}}">
			<script type="text/javascript" src="{{asset('js/dataTables.searchPane.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('js/jquery.dataTables.yadcf.js')}}"></script>
	        <script type="text/javascript">
	            $(document).ready(function(){
	            
		            var table = $('#incident_table11').DataTable({
		                searchPane: true,
		                sort:false,
		                paging: false,
		                bStateSave: true
		            });
		            $('.pane').each(function(i, obj) {
		                if(i != 1 && i != 2 && i != 9){
		                    $(obj).hide();
		                }
		            });
		            $('.dt-searchPanes').each(function(i,obj){
		            	if(i !=0){
		            		$(obj).hide();
		            	}
		            })

		        });
			</script>
			@else
				<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
			<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.searchPane.min.css')}}">
			<script type="text/javascript" src="{{asset('js/dataTables.searchPane.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('js/jquery.dataTables.yadcf.js')}}"></script>
	        <script type="text/javascript">
	            $(document).ready(function(){
	            
		            var table1 = $('#incident_table111_1').DataTable({
		                searchPane: true,
		                sort:false,
		                paging: false,
		                bStateSave: true
					});
					$('.dt-searchPanes').each(function(i,obj){
		            	if(i !=0){
		            		$(obj).hide();
		            	}
					});
		            $('.pane').each(function(i, obj) {
		                if(i != 1 && i != 2 && i != 3 &&  i != 9){
		                    $(obj).hide();
		                }
		            });
		           
					
					var table2 = $('#incident_table111_2').DataTable({
		                searchPane: true,
		                sort:true,
		                paging: false,
		                bStateSave: true
					});
					$('.dt-searchPanes').eq(2).hide();
					$('.pane').eq(28).show();
					console.log($('.pane').eq(28));
		            

		        });
			</script>
			@endif	
		@if(count($fault_lists1)>0)
		<!-- @if($dashboard_value =="site_down")
		
		        <script type="text/javascript">
		            $(document).ready(function(){
		            
		            var table = $('.incident_table1').DataTable({
		                searchPane: true,
		                sort:false,
		                pageLength: 100
		            });
		            $('.pane').each(function(i, obj) {
		                $(obj).hide();
		                if(i==1)
		                {
		                	$(obj).show();
		                }
		            });

		        });
		</script>
		@endif -->
			@if($dashboard_value =="")
			<div class="pagination"> {!! str_replace('/?', '?', $fault_lists1->appends(Input::except('page'))->render()) !!} </div>
			@endif
			@if($dashboard_value =="site_down")
				<table id="incident_table1" class="incident_table1">
			@elseif($dashboard_value =="oh_link_down")
				<table id="incident_table11" class="incident_table1">
			@else
				<a href="#incident_table111_2">Go to Link Faults</a>
				<table id="incident_table111_1" class="incident_table1">	
			@endif		
					<thead>
					<tr>
						<th>Fault ID</th>
						<th>Problem Category</th>
						<!-- <th>Element Type</th> -->
						<th>Element Name</th>
						<th>Client</th>
						<th>Region</th>
						<th>Subcenters</th>
						@if($dashboard_value =="ug_link_down")
						<th>Current Task Owner</th>
						@endif
						<th>Impact</th>
						<th>Event Time</th>
						<th>Duration</th>
						<!-- <th>Status</th> -->
						<!-- <th>Escalation</th> -->
						<th>Responsible Concern</th>
						<th>Ticket Comments</th>
						<th>Task Comments</th>
						<th>Dept Working on this TT</th>
						<th>View / Edit</th>
					</tr>
					</thead>
					<tbody>
					@foreach($fault_lists1 as $fault_list1)
					<tr>
						<td>{{$fault_list1->fault_id}} (TT ID : {{$fault_list1->ticket_id}})</td>
						<td>{{$fault_list1->problem_category}}</td>
						<!-- <td>{{$fault_list1->element_type}}</td> -->
						<td id="impact_wrap">{{$fault_list1->site_name}}</td>
									
						<td>{{$fault_list1->client_name}}</td>
						<td>{{str_replace("&","",str_replace("-"," ",$fault_list1->region))}}</td>
						<td id="impact_wrap">{{$fault_list1->task_subcenter}}</td>
						@if($dashboard_value =="ug_link_down")
						<td style="background:#71651b">{{$fault_list1->task_assigned_dept_concated}}</td>
						@endif
						<td id="impact_wrap">{{$fault_list1->client_side_impact}}</td>
						<td>{{$fault_list1->event_time}}</td>
						<td>{{round($fault_list1->duration/60,2)}} Hr</td>
						<!-- <td>{{$fault_list1->fault_status}}</td> -->
						<!-- <td>{{$fault_list1->escalation_time}}</td> -->
						<td><?php echo(str_replace("@summitcommunications.net","",$fault_list1->responsible_concern)); ?></td>
						<td >
							@if($fault_list1->scl_comment !="" )
							<div class="wide_columns" ><?php echo preg_replace('/<br(\s+)?\/?>/i', "<br>", $fault_list1->scl_comment); ?></div>
							@else
							NA
							@endif
						</td>
						<td><div class="wide_columns_lg" ><?php echo preg_replace('/<br(\s+)?\/?>/i', "<br>", $fault_list1->task_comment); ?></div></td>
						<td>
							
							<?php $assigned_dept_concated = ''; 
									$assigned_dept_arr = explode(',', $fault_list1->assigned_dept);
							?>
                                    @for($i=0;$i<count($assigned_dept_arr);$i++)
                                        @foreach($department_lists as $department_list)
                                            @if($department_list->dept_row_id == $assigned_dept_arr[$i]) 
                                                <?php $assigned_dept_concated .= $department_list->dept_name.','; ?></h5>
                                            @endif

                                        @endforeach  
                                    @endfor

                            <?php echo str_replace("&","",str_replace("-"," ",$assigned_dept_concated)); ?> 

						</td>
						<td><a href="{{ url('ViewTTSingle')}}?ticket_id={{$fault_list1->ticket_id}}" style="color:#fff"><h3><span class="glyphicon glyphicon-eye-open"></span></i></h3>
						<a href="{{ url('EditTT')}}?ticket_id={{$fault_list1->ticket_id}}#{{$fault_list1->fault_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a></td>

					</tr>
					@endforeach
					</tbody>
				
				</table>
			</div>
			<form id="dashboard_export" action="{{url('FaultView')}}" method="GET">
			<input type="hidden" name="dashboard_value" id="dashboard_value" value="{{$dashboard_value}}">
			<input type="hidden" name="dashboard_value_type" id="dashboard_value_type" value="site">
			<center><input type="button" class="btn btn-primary" name="formType" value="Export" onclick="exportExcel()"></center>
		
			<!-- <div id="incident_div"> -->
		</form>
		@endif
		<br>

		@if(count($fault_lists2)>0)

		
			<!-- <div id="incident_div"> -->

			<div id="incident_div">
				@if($dashboard_value =="")
				<div class="pagination"> {!! str_replace('/?', '?', $fault_lists2->appends(Input::except('page'))->render()) !!} </div>
				@endif
				@if($dashboard_value =="site_down")
					<table id="incident_table1" class="incident_table2">
				@elseif($dashboard_value =="oh_link_down")
					<table id="incident_table11" class="incident_table2">
				@else
					<a href="#incident_table111_1">Go to Site Faults</a>
					<table id="incident_table111_2" class="incident_table2">	
				@endif	
					<thead>
					<tr>
						<th>Fault ID</th>
						<th>Problem Category</th>
						<th>Element Name</th>
						<th>Client</th>
						<th>Region</th>
						<th>Subcenters</th>
						@if($dashboard_value =="ug_link_down")
						<th>Current Task Owner</th>
						@endif
						<th>Impact</th>
						<th>Event Time</th>
						<th>Duration</th>
						<th>Responsible Concern</th>
						<th class="wide_columns" >Ticket Comments</th>
						<th class="wide_columns_lg" >Task Comments</th>
						<th>Dept Working on this TT</th>
						<th>View / Edit</th>
					</tr>
					</thead>
					<tbody>
					@foreach($fault_lists2 as $fault_list2)
					<tr>
						<td>{{$fault_list2->fault_id}} (TT ID : {{$fault_list2->ticket_id}})</td>
						<td>{{$fault_list2->problem_category}}</td>
						<td id="impact_wrap">{{$fault_list2->link_name_nttn}},{{$fault_list2->link_name_gateway}}</td>				
						<td>{{$fault_list2->client_name}}</td>
						<td>{{str_replace("&","",str_replace("-"," ",$fault_list2->region))}}</td>
						<td id="impact_wrap">{{$fault_list2->task_subcenter}}</td>
						@if($dashboard_value =="ug_link_down")
						<td style="background:#71651b">{{$fault_list2->task_assigned_dept_concated}}</td>
						@endif
						<td  id="impact_wrap">{{$fault_list2->client_side_impact}}</td>
						<td>{{$fault_list2->event_time}}</td>
						<td>{{round($fault_list2->duration/60,2)}} Hr</td>
						<td><?php echo(str_replace("@summitcommunications.net","",$fault_list2->responsible_concern)); ?></td>
						<td >
							@if($fault_list2->scl_comment !="" )
							<div class="wide_columns" ><?php echo preg_replace('/<br(\s+)?\/?>/i', "<br>", $fault_list2->scl_comment); ?></div>
							@else
							NA
							@endif
						</td>
						<td ><div class="wide_columns_lg" ><?php echo preg_replace('/<br(\s+)?\/?>/i', "<br>", $fault_list2->task_comment); ?></div></td>
						<td>
							
							<?php $assigned_dept_concated = ''; 
									$assigned_dept_arr = explode(',', $fault_list2->assigned_dept);
							?>
                                    @for($i=0;$i<count($assigned_dept_arr);$i++)
                                        @foreach($department_lists as $department_list)
                                            @if($department_list->dept_row_id == $assigned_dept_arr[$i]) 
                                                <?php $assigned_dept_concated .= $department_list->dept_name.','; ?></h5>
                                            @endif

                                        @endforeach  
                                    @endfor

                            <?php echo str_replace("&","",str_replace("-"," ",$assigned_dept_concated)); ?> 

						</td>
						<td><a href="{{ url('ViewTTSingle')}}?ticket_id={{$fault_list2->ticket_id}}" style="color:#fff"><h3><span class="glyphicon glyphicon-eye-open"></span></i></h3>
						<a href="{{ url('EditTT')}}?ticket_id={{$fault_list2->ticket_id}}#{{$fault_list2->fault_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a></td>

					</tr>
					@endforeach
					</tbody>
				</table>
			</div>
			<form id="dashboard_export" action="{{url('FaultView')}}" method="GET">
				<input type="hidden" name="dashboard_value" id="dashboard_value" value="{{$dashboard_value}}">
				<input type="hidden" name="dashboard_value_type" id="dashboard_value_type" value="link">
				<center><input type="button" class="btn btn-primary" name="formType" value="Export" onclick="exportExcel2()"></center>
				</form>	
			@endif
			
    @endif		

		</div>		
	</div>
</div>
@include('navigation.p_footer')