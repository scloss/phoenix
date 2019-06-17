@include('navigation.p_header')
<script type="text/javascript">
	
</script>
<script src="{{asset('js/angular.min.js')}}"></script>
<script src="{{asset('js/element-view.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/element_view_style.css')}}">
<script>
var emailValues='';
function emailfunction(id,value){
  var values = "<?php echo $_GET['id'] ?>"
  
  if(value == 'add'){
  	document.getElementById(id).style.backgroundColor = "#3cb0fd";
	document.getElementById(id).style.color = "#fff";
  	//emailValues += id+',';
  	var len = document.getElementById("checkList[]").length;
  	if(len < 1){
  		var checkList = document.getElementById("checkList[]");
  		$(checkList).append('<option value="'+id+'">'+id+'</option>');
  	}
  	
  }
  if(value == 'submitCustom'){
 //  	document.getElementById(id).style.backgroundColor = "#3cb0fd";
	// document.getElementById(id).style.color = "#fff";
  	//emailValues += id+',';
  	var checkList = document.getElementById("checkList[]");
  	var customValue = document.getElementById("customEmail").value;
  	var res = customValue.split("@");

	if(res.length > 1){
		if(res[1] == 'summitcommunications.net'){
			alert('Please do not assign SCL group mail address in responsible.For internal address use below field ');
		}
		else{
			var filter = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(filter.test(customValue)){
		  		$(checkList).append('<option value="'+customValue+'">'+customValue+'</option>');
		  	}
		}
	}
  }
  if(value == 'submit'){
  	$("select option").each(function() { 
  		emailValues += $(this).text()+',';
	});
	if(emailValues == ''){
		alert("Please Add at least one");
	}
	else{
		emailValues = emailValues.slice(0,-1);
	  	window.opener.document.forms['tt_create_form'].elements[values].value=emailValues;
	  	var splited_value = values.split("_");
	  	for(var i=1;i<5;i++){
	  		var element_id ='fault_'+splited_value[2]+'_task_'+i+'_responsible_concern';
	  		try{
	  			window.opener.document.forms['tt_create_form'].elements['fault_'+splited_value[2]+'_task_'+i+'_responsible_concern'].value = emailValues;
	  		}
	  		catch(e){
	  			console.log(e)
	  		}
	  	}
	  	window.close();
	}
  	
  }
  
    // alert(empname);


  }
  function removeResponsible() {
	    var x = document.getElementById("checkList[]");
	    x.remove(x.selectedIndex);
	}
</script>

<style>

</style>
<body>
<div class="container">
	<div class="col-md-6">
		<div ng-app="responsibleConcernApp" ng-controller="responsibleConcernCtrl">
		 
			<table>
			  <tr>
			  	<td>
			  		Use below field to add external email address
			  	</td>
			  </tr>		
			  <tr>
			  	<td><input type="text" name="customEmail" id="customEmail" value="" placeholder="For External Email"><button id="submit" class="btn btn-primary" onclick="emailfunction(this.id,'submitCustom');">SUBMIT</button></td>
			  </tr>
			  <br>
			  <tr>
			  	<td><input type="text" ng-model="search" style="width: 100%;border-radius:5px;color:#000;" placeholder="Search"></td>
			  </tr>
			  <tr ng-repeat="emailID in emailIDs | filter:search">
			    <td id="@{{emailID.email}}" onclick="emailfunction(this.id,'add');" style="padding:10px;cursor:pointer;">@{{ emailID.email }} (@{{emailID.designation}}) (@{{emailID.department}})</td>
			  </tr>

			</table>
		 
		</div>
	</div>
	<div class="col-md-6">
		<table>
			<tr>
				<td>
					<select id="checkList[]" name="checkList[]" multiple style="height:220px !important;width:100%;color:#000;">		   
					</select>
				</td>

			</tr>
			<tr>
				<td>
					<center>
						<button id="submit" class="btn btn-primary" onclick="emailfunction(this.id,'submit');">SUBMIT</button>
						<button class="btn btn-primary" onclick="removeResponsible()">Remove Selected Person</button>
					</center>
				</td>  
			</tr>
		</table>
	</div>
</div>
 
<script>

var app = angular.module('responsibleConcernApp', []);

app.controller('responsibleConcernCtrl', function($scope, $http) {
   $http.get('/phoenix/public/phoenix_get_employee_api')
   .then(function (response) {$scope.emailIDs = response.data.emp_list;});
});
</script>
@include('navigation.p_footer')
