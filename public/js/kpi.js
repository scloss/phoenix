$(document).ready(function(){
	$("#event_time_from").datetimepicker({
		defaultDate: new Date(),
		ignoreReadonly: true,
		format: 'YYYY-MM-DD HH:mm:ss'
	});
	$("#event_time_to").datetimepicker({
		defaultDate: new Date(),
		ignoreReadonly: true,
		format: 'YYYY-MM-DD HH:mm:ss'
	});
});

function changeFunction(){
	//alert('changed');
	var element_name  =  document.getElementsByName('element_name')[0].value;
	//alert(element_name);
	var vlan_id  =  document.getElementsByName('vlan_id')[0].value;
	var link_id  =  document.getElementsByName('link_id')[0].value;
	var site_ip_address  =  document.getElementsByName('site_ip_address')[0].value;
	if(vlan_id != '' || element_name != '' || link_id != '' || site_ip_address != ''){
		$('.element_type').attr('required', true);
	}
	if(vlan_id == '' && element_name == '' && link_id == '' && site_ip_address == ''){
		$('.element_type').attr('required', false);
	}
}

function elementScript(){
	var client_id = document.getElementsByName('client_id')[0].value;
	var element_type = document.getElementsByName('element_type')[0].value;
	var id= 1;

	if(client_id =='' && element_type ==''){
		alert('Please Insert Client ID and Element Type');
		return false;
	}
	if(client_id ==''){
		alert('Please Insert Client ID');
		return false;
	}
	if(element_type ==''){
		alert('Please Insert Element Type');
		return false;
	}
	window.open('KpiElementView?element_type='+element_type+'&client_id='+client_id+'&id='+id,'_blank');
  		

    
}
function responsibleScript(id){
	window.open('KpiResponsibleConcernView?id='+id,'_blank');
  		

    
}