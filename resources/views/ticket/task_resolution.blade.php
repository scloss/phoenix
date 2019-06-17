@include('navigation.p_header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--   <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{asset('js/create_tt.js')}}"></script>
<script type="text/javascript" src="{{asset('js/edit_tt.js?v1')}}"></script>
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

	var task_resolution_reason_js_arr = <?php echo json_encode($task_resolution_reason_js_arr) ?>;
	var task_resolution_type_js_arr = <?php echo json_encode($task_resolution_type_js_arr) ?>;
	var task_resolution_inventory_type_js_arr = <?php echo json_encode($task_resolution_inventory_type_js_arr) ?>;
	var task_resolution_inventory_detail_js_arr = <?php echo json_encode($task_resolution_inventory_detail_js_arr) ?>;


</script>
<div class="col-md-12">
	@foreach($previous_task_resolutions_lists as $previous_task_resolutions_list)
			<section class="widget" id="default-widget">
				<header>
					<h5>Existed Resolution ID - <b>{{$previous_task_resolutions_list->task_resolution_id}}</b></h5>
				</header>	
				<div class="body" id="resolution_body">
					<div class="row">
						<div class="col-md-6">
							<table id="previous_resolution_table">
								<tr>
									<td>Reason</td>
									<td>{{$previous_task_resolutions_list->reason}}</td>
								</tr>
								<tr>
									<td>Resolution Type</td>
									<td>{{$previous_task_resolutions_list->resolution_type}}</td>
								</tr>
								<tr>
									<td>Inventory Type</td>
									<td>{{$previous_task_resolutions_list->inventory_type}}</td>
								</tr>
								<tr>
									<td>Inventory Detail</td>
									<td>{{$previous_task_resolutions_list->inventory_detail}}</td>
								</tr>
								

								<tr>
									<td>Quantity</td>
									<td>{{$previous_task_resolutions_list->quantity}}</td>
								</tr>
								<tr>
									<td>Remark</td>
									<td>{{$previous_task_resolutions_list->remark}}</td>
								</tr>
								<tr>
									<td>Lat</td>
									<td>{{$previous_task_resolutions_list->lat}}</td>
								</tr>
								<tr>
									<td>Lon</td>
									<td>{{$previous_task_resolutions_list->lon}}</td>
								</tr>
								<tr>
									<td colspan="2">
										<form name="resolution_form" action="{{ url('DeleteResolution') }}" method="POST">
											<input type="hidden" name="task_id" id="task_id" value="{{$task_id}}">
											<input type="hidden" name="ticket_id" id="ticket_id" value="{{$ticket_id}}">
											<input type="hidden" name="fault_id" id="fault_id" value="{{$fault_id}}">
											<input type="hidden" name="resolution_id" id="resolution_id" value="{{$previous_task_resolutions_list->task_resolution_id}}">
											<input type="hidden" name="is_force_majeure" id="is_force_majeure" value="{{$previous_task_resolutions_list->reason}}">
											<input type="hidden" name="lat" id="lat" value="{{$previous_task_resolutions_list->lat}}">
											<input type="hidden" name="lon" id="lon" value="{{$previous_task_resolutions_list->lon}}">
											<input type="submit" class="btn btn-primary" name="Delete" value="Delete">
										</form>
									</td>
								</tr>
							</table>
						</div>

					</div>
				</div>
			</section>
		@endforeach
	</div>
		<form name="resolution_form" action="{{ url('AddResolution') }}" method="POST">
<div id="resolution_form_div" class="container-fluid">


	<div class="col-md-8" id="static_div">
		
		
		<section class="widget" id="default-widget">
			<header>
				<h5>Resolution 1</h5>
				<div class="widget-controls dropdown" required=""><ul class="dropdown-menu dropdown-menu-right" required=""><li class="listkAddResolution_" required=""><a class="listkAddResolution_" required="" href="#" onclick="addTaskResolution()">Add Resolution</a></li></ul><a class="dropdown-toggle" required="" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog" required=""></i></a></div>
			</header>
			<div class="body" id="resolution_body">
				<div class="row">
					<div class="col-md-6">
						<table>
							<tr>
								<td>Reason</td>
								<td><label style="float:left;">


										<select id="select_style" name="task_resolution_reason_1" required>
                                                <option disabled selected></option>
                                                <option value="N/A">N/A</option>
                                                @foreach($task_resolution_reason_lists as $task_resolution_reason_list)
                                                        <option value="{{$task_resolution_reason_list->task_resolution_reason}}">{{$task_resolution_reason_list->task_resolution_reason}}</option>
                                                @endforeach 
	                                    </select>
	                                </label></td>
							</tr>
							<tr>
								<td>Resolution Type</td>
								<td><label style="float:left;">


										<select id="select_style" name="task_resolution_type_1" required>
                                                <option disabled selected></option>
                                                <option value="N/A">N/A</option>
                                                @foreach($task_resolution_type_lists as $task_resolution_type_list)
                                                        <option value="{{$task_resolution_type_list->task_resolution_type}}">{{$task_resolution_type_list->task_resolution_type}}</option>
                                                @endforeach 
	                                    </select>
	                                </label></td>
							</tr>
							<tr>
								<td>Inventory Type</td>
								<td><label style="float:left;">


										<select id="select_style" name="task_resolution_inventory_type_1" required>
                                                <option disabled selected></option>
                                                <option value="N/A">N/A</option>
                                                @foreach($task_resolution_inventory_type_lists as $task_resolution_inventory_type_list)
                                                        <option value="{{$task_resolution_inventory_type_list->task_resolution_inventory_type}}">{{$task_resolution_inventory_type_list->task_resolution_inventory_type}}</option>
                                                @endforeach 
	                                    </select>
	                                </label></td>
							</tr>
							<tr>
								<td>Inventory Detail</td>
								<td><label style="float:left;">


										<select id="select_style" name="task_resolution_inventory_detail_1" required>
                                                <option disabled selected></option>
                                                <option value="N/A">N/A</option>
                                                @foreach($task_resolution_inventory_detail_lists as $task_resolution_inventory_detail_list)
                                                        <option value="{{$task_resolution_inventory_detail_list->task_resolution_inventory_detail}}">{{$task_resolution_inventory_detail_list->task_resolution_inventory_detail}}</option>
                                                @endforeach 
	                                    </select>
	                                </label></td>
							</tr>
							<tr>
								<td>Is Force Majeure</td>
								<td><label style="float:left;">


										<select id="select_style" name="task_resolution_fm_1" required>
                                                <option value="no">no</option>
                                                <option value="yes">yes</option>
                                                
	                                    </select>
	                                </label></td>
							</tr>
							<tr>
								<td>Quantity</td>
								<td><input type="number" min='0' id="task_resolution_quantity_1" name="task_resolution_quantity_1" class="form-control input-transparent" required> </td>
							</tr>

							<tr>
								<td>Lat</td>
								<td><input type="number" min='0' id="task_resolution_lat_1" name="task_resolution_lat_1" class="form-control input-transparent" required> </td>
							</tr>

							<tr>
								<td>Lon</td>
								<td><input type="number" min='0' id="task_resolution_lon_1" name="task_resolution_lon_1" class="form-control input-transparent" required> </td>
							</tr>


							<tr>
								<td>Remark</td>
								<td><input type="text" id="task_resolution_remarks_1" name="task_resolution_remarks_1" class="form-control input-transparent" required> </td>
							</tr>																												
						</table>
					</div>
				</div>		
			</div>			
		</section>
	</div>

</div>
<input type="hidden" name="resolution_counter" id="resolution_counter" value="1">
<input type="hidden" name="task_id" id="task_id" value="{{$task_id}}">
<input type="hidden" name="ticket_id" id="ticket_id" value="{{$ticket_id}}">
<input type="hidden" name="fault_id" id="fault_id" value="{{$fault_id}}">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary" type="submit">ADD RESOLUTIONS</button> 
</form>

@include('navigation.p_footer')