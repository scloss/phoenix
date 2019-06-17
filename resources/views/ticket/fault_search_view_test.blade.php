@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('js/fault.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/incident_style.css')}}">


<div id="incident_div">
				<div class="pagination"> {!! str_replace('/?', '?', $fault_lists2->appends(Input::except('page'))->render()) !!} </div>
				<table id="incident_table">
				
					<tr>
						<th>Fault ID</th>
						<th>Problem Category</th>
						<th>Element Type</th>
						<!-- <th>Link Name</th>
						
						<th>Link ID</th> -->
						<th>Client</th>
						<th>Impact</th>
						<th>Event Time</th>
						<th>Status</th>
						<th>Escalation</th>
						<th>Responsible Concern</th>
						<th>Field Team</th>
						<th>View Details</th>
					</tr>
					
					@foreach($fault_lists2 as $fault_list2)
					<tr>
						<td>{{$fault_list2->fault_id}}</td>
						<td>{{$fault_list2->problem_category}}</td>
						<td>{{$fault_list2->element_type}}</td>
									
						<td>{{$fault_list2->client_name}}</td>
						<td>{{$fault_list2->client_side_impact}}</td>
						<td>{{$fault_list2->event_time}}</td>
						<td>{{$fault_list2->fault_status}}</td>
						<td>{{$fault_list2->escalation_time}}</td>
						<td>{{$fault_list2->responsible_concern}}</td>
						<td>{{$fault_list2->responsible_field_team}}</td>
						<td><a href="{{ url('EditTT')}}?ticket_id={{$fault_list2->ticket_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a></td>

					</tr>
					@endforeach
				
				</table>
			</div>

@include('navigation.p_footer')