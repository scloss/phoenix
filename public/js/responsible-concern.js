var responsibleConcerns='';

function responsiblefunction(id,value){
		responsibleValues = id;
		var responsibleValuesArr = responsibleValues.split('--');
		var responsibleNameId = responsibleValuesArr[0];
	  	var responsibleName = responsibleValuesArr[1];
	  	var district = responsibleValuesArr[2];
	  	var region = responsibleValuesArr[3];
	  	var smsGroup = responsibleValuesArr[4];
		 
		//alert(id_value);
	  	window.opener.document.forms['tt_create_form'].responsibles['responsible_name'+id_value].value = responsibleName+'('+responsibleNameId+')';

	  
	  	window.close();
}