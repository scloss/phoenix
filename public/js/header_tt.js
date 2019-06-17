function incident_insert(id){
	$.post("IncidentCartInsert",
 	{
        added_ticket_id: id,
    } 
 	,function(data, status){
	     
	});
	setTimeout(function () {
	  $( "#incident_box" ).load( "refreshCart", function() {
		  // alert( "Load was performed." );
		});
	  $( "#incident_box_merge" ).load( "refreshIncidentMerge", function() {
		  // alert( "Load was performed." );
		});
	}, 500);
	
}
function incident_delete(id){
 	$.post("IncidentCartDelete",
 	{
        added_ticket_id: id,
    } 
 	,function(data, status){
	     
	});
	setTimeout(function () {

	  $( "#incident_box" ).load( "refreshCart", function() {
		  // alert( "Load was performed." );
		});
	  $( "#incident_box_merge" ).load( "refreshIncidentMerge", function() {
		  // alert( "Load was performed." );
		});
	  
	}, 500);
	
}
setInterval(function(){ 
	$( "#notification_box" ).load( "refreshNotification", function() {
	});
}, 60000);