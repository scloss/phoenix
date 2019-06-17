@include('navigation.p_header')

<script src="{{asset('js/angular.min.js')}}"></script>
<script src="{{asset('js/element-view.js?v430')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/element_view_style.css')}}">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
// $(document).ready(function(){
	var id_value = "<?php echo $_GET['id'] ?>";
	function WhichButton(event,id) {		
	    if(event.button == 2){
	    	elementValues = id;
			var elementValuesArr = elementValues.split('--');
			var elementName = elementValuesArr[1];
			$(document).ready(function(){
				fetch('http://172.20.17.50/phoenix/public/LinkApi', {
	                method: 'post',
	                headers: {
	                    'Accept': 'application/json, text/plain, */*',
	                    'Content-Type': 'application/json'
	                },
	                body: JSON.stringify({
	                    id: elementName
	                })
	            })
	            .then((response) => response.json())
	            .then((responseJson) => {
	                $("#link_name_nttn").text(responseJson.records[0].link_name_nttn);
	                $("#link_name_gateway").text(responseJson.records[0].link_name_gateway);  
	                $("#link_id").text(responseJson.records[0].link_id);  
	                $("#vlan_id").text(responseJson.records[0].vlan_id);  
	                $("#link_category").text(responseJson.records[0].link_category);  
	                $("#link_type").text(responseJson.records[0].link_conn_type);  
	                $("#district").text(responseJson.records[0].district);  
	                $("#region").text(responseJson.records[0].region);  
	                $("#vendor").text(responseJson.records[0].vendor);  
	                $("#client_owner").text(responseJson.records[0].client_owner);  
	                $("#service_type_nttn").text(responseJson.records[0].service_type_nttn);  
	                $("#service_type_gateway").text(responseJson.records[0].service_type_gateway);  
	                $("#redundancy").text(responseJson.records[0].redundancy);  
	                $("#service_impact").text(responseJson.records[0].service_impact);  
	                $("#capacity_nttn").text(responseJson.records[0].capacity_nttn);  
	                $("#capacity_gateway").text(responseJson.records[0].capacity_gateway);  
	                $("#last_mile_provided_by").text(responseJson.records[0].last_mile_provided_by);   
	                $("#last_mile_link_id").text(responseJson.records[0].last_mile_link_id);   
	                $("#LH").text(responseJson.records[0].LH);
	                $("#client_name").text(responseJson.records[0].client_name); 
	                $("#metro").text(responseJson.records[0].metro); 
	                $("#dark_core").text(responseJson.records[0].dark_core); 
	                $("#mobile_backhaul").text(responseJson.records[0].mobile_backhaul);
	                $("#sub_center_primary").text(responseJson.records[0].sub_center_primary); 
	                $("#sub_center_secondary").text(responseJson.records[0].sub_center_secondary);
	            })
	            .catch((error) => {

	            	//alert("error found");
	                
	            });
	    		$("#myModal").modal();
	    	});
	    }
	    else{
	    	return false;
	    }
	}
// });


</script>
<style type="text/css">
	td{
		border : 1px solid grey;
		padding : 2px;
		text-align: center;
	}
	.color_hover_with_white td:hover{
		background:green;
	}
	.color_hover td:hover{
		background:red;

	}
	.modal-body{
	    padding: 0px !important;
	}
</style>
<body oncontextmenu="return false;">



