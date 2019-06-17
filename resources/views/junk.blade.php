<table id="ticket_static_table">
							<tr>
								<td>
									<div class="col-md-12">
										<div class="col-md-2">
											Ticket Title
										</div>
										<div class="col-md-10">
											<input type="text" id="ticket_title" name="ticket_title" class="form-control input-transparent" required>
										</div>
									</div>
								</td>
								<!-- <td>Ticket Title</td>
								<td><input type="text" id="ticket_title" name="ticket_title" class="form-control input-transparent" required></td> -->
							</tr>
							<tr>
								<td>
									<div class="col-md-12">
										<div class="col-md-2">
											Ticket Status
										</div>
										<div class="col-md-10">
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
								</td>
								<!-- <td>Ticket Status</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="ticket_status" required>
											<option selected value="New">New</option>
	                                        @foreach($ticket_status_lists as $ticket_status_list) 
	                                            <option value="{{$ticket_status_list->ticket_status_name}}">{{$ticket_status_list->ticket_status_name}}</option>
	                                        @endforeach
	                                    </select>
	                                </label>
								</td> -->
							</tr>
							<tr>
								<td>
									<div class="col-md-12">
										<div class="col-md-2">
											Attach file
										</div>
										<div class="col-md-10">
											<input type="file" name="ticket_files">
										</div>
									</div>
								</td>
								<!-- <td>Attach file</td>
								<td><input type="file" name="ticket_files"></td> -->
							</tr>
							<tr>
								<td>
									<div class="col-md-12">
										<div class="col-md-2">
											Incident Title
										</div>
										<div class="col-md-10">
											<input type="hidden" name="incident_id">
											<a href="Javascript:incidentScript()">
												<input type="text" id="incident_title" name="incident_title" class="form-control input-transparent" required>
											</a>
										</div>
									</div>
								</td>
								<!-- <td>Incident Title</td>
								<td>
									<input type="hidden" name="incident_id">
									<a href="Javascript:incidentScript()">
										<input type="text" id="incident_title" name="incident_title" class="form-control input-transparent" required>
									</a>
								</td> -->
							</tr>
							<tr>
								<td>
									<div class="col-md-12">
										<div class="col-md-2">
											Incident Description
										</div>
										<div class="col-md-10">
											<textarea rows="3" class="form-control input-transparent" id="incident_description" name="incident_description" required></textarea>
										</div>
									</div>
								</td>
								<!-- <td>Incident Description</td>	
								<td>
									<textarea rows="3" class="form-control input-transparent" id="incident_description" name="incident_description" required></textarea>
								</td> -->
							</tr>
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
						</table>






























@include('navigation.p_header')

<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
<!--   <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="{{asset('js/jquery-ui.js')}}"></script>
<script src="{{asset('lib/moment/moment.js')}}"></script>
<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script  src="{{asset('js/create_tt.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">

<script type="text/javascript">
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
</style>     
<div id="tt_form_div" class="container-fluid">
	<form action="{{ url('CreateTicket') }}" id="tt_create_form" method="post" enctype="multipart/form-data">
	<input type="hidden" name="hidden_fault_ids" id="hidden_fault_ids">
	<div class="col-md-12" id="static_div">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-3">
						<div class="col-md-12">
						
									<div class="row" id="ticket_row">
										<div class="col-md-4">
											<p>Ticket Title</p>
										</div>
										<div class="col-md-8">
											<input type="text" id="ticket_title" name="ticket_title" class="form-control input-transparent" required>
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
											<input type="file" name="ticket_files">
										</div>
									</div>
								
									<div class="row">
										<div class="col-md-4">
											<p>Incident Title</p>
										</div>
										<div class="col-md-8">
											<input type="hidden" name="incident_id">
											<a href="Javascript:incidentScript()">
												<input type="text" id="incident_title" name="incident_title" class="form-control input-transparent" required>
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
					<div class="col-md-3">
						<table>
							<tr>
								<td>SCL Comment</td>
							</tr>
							<tr>	
								<td>
									<textarea rows="7" class="form-control input-transparent" id="ticket_comment_scl" name="ticket_comment_scl" required></textarea>
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
									<textarea rows="7" class="form-control input-transparent" id="ticket_comment_client" name="ticket_comment_client" required></textarea>
								</td>
							</tr>
						</table>
					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>{{$_SESSION['department']}}'s Internal Comment</td>
							</tr>
							<tr>	
								<td>
									<textarea rows="7" class="form-control input-transparent" id="ticket_comment_noc" name="ticket_comment_noc" required></textarea>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>	
		</section>
	</div>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="addFault()" style="color:#fff;"><i class="fa fa-plus-square" ></i></a>
	<br/><br/>

</div> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="btn btn-primary" onclick="tt_create_form_submit()">CREATE TICKET</div>

	</form>
@include('navigation.p_footer')