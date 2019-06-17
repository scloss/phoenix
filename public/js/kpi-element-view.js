var elementValues='';

function elementfunction(id,value){		
	elementValues = id;
	var elementValuesArr = elementValues.split('--');
	var elementName = elementValuesArr[0];
  	var elementNameId = elementValuesArr[1];
	window.opener.document.forms['fault_search'].elements['element_name'].value = elementName;

	window.opener.document.forms['fault_search'].elements['element_name'].value = elementName;
	window.opener.document.forms['fault_search'].elements['element_id'].value = elementNameId;

	window.close();
			  			  		  		
}