<div class="container">
	<div class="col-md-12">
		

		<div class="container">
		  <div class="modal fade" id="myModal" role="dialog">
		    <div class="modal-dialog">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		         		<center><h4>Link Information</h4></center>
		        </div>
		        <div class="modal-body">		        	
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Link ID : </p></div>
		        		<div class="col-md-8"><p id="link_id"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Vlan ID : </p></div>
		        		<div class="col-md-8"><p id="vlan_id"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Link Name NTTN : </p></div>
		        		<div class="col-md-8"><p id="link_name_nttn"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Link Name Gateway : </p></div>
		        		<div class="col-md-8"><p id="link_name_gateway"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Client Name : </p></div>
		        		<div class="col-md-8"><p id="client_name"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Link Category : </p></div>
		        		<div class="col-md-8"><p id="link_category"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Link Type : </p></div>
		        		<div class="col-md-8"><p id="link_type"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>District : </p></div>
		        		<div class="col-md-8"><p id="district"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Region : </p></div>
		        		<div class="col-md-8"><p id="region"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Vendor : </p></div>
		        		<div class="col-md-8"><p id="vendor"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Client Owner : </p></div>
		        		<div class="col-md-8"><p id="client_owner"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Service Type NTTN : </p></div>
		        		<div class="col-md-8"><p id="service_type_nttn"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Service Type Gateway : </p></div>
		        		<div class="col-md-8"><p id="service_type_gateway"></p></div>
		        	</div>    	
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Redundancy : </p></div>
		        		<div class="col-md-8"><p id="redundancy"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Service Impact : </p></div>
		        		<div class="col-md-8"><p id="service_impact"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Capacity NTTN : </p></div>
		        		<div class="col-md-8"><p id="capacity_nttn"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Capacity Gateway : </p></div>
		        		<div class="col-md-8"><p id="capacity_gateway"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Last Mile Provided By : </p></div>
		        		<div class="col-md-8"><p id="last_mile_provided_by"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Last Mile Link ID : </p></div>
		        		<div class="col-md-8"><p id="last_mile_link_id"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Sub Center Primary : </p></div>
		        		<div class="col-md-8"><p id="sub_center_primary"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Sub Center Secondary : </p></div>
		        		<div class="col-md-8"><p id="sub_center_secondary"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Metro : </p></div>
		        		<div class="col-md-8"><p id="metro"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>LH : </p></div>
		        		<div class="col-md-8"><p id="LH"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Dark Core : </p></div>
		        		<div class="col-md-8"><p id="dark_core"></p></div>
		        	</div>
		        	<div class="col-md-12">
		        		<div class="col-md-4"><p>Mobile BackHaul : </p></div>
		        		<div class="col-md-8"><p id="mobile_backhaul"></p></div>
		        	</div>
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
		      </div>
		      
		    </div>
		  </div>			  
		</div>

		<div ng-app="elementApp" ng-controller="elementCtrl" class="widget">


			<table id="element_view_table">
				<tr>
					<td  colspan="4">Right Click on the Link/Site Name Nttn To see Link Details</td>
				</tr>
			  <tr>

			  	<td colspan="4"><input type="text" ng-model="search" style="width: 100%;border-radius:5px;color:#000;" placeholder="Search"></td>		  	
			  </tr>
			  <tr>	
			  	
			  	@if($element_type=='link')
			  	<td >Link Name NTTN</td>
			  	<td>Link Name Gateway</td>
			  	<td>Link ID</td>
			  	<td>Vlan ID</td>
			  	
			  	@else
			  	<td >Site Name</td>
			  	<td>Site IP Address</td>

			  	@endif

			  </tr>
			  <tr ng-repeat="element in elements | filter:search" ng-class="styleFunction(element.problem_category,'{{$problem_category}}')" >
			  	@if($element_type=='link')

			  		
			  		<td onmousedown="WhichButton(event,this.id)" id="@{{ element.link_name_nttn }}--@{{element.link_name_id}}--@{{ element.district }}--@{{ element.region }}--@{{ element.sms_group }}--@{{ element.vendor }}--@{{ element.link_id }}--@{{ element.vlan_id }}--@{{ element.link_name_gateway }}--@{{ element.sub_center_primary }}--@{{element.ticket_id}}--@{{element.problem_category}}--{{$problem_category}}" onclick="elementfunction(this.id,'add',id_value)" style="padding:10px;">@{{ element.link_name_nttn }}<a href="{{ url('EditTT')}}?ticket_id=@{{element.ticket_id}}" target="_blank"> <span ng-if="element.ticket_id != null ">Ticket ID : </span>@{{element.ticket_id}}</a>
			  		</td>
			  		<td onmousedown="WhichButton(event,this.id)"  id="@{{ element.link_name_nttn }}--@{{element.link_name_id}}--@{{ element.district }}--@{{ element.region }}--@{{ element.sms_group }}--@{{ element.vendor }}--@{{ element.link_id }}--@{{ element.vlan_id }}--@{{ element.link_name_gateway }}--@{{ element.sub_center_primary }}--@{{element.ticket_id}}--@{{element.problem_category}}--{{$problem_category}}" onclick="elementfunction(this.id,'add',id_value)" >@{{ element.link_name_gateway }}</td>
			  		<td onmousedown="WhichButton(event,this.id)"  id="@{{ element.link_name_nttn }}--@{{element.link_name_id}}--@{{ element.district }}--@{{ element.region }}--@{{ element.sms_group }}--@{{ element.vendor }}--@{{ element.link_id }}--@{{ element.vlan_id }}--@{{ element.link_name_gateway }}--@{{ element.sub_center_primary }}--@{{element.ticket_id}}--@{{element.problem_category}}--{{$problem_category}}" onclick="elementfunction(this.id,'add',id_value)" >@{{ element.link_id }}</td>
			  		<td onmousedown="WhichButton(event,this.id)"  id="@{{ element.link_name_nttn }}--@{{element.link_name_id}}--@{{ element.district }}--@{{ element.region }}--@{{ element.sms_group }}--@{{ element.vendor }}--@{{ element.link_id }}--@{{ element.vlan_id }}--@{{ element.link_name_gateway }}--@{{ element.sub_center_primary }}--@{{element.ticket_id}}--@{{element.problem_category}}--{{$problem_category}}" onclick="elementfunction(this.id,'add',id_value)" >@{{ element.vlan_id }}</td>

			  		
			  	@else
			  	
			  		<td id="@{{ element.site_name }}--@{{element.site_name_id}}--@{{ element.district }}--@{{ element.region }}--@{{ element.sms_group }}--@{{ element.vendor }}--@{{element.site_ip_address}}--@{{ element.sub_center }}--@{{element.ticket_id}}--@{{element.problem_category}}--{{$problem_category}}" onclick="elementfunction(this.id,'add');" style="padding:10px;" class="color_hover">@{{ element.site_name }} <a href="{{ url('EditTT')}}?ticket_id=@{{element.ticket_id}}" ><span ng-if="element.ticket_id != null ">Ticket ID : </span>@{{element.ticket_id}}</td>
			  		<td>@{{element.site_ip_address}}</td>
			  		
			  	@endif
			  </tr>
			</table>	 
		</div>
	</div>
</div>
 
<script>
var elementType = "<?php echo $_GET['element_type']; ?>";
var clientId = "<?php echo $_GET['client_id'] ?>";
var customUrl = '/phoenix/public/ElementApi?element_type='+elementType+'&client_id='+clientId;
var app = angular.module('elementApp', []);

app.controller('elementCtrl', function($scope, $http) {
   $http.get(customUrl)
   .then(function (response) {$scope.elements = response.data.records;});

    $scope.styleFunction = function(problem_category_old,problem_category_new){
    // console.log("styleFunction "+problem_category_old);
    // console.log("break");



    if(problem_category_old != null){
		console.log(problem_category_old);
		old_problem_array = problem_category_old.split(",");

		for (let i = 0; i < old_problem_array.length; i++) {
		  //console.log(products[i]);
		  if(old_problem_array[i] == problem_category_new){
		  	return "color_hover";
		  }
		}
		return "color_hover_with_white";

    }
    else{
    	return "color_hover_with_white";
    }

  }  


});
</script>
@include('navigation.p_footer')
