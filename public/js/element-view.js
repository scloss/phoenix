var elementValues='';

function elementfunction(id,value){

			
		
			elementValues = id;
			var elementValuesArr = elementValues.split('--');
			var elementName = elementValuesArr[0];
		  	var elementNameId = elementValuesArr[1];
		  	var district = elementValuesArr[2];
		  	var region = elementValuesArr[3];
		  	var smsGroup = elementValuesArr[4];
		  	var vendor = elementValuesArr[5];
		  	

		  		//alert(elementValuesArr[8]);
				
			  	//window.opener.document.forms['tt_create_form'].elements['element_name_'+id_value].value = elementName;
			  	
			  	if(elementType == 'link'){
			  		
			  		var ticket_id = elementValuesArr[10];
			  		var old_ticket_problem_category = elementValuesArr[11];
			  		var new_ticket_problem_category = elementValuesArr[12];


			  		var is_valid = "yes";
			  		if (old_ticket_problem_category != null || old_ticket_problem_category != ""){
			  			var old_problems_array = old_ticket_problem_category.split(",");
			  			for(let i = 0; i < old_problems_array.length; i++){
			  				if(old_problems_array[i] == new_ticket_problem_category){
			  					var is_valid = "no";
			  					break;
			  				}
			  			}
			  				
			  		}  

			  		




			  		
					if(is_valid == "yes"){
						window.opener.document.forms['tt_create_form'].elements['element_id_'+id_value].value = elementNameId;
					  	window.opener.document.forms['tt_create_form'].elements['district_'+id_value].value = district;
					  	window.opener.document.forms['tt_create_form'].elements['region_'+id_value].value = region;
					  	window.opener.document.forms['tt_create_form'].elements['sms_group_'+id_value].value = smsGroup;
					  	window.opener.document.forms['tt_create_form'].elements['responsible_vendor_'+id_value].value = vendor;
						var vlanId = elementValuesArr[7];
				  		var linkId = elementValuesArr[6];
				  		window.opener.document.forms['tt_create_form'].elements['element_name_'+id_value].value = elementName+','+elementValuesArr[8];
				  		window.opener.document.forms['tt_create_form'].elements['vlan_id_'+id_value].value = vlanId;
				  		window.opener.document.forms['tt_create_form'].elements['link_id_'+id_value].value = linkId;
				  		window.opener.document.forms['tt_create_form'].elements['subcenter_'+id_value].value = elementValuesArr[9];
				  		window.opener.document.forms['tt_create_form'].elements['fault_'+id_value+'_task_1_subcenter_names'].value = elementValuesArr[9];

				  		//window.opener.document.forms['tt_create_form'].elements['problem_category_'+id_value].value = new_ticket_problem_category;

				  		//window.opener.document.forms['tt_create_form'].elements['problem_category_'+id_value].disabled = true;
				  		
				  		var assigned_dept = '';
				  		if(region == 'Regional Implementation & Operations 1'){
				  			assigned_dept = 11;
				  		}
				  		if(region == 'Regional Implementation & Operations 2'){
				  			assigned_dept = 12;
				  		}
				  		if(region == 'Regional Implementation & Operations 3'){
				  			assigned_dept = 46;
				  		}
				  		if(region == 'Regional Implementation & Operations 4'){
				  			assigned_dept = 47;
				  		}

				  		//alert(old_ticket_problem_category);
			  			//alert(new_ticket_problem_category);
				  		window.opener.document.forms['tt_create_form'].elements['fault_'+id_value+'_task_1_assigned_dept'].value = assigned_dept;
						//alert('window close');
						window.close();
					}
			  	}
			  	else{
			  		
			  		var showValue = elementValuesArr[8];
					var old_ticket_problem_category = elementValuesArr[9];
					var new_ticket_problem_category = elementValuesArr[10];
			  
					// alert(old_ticket_problem_category);
					// alert(new_ticket_problem_category);
					var is_valid = "yes";
					if (old_ticket_problem_category != null || old_ticket_problem_category != "") {
						  var old_problems_array = old_ticket_problem_category.split(",");
						  for (let i = 0; i < old_problems_array.length; i++) {
							  if (old_problems_array[i] == new_ticket_problem_category) {
								  var is_valid = "no";
								  break;
							  }
						  }
			  
					}
					//alert(is_valid);
					


					//if(!showValue){
					if(is_valid == "yes"){


						window.opener.document.forms['tt_create_form'].elements['element_id_'+id_value].value = elementNameId;
					  	window.opener.document.forms['tt_create_form'].elements['district_'+id_value].value = district;
					  	window.opener.document.forms['tt_create_form'].elements['region_'+id_value].value = region;
					  	window.opener.document.forms['tt_create_form'].elements['sms_group_'+id_value].value = smsGroup;
					  	window.opener.document.forms['tt_create_form'].elements['responsible_vendor_'+id_value].value = vendor;
				  		var siteIpAddress = elementValuesArr[6];
				  		window.opener.document.forms['tt_create_form'].elements['element_name_'+id_value].value = elementName;
				  		window.opener.document.forms['tt_create_form'].elements['site_ip_address_'+id_value].value = siteIpAddress;
				  		window.opener.document.forms['tt_create_form'].elements['subcenter_'+id_value].value = elementValuesArr[7];
				  		window.opener.document.forms['tt_create_form'].elements['fault_'+id_value+'_task_1_subcenter_names'].value = elementValuesArr[7];
				  		var assigned_dept = '';
				  		if(region == 'Regional Implementation & Operations 1'){
				  			assigned_dept = 11;
				  		}
				  		if(region == 'Regional Implementation & Operations 2'){
				  			assigned_dept = 12;
				  		}
				  		if(region == 'Regional Implementation & Operations 3'){
				  			assigned_dept = 46;
				  		}
				  		if(region == 'Regional Implementation & Operations 4'){
				  			assigned_dept = 47;
				  		}
				  		window.opener.document.forms['tt_create_form'].elements['fault_'+id_value+'_task_1_assigned_dept'].value = assigned_dept;
						//alert('window close');
						window.close();
					}
			  	}
			  	
	  		
}