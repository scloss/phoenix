@include('navigation.p_header')
<script type="text/javascript">
  
</script>
<script src="{{asset('js/angular.min.js')}}"></script>
<script src="{{asset('js/element-view.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/element_view_style.css')}}">
<script>
var emailValues='';
function emailfunction(id,value){

  
  if(value == 'add'){
    document.getElementById(id).style.backgroundColor = "#3cb0fd";
  document.getElementById(id).style.color = "#fff";
    //emailValues += id+',';
    var checkList = document.getElementById("checkList[]");
    $(checkList).append('<option value="'+id+'">'+id+'</option>');
  }

  if(value == 'submit'){
    $("select option").each(function() { 
      emailValues += $(this).text()+', ';
  });
  if(emailValues == ''){
    alert("Please Add at least one");
  }
  else{
    emailValues = emailValues.slice(0,-2);
      window.opener.document.forms['element_create_form'].elements['telegram_group'].value=emailValues;
    
      window.close();
  }
    
  }
  
  


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
          <td><input type="text" ng-model="search" style="width: 100%;border-radius:5px;color:#000;" placeholder="Search"></td>
        </tr>
        <tr ng-repeat="x in names | filter:search">
          <td id="@{{x.id}}" onclick="emailfunction(this.id,'add');" style="padding:10px;cursor:pointer;">@{{ x.id }},@{{ x.group_name }}</td>
        </tr>

      </table>
     
    </div>
  </div>
  <div class="col-md-6">
    <table>
      <tr>
        <td>
          <select id="checkList[]" name="checkList[]" multiple style="height:220px !important;width:380px;color:#000;">      
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
   $http.get('/phoenix/public/telegram_group_api')
   .then(function (response) {$scope.names = response.data.telegram_group;});
});
</script>
@include('navigation.p_footer')
