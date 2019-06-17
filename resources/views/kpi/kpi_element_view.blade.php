@include('navigation.p_header')
<script type="text/javascript">
	var id_value = "<?php echo $_GET['id'] ?>";
</script>
<script src="{{asset('js/angular.min.js')}}"></script>
<script src="{{asset('js/kpi-element-view.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/element_view_style.css')}}">
<style type="text/css">
	.color_hover_with_white td:hover{
		background:green;
	}
	.color_hover td:hover{
		background:red;
	}
</style>
<body>
<div class="container">
	<div class="col-md-6">
		<div ng-app="elementApp" ng-controller="elementCtrl" class="widget">
			<table id="element_view_table">
			  <tr>
			  	<td><input type="text" ng-model="search" style="width: 100%;border-radius:5px;color:#000;" placeholder="Search"></td>		  	
			  </tr>
			  <tr ng-repeat="element in elements | filter:search" ng-class="{color_hover_with_white: element.ticket_id == null, color_hover: element.ticket_id != null}">
			  	@if($element_type=='link')
			  		
			  		<td id="@{{ element.link_name }}--@{{element.link_name_id}}" onclick="elementfunction(this.id,'add')" style="padding:10px;">@{{ element.link_name }}<a href="{{ url('EditTT')}}?ticket_id=@{{element.ticket_id}}" target="_blank"> <span ng-if="element.ticket_id != null">Ticket ID : </span>@{{element.ticket_id}}</a>
			  		</td>

			  	@else
			  	
			  		<td id="@{{ element.site_name }}--@{{element.site_name_id}}" onclick="elementfunction(this.id,'add');" style="padding:10px;" class="color_hover">@{{ element.site_name }}<a href="{{ url('EditTT')}}?ticket_id=@{{element.ticket_id}}" ><span ng-if="element.ticket_id != null">Ticket ID : </span>@{{element.ticket_id}}</td>
			  		
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
});
</script>
@include('navigation.p_footer')
