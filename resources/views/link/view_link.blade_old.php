@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('js/fault.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/incident_style.css')}}">
<script type="text/javascript">
    
    document.getElementById('link-collapse').className = 'panel-collapse collapse in';
    document.getElementById('link_view').className = 'active';

    $(document).ready(function () {
    		$('[name=link_category]').val( '<?php echo $link_category ?>' );
    		$('[name=link_conn_type]').val( '<?php echo $link_conn_type ?>' );
    		$('[name=region]').val( '<?php echo $region ?>' );
    		$('[name=vendor]').val( '<?php echo $vendor ?>' );
    		$('[name=client_owner]').val( '<?php echo $client_owner ?>' );
    		$('[name=service_type_nttn]').val( '<?php echo $service_type_nttn ?>' );
    		$('[name=service_type_gateway]').val( '<?php echo $service_type_gateway ?>' );
    		$('[name=redundancy]').val( '<?php echo $redundancy ?>' );
    		$('[name=service_impact]').val( '<?php echo $service_impact ?>' );
    		$('[name=last_mile_provided_by]').val( '<?php echo $last_mile_provided_by ?>' );
    		$('[name=sub_center_primary]').val( '<?php echo $sub_center_primary ?>' );
    		$('[name=sub_center_secondary]').val( '<?php echo $sub_center_secondary ?>' );
    		$('[name=metro]').val( '<?php echo $metro ?>' );
    		$('[name=lh]').val( '<?php echo $lh ?>' );
    		$('[name=dark_core]').val( '<?php echo $dark_core ?>' );
    		$('[name=mobile_backhaul]').val( '<?php echo $mobile_backhaul ?>' );

	});


