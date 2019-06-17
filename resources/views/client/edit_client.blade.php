@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('js/fault.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/incident_style.css')}}">

<div class="container-fluid" id="incident_main_div">	
	<h2 class="page-title">Edit Client <span class="fw-semi-bold"></span></h2>
		<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="client_create" action="{{url('update_client')}}" method="POST">
							@foreach($client_lists as $client_list)
							<tr>
								<td colspan="10" id="section_header">Client</td>
							</tr>
							<tr>

								<td>Client Name</td>
								<td><input type="text" name="client_name" class="form-control input-transparent" value="{{$client_list->client_name}}" required></td>
								<td>Client Priority</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="client_priority" required>
											@if($client_list->priority=="VVIP")
											<option selected value="VVIP">VVIP</option>
											@else
											<option value="VVIP">VVIP</option>
											@endif
											@if($client_list->priority=="Category-A")
											<option selected value="Category-A">Category-A</option>
											@else
											<option value="Category-A">Category-A</option>
											@endif
											@if($client_list->priority=="Category-B")
											<option selected value="Category-B">Category-B</option>
											@else
											<option value="Category-B">Category-B</option>
											@endif
											@if($client_list->priority=="Category-C")
											<option selected value="Category-C">Category-C</option>
											@else
											<option value="Category-C">Category-C</option>
											@endif
							
	                                    </select>
	                                </label>
								</td>
								<td>KAM</td>
								<td><input type="text" name="kam" class="form-control input-transparent" value="{{$client_list->kam_name}}" required></td>
							</tr>

							<tr>
								<td>Email</td>
								<td><input type="text" name="email" class="form-control input-transparent" value="{{$client_list->email}}" required></td>
								<td>Phone</td>
								<td><input type="text" name="phone" class="form-control input-transparent" value="{{$client_list->phone}}" required></td>

								<td>Client Type</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="client_type" required>
											@if($client_list->client_type=="ISP")
											<option selected value="ISP">ISP</option>
											@else
											<option value="ISP">ISP</option>
											@endif
											@if($client_list->client_type=="Telco")
											<option selected value="Telco">Telco</option>
											@else
											<option value="Telco">Telco</option>
											@endif											
																		
	                                    </select>
	                                </label>
	                              </td>

							</tr>
							<tr>
								<td colspan="10">
									<input type="hidden" name="client_id" value="{{$client_list->client_id}}">
									<input type="submit" class="btn btn-primary" name="formType" value="Update Client">
								</td>
							</tr>
							@endforeach
							</form>
						</table>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>	
@include('navigation.p_footer')