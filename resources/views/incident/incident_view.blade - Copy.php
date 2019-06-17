@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('js/incident.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/incident_style.css')}}">
<div class="container-fluid" id="incident_main_div">
	<!-- @if(isset($_SESSION["CURRENT_LIST"]))
	<p style="color:#fff;">{{$_SESSION["CURRENT_LIST"]}}</p>
	@endif -->
	<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="incident_search" action="{{url('IncidentView')}}" method="GET">
								<tr>
									<td colspan="14" id="section_header">Incident</td>
								</tr>
								<tr>
									<td>Incident ID</td>
									<td>
										<input type="text" name="incident_id" class="form-control input-transparent">
									</td>
									<td>Incident Title</td>
									<td>
										<input type="text" name="incident_title" class="form-control input-transparent">
									</td>
									<td colspan="3">Incident Description</td>
									<td colspan="3">
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
									<td colspan="14" id="section_header">Ticket</td>
								</tr>	
								<tr>
									<td>Ticket ID</td>
									<td>
										<input type="text" name="ticket_id" class="form-control input-transparent">
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
												<option value="open">Open</option>
												<option value="closed">Closed</option>
		                                    </select>
		                                </label>
									</td>
									<td>Assigned Dept</td>
									<td colspan="2">
										<label style="float:left;">
											<select id="select_style" name="assigned_dept" >
												<option disabled selected></option>
												@foreach($department_lists as $department_list) 
		                                            <option value="{{$department_list->dept_name}}">{{$department_list->dept_name}}</option>
		                                        @endforeach
		                                    </select>
		                                </label>
		                            </td> 
		                            <td>Ticket Time From</td>
									<td>
										<div id="ticket_time_from" class="input-group">
		                                    <input id="datepicker2i" type="text" name="ticket_time" class="form-control input-transparent" >
		                                    <span class="input-group-addon btn btn-info">
		                                        <span class="glyphicon glyphicon-calendar"></span>                    
		                                    </span>
		                                </div> 
									</td> 
									<td>Ticket Time To</td>
									<td>
										<div id="ticket_time_to" class="input-group">
		                                    <input id="datepicker2i" type="text" name="ticket_time" class="form-control input-transparent" >
		                                    <span class="input-group-addon btn btn-info">
		                                        <span class="glyphicon glyphicon-calendar"></span>                    
		                                    </span>
		                                </div> 
									</td>  
								</tr>
								<tr>
									<td colspan="5">SCL Comment</td>
									<td colspan="5">Client Comment</td>
									<td colspan="4">NOC Comment</td>
								</tr>
								<tr>	
									<td colspan="5">
										<textarea rows="7" class="form-control input-transparent" id="ticket_comment_scl" name="ticket_comment_scl" ></textarea>
									</td>
									<td colspan="5">
										<textarea rows="7" class="form-control input-transparent" id="ticket_comment_client" name="ticket_comment_client" ></textarea>
									</td>
									<td colspan="4">
										<textarea rows="7" class="form-control input-transparent" id="ticket_comment_noc" name="ticket_comment_noc" ></textarea>
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
				<table id="incident_table">
					<tr>
						<th>ID</th>
						<th>Incident Title</th>
						<th>Description</th>
						<th>DateTime</th>
						<th>Incident Merge Time</th>
						<th>Incident Merger</th>
						<th>Add to Incident Cart</th>
					</tr>
					<tr id="10" onclick="show_related_tickets(this.id)">
						<td>10</td>
						<td>Node B flapped</td>
						<td>Node B constantly flapping. Cannot find root cause</td>
						<td>2016-10-11 10:15:23</td>
						<td></td>
						<td></td>
						<td class="addtocart" ><span class="glyphicon glyphicon-shopping-cart" id="10|Node B flapped" onclick="incident_insert(this.id)"></td>
					</tr>
					
					<tr>			
						<td colspan="7" id="related_tickets_10">
							<div id="easingDiv_10">
							<table id="incident_inner_table">
								<thead>
								<tr>
	                                <th class="hidden-xs">ID</th>
	                                <th class="hidden-xs">Ticket Title</th>
	                                <th class="hidden-xs">Description</th>
	                                <th class="hidden-xs">Assigned To</th>
	                                <th class="hidden-xs">Opening Time</th>
	                                <th class="hidden-xs">Status</th>
	                                <th class="hidden-xs">Closing Time</th>
	                                <th class="hidden-xs">Duration</th>
	                                <th class="hidden-xs">Action</th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            <tr id="myDiv">
	                                <td class="hidden-xs">1</td>
	                                <td class="context-menu-one">
	                                    MNTGB05 to MNTGB01 Link Down.
	                                </td>
	                                <td class="hidden-xs" id="decription" title="Client : ROBI | Impact : No outage occured">
	                                	<p class="no-margin">
	                                        <small>
	                                            <span class="fw-semi-bold">Client : </span>
	                                            <span>&nbsp; ROBI</span>
	                                        </small>
	                                    </p>
	                                    <p class="no-margin">
	                                        <small>
	                                            <span class="fw-semi-bold">Impact : </span>
	                                            <span>&nbsp; No outage occured</span>
	                                        </small>
	                                    </p>
	                                </td>
	                                <td class="hidden-xs">
	                                    <p class="no-margin">
	                                        <small>
	                                            <span class="fw-semi-bold">Dept:</span>
	                                            <span>&nbsp; O&M1</span>
	                                        </small>
	                                    </p>
	                                    <p>
	                                        <small>
	                                            <span class="fw-semi-bold">Responsible Person:</span>
	                                            <span>&nbsp; Shamama Shahrin Arani</span>
	                                        </small>
	                                    </p>
	                                </td>
	                                <td class="hidden-xs">
	                                    10:05:03 2016-11-02
	                                </td>
	                                <td class="hidden-xs">
	                                	<span class="label label-success">Closed</span>                              
	                                </td>
	                                <td class="hidden-xs">
	                                    10:25:53 2016-11-02
	                                </td>
	                                <td>
	                                	0h 20min 50s
	                                </td>
	                                <td>
	                                	<i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i>
	                                </td>
	                            </tr>
	                           <tr>
	                                <td class="hidden-xs">3</td>
	                                <td>
	                                    MNTGB05 to MNTGB01 Link Down.
	                                </td>
	                                <td class="hidden-xs">
	                                	<p class="no-margin">
	                                        <small>
	                                            <span class="fw-semi-bold">Client : </span>
	                                            <span>&nbsp; ROBI</span>
	                                        </small>
	                                    </p>
	                                    <p class="no-margin">
	                                        <small>
	                                            <span class="fw-semi-bold">Impact : </span>
	                                            <span>&nbsp; No outage occured</span>
	                                        </small>
	                                    </p>
	                                </td>
	                                <td class="hidden-xs">
	                                    <p class="no-margin">
	                                        <small>
	                                            <span class="fw-semi-bold">Dept:</span>
	                                            <span>&nbsp; O&M1</span>
	                                        </small>
	                                    </p>
	                                    <p>
	                                        <small>
	                                            <span class="fw-semi-bold">Responsible Person:</span>
	                                            <span>&nbsp; Shamama Shahrin Arani</span>
	                                        </small>
	                                    </p>
	                                </td>
	                                <td class="hidden-xs">
	                                    10:05:03 2016-11-02
	                                </td>
	                                <td class="hidden-xs">
	                                    <span class="label label-important">Active</span>  
	                                </td>
	                                <td class="hidden-xs">
	                                    10:25:53 2016-11-02
	                                </td>
	                                <td>
	                                	0h 20min 50s
	                                </td>
	                                <td>
	                                	<i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i>
	                                </td>
	                            </tr>
	                            </tbody>

							</table>
							</div>
						</td>
                           
					</tr>
					 
					<tr id="12" onclick="show_related_tickets(this.id)">
						<td>12</td>
						<td>Node C flapped</td>
						<td>Node C constantly flapping. Cannot find root cause</td>
						<td>2016-07-15 11:25:28</td>
						<td></td>
						<td></td>
						<td class="addtocart" ><span class="glyphicon glyphicon-shopping-cart" id="12|Node C flapped" onclick="incident_insert(this.id)"></td>
						<!-- <td><a href="#" id="12" onclick="show_related_tickets(this.id)"><span class="glyphicon glyphicon-chevron-down" id="span_12"></span></a></td> -->
					</tr>
					<tr>
						<td colspan="7"  id="related_tickets_12">
							<div id="easingDiv_12">
							<table id="incident_inner_table">
								<thead>
								<tr>
	                                <th class="hidden-xs">ID</th>
	                                <th class="hidden-xs">Ticket Title</th>
	                                <th class="hidden-xs">Description</th>
	                                <th class="hidden-xs">Assigned To</th>
	                                <th class="hidden-xs">Opening Time</th>
	                                <th class="hidden-xs">Status</th>
	                                <th class="hidden-xs">Closing Time</th>
	                                <th class="hidden-xs">Duration</th>
	                                <th class="hidden-xs">Action</th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            <tr id="myDiv">
	                                <td class="hidden-xs">8</td>
	                                <td class="context-menu-one">
	                                    MNTGB05 to MNTGB01 Link Down.
	                                </td>
	                                <td class="hidden-xs" id="decription" title="Client : ROBI | Impact : No outage occured">
	                                	<p class="no-margin">
	                                        <small>
	                                            <span class="fw-semi-bold">Client : </span>
	                                            <span>&nbsp; ROBI</span>
	                                        </small>
	                                    </p>
	                                    <p class="no-margin">
	                                        <small>
	                                            <span class="fw-semi-bold">Impact : </span>
	                                            <span>&nbsp; No outage occured</span>
	                                        </small>
	                                    </p>
	                                </td>
	                                <td class="hidden-xs">
	                                    <p class="no-margin">
	                                        <small>
	                                            <span class="fw-semi-bold">Dept:</span>
	                                            <span>&nbsp; O&M1</span>
	                                        </small>
	                                    </p>
	                                    <p>
	                                        <small>
	                                            <span class="fw-semi-bold">Responsible Person:</span>
	                                            <span>&nbsp; Shamama Shahrin Arani</span>
	                                        </small>
	                                    </p>
	                                </td>
	                                <td class="hidden-xs">
	                                    10:05:03 2016-11-02
	                                </td>
	                                <td class="hidden-xs">
	                                	<span class="label label-important">Active</span>                              
	                                </td>
	                                <td class="hidden-xs">
	                                    10:25:53 2016-11-02
	                                </td>
	                                <td>
	                                	0h 20min 50s
	                                </td>
	                                <td>
	                                	<i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i>
	                                </td>
	                            </tr>
	                           <tr>
	                                <td class="hidden-xs">9</td>
	                                <td>
	                                    MNTGB05 to MNTGB01 Link Down.
	                                </td>
	                                <td class="hidden-xs">
	                                	<p class="no-margin">
	                                        <small>
	                                            <span class="fw-semi-bold">Client : </span>
	                                            <span>&nbsp; ROBI</span>
	                                        </small>
	                                    </p>
	                                    <p class="no-margin">
	                                        <small>
	                                            <span class="fw-semi-bold">Impact : </span>
	                                            <span>&nbsp; No outage occured</span>
	                                        </small>
	                                    </p>
	                                </td>
	                                <td class="hidden-xs">
	                                    <p class="no-margin">
	                                        <small>
	                                            <span class="fw-semi-bold">Dept:</span>
	                                            <span>&nbsp; O&M1</span>
	                                        </small>
	                                    </p>
	                                    <p>
	                                        <small>
	                                            <span class="fw-semi-bold">Responsible Person:</span>
	                                            <span>&nbsp; Shamama Shahrin Arani</span>
	                                        </small>
	                                    </p>
	                                </td>
	                                <td class="hidden-xs">
	                                    10:05:03 2016-11-02
	                                </td>
	                                <td class="hidden-xs">
	                                    <span class="label label-important">Active</span>  
	                                </td>
	                                <td class="hidden-xs">
	                                    10:25:53 2016-11-02
	                                </td>
	                                <td>
	                                	0h 20min 50s
	                                </td>
	                                <td>
	                                	<i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i>
	                                </td>
	                            </tr>
	                            </tbody>

							</table>
						</td>
                            
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
@include('navigation.p_footer')