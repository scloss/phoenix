@include('navigation.p_header')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--   <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('lib/moment/moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script  src="{{asset('js/create_tt.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">

<script type="text/javascript">
var client_arr = <?php echo json_encode($client_arr) ?>;
var client_js_arr = <?php echo json_encode($client_js_arr) ?>;
 $( function() {
    var clientValues = [
      "ROBI",
      "Airtel",
      "GP",
      "Mango",
      "Banglanet"
    ];
    // $( "#client_id" ).autocomplete({
    //   source: clientValues
    // });
    var elementType = [
      "Site",
      "Link"
    ];
    $( "#element_type" ).autocomplete({
      source: elementType
    });
    var elementName = [
      "Dhaka to uttara",
      "Uttara to borak tower",
      "Iqbal tower to notun bazar"
    ];
    $( "#element_name2" ).autocomplete({
      source: elementName
    });
    var reasonList = [
      "Dhaka to uttara",
      "Uttara to borak tower",
      "Iqbal tower to notun bazar"
    ];
    $( "#reason" ).autocomplete({
      source: reasonList
    });
    $( "#provider_name" ).autocomplete({
      source: clientValues
    });
    var problemCategoryList = [
      "High Loss",
      "Link Down",
      "Site Down"
    ];
    $( "#problem_category" ).autocomplete({
      source: problemCategoryList
    });
    var problemSourceList = [
      "High Loss",
      "Link Down",
      "Site Down"
    ];
    $( "#problem_source" ).autocomplete({
      source: problemSourceList
    });
    var issueTypeList = [
      "NTTN",
      "IIG",
      "ICX",
      "ITC"
    ];
    $( "#issue_type" ).autocomplete({
      source: issueTypeList
    });
  } );
</script>
<style type="text/css">
	table{
		/*border:1px solid grey;*/
		width:100%;
		border-collapse:separate; 
		border-spacing: 0px 7px;
	}	
	table td{
		text-align:center;
	}
</style>     
<div id="tt_form_div" class="container-fluid">
	<form action="{{ url('createTicket') }}" id="tt_create_form" method="post" enctype="multipart/form-data">
	<div class="col-md-12" id="static_div">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">

					<div class="col-md-4">
						<table>
							<tr>
								<td>Ticket Title</td>
								<td><input type="text" id="ticket_title" name="ticket_title" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Ticket Status</td>
								<td>
									<label style="float:left;">
										<select id="select_style">
	                                        <option value="active">Active
	                                        <option value="pending_at_scl">Pending at Scl
	                                        <option value="pending_at_client">Pending at Client
	                                        <option value="requested_for_closing">Requested for closing
	                                        <option value="closed">Closed
	                                    </select>
	                                </label>
								</td>
							</tr>
							<tr>
								<td>Attach file</td>
								<td><input type="file" name="ticket_files"></td>
							</tr>
							<tr>
								<td>Incident Title</td>
								<td><input type="text" id="incident_title" name="incident_title" class="form-control input-transparent"></td>
							</tr>
						</table>
					</div>
					<div class="col-md-6">
						<table>
							<tr>
								<td>Comment</td>
								<td>
									<textarea rows="7" class="form-control input-transparent" id="provider_side_impact" name="provider_side_impact">

									</textarea>
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
	<div class="col-md-12" id="dynamic_div">
		<section class="widget" id="default-widget"">
			<header>
				<h5>Fault 1</h5>
				 <div class="widget-controls dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" >
						<i class="fa fa-cog"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li>
                            <a title="Add" href="#" onClick="addFaultDummy()">Add</a>
                        </li>
                        <li>
                            <a title="Copy" href="#" onClick="addFaultDummy()">Copy</a>
                        </li>
                        <li class="divider"></li>
                        <li><a  title="Close" href="#" >Close</a></li>
                    </ul>
				</div>
			</header>
			<div class="body">
				<div class="row">
					<div class="col-md-3">
						<table>
							<tr>
								<td>Client ID</td>
								<td>
									<div class="ui-widget">
										<label style="float:left;">
										    <select name="client_id" id="select_style" class="client_id" required>
	                                            <option disabled selected></option>
	                                            <!-- @foreach($client_lists as $client_list) 
	                                            	<option value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                            @endforeach    -->                                         
	                                        </select>
                                        </label>

									</div>
								</td>
							</tr>
							<tr>
								<td>Element Type</td>
								<td>
									<label style="float:left;">
										<select name="element_type" id="select_style" class="element_type" required>
	                                       <option disabled selected></option>
	                                       <option value="link">Link</option> 
	                                       <option value="site">Site</option>                                          
	                                    </select>
                                    </label>
								</td>
							</tr>
							<tr>
								<td>Element Name</td>
								<td><a id="element_name" href="Javascript:elementScript('element_name')"><textarea name="element_name" id="element_name" class="form-control input-transparent"></textarea></a></td>
							</tr>
							<tr>
								<td>VLAN ID</td>
								<td><input type="text" name="vlan_id" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Link ID</td>
								<td><input type="text" name="link_id" class="form-control input-transparent"></td>
							</tr>	
							<tr>
								<td>Site Ip Address</td>
								<td><input type="text" name="site_ip_address" class="form-control input-transparent"></td>
							</tr>				
							<tr>
								<td>District</td>
								<td><input type="text" name="district" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Region</td>
								<td><input type="text" name="region" class="form-control input-transparent"></td>
							</tr>	
							<tr>
								<td>SMS Group</td>
								<td><textarea name="sms_group" id="sms_group" class="form-control input-transparent"></textarea></td>
							</tr>
						</table>
					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>Problem Source</td>
								<td><input type="text" name="problem_source" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Client Priority</td>
								<td><input type="text" name="client_priority" id="client_priority" class="form-control input-transparent" placeholder="auto selected depending on client id"></td>
							</tr>
							<tr>
								<td>Client Side Impact</td>
								<td>
									<textarea name="client_side_impact" id="client_side_impact" class="form-control input-transparent"></textarea>
								</td>
							</tr>
							<tr>
								<td>Responsible Field Team</td>
								<td><input type="text" name="repsonsible_field_team" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Provider</td>
								<td><input type="text" id="provider_name" name="provider_name" class="form-control input-transparent"></td>
							</tr>
							
						</table>	
					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>Reason</td>
								<td><input type="text" id="reason" name="reason" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Issue Type</td>
								<td><input type="text" id="issue_type" name="issue_type" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Problem Category</td>
								<td><input type="text" id="problem_category" name="problem_category" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Problem Source</td>
								<td><input type="text" id="problem_source" name="problem_source" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Escalation Time</td>
								<td>
									<div id="escalation_time_2" class="input-group">
	                                    <input id="datepicker2i" type="text" class="form-control input-transparent"">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
	                            </td>
							</tr>
							
						</table>
					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>Responsible Concern</td>
								<td><input type="text" id="responsible_concern" name="responsible_concern" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Event Time</td>
								<td>
									<div id="event_time" class="input-group">
	                                    <input id="datepicker2i" type="text" class="form-control input-transparent"">
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div>
	                             </td>
							</tr>
							<tr>
								<td>Provider Side Impact</td>
								<td><textarea rows="4" class="form-control input-transparent" id="provider_side_impact" name="provider_side_impact"></textarea></td>
							</tr>
							
							<tr>
								<td>Remarks</td>
								<td><textarea rows="4" class="form-control input-transparent" id="remarks" name="remarks"></textarea></td>
							</tr>
							
						</table>
					</div>
				</div>
			</div>
		</section>

		<!-- <section class="widget" id="default-widget2"">
			<header>
				<h5>Fault 2</h5>
				 <div class="widget-controls dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" >
						<i class="fa fa-cog"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <a title="Copy" href="#" onClick="addFaultDummy()">Copy</a>
                        </li>
                        <li class="divider"></li>
                        <li><a  title="Close" href="#" onClick="removeFaultDummy()">Close</a></li>
                    </ul>
				</div>
			</header>
			<div class="body">
				<div class="row">
					<div class="col-md-3">
						<table>
							<tr>
								<td>Element Type</td>
								<td><input type="text" id="element_type2" name="element_type2" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Client ID</td>
								<td>
									<div class="ui-widget">
									  <input type="text" id="client_id1" class="form-control input-transparent">
									</div>
								</td>
							</tr>
							<tr>
								<td>Element Name</td>
								<td><input type="text" id="element_name2" name="element_name2" class="form-control input-transparent"></td>
							</tr>					
							<tr>
								<td>Problem Source</td>
								<td><input type="text" name="problem_source" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Client Priority</td>
								<td><input type="text" name="client_priority" class="form-control input-transparent" placeholder="auto selected depending on client id"></td>
							</tr>
						</table>
					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>Client Side Impact</td>
								<td><input type="text" name="client_side_impact" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Responsible Field Team</td>
								<td><input type="text" name="repsonsible_field_team" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Provider</td>
								<td><input type="text" id="provider_name" name="provider_name" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Reason</td>
								<td><input type="text" id="reason" name="reason" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Issue Type</td>
								<td><input type="text" id="issue_type" name="issue_type" class="form-control input-transparent"></td>
							</tr>
						</table>	
					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>Problem Category</td>
								<td><input type="text" id="problem_category" name="problem_category" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Problem Source</td>
								<td><input type="text" id="problem_source" name="problem_source" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Escalation Time</td>
								<td><input type="text" id="escalation_time" name="escalation_time2" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Responsible Concern</td>
								<td><input type="text" id="responsible_concern" name="responsible_concern" class="form-control input-transparent"></td>
							</tr>
							<tr>
								<td>Event Time</td>
								<td><input type="text" name="event_time2" class="form-control input-transparent"></td>
							</tr>
						</table>
					</div>
					<div class="col-md-3">
						<table>
							<tr>
								<td>Provider Side Impact</td>
								<td><textarea rows="4" class="form-control input-transparent" id="provider_side_impact" name="provider_side_impact"></textarea></td>
							</tr>
							
							<tr>
								<td>Remarks</td>
								<td><textarea rows="4" class="form-control input-transparent" id="remarks" name="remarks"></textarea></td>
							</tr>
							
						</table>
					</div>
				</div>
			</div>
		</section> -->
	</div>
	</form>
</div> 
@include('navigation.p_footer')