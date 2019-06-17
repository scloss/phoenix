@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('js/fault.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/incident_style.css')}}">
<script type="text/javascript">
    
    document.getElementById('site-collapse').className = 'panel-collapse collapse in';
    document.getElementById('site_view').className = 'active';

    $(document).ready(function () {
    		$('[name=site_type]').val( '<?php echo $site_type ?>' );
    		$('[name=region]').val( '<?php echo $region ?>' );
    		$('[name=vendor]').val( '<?php echo $vendor ?>' );
    		$('[name=device_type]').val( '<?php echo $device_type ?>' );
    		$('[name=device_vendor]').val( '<?php echo $device_vendor ?>' );
    		$('[name=device_model]').val( '<?php echo $device_model ?>' );
    		$('[name=upazilla]').val( '<?php echo $upazilla ?>' );
    		$('[name=sub_center]').val( '<?php echo $sub_center ?>' );
	});


</script>
<div class="container-fluid" id="incident_main_div">	
	<h2 class="page-title">View Site <span class="fw-semi-bold"></span></h2>
		<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="element_create_form" action="{{url('search_site')}}" method="GET">
							<tr>
								<td colspan="10" id="section_header">Site</td>
							</tr>
							<tr>


								<td>Client</td>
								<td><label style="float:left;">
									<select id="select_style" name="client">
											<option></option>
											@foreach($client_lists as $client_list)

	                                            	<option value="{{$client_list->client_id}}"
	                                            		@if($client_list->client_id == $client)
	                                            			selected
	                                            		@endif


	                                            		>{{$client_list->client_name}}</option>
	                                        @endforeach																	
	                                </select>
	                                </label>
	                            </td>

								<td>Site Name</td>
								<td>
									<input type="text" name="site_name" class="form-control input-transparent" value="{{$site_name}}">
								</td>
								<td>MW Site Name</td>
								<td><input type="text" name="mw_site_name" class="form-control input-transparent" value="{{$mw_site_name}}"></td>
							</tr>

							<tr>
								<td>Site IP Address</td>
								<td><input type="text" name="site_ip_address" class="form-control input-transparent" value="{{$site_ip_address}}"></td>
								<td>Site Type</td>
								<td><!-- <input type="text" name="site_type" class="form-control input-transparent" value="{{$site_type}}"> -->
									
									<label style="float:left;">
									<select name="site_type">
										<option value=''></option>
										<option value='Access'>Access</option>
										<option value='Aggregation'>Aggregation</option>
										<option value='Core'>Core</option>
										<option value='Handover'>Handover</option>
										<option value='NA'>NA</option>
										<option value='POP'>POP</option>
										<option value='Preaggregation'>Preaggregation</option>

									  
									</select>
								</label>
								</td>
								<td>Region</td>
								<td><!-- <input type="text" name="region" class="form-control input-transparent" value="{{$region}}"> -->
									<label style="float:left;">
									<select name="region">
										<option value=''></option>
										<option value="Gateway Operations">Gateway Operations</option>
										<option value="O&M-1">O&M-1</option>
										<option value="O&M-1, O&M-2">O&M-1, O&M-2</option>
										<option value="O&M-1, O&M-2, O&M-3">O&M-1, O&M-2, O&M-3</option>
										<option value="O&M-2">O&M-2</option>
										<option value="O&M-2, O&M-3">O&M-2, O&M-3</option>
										<option value="O&M-3">O&M-3</option>
										<option value="O&M-3, O&M-1">O&M-3, O&M-1</option>

									</select>
								</label>
								</td>

							</tr>
							<tr>

								<td>District</td>
								<td><label style="float:left;">
									<select id="select_style" name="district">
											<option></option>
											@foreach($district_lists as $district_list)

	                                            	<option value="{{$district_list->district_name}}" 
	                                            		@if($district_list->district_name == $district)
	                                            			selected
	                                            		@endif


	                                            		>{{$district_list->district_name}}</option>
	                                        @endforeach																	
	                                </select>
	                                </label>
	                            </td>
								<td>Vendor</td>
								<td><!-- <input type="text" name="vendor" class="form-control input-transparent" value="{{$vendor}}"> -->
									<label style="float:left;">
									<select id="select_style" name="vendor">
											<option value=''></option>
											@foreach($vendor_lists as $vendor_list)

	                                            	<option value="{{$vendor_list->vendor_name}}">{{$vendor_list->vendor_name}}</option>
	                                        @endforeach																	
	                                </select>
	                            </label>
								</td>

								<td>Site Node Address</td>
								<td><input type="text" name="site_node_address" class="form-control input-transparent" value="{{$site_node_address}}"></td>
							</tr>


							<tr>
								<td>Device Type</td>
								<td><!-- <input type="text" name="device_type" class="form-control input-transparent" value="{{$device_type}}"> -->
									<label style="float:left;">
									<select id="select_style" name="device_type">
									<option value=''></option>
									<option value='CDR Server'>CDR Server</option>
									<option value='DWDM MUX'>DWDM MUX</option>
									<option value='EMS Server'>EMS Server</option>
									<option value='Media Gateway Server'>Media Gateway Server</option>
									<option value='MUX'>MUX</option>
									<option value='NTP Server'>NTP Server</option>
									<option value='Router'>Router</option>
									<option value='SDH MUX'>SDH MUX</option>
									<option value='Soft Switch Server'>Soft Switch Server</option>
									<option value='Switch'>Switch</option>
									</select>
								</label>
								</td>
								<td>Device Vendor</td>
								<td><!-- <input type="text" name="device_vendor" class="form-control input-transparent" value="{{$device_vendor}}"> -->
									<label style="float:left;">
									<select id="select_style" name="device_vendor">
									<option value='' ></option>
									<option value='BDCOM'>BDCOM</option>
									<option value='Cisco'>Cisco</option>
									<option value='Cisco'>Cisco</option>
									<option value='D-Link'>D-Link</option>
									<option value='DELL'>DELL</option>
									<option value='Edge Core'>Edge Core</option>
									<option value='Huawei'>Huawei</option>
									<option value='Juniper'>Juniper</option>
									<option value='Microtik'>Microtik</option>
									<option value='Nexus'>Nexus</option>
									<option value='Tejas'>Tejas</option>
									<option value='ZTE'>ZTE</option>
									</select>
								</label>
								</td>
								<td>Device Model</td>
								<td><!-- <input type="text" name="device_model" class="form-control input-transparent" value="{{$device_model}}"> -->
									<label style="float:left;">
									<select id="select_style" name="device_model">
									<option value=''></option>
									<option value='?TJ100ME'>?TJ100ME</option>
									<option value='ACX 1100'>ACX 1100</option>
									<option value='ACX 2100'>ACX 2100</option>
									<option value='ACX 2200'>ACX 2200</option>
									<option value='ACX1000'>ACX1000</option>
									<option value='DGS-3120-24SC'>DGS-3120-24SC</option>
									<option value='ECS4620-28F-DC'>ECS4620-28F-DC</option>
									<option value='ES3528M-SFP'>ES3528M-SFP</option>
									<option value='MX 104'>MX 104</option>
									<option value='MX480'>MX480</option>
									<option value='MX80-p'>MX80-p</option>
									<option value='NA'>NA</option>
									<option value='OptiX OSN 1800 V'>OptiX OSN 1800 V</option>
									<option value='OptiX OSN 8800 T16'>OptiX OSN 8800 T16</option>
									<option value='OptiX OSN 8800'>OptiX OSN 8800</option>
									<option value='S3328TP-EI'>S3328TP-EI</option>
									<option value='SG300-28'>SG300-28</option>
									<option value='TJ100ME'>TJ100ME</option>
									<option value='TJ100ME'>TJ100ME</option>
									<option value='TJ1100'>TJ1100</option>
									<option value='TJ1100'>TJ1100</option>
									<option value='TJ1270'>TJ1270</option>
									<option value='TJ1400'>TJ1400</option>
									<option value='TJ1600'>TJ1600</option>
									<option value='ZX8000'>ZX8000</option>

								</select>
								</label>
								</td>

							</tr>

							<tr>
								<td>Upazilla</td>
								<td><!-- <input type="text" name="upazilla" class="form-control input-transparent" value="{{$upazilla}}"> -->
									<label style="float:left;">
									<select id="select_style" name="upazilla">
									<option value=''></option>
									<option value='Belabo'>Belabo</option>
									<option value='Dhamrai'>Dhamrai</option>
									<option value='DNCC'>DNCC</option>
									<option value='Dohar'>Dohar</option>
									<option value='DSCC'>DSCC</option>
									<option value='Gazipur sadar'>Gazipur sadar</option>
									<option value='Ghatail'>Ghatail</option>
									<option value='Kalihati'>Kalihati</option>
									<option value='Kuliarchar'>Kuliarchar</option>
									<option value='Manikganj Sadar'>Manikganj Sadar</option>
									<option value='Mirzapur'>Mirzapur</option>
									<option value='Modhupur'>Modhupur</option>
									<option value='Monohordi'>Monohordi</option>
									<option value='Mymensingh Sadar'>Mymensingh Sadar</option>
									<option value='Nawabganj'>Nawabganj</option>
									<option value='Sadar'>Sadar</option>
									<option value='Savar'>Savar</option>
									<option value='Shirajdikhan'>Shirajdikhan</option>
									<option value='Siddirgonj'>Siddirgonj</option>
									<option value='Sonargaon'>Sonargaon</option>
									<option value='Sreenagar'>Sreenagar</option>
									<option value='Sreepur'>Sreepur</option>
									<option value='Trishal'>Trishal</option>
									<option value='Valuka'>Valuka</option>
									<option value='Wazirpur'>Wazirpur</option>
									</select>
								</label>
								</td>
								<td>Sub Center</td>
								<td><!-- <input type="text" name="sub_center" class="form-control input-transparent" value="{{$sub_center}}"> -->
									<label style="float:left;">
									<select id="select_style" name="sub_center">
									<option value=''></option>
									<option value='Banani'>Banani</option>
									<option value='Barisal'>Barisal</option>
									<option value='Bogra'>Bogra</option>
									<option value='Chittagong'>Chittagong</option>
									<option value='Comilla'>Comilla</option>
									<option value='CoxsBazar'>CoxsBazar</option>
									<option value='Dhanmondi'>Dhanmondi</option>
									<option value='Faridpur'>Faridpur</option>
									<option value='Gateway Operations'>Gateway Operations</option>
									<option value='Gazipur'>Gazipur</option>
									<option value='Jessore'>Jessore</option>
									<option value='Kawran Bazar'>Kawran Bazar</option>
									<option value='Khulna'>Khulna</option>
									<option value='Kushtia'>Kushtia</option>
									<option value='Mirpur'>Mirpur</option>
									<option value='Mymensingh'>Mymensingh</option>
									<option value='Narayanganj'>Narayanganj</option>
									<option value='Paltan'>Paltan</option>
									<option value='Rajshahi'>Rajshahi</option>
									<option value='Rangpur'>Rangpur</option>
									<option value='Savar'>Savar</option>
									<option value='Shariatpur'>Shariatpur</option>
									<option value='Sylhet'>Sylhet</option>
									<option value='Tangail'>Tangail</option>
									<option value='Uttara'>Uttara</option>
								</select>
								</td>
							</tr>

							<tr>

								<td colspan="10">
									<input type="submit" class="btn btn-primary" name="formType" value="Search Site">
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
			<div class="pagination"> {!! str_replace('/?', '?', $site_lists->appends(Input::except('page'))->render()) !!} </div>
				<table id="incident_table">
				
					<tr>
						<th>Client</th>
						<th>Site Name</th>

						<th>MW Site Name</th>
						<th>Site IP Address</th>
						<th>Site Type</th>
						<th>Region</th>
						<th>District</th>
						<th>Vendor</th>
						@if($_SESSION['access_type'] == 'SL')
						<th>Action</th>
						@endif

					</tr>
					
					@foreach($site_lists as $site_list)
					<tr>
						<td>@foreach($client_lists as $client_list)
								@if($client_list->client_id==$site_list->client)
									{{$client_list->client_name}}
								@endif
	                        	                    	
	                        @endforeach	</td>
						<td>{{$site_list->site_name}}</td>
						<td>{{$site_list->mw_site_name}}</td>
						<td>{{$site_list->site_ip_address}}</td>
						<td>{{$site_list->site_type}}</td>
									
						
						<td>{{$site_list->region}}</td>
						<td>{{$site_list->district}}</td>
						<td>{{$site_list->vendor}}</td>
						@if($_SESSION['access_type'] == 'SL')
						<td><a href="{{ url('edit_site')}}?site_name_id={{$site_list->site_name_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a>&nbsp;&nbsp;<a data-toggle="modal" data-target="#myModal{{$site_list->site_name_id}}"><i class="fa fa-times" aria-hidden="true" id="edit_icon"></i>
						</a>
						<div class="modal fade" id="myModal{{$site_list->site_name_id}}" role="dialog">
									    <div class="modal-dialog">
									    
									      <!-- Modal content-->
									      <div class="modal-content">
									        <div class="modal-header">
									          <button type="button" class="close" data-dismiss="modal">&times;</button>
									          <h4 class="modal-title">Delete Site</h4>
									        </div>
									        <div class="modal-body">
									        <form method="POST" action="{{url('delete_site')}}">
									          <b><p>Are you sure you want to delete this Site?</p></b>
									          <br>
									         
									          <input type="submit" class="btn btn-danger form-control" name="submit" value="Delete Site">
									          <input type="hidden" name="site_name_id" value="{{$site_list->site_name_id}}">
									         </form> 
									        </div>
									        <div class="modal-footer">
									          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									        </div>
									      </div>
									      
									    </div>
  							</div>
						</td>
						@endif

					</tr>
					@endforeach
				
				</table>
			</div>	
</div>		
@include('navigation.p_footer')