@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('js/fault.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/incident_style.css')}}">
<script type="text/javascript">
    
    document.getElementById('client-collapse').className = 'panel-collapse collapse in';
    document.getElementById('client_view').className = 'active';
</script>
<div class="container-fluid" id="incident_main_div">	
	<h2 class="page-title">View Client <span class="fw-semi-bold"></span></h2>
		<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="client_create" action="{{url('search_client')}}" method="GET">
							<tr>
								<td colspan="10" id="section_header">Client</td>
							</tr>
							<tr>

								<td>Client Name</td>
								<td><input type="text" name="client_name" class="form-control input-transparent"></td>
								<td>Client Priority</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="client_priority">
											<option></option>
											<option value="VVIP">VVIP</option>
											<option value="Category-A">Category-A</option>
											<option value="Category-B">Category-B</option>
											<option value="Category-C">Category-C</option>								
	                                    </select>
	                                </label>
								</td>
								<td>KAM</td>
								<td><input type="text" name="kam" class="form-control input-transparent"></td>
							</tr>

							<tr>
								<td>Email</td>
								<td><input type="text" name="email" class="form-control input-transparent"></td>
								<td>Phone</td>
								<td><input type="text" name="phone" class="form-control input-transparent"></td>

								<td>Client Type</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="client_type">
											<option></option>
											<option value="ISP">ISP</option>
											<option value="Telco">Telco</option>								
	                                    </select>
	                                </label>
	                              </td>

							</tr>
							<tr>
								<td colspan="10">
									<input type="submit" class="btn btn-primary" name="formType" value="Search Client">
								</td>
							</tr>
							</form>
						</table>
					</div>
				</div>
			</div>
		</section>
	</div>

	<div id="incident_div">
			<div class="pagination"> {!! str_replace('/?', '?', $client_lists->appends(Input::except('page'))->render()) !!} </div>
				<table id="incident_table">
				
					<tr>
						<th>Client Name</th>
						<th>Priority</th>
						<th>KAM Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Client Type</th>
						<th>Action</th>

					</tr>
					
					@foreach($client_lists as $client_list)
					<tr>
						<td>{{$client_list->client_name}}</td>
						<td>{{$client_list->priority}}</td>
						<td>{{$client_list->kam_name}}</td>
						<td>{{$client_list->email}}</td>
									
						<td>{{$client_list->phone}}</td>
						<td>{{$client_list->client_type}}</td>

						<td><a href="{{ url('edit_client')}}?client_id={{$client_list->client_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a>&nbsp;&nbsp;<!-- <a data-toggle="modal" data-target="#myModal{{$client_list->client_id}}"><i class="fa fa-times" aria-hidden="true" id="edit_icon"></i>
						</a> -->
						<div class="modal fade" id="myModal{{$client_list->client_id}}" role="dialog">
									    <div class="modal-dialog">
									    
									      <!-- Modal content-->
									      <div class="modal-content">
									        <div class="modal-header">
									          <button type="button" class="close" data-dismiss="modal">&times;</button>
									          <h4 class="modal-title">Delete Client</h4>
									        </div>
									        <div class="modal-body">
									        <form method="POST" action="{{url('delete_client')}}">
									          <b><p>Are you sure you want to delete this Client?</p></b>
									          <br>
									         
									          <input type="submit" class="btn btn-danger form-control" name="submit" value="Delete Client">
									          <input type="hidden" name="client_id" value="{{$client_list->client_id}}">
									         </form> 
									        </div>
									        <div class="modal-footer">
									          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									        </div>
									      </div>
									      
									    </div>
  							</div>
						</td>

					</tr>
					@endforeach
				
				</table>
			</div>
</div>	
@include('navigation.p_footer')