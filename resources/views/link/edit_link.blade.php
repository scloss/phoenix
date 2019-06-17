@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('js/fault.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/incident_style.css')}}">

<script type="text/javascript">

	function getSMSGroups(){
		window.open('sms_group_view','_blank');
  		return false;

    
	}

	function getTelegramGroups(){
		window.open('telegram_group_view','_blank');
		return false;
	}

	$(document).ready(function () {
    		$('[name=link_category]').val( '<?php echo $link_lists[0]->link_category ?>' );
    		$('[name=link_conn_type]').val( '<?php echo $link_lists[0]->link_conn_type ?>' );
    		$('[name=region]').val( '<?php echo $link_lists[0]->region ?>' );
    		$('[name=vendor]').val( '<?php echo $link_lists[0]->vendor ?>' );
    		$('[name=client_owner]').val( '<?php echo $link_lists[0]->client_owner ?>' );
    		$('[name=service_type_nttn]').val( '<?php echo $link_lists[0]->service_type_nttn ?>' );
    		$('[name=service_type_gateway]').val( '<?php echo $link_lists[0]->service_type_gateway ?>' );
    		$('[name=redundancy]').val( '<?php echo $link_lists[0]->redundancy ?>' );
    		$('[name=service_impact]').val( '<?php echo $link_lists[0]->service_impact ?>' );
    		$('[name=service_type_nttn]').val( '<?php echo $link_lists[0]->service_type_nttn ?>' );
    		$('[name=last_mile_provided_by]').val( '<?php echo $link_lists[0]->last_mile_provided_by ?>' );
    		$('[name=sub_center_primary]').val( '<?php echo $link_lists[0]->sub_center_primary ?>' );
    		$('[name=sub_center_secondary]').val( '<?php echo $link_lists[0]->sub_center_secondary ?>' );
    		$('[name=metro]').val( '<?php echo $link_lists[0]->metro ?>' );
    		$('[name=lh]').val( '<?php echo $link_lists[0]->LH ?>' );
    		$('[name=dark_core]').val( '<?php echo $link_lists[0]->dark_core ?>' );
			$('[name=mobile_backhaul]').val( '<?php echo $link_lists[0]->mobile_backhaul ?>' );
			$('[name=uni_nni]').val( '<?php echo $link_lists[0]->uni_nni ?>' );

	});


