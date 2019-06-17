$(document).ready(function(){

	// $("#escalation_time").datetimepicker({
	// 	format: 'YYYY-MM-DD HH:mm:ss'
	// });
	$("#event_time").datetimepicker({
		format: 'YYYY-MM-DD HH:mm:ss'
	});
	// $("#escalation_time_to").datetimepicker({
	// 	format: 'YYYY-MM-DD HH:mm:ss'
	// });
	$("#event_time_to").datetimepicker({
		format: 'YYYY-MM-DD HH:mm:ss'
	});

	$("#clear_time").datetimepicker({
		format: 'YYYY-MM-DD HH:mm:ss'
	});
	$("#clear_time_to").datetimepicker({
		format: 'YYYY-MM-DD HH:mm:ss'
	});

});

function elementListFunction(id){


		var idArr = id.split('_');

		var idTemp = idArr[2];

		var element_type_id = 'element_type';
		var client_id_id = 'client_id';

  		element_type =document.getElementsByName(element_type_id)[0].value;
  		client_id =document.getElementsByName(client_id_id)[0].value;

  		window.open('/phoenix/public/ElementView?element_type='+element_type+'&client_id='+client_id+'&id=fault_search_form');


	}



	var elementValues='';

// function elementfunction(id,value,id_value){
		
// 			elementValues = id;
// 			//alert(id);
// 			if(id_value =='fault_search_form'){
// 				var elementValuesArr = elementValues.split('--');
// 				var elementName = elementValuesArr[0];
// 			  	var elementNameId = elementValuesArr[1];
// 			  	var district = elementValuesArr[2];
// 			  	var region = elementValuesArr[3];
// 			  	var smsGroup = elementValuesArr[4];
// 			  	var vendor = elementValuesArr[5];
		  	

// 		  		//alert(elementValuesArr[8]);
				
// 			  	//window.opener.document.forms['tt_create_form'].elements['element_name_'+id_value].value = elementName;
// 			  	// window.opener.document.forms['tt_create_form'].elements['element_id_'+id_value].value = elementNameId;
// 			  	// window.opener.document.forms['tt_create_form'].elements['district_'+id_value].value = district;
// 			  	// window.opener.document.forms['tt_create_form'].elements['region_'+id_value].value = region;
// 			  	// window.opener.document.forms['tt_create_form'].elements['sms_group_'+id_value].value = smsGroup;
// 			  	// window.opener.document.forms['tt_create_form'].elements['responsible_vendor_'+id_value].value = vendor;
// 			  	if(elementType == 'link'){
// 			  		var vlanId = elementValuesArr[7];
// 			  		var linkId = elementValuesArr[6];
// 			  		window.opener.document.forms[id_value].elements['element_name'].value = elementName;
// 			  		var showValue = elementValuesArr[9];
// 			  		//alert(showValue);
// 					if(!showValue){
// 						window.close();
// 					}
// 			  	}
// 			  	else{
// 			  		var siteIpAddress = elementValuesArr[6];
// 			  		window.opener.document.forms[id_value].elements['element_name'].value = elementName;
// 			  		var showValue = elementValuesArr[7];
// 			  		//alert(showValue);
// 					if(!showValue){
// 						window.close();
// 					}
// 			  	}

// 			}
// 			else{
// 				var elementValuesArr = elementValues.split('--');
// 				var elementName = elementValuesArr[0];
// 			  	var elementNameId = elementValuesArr[1];
// 			  	var district = elementValuesArr[2];
// 			  	var region = elementValuesArr[3];
// 			  	var smsGroup = elementValuesArr[4];
// 			  	var vendor = elementValuesArr[5];
		  	

// 		  		//alert(elementValuesArr[8]);
				
// 			  	//window.opener.document.forms['tt_create_form'].elements['element_name_'+id_value].value = elementName;
// 			  	window.opener.document.forms['tt_create_form'].elements['element_id_'+id_value].value = elementNameId;
// 			  	window.opener.document.forms['tt_create_form'].elements['district_'+id_value].value = district;
// 			  	window.opener.document.forms['tt_create_form'].elements['region_'+id_value].value = region;
// 			  	window.opener.document.forms['tt_create_form'].elements['sms_group_'+id_value].value = smsGroup;
// 			  	window.opener.document.forms['tt_create_form'].elements['responsible_vendor_'+id_value].value = vendor;
// 			  	if(elementType == 'link'){
// 			  		var vlanId = elementValuesArr[7];
// 			  		var linkId = elementValuesArr[6];
// 			  		window.opener.document.forms['tt_create_form'].elements['element_name_'+id_value].value = elementName+','+elementValuesArr[8];
// 			  		window.opener.document.forms['tt_create_form'].elements['vlan_id_'+id_value].value = vlanId;
// 			  		window.opener.document.forms['tt_create_form'].elements['link_id_'+id_value].value = linkId;
// 			  		var showValue = elementValuesArr[9];
// 			  		//alert(showValue);
// 					if(!showValue){
// 						window.close();
// 					}
// 			  	}
// 			  	else{
// 			  		var siteIpAddress = elementValuesArr[6];
// 			  		window.opener.document.forms['tt_create_form'].elements['element_name_'+id_value].value = elementName;
// 			  		window.opener.document.forms['tt_create_form'].elements['site_ip_address_'+id_value].value = siteIpAddress;
// 			  		var showValue = elementValuesArr[7];
// 			  		//alert(showValue);
// 					if(!showValue){
// 						window.close();
// 					}
// 			  	}

// 			}
			
			  
			  	
	  		
// }