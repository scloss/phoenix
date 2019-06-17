@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="{{asset('lib\moment\moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<!-- <script src="{{asset('js/fault.js')}}"></script> -->
<script type="text/javascript" src="{{asset('js/kpi.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/incident_style.css')}}">
<div class="container-fluid" id="incident_main_div">
	<script type="text/javascript">
    
    document.getElementById('kpi-collapse').className = 'panel-collapse collapse in';
    document.getElementById('kpi_module_fault').className = 'active';
</script>

<style type="text/css">
	/*td { white-space:pre }*/
	br:before { content: "\A"; white-space: pre-line }
	label {
    display: inline-block;
    /*width: 5em;*/
  }
  #incident_search_table td{
    padding:10px;
    border:1px solid grey;
    text-align:center;
  }
</style>
	<!-- @if(isset($_SESSION["CURRENT_LIST"]))
	<p style="color:#fff;">{{$_SESSION["CURRENT_LIST"]}}</p>
	@endif -->
	<h2 class="page-title">KPI Report Fault<span class="fw-semi-bold"></span></h2>
	<div clss="row">
		<section class="widget" id="default-widget"">
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<table id="incident_search_table">
							<form id="fault_search" action="{{url('KpiViewFault')}}" method="GET">
								<input type="hidden" name="element_id">
							<tr>
								<td colspan="10" id="section_header">KPI Report Fault</td>
							</tr>

							<tr>
								<td>Client ID</td>
								<td>Element Type</td>
								<td>Link Category</td>
								<td>Link Conn Type</td>
							</tr>
							<tr>
								
								<td>
									<label>
										<select id="select_style" name="client_id" class="client_id">
											<option selected></option>
											@foreach($client_lists as $client_list) 
												@if($client_list->client_id == $fault_arr['client_id']) 
	                                            	<option selected value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                            @else
	                                            	<option value="{{$client_list->client_id}}">{{$client_list->client_name}}</option>
	                                            @endif
	                                        @endforeach
	                                    </select>
	                                </label>
								</td>
								
								<td>
									<label>
										<select id="select_style" required name="element_type" class="element_type">
												<option selected></option>
											@if($fault_arr['element_type']=="link")
												<option selected value="link">Link</option>
												<option value="site">Site</option>
											@elseif($fault_arr['element_type']=="site")
												<option value="link">Link</option>
												<option selected value="site">Site</option>
											@else
												<option value="link">Link</option>
												<option value="site">Site</option>	
											@endif

	                                    </select>
	                                </label>
								</td>
								<td>
									<label>
										<select id="select_style" name="link_category" class="link_category">
												<option selected></option>
												<option value="Access">Access</option>
												<option value="Backbone">Backbone</option>
												<option value="Aggregation">Aggregation</option>
												<option value="Capacity">Capacity</option>
												<option value="Handover">Handover</option>
												<option value="Messenger">Messenger</option>
												<option value="Normal">Normal / Non Armored</option>
	                                    </select>
	                                </label>
								</td>
								<td>
									<label>
										<select id="select_style" name="link_conn_type" class="link_conn_type">
												<option selected></option>
												<option value="OH">OH</option>
												<option value="UG">UG</option>
												<option value="OU">OU</option>
	                                    </select>
	                                </label>
								</td>
								
							</tr>
							<tr>	
								<td>Event Time From</td>
								<td>Event Time To</td>
								<td>MTTR Report List</td>
								<td>LH</td>
							</tr>
							<tr>	
				
								<td>
									<div id="event_time_from" class="input-group">
	                                    <input id="datepicker2i" type="text" name="event_time_from" class="form-control input-transparent" readonly requried value="{{$fault_arr['event_time_from']}}" >
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>
								<td>
									<div id="event_time_to" class="input-group">
	                                    <input id="datepicker2i" type="text" name="event_time_to" class="form-control input-transparent" readonly requried value="{{$fault_arr['event_time_to']}}" >
	                                    <span class="input-group-addon btn btn-info">
	                                        <span class="glyphicon glyphicon-calendar"></span>                    
	                                    </span>
	                                </div> 
								</td>	
								
								<td>
									<label>
										<select id="select_style" name="report_list" required>
											<option selected value="client_wise_mttr">Client Wise</option>
											<option value="region_wise_mttr">Region Wise</option>
											<option value="district_wise_mttr">District Wise</option>

	                                    </select>
	                                </label>
								</td>
								<td>
									<label>
										<select id="select_style" name="LH" class="LH">
												<option selected value=""></option>
												<option value="yes">Yes</option>
												<option  value="No">No</option>									
	                                    </select>
	                                </label>
								</td>
								
							</tr>
							<tr>
								<td>Metro</td>
								<td>Dark Core</td>
								<td>Mobile Backhaul</td>
								<td>Region</td>
							</tr>
								<td>
									<label>
										<select id="select_style" name="metro" class="metro">
												<option selected value=""></option>
												<option value="yes">Yes</option>
												<option value="No">No</option>									
	                                    </select>
	                                </label>
								</td>
								<td>
									<label>
										<select id="select_style" name="dark_core" class="dark_core">
												<option selected value=""></option>
												<option value="yes">Yes</option>
												<option value="No">No</option>									
	                                    </select>
	                                </label>
								</td>
								<td>
									<label>
										<select id="select_style" name="mobile_backhaul" class="mobile_backhaul">
												<option selected value=""></option>
												<option value="yes">Yes</option>
												<option value="No">No</option>									
	                                    </select>
	                                </label>
								</td>
								<td>
									<center>
									<label>
									
									<select  name="region" id="region" style="width: 200px">
										<option value=''  selected></option>
										<option value="Gateway Operations">Gateway Operations</option>
										<option value="Regional Implementation & Operations 1">Regional Implementation & Operations 1</option>
										<option value="Regional Implementation & Operations 1, Regional Implementation & Operations 2">Regional Implementation & Operations 1, Regional Implementation & Operations 2</option>
										<option value="Regional Implementation & Operations 1, Regional Implementation & Operations 2, Regional Implementation & Operations 3">Regional Implementation & Operations 1, Regional Implementation & Operations 2, Regional Implementation & Operations 3</option>
										<option value="Regional Implementation & Operations 2">Regional Implementation & Operations 2</option>
										<option value="Regional Implementation & Operations 2, Regional Implementation & Operations 3">Regional Implementation & Operations 2, Regional Implementation & Operations 3</option>
										<option value="Regional Implementation & Operations 3">Regional Implementation & Operations 3</option>
										<option value="Regional Implementation & Operations 3, Regional Implementation & Operations 1">Regional Implementation & Operations 3, Regional Implementation & Operations 1</option>

										
										
									</select>
									</label>
									</center>
								</td>
							</tr>
							<tr>
								<td>District</td>
							</tr>
							<tr>
								<td>
									<center>
									<label>								
										<select  name="district" id="district">
											<option value=''  selected></option>
											@foreach($district_lists as $district_list)
											<option value="{{$district_list->district_name}}">{{$district_list->district_name}}</option>
											
											@endforeach
											
											
										</select>
									</label>
									</center>
								</td>
							</tr>
							<tr>
								<td colspan="10">
									<input type="submit" class="btn btn-primary" name="formType" value="Export">
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