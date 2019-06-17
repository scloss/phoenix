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
	document.getElementById('link_create').className = 'active';
</script>
<script type="text/javascript">

	function getSMSGroups(){
		window.open('sms_group_view','_blank');
		return false;


	}


</script>
<div class="container-fluid" id="incident_main_div">	
	<h2 class="page-title">Create Link <span class="fw-semi-bold"></span></h2>	
	<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="element_create_form" action="{{url('insert_link')}}" method="POST">
								<tr>
									<td colspan="10" id="section_header">Link</td>

								</tr>

								<tr>

									<td>Client</td>
									<td><label style="float:left;">
										<select id="select_style" name="client" required>
											<option value='' disabled selected></option>
											@foreach($client_lists as $client_list)

											<option value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
											@endforeach																	
										</select>
									</label>
								</td>

								<td>Link ID</td>
								<td>
									<input type="text" name="link_id" class="form-control input-transparent" required>
								</td>
								<td>VLAN ID</td>
								<td><input type="text" name="vlan_id" class="form-control input-transparent" required></td>
							</tr>

							<tr>

								<td>Link Category</td>
								<td>
									<label style="float:left;">
										<select  name="link_category" required>
											<option value='' disabled selected></option>
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
								<!-- <td><input type="text" name="link_category" class="form-control input-transparent" required></td> -->

								<td>Link Conn Type</td>
								<td>
									<label style="float:left;">
									<select  name="link_conn_type" required>
										<option value='' disabled selected></option>
										<option value="Access">Access</option>
										<option value="LH">LH</option>
										<option value="NA">NA</option>
										<option value="OH">OH</option>
										<option value="UG">UG</option>
										<option value="OU">OU</option>
										<option value="PGCB">PGCB</option>
										<option value="SCL">SCL</option>
										<option value="TX">TX</option>
										

										
									</select>
									</label>


								</td>

								<!-- <td><input type="text" name="link_conn_type" class="form-control input-transparent" required></td> -->

								<td>District</td>
								<td>
									<label style="float:left;">
										<select id="select_style" name="district" required>
											<option value='' disabled selected></option>
											@foreach($district_lists as $district_list)

											<option value="{{$district_list->district_name}}">{{$district_list->district_name}}</option>
											@endforeach																	
										</select>
									</label>
							</td>
						</tr>

						<tr>
							<td>Region</td>
							<td>
								<label style="float:left;">
									
									<select  name="region" required>
										<option value='' disabled selected></option>
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
							<!-- <td><input type="text" name="region" class="form-control input-transparent" required></td> -->


							<td>SMS Group</td>
							<td><input type="text" name="sms_group" class="form-control input-transparent" readonly required onclick="getSMSGroups()"></td>

							<td>Vendor</td>
							<td>
								<label style="float:left;">
								<select id="select_style" name="vendor" required>
											<option value='' disabled selected></option>
											@foreach($vendor_lists as $vendor_list)

											<option value="{{$vendor_list->vendor_name}}">{{$vendor_list->vendor_name}}</option>
											@endforeach





																										
										</select>
								</label>
							</td>

								<!-- <input type="text" name="vendor" class="form-control input-transparent" required> -->

						</tr>

						<tr>
							<td>Client Owner</td>
							<td>
								<label style="float:left;">
								<select id="select_style" name="client_owner" required>
											<option value='' disabled selected></option>
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
							<td>
								<label style="float:left;">
								<select id="select_style" name="service_type_nttn" required>
											<option value='' disabled selected></option>
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
							<!-- <td>
								<input type="text" name="service_type_nttn" class="form-control input-transparent" required >
							</td> -->

							<td>Service Type Gateway</td>
							<td>
								<label style="float:left;">
								<select id="select_style" name="service_type_gateway" required>
											<option value='' disabled selected></option>
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
							<!-- <td><input type="text" name="service_type_gateway" class="form-control input-transparent" required></td> -->

						</tr>


						<tr>
							<td>Link Name NTTN</td>
							<td><input type="text" name="link_name_nttn" class="form-control input-transparent" required></td>


							<td>Link Name Gateway</td>
							<td><input type="text" name="link_name_gateway" class="form-control input-transparent"  required ></td>

							<td>Redundancy</td>
							<td>
								<label style="float:left;">
								<select id="select_style" name="redundancy" required>
											<option value='' disabled selected></option>
											<option value='N/A'>N/A</option>
											<option value='NA'>NA</option>
											<option value='No'>No</option>
											<option value='Primary'>Primary</option>
											<option value='Secondery'>Secondery</option>
											<option value='Thirdlink'>Thirdlink</option>


																											
										</select>
								</label>

								</td>
							<!-- <td><input type="text" name="redundancy" class="form-control input-transparent" required></td> -->

						</tr>

						<tr>
							<td>Service Impact</td>
							<td>
								<label style="float:left;">
								<select id="select_style" name="service_impact" required>
											<option value='' disabled selected></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>

								</td>
							<!-- <td><input type="text" name="service_impact" class="form-control input-transparent" required></td> -->


							<td>Capacity NTTN</td>
							<td><input type="text" name="capacity_nttn" class="form-control input-transparent" required ></td>

							<td>Capacity Gateway</td>
							<td><input type="text" name="capacity_gateway" class="form-control input-transparent" required></td>

						</tr>

						<tr>
							<td>Last Mile Provided By</td>
							<td>
								<label style="float:left;">
								<select id="select_style" name="last_mile_provided_by" required>
											<option value='' disabled selected></option>
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
							<!-- <td><input type="text" name="last_mile_provided_by" class="form-control input-transparent" required></td> -->


							<td>Last Mile Link ID</td>
							<td><input type="text" name="last_mile_link_id" class="form-control input-transparent" required ></td>

							<td>Sub Center Primary</td>
							<td>
								<label style="float:left;">
								<select id="select_style" name="sub_center_primary" required>
											<option value='' disabled selected></option>
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
											<option value='Mirpur'>Mirpur</option>

																										
										</select>
								</label>

								</td>
							<!-- <td><input type="text" name="sub_center_primary" class="form-control input-transparent" required></td> -->

						</tr>

						<tr>
							<td>Sub Center Secondary</td>
							<td>
								<label style="float:left;">
								<select id="select_style" name="sub_center_secondary" required>
											<option value='' disabled selected></option>
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
											<option value='Mirpur'>Mirpur</option>


																										
										</select>
								</label>

								</td>
							<!-- <td><input type="text" name="sub_center_secondary" class="form-control input-transparent" required></td> -->


							<td>Metro</td>
							<td>
								<label style="float:left;">
								<select id="select_style" name="metro" required>
											<option value='' disabled selected></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>

								</td>
							<!-- <td><input type="text" name="metro" class="form-control input-transparent" required ></td> -->

							<td>LH</td>
							<td>
								<label style="float:left;">
								<select id="select_style" name="lh" required>
											<option value='' disabled selected></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>

								</td>
							<!-- <td><input type="text" name="lh" class="form-control input-transparent" required></td> -->

						</tr>

						<tr>
							<td>Dark Core</td>
							<td>
								<label style="float:left;">
								<select id="select_style" name="dark_core" required>
											<option value=''></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>

								</td>

