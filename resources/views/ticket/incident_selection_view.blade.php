@include('navigation.p_header')
<script type="text/javascript">
	
</script>
<script src="{{asset('js/angular.min.js')}}"></script>
<script src="{{asset('js/incident.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--   <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('lib/moment/moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/element_view_style.css')}}">
<script>
$(document).ready(function(){
	$("#creation_date").datetimepicker();
});

var emailValues='';
function incidentFunction(id){
	var id_arr = id.split('--');
	window.opener.document.forms['tt_create_form'].elements['incident_id'].value=id_arr[0];
  	window.opener.document.forms['tt_create_form'].elements['incident_title'].value=id_arr[1];
  	window.opener.document.forms['tt_create_form'].elements['incident_description'].value=id_arr[2];
  	window.close();
  }

function newIncident(){
	var incident_title = document.getElementById("customEmail").value;
	var incident_location = document.getElementById("location").value;
	
	var full_title = incident_location +"|" + incident_title;

	window.opener.document.forms['tt_create_form'].elements['incident_title'].value = full_title;
	window.opener.document.forms['tt_create_form'].elements['incident_description'].value = $('#customDescription').val();
	window.close();
}
	
</script>

<style>
td{
	padding:10px;
	cursor:pointer;
	border:1px solid white;
}
select{
	color:#000;
}
input{
	color:#000;
}
</style>
<body>
<div class="container">
	<div class="col-md-6">
		<div ng-app="incidentListApp" ng-controller="incidentListCtrl">
		 
			<table>
			  <tr>
			  	<td colspan="4">
			  		Use below field to add new Incident
			  	</td>
			  </tr>		
			  <tr>
			  	<td colspan="3">
			  		<input type="text" name="customEmail" id="customEmail" value=""  class="form-control input-transparent" placeholder="Incident Title">
					<input type="text" name="location" id="location" value=""  class="form-control input-transparent" placeholder="Incident Location">
			  		<textarea id="customDescription" name="customDescription" class="form-control input-transparent" placeholder="Incident Description"></textarea>
			  	</td>
			  	<td><button id="submit" class="btn btn-primary" onclick="newIncident();">SUBMIT</button></td>
			  </tr>
			  <tr>
			  	<td>Incident Title</td><td>Incident Status</td><td>Incident Creation Time</td><td>Incident Merge Time</td>
			  </tr>
			  <tr>
			  	<td><input type="text" ng-model="search" style="width: 100%;border-radius:5px;color:#000;" placeholder="Search"></td>
			  	<td>
			  		<select ng-model="status">
			  			<option value="open">Open</option>
			  			<!-- <option value="closed">Closed</option> -->
			  		</select>
			  	</td>
			  	<td>	  		
			  		<div id="creation_date" class="input-group">
	                    <input id="datepicker2i" ng-model="creation_date" type="text" name="creation_date" class="form-control input-transparent">
	                    <span class="input-group-addon btn btn-info">
	                        <span class="glyphicon glyphicon-calendar"></span>                    
	                    </span>
	                </div>
			  	</td>
			  	<td>
			  		<div id="merge_time" class="input-group">
	                    <input id="datepicker2i" ng-model="merge_time" type="text" name="merge_time" class="form-control input-transparent">
	                    <span class="input-group-addon btn btn-info">
	                        <span class="glyphicon glyphicon-calendar"></span>                    
	                    </span>
	                </div>
			  	</td>
			  </tr> 
			  <tr ng-repeat="emailID in emailIDs | filter:{incident_title:search,incident_status:status,incident_row_created_date:creation_date,incident_merge_time:merge_time}">
			  	<div id="@{{emailID.incident_id}}--@{{emailID.incident_title}}--@{{emailID.incident_description}}" onclick="incidentFunction(this.id);">
			  		<td id="@{{emailID.incident_id}}--@{{emailID.incident_title}}--@{{emailID.incident_description}}" onclick="incidentFunction(this.id);">@{{ emailID.incident_title }}</td>
			  		<td id="@{{emailID.incident_id}}--@{{emailID.incident_title}}--@{{emailID.incident_description}}" onclick="incidentFunction(this.id);">@{{ emailID.incident_status }}</td>
			  		<td id="@{{emailID.incident_id}}--@{{emailID.incident_title}}--@{{emailID.incident_description}} onclick="incidentFunction(this.id);">@{{emailID.incident_row_created_date}}</td>
			  		<td id="@{{emailID.incident_id}}--@{{emailID.incident_title}}--@{{emailID.incident_description}}" onclick="incidentFunction(this.id);">@{{emailID.incident_merge_time}}</td> 			
			  	</div>
			  </tr>

			</table>
		 
		</div>
	</div>
	
</div>
 
<script>

var app = angular.module('incidentListApp', []);

app.controller('incidentListCtrl', function($scope, $http) {
   $http.get('/phoenix/public/IncidentListApi')
   .then(function (response) {$scope.emailIDs = response.data.records;});
});
</script>
@include('navigation.p_footer')
