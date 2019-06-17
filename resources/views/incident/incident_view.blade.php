@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/incident_style.css')}}">
<div class="container-fluid" id="incident_main_div">
<script type="text/javascript">
	var incident_js_arr = <?php echo json_encode($incident_js_arr) ?>;
</script>
<script type="text/javascript">
    
    document.getElementById('incident-collapse').className = 'panel-collapse collapse in';
    document.getElementById('incident_view').className = 'active';

	$( document ).ready(function() {
    	console.log( "i m ready!" );
		var incident_id = document.getElementById('search-0').value;
		var incident_title = document.getElementById('search-1').value;
		var incident_description = document.getElementById('search-2').value;
		var incident_status = document.getElementById('search-3').value;
		var incident_user_id = document.getElementById('search-4').value;
		var ticket_id = document.getElementById('search-5').value;
		var ticket_title = document.getElementById('search-6').value;
		var ticket_status = document.getElementById('search-7').value;
		var assigned_dept = document.getElementById('search-8').value;
		var ticket_time_from = document.getElementById('search-9').value;
		var ticket_time_to = document.getElementById('search-10').value;
		var ticket_closing_time_from = document.getElementById('search-11').value;
		var ticket_closing_time_to = document.getElementById('search-12').value;


		$("input[name=incident_id]").val(incident_id);
		$("input[name=incident_title]").val(incident_title);
		$("textarea[name=incident_description]").val(incident_description);
		$("select[name=incident_status]").val(incident_status);
		$("input[name=incident_merger_id]").val(incident_user_id);
		$("input[name=ticket_id]").val(ticket_id);
		$("input[name=ticket_title]").val(ticket_title);
		$("select[name=ticket_status]").val(ticket_status);
		$("select[name=assigned_dept]").val(assigned_dept);
		$("input[name=ticket_time_from]").val(ticket_time_from);
		$("input[name=ticket_time_to]").val(ticket_time_to);
		$("input[name=ticket_closing_time_from]").val(ticket_closing_time_from);
		$("input[name=ticket_closing_time_to]").val(ticket_closing_time_to);	
		
	});
</script>

