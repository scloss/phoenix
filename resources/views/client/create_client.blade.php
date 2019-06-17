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
    document.getElementById('client_create').className = 'active';
</script>

<div class="container-fluid" id="incident_main_div">	
	<h2 class="page-title">Create Client <span class="fw-semi-bold"></span></h2>
		<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="client_create" action="{{url('insert_client')}}" method="POST">
							<tr>
								<td colspan="10" id="section_header">Client</td>
							</tr>
							<tr>

								<td>Client Name</td>
								<td><input type="text" name="client_name" class="form-control input-transparent" required></td>
								<td>Client Priority</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="client_priority" required>
											<option value="VVIP">VVIP</option>
											<option value="Category-A">Category-A</option>
											<option value="Category-B">Category-B</option>
											<option value="Category-B">Category-C</option>								
	                                    </select>
	                                </label>
								</td>
								<td>KAM</td>
								<td><input type="text" name="kam" class="form-control input-transparent" required></td>
							</tr>

							<tr>
								<td>Email</td>
								<td><input type="text" name="email" class="form-control input-transparent" required></td>
								<td>Phone</td>
								<td><input type="text" name="phone" class="form-control input-transparent" required></td>

								<td>Client Type</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="client_type" required>
											<option value="ISP">ISP</option>
											<option value="Telco">Telco</option>								
	                                    </select>
	                                </label>
	                              </td>

							</tr>
							<tr>
								<td colspan="10">
									<input type="submit" class="btn btn-primary" name="formType" value="Create Client">
								</td>
							</tr>
							</form>
						</table>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>	
@include('navigation.p_footer')