<!-- 							<td><input type="text" name="dark_core" class="form-control input-transparent" required></td> -->


							<td>Mobile Backhaul</td>
							<td>
								<label style="float:left;">
								<select id="select_style" name="mobile_backhaul" required>
											<option value='' disabled selected></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>

								</td>
							<!-- <td><input type="text" name="mobile_backhaul" class="form-control input-transparent" required ></td> -->

							<td></td>
							<td></td>

						</tr>

						<tr>
							<td colspan="10">
								<input type="submit" class="btn btn-primary" name="formType" value="Create Link">
							</td>
						</tr>



							<!-- <tr>

								<td>Client</td>
								<td><label style="float:left;">
									<select id="select_style" name="client" required>
											<option></option>
											@foreach($client_lists as $client_list)

	                                            	<option value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                        @endforeach																	
	                                </select>
	                                </label>
	                            </td>

								<td>Link Name</td>
								<td>
									<input type="text" name="link_name" class="form-control input-transparent" required>
								</td>
								<td>VLAN ID</td>
								<td><input type="text" name="vlan_id" class="form-control input-transparent" required></td>
							</tr> -->

							<!-- <tr>
								<td>Capacity</td>
								<td><input type="text" name="capacity" class="form-control input-transparent" required></td>
								

								<td>Link ID</td>
								<td><input type="text" name="link_id" class="form-control input-transparent" required></td>

							</tr> -->
							<!-- 	
							<tr>
								

							-->
						</form>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>
</div>	
@include('navigation.p_footer')