</script>
<div class="container-fluid" id="incident_main_div">
<h2 class="page-title">Edit Link <span class="fw-semi-bold"></span></h2>		
		<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="element_create_form" action="{{url('update_link')}}" method="POST">
							@foreach($link_lists as $link_list)
							<tr>
								<td colspan="10" id="section_header">Link</td>
							</tr>

							<datalist id="na_list">
									<option value="NA">  
							</datalist>

							<tr>

								<td>Client</td>
								<td><label style="float:left;">
									<select id="select_style" name="client" required >
										<option value='' disabled selected></option>
											@foreach($client_lists as $client_list)
												@if($client_list->client_id==$link_list->client)
	                                            	<option selected value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                            @else
	                                            	<option value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                            @endif		
	                                        @endforeach																		
	                                </select>
	                                </label>
	                            </td>

								<td>Link ID</td>
								<td>
									<input type="text" name="link_id" class="form-control input-transparent" required value="{{$link_list->link_id}}" list="na_list">
								</td>
								<td>VLAN ID</td>
								<td><input type="text" name="vlan_id" class="form-control input-transparent" required value="{{$link_list->vlan_id}}" list="na_list"></td>
							</tr>

							<tr>

								<td>Link Category</td>
								<td><!-- <input type="text" name="link_category" class="form-control input-transparent" required value="{{$link_list->link_category}}"> -->
									<label style="float:left;">
										<select  name="link_category" required>
											<option value='' disabled selected></option>
											<option value="Backbone">Backbone</options>
											<option value="Transmission">Transmission</options>
											<option value="Signalling">Signalling</options>
											<option value="KPI">KPI</options>
											<option value="Infrastructure">Infrastructure</options>
											<option value="Leased">Leased</options>
											<option value="Access">Access</options>
											<option value="Trunk">Trunk</options>
											<option value="Capacity">Capacity</options>
											<option value="Aggregation">Aggregation</options>
											<option value="Messenger +Normal">Messenger +Normal</options>
											<option value="Normal">Normal</options>
											<option value="DWDM">DWDM</options>
											<option value="Handover">Handover</options>
											<option value="Dark Core">Dark Core</options>
										
										</select>
									</label>
								</td>

								<td>Link Conn Type</td>
								<td><!-- <input type="text" name="link_conn_type" class="form-control input-transparent" required value="{{$link_list->link_conn_type}}"> -->
									<label style="float:left;">
									<select  name="link_conn_type" required>
										<option value="Access">Access</option>
										<option value="LH">LH</option>
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
										<option value='' disabled selected></option>
										
									</select>
									</label>
								</td>

								<td>District</td>
								<td><label style="float:left;">
									<select id="select_style" name="district" required>
											<option></option>
											@foreach($district_lists as $district_list)
												@if($district_list->district_name==$link_list->district)
	                                            	<option selected value="{{$district_list->district_name}}">{{$district_list->district_name}}</option>
	                                            @else
	                                            	<option value="{{$district_list->district_name}}">{{$district_list->district_name}}</option>
	                                            @endif	
	                                        @endforeach																		
	                                </select>
	                                </label>
	                            </td>
							</tr>

							<tr>
								<td>Region</td>
								<td><!-- <input type="text" name="region" class="form-control input-transparent" required value="{{$link_list->region}}" > -->
									<label style="float:left;">
									
									<select  name="region" required style="width: 200px">
										<option value='' disabled selected></option>
										<option value="Gateway Operations">Gateway Operations</option>
										<option value="Regional Implementation & Operations 1">Regional Implementation & Operations 1</option>
										<option value="Regional Implementation & Operations 1, Regional Implementation & Operations 2">Regional Implementation & Operations 1, Regional Implementation & Operations 2</option>
										<option value="Regional Implementation & Operations 1, Regional Implementation & Operations 2, Regional Implementation & Operations 3">Regional Implementation & Operations 1, Regional Implementation & Operations 2, Regional Implementation & Operations 3</option>
										<option value="Regional Implementation & Operations 2">Regional Implementation & Operations 2</option>
										<option value="Regional Implementation & Operations 2, Regional Implementation & Operations 3">Regional Implementation & Operations 2, Regional Implementation & Operations 3</option>
										<option value="Regional Implementation & Operations 3">Regional Implementation & Operations 3</option>
										<option value="Regional Implementation & Operations 3, Regional Implementation & Operations 1">Regional Implementation & Operations 3, Regional Implementation & Operations 1</option>
										<option value="Regional Implementation & Operations 4">Regional Implementation & Operations 4</option>
										<option value="Regional Implementation & Operations 1, Regional Implementation & Operations 4">Regional Implementation & Operations 1, Regional Implementation & Operations 4</option>
										<option value="Regional Implementation & Operations 2, Regional Implementation & Operations 4">Regional Implementation & Operations 2, Regional Implementation & Operations 4</option>
										<option value="Regional Implementation & Operations 3, Regional Implementation & Operations 4">Regional Implementation & Operations 3, Regional Implementation & Operations 4</option>
										
										
									</select>
									</label>
									
								</td>
								

								<td>SMS Group</td>
								<td><input type="text" name="sms_group" class="form-control input-transparent" readonly required onclick="getSMSGroups()" value="{{$link_list->sms_group}}"></td>

								<td>Vendor</td>
								<td><!-- <input type="text" name="vendor" class="form-control input-transparent" required value="{{$link_list->vendor}}"> -->
									<label style="float:left;">
								<select id="select_style" name="vendor" required>
											<option value='' disabled selected></option>
											@foreach($vendor_lists as $vendor_list)

											<option value="{{$vendor_list->vendor_name}}">{{$vendor_list->vendor_name}}</option>
											@endforeach





																										
										</select>
								</label>
									

								</td>

							</tr>

							<tr>
								<td>Client Owner</td>
								<td><!-- <input type="text" name="client_owner" class="form-control input-transparent" required value="{{$link_list->client_owner}}"> -->
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
								<td><!-- <input type="text" name="service_type_nttn" class="form-control input-transparent" required value="{{$link_list->service_type_nttn}}" > -->
									<label style="float:left;">
								<select id="select_style" name="service_type_nttn" required>
											<option value='' disabled selected></option>
											<option value='Access'>Access</option>
											<option value='Active'>Active</option>
											<option value='Capacity'>Capacity</option>
											<option value='IIG'>IIG</option>
											<option value='ISP'>ISP</option>
											<option value='Link'>Link</option>
											<option value='NA'>NA</option>
											<option value='No'>No</option>
											<option value='OH'>OH</option>
											<option value='Passive'>Passive</option>
											<option value='UG'>UG</option>


																											
										</select>
								</label>
								</td>

								<td>Service Type Gateway</td>
								<td><!-- <input type="text" name="service_type_gateway" class="form-control input-transparent" required value="{{$link_list->service_type_gateway}}"> -->
									<label style="float:left;">
								<select id="select_style" name="service_type_gateway" required>
											<option value='' disabled selected></option>
											<option value='DOMESTIC'>DOMESTIC</option>
											<option value='IIG Backbone'>IIG Backbone</option>
											<option value='INTERNATIONAL'>INTERNATIONAL</option>
											<option value='Internet'>Internet</option>
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
								<td><input type="text" name="link_name_nttn" class="form-control input-transparent" required value="{{$link_list->link_name_nttn}}" list="na_list"></td>
								

								<td>Link Name Gateway</td>
								<td><input type="text" name="link_name_gateway" class="form-control input-transparent"  required value="{{$link_list->link_name_gateway}}" list="na_list"></td>

								<td>Redundancy</td>
								<td><!-- <input type="text" name="redundancy" class="form-control input-transparent" required value="{{$link_list->redundancy}}"> -->
									<label style="float:left;">
								<select id="select_style" name="redundancy" required>
											<option value='' disabled selected></option>
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
								<td><!-- <input type="text" name="service_impact" class="form-control input-transparent" required value="{{$link_list->service_impact}}"> -->
									<label style="float:left;">
								<select id="select_style" name="service_impact" required>
											<option value='' disabled selected></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>
								</td>
								

								<td>Capacity NTTN</td>
								<td><input type="text" name="capacity_nttn" class="form-control input-transparent" required value="{{$link_list->capacity_nttn}}" list="na_list"></td>

								<td>Capacity Gateway</td>
								<td><input type="text" name="capacity_gateway" class="form-control input-transparent" required value="{{$link_list->capacity_gateway}}" list="na_list"></td>

							</tr>

							<tr>
								<td>Last Mile Provided By</td>
								<td><!-- <input type="text" name="last_mile_provided_by" class="form-control input-transparent" required value="{{$link_list->last_mile_provided_by}}"> -->
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
								

								<td>Last Mile Link ID</td>
								<td><input type="text" name="last_mile_link_id" class="form-control input-transparent" required value="{{$link_list->last_mile_link_id}}" list="na_list"></td>

								<td>Subcenter Primary</td>
								<td><!-- <input type="text" name="sub_center_primary" class="form-control input-transparent" required value="{{$link_list->sub_center_primary}}"> -->
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
											<option value='Gateway_IIG'>Gateway_IIG</option>
											<option value='Gazipur'>Gazipur</option>
											<option value='Jessore'>Jessore</option>
											<option value='Kawran_Bazar'>Kawran_Bazar</option>
											<option value='Khulna'>Khulna</option>
											<option value='Kushtia'>Kushtia</option>
											<option value='Mirpur'>Mirpur</option>
											<option value='Mymensingh'>Mymensingh</option>
											<option value='NA'>NA</option>
											<option value='Narayanganj'>Narayanganj</option>
											<option value='Paltan'>Paltan</option>
											<option value='Rajshahi'>Rajshahi</option>
											<option value='Rangpur'>Rangpur</option>
											<option value='Savar'>Savar</option>
											<option value='Shariatpur'>Shariatpur</option>
											<option value='Sylhet'>Sylhet</option>
											<option value='Tangail'>Tangail</option>
											<option value='Underground'>Underground</option>
											<option value='Uttara'>Uttara</option>
											<option value='CTG_North'>CTG_North</option>
											<option value='CTG_South'>CTG_South</option>
											<option value='Coxsbazar'>Coxsbazar</option>
											<option value='Feni'>Feni</option>

																										
										</select>
								</label>
								</td>

							</tr>

							<tr>
								<td>Subcenter Secondary</td>
								<td><!-- <input type="text" name="sub_center_secondary" class="form-control input-transparent" required value="{{$link_list->sub_center_secondary}}"> -->
									<label style="float:left;">
								<select id="select_style" name="sub_center_secondary" required>
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
											<option value='Gateway_IIG'>Gateway_IIG</option>
											<option value='Gazipur'>Gazipur</option>
											<option value='Jessore'>Jessore</option>
											<option value='Karwan_Bazar'>Kawran_Bazar</option>
											<option value='Khulna'>Khulna</option>
											<option value='Kushtia'>Kushtia</option>
											<option value='Mirpur'>Mirpur</option>
											<option value='Mymensingh'>Mymensingh</option>
											<option value='NA'>NA</option>
											<option value='Narayanganj'>Narayanganj</option>
											<option value='Paltan'>Paltan</option>
											<option value='Rajshahi'>Rajshahi</option>
											<option value='Rangpur'>Rangpur</option>
											<option value='Savar'>Savar</option>
											<option value='Shariatpur'>Shariatpur</option>
											<option value='Sylhet'>Sylhet</option>
											<option value='Tangail'>Tangail</option>
											<option value='Underground'>Underground</option>
											<option value='Uttara'>Uttara</option>
											<option value='CTG_North'>CTG_North</option>
											<option value='CTG_South'>CTG_South</option>
											<option value='Coxsbazar'>Coxsbazar</option>
											<option value='Feni'>Feni</option>



																										
										</select>
								</label>

									
								</td>
								

								<td>Metro</td>
								<td><!-- <input type="text" name="metro" class="form-control input-transparent" required value="{{$link_list->metro}}"> -->
									
									<label style="float:left;">
								<select id="select_style" name="metro" required>
											<option value='' disabled selected></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>
								</td>

								<td>LH</td>
								<td><!-- <input type="text" name="lh" class="form-control input-transparent" required value="{{$link_list->LH}}"> -->
									<label style="float:left;">
								<select id="select_style" name="lh" required>
											<option value='' disabled selected></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>
								</td>

							</tr>

							<tr>
								<td>Dark Core</td>
								<td><!-- <input type="text" name="dark_core" class="form-control input-transparent" required value="{{$link_list->dark_core}}"> -->
									<label style="float:left;">
								<select id="select_style" name="dark_core" required>
											<option value=''></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>
								</td>
								

								<td>Mobile Backhaul</td>
								<td><!-- <input type="text" name="mobile_backhaul" class="form-control input-transparent" required value="{{$link_list->mobile_backhaul}}"> -->
									<label style="float:left;">
								<select id="select_style" name="mobile_backhaul" required>
											<option value='' disabled selected></option>
											<option value="yes">Yes</option>
											<option value="no">NO</option>																	
										</select>
								</label>

								</td>

								<td>Telegram Group</td>
								<td><input type="text" name="telegram_group" class="form-control input-transparent" readonly required onclick="getTelegramGroups()" value="{{$link_list->telegram_group}}"></td>


							</tr>


							<tr>
								<td>UNI/NNI</td>
								<td>
									<label style="float:left;">
									<select id="select_style" name="uni_nni" required>
										<option value='' disabled selected></option>
										<option value="uni">UNI</option>
										<option value="nni">NNI</option>																	
									</select>
									</label>
								</td>
								<td>Comments</td>
								<td ><input type="text" name="comment" class="form-control input-transparent"  required ></td>
								

								<!-- <td>Mobile Backhaul</td>
								<td><input type="text" name="mobile_backhaul" class="form-control input-transparent" required value="{{$link_list->mobile_backhaul}}"></td>

								<td></td>
								<td></td> -->

							</tr>



													
							<tr>
								<td colspan="10">
									<input type="hidden" name="link_name_id" value="{{$link_list->link_name_id}}">
									<input type="submit" class="btn btn-primary" name="formType" value="Edit Link">
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