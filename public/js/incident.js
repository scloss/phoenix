function show_related_tickets(id){
	var idName = "#related_tickets_"+id;
	var easingDiv = "#easingDiv_"+id;
	// $(idName).toggle();
		$(easingDiv).slideToggle(350);
		$(idName).slideToggle();
		$(easingDiv).slideToggle(350);
	// if(className == "glyphicon glyphicon-chevron-up"){
	// 	$(spanId).removeClass("glyphicon glyphicon-chevron-up");
	// 	$(spanId).addClass('glyphicon glyphicon-chevron-down');
	// }
	// else{
	// 	$(spanId).removeClass("glyphicon glyphicon-chevron-down");
	// 	$(spanId).addClass("glyphicon glyphicon-chevron-up");
	// }

}

$(document).ready(function(){

	$("#ticket_time_from").datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss'
			});
	$("#ticket_time_to").datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss'
			});
	$("#ticket_closing_time_from").datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss'
			});
	$("#ticket_closing_time_to").datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss'
			});
	$("#escalation_time").datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss'
			});
	$("#event_time").datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss'
			});

	$( ".related_class" ).each(function() {
	  	$("#"+this.id).hide();
	});
		
	// var count=0;
	// $('input[type=text]').each(function(){
	//     if(count <10){
	// 		alert($(this).attr("name"));
	// 		count++;
	// 	}
	// });
	// $('#form').find(':input').each(function(){
	//   if(count <10){
	// 		alert($(this).attr("name"));
	// 		count++;
	// 	}
	// })
	// alert(count);
	// $("#related_tickets_10").hide();
	// $("#related_tickets_12").hide();
	// $("#datetimepicker2").datetimepicker({});

	// $('#testDiv').hide();


	// $('#related_tickets_10').hide();
	// $('#related_tickets_12').hide();
	// $("#datetimepicker1").datetimepicker();
	// $("#datetimepicker2").datetimepicker();
	// $("#datetimepicker3").datetimepicker();
	// $("#datetimepicker4").datetimepicker();

	// $('#10').click(function(){
	//     $('#testDiv').slideToggle(350);
	// 	$('#related_tickets_10').slideToggle();
	// 	$('#testDiv').slideToggle(350);
	// });
});