</script>
<div class="container-fluid" id="incident_main_div">	
	<h2 class="page-title">View Link <span class="fw-semi-bold"></span></h2>	
		<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="element_create_form" action="{{url('search_link')}}" method="GET">
							<tr>
								<td colspan="10" id="section_header">Link</td>
							</tr>
							<!-- <tr>

								<td>Client</td>
								<td><label style="float:left;">
									<select id="select_style" name="client">
											<option></option>
											@foreach($client_lists as $client_list)

	                                            	<option value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                        @endforeach																	
	                                </select>
	                                </label>
	                            </td>

								<td>Link Name</td>
								<td>
									<input type="text" name="link_name" class="form-control input-transparent">
								</td>
								<td>VLAN ID</td>
								<td><input type="text" name="vlan_id" class="form-control input-transparent"></td>
							</tr>

							<tr>
								<td>Capacity</td>
								<td><input type="text" name="capacity" class="form-control input-transparent"></td>
								<td>Link Conn Type</td>
								<td><input type="text" name="link_conn_type" class="form-control input-transparent"></td>

								<td>Link ID</td>
								<td><input type="text" name="link_id" class="form-control input-transparent"></td>

							</tr>
							<tr>
								<td>Region</td>
								<td><input type="text" name="region" class="form-control input-transparent"></td>
								<td>District</td>
								<td><label style="float:left;">
									<select id="select_style" name="district">
											<option></option>
											@foreach($district_lists as $district_list)

	                                            	<option value="{{$district_list->district_name}}">{{$district_list->district_name}}</option>
	                                        @endforeach																	
	                                </select>
	                                </label>
	                            </td>

								<td>Vendor</td>
								<td><input type="text" name="vendor" class="form-control input-transparent"></td>

							</tr> -->




							<tr>

								<td>Client</td>
								<td><label style="float:left;">
									<select id="select_style" name="client"  >
											<option></option>
											@foreach($client_lists as $client_list)

	                                            	<option value="{{$client_list->client_id}}"

	                                            		@if($client == $client_list->client_id)
	                                            		selected
	                                            		@endif
	                                            		>{{$client_list->client_name}}</option>
	                                        @endforeach																	
	                                </select>
	                                </label>
	                            </td>

								<td>Link ID</td>
								<td>
									<input type="text" name="link_id" class="form-control input-transparent"  value="{{$link_id}}">
								</td>
								<td>VLAN ID</td>
								<td><input type="text" name="vlan_id" class="form-control input-transparent"  value="{{$vlan_id}}"></td>
							</tr>

							<tr>

								<td>Link Category</td>
								<td><!-- <input type="text" name="link_category" class="form-control input-transparent"  value="{{$link_category}}"> -->
									<label style="float:left;">
										<select  name="link_category" id="link_category" value="{{$link_category}}" >
											<option selected ></option>
											<option value="Access">Access</options>
											<option value="Aggregation">Aggregation</options>
											<option value="Backbone">Backbone</options>
											<option value="Capacity">Capacity</options>
											<option value="DWDM">DWDM</options>
											<option value="Handover">Handover</options>
											<option value="Infrastructure">Infrastructure</options>
											<option value="KPI">KPI</options>
											<option value="Leased">Leased</options>
											<option value="LH">LH</options>
											<option value="Messenger +Normal">Messenger +Normal</options>
											<option value="Messenger">Messenger</options>
											<option value="Messenger+ Normal">Messenger+ Normal</options>
											<option value="Messenger+Normal">Messenger+Normal</options>
											<option value="NA">NA</options>
											<option value="Normal">Normal</options>
											<option value="OH">OH</options>
											<option value="Signalling">Signalling</options>
											<option value="Transmission">Transmission</options>
											<option value="Trunk">Trunk</options>
											<option value="TX">TX</options>
											<option value="UG">UG</options>
											<option value="UG+ Messenger">UG+ Messenger</options>
										
										</select>
									</label>
								</td>

								<td>Link Conn Type</td>
								<td><!-- <input type="text" name="link_conn_type" class="form-control input-transparent"  value="{{$link_conn_type}}"> -->
									<label style="float:left;">
									<select  name="link_conn_type"  id="link_conn_type">
										<option value='' selected></option>
										<option value="Access">Access</option>
										<option value="LH">LH</option>
										<option value="N/A">N/A</option>
										<option value="NA">NA</option>
										<option value="OH">OH</option>
										<option value="OH&UG">OH&UG</option>
										<option value="OH/UG">OH/UG</option>
										<option value="OHJ">OHJ</option>
										<option value="OU">OU</option>
										<option value="PGCB">PGCB</option>
										<option value="SCL">SCL</option>
										<option value="TX">TX</option>
										<option value="UG">UG</option>
										<option value="UG+OH">UG+OH</option>
										
									</select>
									</label>
									
								</td>

								<td>District</td>
								<td><label style="float:left;">
									<select id="select_style" name="district" >
											<option></option>
											@foreach($district_lists as $district_list)



	                                            	<option value="{{$district_list->district_name}}" 
	                                            		@if($district == $district_list->district_name)
	                                            		selected
	                                            		@endif

	                                            		>{{$district_list->district_name}}</option>
	                                        @endforeach																	
	                                </select>
	                                </label>
	                            </td>
							</tr>

							<tr>
								<td>Region</td>
								<td><!-- <input type="text" name="region" class="form-control input-transparent" value="{{$region}}"> -->
									<label style="float:left;">
									
									<select  name="region" id="region">
										<option value=''  selected></option>
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
								

								<td>SMS Group</td>
								<td><input type="text" name="sms_group" class="form-control input-transparent" readonly  onclick="getSMSGroups()"</td>

								<td>Vendor</td>
								<td><!-- <input type="text" name="vendor" class="form-control input-transparent" value="{{$vendor}}"> -->
									<label style="float:left;">
								<select id="select_style" name="vendor" id="vendor">
											<option value=''  selected></option>
											@foreach($vendor_lists as $vendor_list)

											<option value="{{$vendor_list->vendor_name}}">{{$vendor_list->vendor_name}}</option>
											@endforeach





																										
										</select>
								</label>
								</td>

							</tr>

							<tr>
								<td>Client Owner</td>
								<td><!-- <input type="text" name="client_owner" class="form-control input-transparent" value="{{$client_owner}}"> -->
									<label style="float:left;">
								<select id="select_style" name="client_owner" id="client_owner">
											<option value=''  selected></option>
											<option value='GP'>GP</option>
											<option value='SCL ICX'>SCL ICX</option>
											<option value='SCL IIG'>SCL IIG</option>
											<option value='SCL ITC'>SCL ITC</option>
											<option value='SCL NTTN'>SCL NTTN</option>
											<option value='SCL'>SCL</option>


																										
										</select>
								</label>
								</td>
								

								<td>Service Type NTTN</td>
								<td><!-- <input type="text" name="service_type_nttn" class="form-control input-transparent"  value="{{$service_type_nttn}}"> -->
									<label style="float:left;">
								<select id="select_style" name="service_type_nttn" id="service_type_nttn">
											<option value=''  selected></option>
											<option value='Access'>Access</option>
											<option value='Active'>Active</option>
											<option value='Capacity'>Capacity</option>
											<option value='IIG'>IIG</option>
											<option value='ISP'>ISP</option>
											<option value='Link'>Link</option>
											<option value='N/A'>N/A</option>
											<option value='NA'>NA</option>
											<option value='No'>No</option>
											<option value='OH'>OH</option>
											<option value='Passive'>Passive</option>
											<option value='UG'>UG</option>


																											
										</select>
								</label>
								</td>

								<td>Service Type Gateway</td>
								<td><!-- <input type="text" name="service_type_gateway" class="form-control input-transparent" value="{{$service_type_gateway}}"> -->
									<label style="float:left;">
								<select id="select_style" name="service_type_gateway"  id="service_type_gateway">
											<option value=''  selected></option>
											<option value='DOMESTIC'>DOMESTIC</option>
											<option value='IIG Backbone'>IIG Backbone</option>
											<option value='INTERNATIONAL'>INTERNATIONAL</option>
											<option value='Internet'>Internet</option>
											<option value='N/A'>N/A</option>
											<option value='NA'>NA</option>
											<option value='No'>No</option>
											<option value='Primary'>Primary</option>
											<option value='Primary(IP Transit)'>Primary(IP Transit)</option>
											<option value='Primary(IPLC)'>Primary(IPLC)</option>
											<option value='Primary(IPLC+IP Transit)'>Primary(IPLC+IP Transit)</option>
											<option value='Secondary'>Secondary</option>
											<option value='Secondary(IP Transit)'>Secondary(IP Transit)</option>
											<option value='Secondary(IPLC)'>Secondary(IPLC)</option>
											<option value='Secondary(IPLC+IP Transit)'>Secondary(IPLC+IP Transit)</option>
											<option value='Upstream Transmission'>Upstream Transmission</option>
											<option value='Youtube'>Youtube</option>

																										
										</select>
								</label>
								</td>

							</tr>

							
							<tr>
								<td>Link Name NTTN</td>
								<td><input type="text" name="link_name_nttn" class="form-control input-transparent" value="{{$link_name_nttn}}"></td>
								

								<td>Link Name Gateway</td>
								<td><input type="text" name="link_name_gateway" class="form-control input-transparent"   value="{{$link_name_gateway}}"></td>

								<td>Redundancy</td>
								<td><!-- <input type="text" name="redundancy" class="form-control input-transparent" value="{{$redundancy}}"> -->
									<label style="float:left;">
								<select id="select_style" name="redundancy" id="redundancy">
											<option value=''  selected></option>
											
											<option value='NA'>NA</option>
											<option value='No'>No</option>
											<option value='Primary'>Primary</option>
											<option value='Secondery'>Secondery</option>
											<option value='Thirdlink'>Thirdlink</option>


																											
										</select>
								</label>
								</td>

							</tr>

							<tr>
								<td>Service Impact</td>
								<td><!-- <input type="text" name="service_impact" class="form-control input-transparent" value="{{$service_impact}}"> -->
									<label style="float:left;">
								<select id="select_style" name="service_impact"  id="service_impact">
											<option value=''  selected></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>
								</td>
								

								<td>Capacity NTTN</td>
								<td><input type="text" name="capacity_nttn" class="form-control input-transparent"  value="{{$capacity_nttn}}"></td>

								<td>Capacity Gateway</td>
								<td><input type="text" name="capacity_gateway" class="form-control input-transparent" value="{{$capacity_gateway}}"></td>

							</tr>

							<tr>
								<td>Last Mile Provided By</td>
								<td><!-- <input type="text" name="last_mile_provided_by" class="form-control input-transparent" value="{{$last_mile_provided_by}}"> -->
									<label style="float:left;">
								<select id="select_style" name="last_mile_provided_by" id="last_mile_provided_by">
											<option value=''  selected></option>
											<option value='BDCOM'>BDCOM</option>
											<option value='Client'>Client</option>
											<option value='GP'>GP</option>
											<option value='NA'>NA</option>
											<option value='PGCB'>PGCB</option>
											<option value='PGCB/SCL'>PGCB/SCL</option>
											<option value='SCL'>SCL</option>
											<option value='SCL/PGCB'>SCL/PGCB</option>

																											
										</select>
								</label>
								</td>
								

								<td>Last Mile Link ID</td>
								<td><input type="text" name="last_mile_link_id" class="form-control input-transparent"  value="{{$last_mile_link_id}}"></td>

								<td>Sub Center Primary</td>
								<td><!-- <input type="text" name="sub_center_primary" class="form-control input-transparent" value="{{$sub_center_primary}}"> -->
									<label style="float:left;">
								<select id="select_style" name="sub_center_primary" id="sub_center_primary" >
											<option value=''  selected></option>
											<option value='Banani'>Banani</option>
											<option value='Barisal'>Barisal</option>
											<option value='Bogra'>Bogra</option>
											<option value='Chittagong'>Chittagong</option>
											<option value='Comilla'>Comilla</option>
											<option value='Dhanmondi'>Dhanmondi</option>
											<option value='Faridpur'>Faridpur</option>
											<option value='Gateway_ICX'>Gateway_ICX</option>
											<option value='Gateway_ITC'>Gateway_ITC</option>
											<option value='Gazipur'>Gazipur</option>
											<option value='Jessore'>Jessore</option>
											<option value='Karwan_Bazar'>Karwan_Bazar</option>
											<option value='Khulna'>Khulna</option>
											<option value='Kushtia'>Kushtia</option>
											<option value='Mymensing'>Mymensing</option>
											<option value='NA'>NA</option>
											<option value='Narayanganj'>Narayanganj</option>
											<option value='Paltan'>Paltan</option>
											<option value='Rajshahi'>Rajshahi</option>
											<option value='Rangpur'>Rangpur</option>
											<option value='Savar'>Savar</option>
											<option value='Shariatpur'>Shariatpur</option>
											<option value='Sylhet'>Sylhet</option>
											<option value='Underground'>Underground</option>
											<option value='Uttara'>Uttara</option>

																										
										</select>
								</label>
								</td>

							</tr>
							<tr>
								<td>Sub Center Secondary</td>
								<td><!-- <input type="text" name="sub_center_secondary" class="form-control input-transparent" value="{{$sub_center_secondary}}"> -->
									<label style="float:left;">
								<select id="select_style" name="sub_center_secondary" id="sub_center_secondary">
											<option value=''  selected></option>
											<option value='Banani'>Banani</option>
											<option value='Banani/ Palton'>Banani/ Palton</option>
											<option value='Bogra'>Bogra</option>
											<option value='Chittagong'>Chittagong</option>
											<option value='Comilla'>Comilla</option>
											<option value='Dhaka'>Dhaka</option>
											<option value='Dhanmondi'>Dhanmondi</option>
											<option value='Dinajpur'>Dinajpur</option>
											<option value='Gaibandha'>Gaibandha</option>
											<option value='Gateway_ICX'>Gateway_ICX</option>
											<option value='Gateway_IIG'>Gateway_IIG</option>
											<option value='Gateway_ITC'>Gateway_ITC</option>
											<option value='Karwan_Bazar'>Karwan_Bazar</option>
											<option value='Kawran Bazar'>Kawran Bazar</option>
											<option value='Kawran BZ'>Kawran BZ</option>
											<option value='Mirpur'>Mirpur</option>
											<option value='Mymensing'>Mymensing</option>
											<option value='NA'>NA</option>
											<option value='Narayanganj'>Narayanganj</option>
											<option value='Nilphamari'>Nilphamari</option>
											<option value='Paltan'>Paltan</option>
											<option value='Palton'>Palton</option>
											<option value='Rangpur'>Rangpur</option>
											<option value='Savar'>Savar</option>
											<option value='Uttara'>Uttara</option>



																										
										</select>
								</label>
								</td>
								

								<td>Metro</td>
								<td><!-- <input type="text" name="metro" class="form-control input-transparent"  value="{{$metro}}"> -->
									<label style="float:left;">
								<select id="select_style" name="metro"  id="metro">
											<option value=''  selected></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>

								</td>

								<td>LH</td>
								<td><!-- <input type="text" name="lh" class="form-control input-transparent" value="{{$lh}}"> -->
									<label style="float:left;">
								<select id="select_style" name="lh" id="lh">
											<option value=''  selected></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>
								</td>

							</tr>

							<tr>
								<td>Dark Core</td>
								<td><!-- <input type="text" name="dark_core" class="form-control input-transparent" value="{{$dark_core}}" > -->
									<label style="float:left;">
								<select id="select_style" name="dark_core" id="dark_core">
											<option value=''></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>

								</td>
								

								<td>Mobile Backhaul</td>
								<td><!-- <input type="text" name="mobile_backhaul" class="form-control input-transparent"  value="{{$mobile_backhaul}}"> -->
									<label style="float:left;">
								<select id="select_style" name="mobile_backhaul" id="mobile_backhaul">
											<option value=''  selected></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>
								</td>

								<td></td>
								<td></td>

							</tr>


							<tr>
								<td colspan="10">
									<input type="submit" class="btn btn-primary" name="formType" value="Search Link">
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
			<div class="pagination"> {!! str_replace('/?', '?', $link_lists->appends(Input::except('page'))->render()) !!} </div>
				<table id="incident_table">
				
					<tr>
						<th>Client</th>
						<th>Link Name NTTN</th>
						<th>Link Name Gateway</th>
						<th>VLAD ID</th>
						<th>Link Conn Type</th>
						<th>Link ID</th>
						<th>Region</th>
						<th>District</th>
						<th>Vendor</th>
						@if($_SESSION['access_type'] == 'SL')
						<th>Action</th>
						@endif

					</tr>
					
					@foreach($link_lists as $link_list)
					<tr>
						<td>@foreach($client_lists as $client_list)
								@if($client_list->client_id==$link_list->client)
									{{$client_list->client_name}}
								@endif
	                        	                    	
	                        @endforeach	</td>

						<td>{{$link_list->link_name_nttn}}</td>
						<td>{{$link_list->link_name_gateway}}</td>
						<td>{{$link_list->vlan_id}}</td>
						<td>{{$link_list->link_conn_type}}</td>
						<td>{{$link_list->link_id}}</td>
						<td>{{$link_list->region}}</td>
						<td>{{$link_list->district}}</td>
						<td>{{$link_list->vendor}}</td>

						@if($_SESSION['access_type'] == 'SL')

						<td><a href="{{ url('edit_link')}}?link_name_id={{$link_list->link_name_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a>&nbsp;&nbsp;
						<a data-toggle="modal" data-target="#myModal{{$link_list->link_name_id}}"><i class="fa fa-times" aria-hidden="true" id="edit_icon"></i>
						</a>
						<div class="modal fade" id="myModal{{$link_list->link_name_id}}" role="dialog">
									    <div class="modal-dialog">
									    
									      <!-- Modal content-->
									      <div class="modal-content">
									        <div class="modal-header">
									          <button type="button" class="close" data-dismiss="modal">&times;</button>
									          <h4 class="modal-title">Delete Link</h4>
									        </div>
									        <div class="modal-body">
									        <form method="POST" action="{{url('delete_link')}}">
									          <b><p>Are you sure you want to delete this Link?</p></b>
									          <br>
									         
									          <input type="submit" class="btn btn-danger form-control" name="submit" value="Delete Link">
									          <input type="hidden" name="link_name_id" value="{{$link_list->link_name_id}}">
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