<script src="{{asset('js/incident.js')}}"></script>
	<!-- @if(isset($_SESSION["CURRENT_LIST"]))
	<p style="color:#fff;">{{$_SESSION["CURRENT_LIST"]}}</p>
	@endif -->
	<h2 class="page-title">View Incident <span class="fw-semi-bold"></span></h2>
	<div clss="row">
		@foreach($search_value as $key=>$value)
		<input type="hidden" id="search-{{$key}}" value="{{$value}}">
		@endforeach
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="incident_search" action="{{url('IncidentView')}}" method="GET">
								<tr>
									<td colspan="10" id="section_header">Incident</td>
								</tr>
								<tr>
									<td>Incident ID</td>
									<td>
										<input type="text" name="incident_id" class="form-control input-transparent" title="You can add multiple Ids like x,y,z etc."  placeholder="You can add multiple Ids like x,y,z etc.">
									</td>
									<td>Incident Title</td>
									<td>
										<input type="text" name="incident_title" class="form-control input-transparent">
									</td>
									<td >Incident Description</td>
									<td>
										<textarea rows="3" name="incident_description" class="form-control input-transparent"></textarea>
									</td>
									<td>Incident Status</td>
									<td>
										<label style="float:left;">
											<select id="select_style" name="incident_status" >
												<option disabled selected></option>
												<option value="open">Open</option>
												<option value="closed">Closed</option>
		                                    </select>
		                                </label>
									</td>
									<td>Incident User ID</td>
									<td>
										<input type="text" name="incident_merger_id" class="form-control input-transparent">
									</td>
									<!-- <input type="hidden" name="incident_fields">
									<input type="hidden" name="ticket_fields">
									<input type="hidden" name="fault_fields"> -->
								</tr>
								<tr>
									<td colspan="10" id="section_header">Ticket</td>
								</tr>	
								<tr>
									<td>Ticket ID</td>
									<td>
										<input type="text" name="ticket_id" class="form-control input-transparent"  title="You can add multiple Ids like x,y,z etc."  placeholder="You can add multiple Ids like x,y,z etc.">
									</td>
									<td>Ticket Title</td>
									<td>
										<input type="text" name="ticket_title" class="form-control input-transparent">
									</td>
									<td>Ticket Status</td>
									<td>
										<label style="float:left;">
											<select id="select_style" name="ticket_status" >
												<option disabled selected></option>
												<option value="New">New</option>
												<option value="Acknowledged">Acknowledged</option>
												<option value="Closed">Closed</option>
		                                    </select>
		                                </label>
									</td>
									<td>Assigned Dept</td>
									<td>
										<label style="float:left;">
											<select id="select_style" name="assigned_dept" >
												<option disabled selected></option>
												@foreach($department_lists as $department_list) 
		                                            <option value="{{$department_list->dept_row_id}}">{{$department_list->dept_name}}</option>
		                                        @endforeach
		                                    </select>
		                                </label>
		                            </td>
		                        </tr>    
		                        <tr>     
		                            <td>Ticket Time From</td>
									<td>
										<div id="ticket_time_from" class="input-group">
		                                    <input id="datepicker2i" type="text" name="ticket_time_from" class="form-control input-transparent" >
		                                    <span class="input-group-addon btn btn-info">
		                                        <span class="glyphicon glyphicon-calendar"></span>                    
		                                    </span>
		                                </div> 
									</td> 
									<td>Ticket Time To</td>
									<td>
										<div id="ticket_time_to" class="input-group">
		                                    <input id="datepicker2i" type="text" name="ticket_time_to" class="form-control input-transparent" >
		                                    <span class="input-group-addon btn btn-info">
		                                        <span class="glyphicon glyphicon-calendar"></span>                    
		                                    </span>
		                                </div> 
									</td>  
									<td>Ticket Closing Time From</td>
									<td>
										<div id="ticket_closing_time_from" class="input-group">
		                                    <input id="datepicker2i" type="text" name="ticket_closing_time_from" class="form-control input-transparent" >
		                                    <span class="input-group-addon btn btn-info">
		                                        <span class="glyphicon glyphicon-calendar"></span>                    
		                                    </span>
		                                </div> 
									</td>
									<td>Ticket Closing Time to</td>
									<td>
										<div id="ticket_closing_time_to" class="input-group">
		                                    <input id="datepicker2i" type="text" name="ticket_closing_time_to" class="form-control input-transparent" >
		                                    <span class="input-group-addon btn btn-info">
		                                        <span class="glyphicon glyphicon-calendar"></span>                    
		                                    </span>
		                                </div> 
									</td> 
								</tr>								
								<tr>
									<td colspan="14">
										<input type="submit" class="btn btn-primary"  name="Search" value="Search">
									</td>
								</tr>
							</form>
						</table>
					</div>
				</div>
			</div>
		</section>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div id="incident_div">
				@if(count($searched_lists)>0)
				<div class="pagination"> {!! str_replace('/?', '?', $searched_lists->appends(Input::except('page'))->render()) !!} </div>
				@endif
				<table id="incident_table">
					<tr>
						<th>ID</th>
						<th>Incident Title</th>
						<th>Description</th>
						<th>DateTime</th>
						<th>Add to Incident Cart</th>
					</tr>
					@for($k=0;$k<count($incident_js_arr);$k++)
						<?php $i = $incident_js_arr[$k]; ?>
						@if(array_key_exists($i,$total_arr_lists))
							<tr id="{{$i}}" onclick="show_related_tickets({{$i}})">
								<td>{{$incident_arr_lists[$i]['incident_id']}}</td>
								<td>{{$incident_arr_lists[$i]['incident_title']}}</td>
								<td>{{$incident_arr_lists[$i]['incident_description']}}</td>
								<td>{{$incident_arr_lists[$i]['incident_row_created_date']}}</td>
								<td class="addtocart" ><span class="glyphicon glyphicon-shopping-cart" id="{{$i}}|{{$incident_arr_lists[$i]['incident_title']}}" onclick="incident_insert(this.id)"></td>
							</tr>
							<tr>
								<td colspan="7" class="related_class"  id="related_tickets_{{$i}}">
									<div id="easingDiv_{{$i}}">
										<table id="incident_inner_table">
											<thead>
											<tr>
				                                <th class="hidden-xs">ID</th>
				                                <th class="hidden-xs">Ticket Title</th>
				                                <th class="hidden-xs">Assigned To</th>
				                                <th class="hidden-xs">Opening Time</th>
				                                <th class="hidden-xs">Status</th>
				                                <th class="hidden-xs">Closing Time</th>
				                                <th class="hidden-xs">Duration</th>
				                                <th class="hidden-xs">Action</th>
				                            </tr>
				                            </thead>
				                            <tbody>
				                            	@for($j=0;$j<count($total_arr_lists[$i]);$j++)
													<tr id="myDiv">
														<td class="hidden-xs">
															{{$total_arr_lists[$i][$j]['ticket_id']}}
														</td>
														<td class="context-menu-one">
															{{$total_arr_lists[$i][$j]['ticket_title']}}
														</td>	
														<td class="hidden-xs">
						                                    <p class="no-margin">
						                                        <small>
						                                        	{{$total_arr_lists[$i][$j]['assigned_dept']}}
						                                       
						                                        </small>
						                                    </p>
						                                </td>
														<td class="hidden-xs">
						                                    {{$total_arr_lists[$i][$j]['ticket_row_created_date']}}
						                                </td>
						                                <td class="hidden-xs">
						                                	@if($total_arr_lists[$i][$j]['ticket_status'] == 'Closed')
						                                		<span class="label label-success">Closed</span>
						                                	@else	
						                                		<span class="label label-danger">{{$total_arr_lists[$i][$j]['ticket_status']}}</span>
						                                	@endif	
						                                </td> 
						                                <td class="hidden-xs">
						                                    {{$total_arr_lists[$i][$j]['ticket_closing_time']}}
						                                </td>
						                                <td class="hidden-xs">
						                                	<?php 
						                                		$start_time = new DateTime($total_arr_lists[$i][$j]['ticket_row_created_date']);
						                                		$end_time = new DateTime($total_arr_lists[$i][$j]['ticket_closing_time']);
						                                		$diff = $start_time->diff($end_time);
        														echo $diff->format('%a days %h hours %i minutes');
						                                	?>
						                                </td>
														<td>
						                                	<a href="{{url('EditTT')}}?ticket_id={{$total_arr_lists[$i][$j]['ticket_id']}}"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a>
						                                </td> 
													</tr>
												@endfor
				                            </tbody>
										</table>		
									</div>
								</td>
							</tr>
						@endif	
					@endfor
				</table>
			</div>
		</div>
	</div>
</div>
@include('navigation.p_footer')