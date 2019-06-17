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
    		$('[name=site_type]').val( '<?php echo $site_lists[0]->site_type ?>' );
    		$('[name=region]').val( '<?php echo $site_lists[0]->region ?>' );
    		$('[name=vendor]').val( '<?php echo $site_lists[0]->vendor ?>' );
    		$('[name=device_type]').val( '<?php echo $site_lists[0]->device_type ?>' );
    		$('[name=device_vendor]').val( '<?php echo $site_lists[0]->device_vendor ?>' );
    		$('[name=device_model]').val( '<?php echo $site_lists[0]->device_model ?>' );
    		$('[name=upazilla]').val( '<?php echo $site_lists[0]->upazilla ?>' );
    		$('[name=sub_center]').val( '<?php echo $site_lists[0]->sub_center ?>' );
	});

	



</script>
<div class="container-fluid" id="incident_main_div">	
	<h2 class="page-title">Edit Site <span class="fw-semi-bold"></span></h2>
		<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="element_create_form" action="{{url('update_site')}}" method="POST">
							
							<datalist id="na_list">
								<option value="NA">  
							</datalist>

							@foreach($site_lists as $site_list)
							<tr>
								<td colspan="10" id="section_header">Site</td>
							</tr>
							<tr>

								<td>Client</td>
								<td><label style="float:left;">
									<select id="select_style" name="client" required>
											<option></option>
											@foreach($client_lists as $client_list)
												@if($client_list->client_id==$site_list->client)
	                                            	<option selected value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                            @else
	                                            	<option value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                            @endif		
	                                        @endforeach																	
	                                </select>
	                                </label>
	                            </td>

								<td>Site Name</td>
								<td>
									<input type="text" name="site_name" class="form-control input-transparent" value="{{$site_list->site_name}}" required list="na_list">
								</td>
								<td>MW Site Name</td>
								<td><input type="text" name="mw_site_name" class="form-control input-transparent"  value="{{$site_list->mw_site_name}}" required list="na_list"></td>
							</tr>

							<tr>
								<td>Site IP Address</td>
								<td><input type="text" name="site_ip_address" class="form-control input-transparent"  value="{{$site_list->site_ip_address}}" required list="na_list"></td>
								
								<!-- <td>Site Type</td>
								<td><input type="text" name="site_type" class="form-control input-transparent"  value="{{$site_list->site_type}}" required></td> -->

								<td>Site Type</td>
								<td><!-- <input type="text" name="site_type" class="form-control input-transparent" required> -->
									<label style="float:left;">
									<select name="site_type">
										<option value='' disabled selected></option>
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
								<td><!-- <input type="text" name="region" class="form-control input-transparent"  value="{{$site_list->region}}" required> -->
									<label style="float:left;">
									<select name="region" style="width: 200px">
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

							</tr>
							<tr>

								<td>District</td>
								<td><label style="float:left;">
									<select id="select_style" name="district" required>
											<option></option>
											@foreach($district_lists as $district_list)
												@if($district_list->district_name==$site_list->district)
	                                            	<option selected value="{{$district_list->district_name}}">{{$district_list->district_name}}</option>
	                                            @else
	                                            	<option value="{{$district_list->district_name}}">{{$district_list->district_name}}</option>
	                                            @endif	
	                                        @endforeach																	
	                                </select>
	                                </label>
	                            </td>

								<td>SMS Group</td>
								<td><input type="text" name="sms_group" class="form-control input-transparent" readonly required  value="{{$site_list->sms_group}}" onclick="getSMSGroups()"></td>
								<td>Vendor</td>
								<td><!-- <input type="text" name="vendor" class="form-control input-transparent" required value="{{$site_list->vendor}}" > -->
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
								<td>Site Node Address</td>
								<td><input type="text" name="site_node_address" class="form-control input-transparent" required value="{{$site_list->site_node_address}}" list="na_list"></td>
								<td>Device Type</td>
								<td><!-- <input type="text" name="device_type" class="form-control input-transparent" required value="{{$site_list->device_type}}" > -->
									<label style="float:left;">
									<select id="select_style" name="device_type" required>
									<option value='' disabled selected></option>
									<option value='NA'>NA</option>
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
								<td><!-- <input type="text" name="device_vendor" class="form-control input-transparent" required value="{{$site_list->device_vendor}}"> -->
									<label style="float:left;">
									<select id="select_style" name="device_vendor" required>
									<option value='' disabled selected></option>
									<option value='NA'>NA</option>
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
							</tr>

							<tr>
								<td>Device Model</td>
								<td><!-- <input type="text" name="device_model" class="form-control input-transparent" required value="{{$site_list->device_model}}"> -->
									<label style="float:left;">
									<select id="select_style" name="device_model" required>
									<option value='NA'>NA</option>
									<option value='9000'>9000</option>
									<option value='5952E ZTE'>5952E ZTE</option>
									<option value='ACX1000'>ACX1000</option>
									<option value='ACX1100'>ACX1100</option>
									<option value='ACX2100'>ACX2100</option>
									<option value='ACX2200'>ACX2200</option>
									<option value='ASR1000'>ASR1000</option>
									<option value='ASR1013'>ASR1013</option>
									<option value='ASR1014'>ASR1014</option>
									<option value='ASR9001'>ASR9001</option>
									<option value='ASR9006'>ASR9006</option>
									<option value='ASR9010'>ASR9010</option>
									<option value='ATN 910 B-A'>ATN 910 B-A</option>
									<option value='ATN 910B'>ATN 910B</option>
									<option value='ATN 910B-D DC'>ATN 910B-D DC</option>
									<option value='ATN 910B-F'>ATN 910B-F</option>
									<option value='ATN 910B-F DC'>ATN 910B-F DC</option>
									<option value='ATN 910C-B'>ATN 910C-B</option>
									<option value='ATN902B'>ATN902B</option>
									<option value='BDCOM'>BDCOM</option>
									<option value='Catalyst 4500'>Catalyst 4500</option>
									<option value='Catalyst 4500X'>Catalyst 4500X</option>
									<option value='CCR1036-12G-4S'>CCR1036-12G-4S</option>
									<option value='Cisco ASR9K Series'>Cisco ASR9K Series</option>
									<option value='ciscoASR903'>ciscoASR903</option>
									<option value='ciscoSB'>ciscoSB</option>
									<option value='DELL'>DELL</option>
									<option value='DGS-3120-24SC'>DGS-3120-24SC</option>
									<option value='DGS-3120-24SC-DC'>DGS-3120-24SC-DC</option>
									<option value='ECS4510-28F'>ECS4510-28F</option>
									<option value='ECS4620-28F'>ECS4620-28F</option>
									<option value='ECS4620-28F-DC'>ECS4620-28F-DC</option>
									<option value='Edgecore-3620'>Edgecore-3620</option>
									<option value='ES3528M-SFP'>ES3528M-SFP</option>
									<option value='EX-4200'>EX-4200</option>
									<option value='IBM x3550 M3'>IBM x3550 M3</option>
									<option value='M721'>M721</option>
									<option value='ME-3800X'>ME-3800X</option>
									<option value='MX104'>MX104</option>
									<option value='MX204'>MX204</option>
									<option value='MX240'>MX240</option>
									<option value='MX480'>MX480</option>
									<option value='MX80'>MX80</option>
									<option value='MX80-p'>MX80-p</option>
									<option value='NE-05'>NE-05</option>
									<option value='NE05E-SE'>NE05E-SE</option>
									<option value='NE20'>NE20</option>
									<option value='NE20E-S2F'>NE20E-S2F</option>
									<option value='NE-40'>NE-40</option>
									<option value='NE40E-X3A'>NE40E-X3A</option>
									<option value='NE40-X3A-P01'>NE40-X3A-P01</option>
									<option value='OptiX OSN 1800 V'>OptiX OSN 1800 V</option>
									<option value='OptiX OSN 8800'>OptiX OSN 8800</option>
									<option value='OptiX OSN 8800 T16'>OptiX OSN 8800 T16</option>
									<option value='OSCILLOQUARTZ/5220'>OSCILLOQUARTZ/5220</option>
									<option value='PowerEdge R730'>PowerEdge R730</option>
									<option value='S2528GX'>S2528GX</option>
									<option value='S3328TP-EI'>S3328TP-EI</option>
									<option value='S3756F'>S3756F</option>
									<option value='S385'>S385</option>
									<option value='S5600'>S5600</option>
									<option value='S5720-28X-LI-DC'>S5720-28X-LI-DC</option>
									<option value='SG300'>SG300</option>
									<option value='SG300-28'>SG300-28</option>
									<option value='SRX240'>SRX240</option>
									<option value='SRX240h2'>SRX240h2</option>
									<option value='TJ100CPR4'>TJ100CPR4</option>
									<option value='TJ100ME'>TJ100ME</option>
									<option value='TJ1100'>TJ1100</option>
									<option value='TJ1270'>TJ1270</option>
									<option value='TJ1400'>TJ1400</option>
									<option value='TJ1400_Type-7SR'>TJ1400_Type-7SR</option>
									<option value='TJ1600'>TJ1600</option>
									<option value='TJ1600_MODEL_POTP'>TJ1600_MODEL_POTP</option>
									<option value='TJMC1270'>TJMC1270</option>
									<option value='TP48200BN20B3'>TP48200BN20B3</option>
									<option value='TP48600BN16C2'>TP48600BN16C2</option>
									<option value='WS-C2960X-24PD-L'>WS-C2960X-24PD-L</option>
									<option value='WS-C3850-48T'>WS-C3850-48T</option>
									<option value='ZX8000'>ZX8000</option>
									<option value='ZXMP S330'>ZXMP S330</option>
									<option value='ZXMP S385'>ZXMP S385</option>

								</select>
								</label>
								</td>
								<td>Upazilla</td>
								<td><!-- <input type="text" name="upazilla" class="form-control input-transparent" required value="{{$site_list->upazilla}}"> -->
									<label style="float:left;">
									<select id="select_style" name="upazilla" required>
									<option value='' disabled selected></option>
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
								<td>Subcenter</td>
								<td><!-- <input type="text" name="sub_center" class="form-control input-transparent" required value="{{$site_list->sub_center}}"> -->
									<label style="float:left;">
									<select id="select_style" name="sub_center" required>
									<option value='' disabled selected></option>
									<option value='Banani'>Banani</option>
									<option value='Barisal'>Barisal</option>
									<option value='Bogra'>Bogra</option>
									<option value='Chittagong'>Chittagong</option>
									<option value='Comilla'>Comilla</option>
									<option value='CoxsBazar'>CoxsBazar</option>
									<option value='Dhanmondi'>Dhanmondi</option>
									<option value='Faridpur'>Faridpur</option>
									<option value='Gazipur'>Gazipur</option>
									<option value='Gateway_ICX'>Gateway_ICX</option>
									<option value='Gateway_IIG'>Gateway_IIG</option>
									<option value='Gateway_ITC'>Gateway_ITC</option>
									<option value='Jessore'>Jessore</option>
									<option value='Kawran_Bazar'>Kawran_Bazar</option>
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
									<option value='CTG_North'>CTG_North</option>
									<option value='CTG_South'>CTG_South</option>
									<option value='Coxsbazar'>Coxsbazar</option>
									<option value='Feni'>Feni</option>
									</select>
								</label>
								</td>

							</tr>

							<tr>
								<td>Telegram Group</td>
								<td><input type="text" name="telegram_group" class="form-control input-transparent" readonly required onclick="getTelegramGroups()" value="{{$site_list->telegram_group}}"></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>

							<tr>
								<td></td>
								<td></td>
								<td>Comments</td>
								<td><input type="text" name="comments" class="form-control input-transparent" required ></td>
								<td></td>
								<td></td>

							</tr>





							<tr>

								<td colspan="10">
								<input type="hidden" name="site_name_id" value="{{$site_list->site_name_id}}">
									<input type="submit" class="btn btn-primary" name="formType" value="Edit Site">
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