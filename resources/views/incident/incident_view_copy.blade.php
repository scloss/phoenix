@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('js/incident.js')}}"></script>
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
							<tr>
								<td colspan="10">Incident</td>
							</tr>
							<tr>
								<td>Incident Title</td>
								<td>
									<input type="text" name="incident_title" class="form-control input-transparent">
								</td>
								<td>Incident Description</td>
								<td>
									<textarea rows="3" name="incident_description" class="form-control input-transparent"></textarea>
								</td>
								<td>Incident Status</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="incident_status" required>
											<option disabled selected></option>
											<option value="active">Active</option>
											<option value="closed">Closed</option>
	                                    </select>
	                                </label>
								</td>
								<td>Incident User ID</td>
								<td>
									<input type="text" name="incident_user_id" class="form-control input-transparent">
								</td>
								<td>Incident User Dept</td>
								<td>
									<input type="text" name="incident_user_dept" class="form-control input-transparent">
								</td>
							</tr>
							<tr>
								<td colspan="10">Ticket</td>
							</tr>	
							<tr>
								<td>Ticket Title</td>
								<td colspan="3">
									<input type="text" name="ticket_title" class="form-control input-transparent">
								</td>
								<td>Ticket Status</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="ticket_status" required>
											<option disabled selected></option>
											<option value="active">Active</option>
											<option value="closed">Closed</option>
	                                    </select>
	                                </label>
								</td>
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
	                            <td>Ticket Time</td>
								<td>
									<div id="ticket_time" class="input-group">
	                                    <input id="datepicker2i" type="text" name="ticket_time" class="form-control input-transparent" required>
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>  
							</tr>
							<tr>
								<td colspan="4">SCL Comment</td>
								<td colspan="3">Client Comment</td>
								<td colspan="3">NOC Comment</td>
							</tr>
							<tr>	
								<td colspan="4">
									<textarea rows="7" class="form-control input-transparent" id="ticket_comment_scl" name="ticket_comment_scl" required></textarea>
								</td>
								<td colspan="3">
									<textarea rows="7" class="form-control input-transparent" id="ticket_comment_client" name="ticket_comment_client" required></textarea>
								</td>
								<td colspan="3">
									<textarea rows="7" class="form-control input-transparent" id="ticket_comment_noc" name="ticket_comment_noc" required></textarea>
								</td>
							</tr>
							<tr>
								<td colspan="10">Fault</td>
							</tr>
							<tr>
								<td>Client ID</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="client_id" required>
											<option disabled selected></option>
											@foreach($client_lists as $client_list) 
	                                            <option value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
								<td>Element Type</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="element_type" required>
											<option disabled selected></option>
											<option value="link">Link</option>
											<option value="site">Site</option>
	                                    </select>
	                                </label>
								</td>
								<td>Element Name</td>
								<td><input type="text" name="element_name" class="form-control input-transparent"></td>
								<td>VLAN ID</td>
								<td><input type="text" name="vlan_id" class="form-control input-transparent"></td>
								<td>LINK ID</td>
								<td><input type="text" name="link_id" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>SITE IP ADDRESS</td>
								<td><input type="text" name="site_ip_address" class="form-control input-transparent"></td>
								<td>Fault Status</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="fault_status" required>
											<option disabled selected></option>
											<option value="active">Active</option>
											<option value="closed">Closed</option>
	                                    </select>
	                                </label>
								</td>
								<td>District</td>
								<td><input type="text" name="district" class="form-control input-transparent"></td>
								<td>Region</td>
								<td><input type="text" name="region" class="form-control input-transparent"></td>
								<td>SMS Group</td>
								<td><input type="text" name="sms_group" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Client Priority</td>
								<td><input type="text" name="client_priority" class="form-control input-transparent"></td>
								<td>Client Side Impact</td>
								<td><input type="text" name="client_side_impact" class="form-control input-transparent"></td>
								<td>Link Type</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="link_type_lists" required>
											<option disabled selected></option>
											@foreach($link_type_lists as $link_type_list) 
	                                            <option value="{{$link_type_list->link_type_name}}">{{$link_type_list->link_type_name}}</option>
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
								<td>Responsible Field Team</td>
								<td><input type="text" name="responsible_field_team" class="form-control input-transparent"></td>
								<td>Provider</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="provider" required>
											<option disabled selected></option>
											@foreach($client_lists as $client_list) 
	                                            <option value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
							</tr>
							<tr>
								<td>Reason</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="reason" required>
											<option disabled selected></option>
											@foreach($reason_lists as $reason_list) 
	                                            <option value="{{$reason_list->reason_name}}">{{$reason_list->reason_name}}</option>
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
								<td>Issue Type</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="issue_type" required>
											<option disabled selected></option>
											@foreach($issue_type_lists as $issue_type_list) 
	                                            <option value="{{$issue_type_list->issue_type_name}}">{{$issue_type_list->issue_type_name}}</option>
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
								<td>Problem Category</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="problem_category" required>
											<option disabled selected></option>
											@foreach($problem_category_lists as $problem_category_list) 
	                                            <option value="{{$problem_category_list->problem_name}}">{{$problem_category_list->problem_name}}</option>
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
								<td>Problem Source</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="problem_source" required>
											<option disabled selected></option>
											@foreach($problem_source_lists as $problem_source_list) 
	                                            <option value="{{$problem_source_list->problem_source_name}}">{{$problem_source_list->problem_source_name}}</option>
	                                        @problem_source_name
	                                    </select>
	                                </label>
								</td>
								<td>Responsible Vendor</td>
								<td><input type="text" name="responsible_vendor" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Escalation Time</td>
								<td>
									<div id="escalation_time" class="input-group">
	                                    <input id="datepicker2i" type="text" name="escalation_time" class="form-control input-transparent" required>
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
								<td>Responsible Concern</td>
								<td><input type="text" name="responsible_concern" class="form-control input-transparent"></td>
								<td>Event Time</td>
								<td>
									<div id="event_time" class="input-group">
	                                    <input id="datepicker2i" type="text" name="event_time" class="form-control input-transparent" required>
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
								<td>Provider Side Impact</td>
								<td><input type="text" name="provider_side_impact" class="form-control input-transparent"></td>
								<td>Remarks</td>
								<td><input type="text" name="remarks" class="form-control input-transparent"></td>
							</tr>
							<!-- <tr>
								<td></td><td></td><td></td><td><button type="button" class="btn btn-primary" data-placement="top" data-original-title=".btn .btn-primary">Search</button></td><td></td><td></td><td></td>
								<td></td>
							</tr> -->
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
						<th>Tickets</th>
						<th>Add to Incident Cart</th>
					</tr>
					<tr id="10" onclick="show_related_tickets(this.id)">
						<td>10</td>
						<td>Node B flapped</td>
						<td>Node B constantly flapping. Cannot find root cause</td>
						<td>2016-10-11 10:15:23</td>
						<td>1,3</td>
						<td class="addtocart" ><span class="glyphicon glyphicon-shopping-cart" id="10|Node B flapped" onclick="incident_insert(this.id)"></td>
					</tr>
					
					<tr>			
						<td colspan="6" id="related_tickets_10">
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
						<td>8,9</td>
						<td class="addtocart" ><span class="glyphicon glyphicon-shopping-cart" id="12|Node C flapped" onclick="incident_insert(this.id)"></td>
						<!-- <td><a href="#" id="12" onclick="show_related_tickets(this.id)"><span class="glyphicon glyphicon-chevron-down" id="span_12"></span></a></td> -->
					</tr>
					<tr>
						<td colspan="6"  id="related_tickets_12">
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