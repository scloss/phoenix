var divCounter = 0;/* this counter track the div count after dynamically adding fault and deleting fault*/

$(document).ready(function(){
	addFault();
    $('.client_id').change(function() {
     	var id = $(this).val();
       	$('#client_priority').val(client_arr[id]); 
    });

    $(".keydownDisabled").keydown(function(e){
        e.preventDefault();
    });

});

function tt_create_form_submit(){

	//check whether browser fully supports all File API
	if( document.getElementById("ticket_files").files.length != 0 ){

		if (window.File && window.FileReader && window.FileList && window.Blob)
		{
	        //get the file size and file type from file input field
	        var fsize = $('#ticket_files')[0].files[0].size;
	        
	        if(fsize>20971520) //do something if file size more than 1 mb (1048576)
	        {
	        	alert(fsize +" bites\nToo big!");
	        }else{
	        	alert("Your file size is"+fsize +"bites\n. Do you want to submit");
	        }
    	}
    	else{
    	alert("Please upgrade your browser, because your current browser lacks some new features we need!");
    	}

	}



	//alert('asdf');
	/***************VALIDATION UPDATE BEFORE SUBMITTING FORM*********************************/
	for(var i=1;i<(divCounter+1);i++){
		var element_type_temp_val = $('.element_type_'+i).val();
		if(element_type_temp_val == 'link'){
			document.getElementById('site_ip_address_'+i).required = false;
			document.getElementById('vlan_id_'+i).required = true;
			document.getElementById('link_id_'+i).required = true;
		}
		if(element_type_temp_val == 'site'){
			document.getElementById('vlan_id_'+i).required = false;
			document.getElementById('link_id_'+i).required = false;
			document.getElementById('site_ip_address_'+i).required = true;
		}
	}
	/****************************************************************************************/
	var hasDuplicate = false;
	var dupTestArray = new Array();
	for(var j=1;j<(divCounter+1);j++){
		try{
			var et = document.getElementsByClassName('element_type_'+j);
			var strEt = et[0].options[et[0].selectedIndex].text;		
			dupTestArray[j] = document.getElementById('element_id_'+j).value+'--'+strEt;
		}
		catch(err){
			
		}
	}
	hasDuplicate = hasDuplicates(dupTestArray);
	if(hasDuplicate == true){
		alert('Multiple faults have same element id and name');		
	}
	else{

		var submitButton = document.getElementById('submit-button');		
		//submitButton.click();
		//alert(divCounter);
		var errorStr0 = 'Mentioned fields crossed character limit.Please make it short';
		var errorStr = '';
		for(var i=1;i<=divCounter;i++){
			if(lengthValidator('client_side_impact_'+i,2000) == false){
				var val = document.getElementById('client_side_impact_'+i).value;
				errorStr += '  (Fault '+i+' : Client Side Impact ['+val.length+']),';
			}
			if(lengthValidator('provider_side_impact_'+i,700) == false){
				var val = document.getElementById('provider_side_impact_'+i).value;
				errorStr += '  (Fault '+i+' : Provider Side Impact ['+val.length+']),';
			}
			if(lengthValidator('remarks_'+i,4800) == false){
				var val = document.getElementById('remarks_'+i).value;
				errorStr += '  (Fault '+i+' : Remarks ['+val.length+']),';
			}
			var taskCounts = document.getElementById('fault_'+i+'_task_counter').value;

			if(taskCounts > 0){
				for(var j=1;j<=taskCounts;j++){
					if(lengthValidator('fault_'+i+'_task_'+j+'_description',2000) == false){
						var val = document.getElementById('fault_'+i+'_task_'+j+'_description').value;
						errorStr += '  (Fault '+i+' Task '+j+': Task Description ['+val.length+']),';
					}
					if(lengthValidator('fault_'+i+'_task_'+j+'_description',2000) == false){
						var val = document.getElementById('fault_'+i+'_task_'+j+'_description').value;
						errorStr += '  (Fault '+i+' Task '+j+': Task Comment ['+val.length+']),';
					}
				}
			}
		}
		var errStr = errorStr0 + errorStr;
		if(errorStr !=''){
			alert(errStr);
		}
		else{
			//alert('submit');
			submitButton.click();
		}
		

	}
	//alert(hasDuplicate);
	
}
function hasDuplicates(array) {
    var valuesSoFar = Object.create(null);
    for (var i = 1; i < array.length; ++i) {
        var value = array[i];
        
    	if (value in valuesSoFar) {
        	return true;
    	}
        
        
        valuesSoFar[value] = true;
    }
    return false;
}

function lengthValidator(id,limit){
	//alert(id);
	try{
		var val = document.getElementById(id).value;
		//alert(val.length);
		if(val.length > limit){
			return false;
		}
		else{
			return true;
		}
	}
	catch(ex){
		return true;
	}
	

}
/*****************************CREATE CLIENT ID SELECT FROM CLIENT TABLE**********************************/
function createClientIdSelect(classObject){
	var opt = document.createElement('option');
	    opt.value = "";
	    opt.innerHTML = "";
	    classObject.appendChild(opt);
	for(var i = 0; i<=client_js_arr.length; i++){
	    var opt = document.createElement('option');
	    var tempValue = client_js_arr[i];
	    try {
		    var tempArr = tempValue.split('--');
		    opt.value = tempArr[0];
		    opt.innerHTML = tempArr[1];
		    classObject.appendChild(opt);
	    }
	    catch(err){
	    }
	}
}
/**********************************************************************************************************/
function createElementTypeSelect(classObject){
	var opt = document.createElement('option');
	    opt.value = "";
	    opt.innerHTML = "";
	    classObject.appendChild(opt);
	var opt = document.createElement('option');
	opt.value = 'link';
	opt.innerHTML = 'Link';
	classObject.appendChild(opt);

	var opt2 = document.createElement('option');
	opt2.value = 'site';
	opt2.innerHTML = 'Site';
	classObject.appendChild(opt2);
}
function addFault(){
	divCounter++;

	var tempPreviousValue = $("#hidden_fault_ids").val();
	tempPreviousValue += divCounter+',';
	$("#hidden_fault_ids").val(tempPreviousValue);

	dynamicDivName = 'dynamic_div_'+divCounter;
	var parentDiv = document.getElementById("tt_form_div");
	var form = document.getElementById("tt_create_form");

	var dynamicMasterDiv = elementGenerator("col-md-12",'',dynamicDivName,'div','');
	var section = elementGenerator("widget",'',"default-widget",'section','');
	var header = elementGenerator('','','','header','');
	faultHeaderName = 'fault_header_id_'+divCounter;
	var h4 = elementGenerator('','',faultHeaderName,'h3','');
	var faultName = "Fault "+divCounter;
	var textNode = document.createTextNode(faultName);  
	h4.appendChild(textNode);

	var widgetControlsDropdown = elementGenerator("widget-controls dropdown",'','','div','')
	var cog = elementGenerator("dropdown-toggle",'','','a','');
	cog.setAttribute("data-toggle",'dropdown');
	var icon = elementGenerator("fa fa-cog",'','','i','');	
	var dropMenuRight = elementGenerator('dropdown-menu dropdown-menu-right','','','ul','');

	var linkAddName = 'linkAdd_'+divCounter;
	var listAdd = elementGenerator("listAdd",'','','li','');
	var linkAdd = elementGenerator("linkAdd",'','','a','');
	linkAdd.setAttribute("href", 'javascript:void();');
	linkAdd.setAttribute("onclick", 'addFault('+divCounter+')');
	var linkAddTextNode = document.createTextNode('ADD');
	linkAdd.appendChild(linkAddTextNode);

	var linkAddTaskName = 'linkAddTask_'+divCounter;
	var listAddTask = elementGenerator("listkAddTask_",'','','li','');
	var linkAddTask = elementGenerator("linkAddTask_",'','','a','');
	linkAddTask.setAttribute("href", 'javascript:void();');
	linkAddTask.setAttribute("onclick", 'addFaultTask('+divCounter+')');
	var linkAddTaskTextNode = document.createTextNode('ADD Task');
	linkAddTask.appendChild(linkAddTaskTextNode);

	var linkCopyName = 'linkCopy_'+divCounter;
	var listCopy = elementGenerator("listCopy",'','','li','');
	var linkCopy = elementGenerator(linkCopyName,'','','a','');
	linkCopy.setAttribute("href", 'javascript:void();');
	linkCopy.setAttribute("onclick", 'copyFault('+divCounter+')');
	var linkCopyTextNode = document.createTextNode('COPY');
	linkCopy.appendChild(linkCopyTextNode);

	if(divCounter != 1){
		var linkDeleteName = 'linkDelete_'+divCounter;
		var listDelete = elementGenerator("listDelete",'','','li','');
		var linkDelete = elementGenerator(linkDeleteName,'','','a','');
		linkDelete.setAttribute("href", 'javascript:void();');
		linkDelete.setAttribute("onclick", 'DeleteFault('+divCounter+')');
		var linkDeleteTextNode = document.createTextNode('Delete');
		linkDelete.appendChild(linkDeleteTextNode);
	}

	var dynamicDiv = elementGenerator("body",'','','div','');
	var dynamicDivInnerRow = elementGenerator("row",'','','div','');
	var dynamicDivInnerColMod = elementGenerator("col-md-3",'','','div','');
	var dynamicDivInnerTable = elementGenerator('','','','table','');
	var dditTableBody = elementGenerator('','','','tbody','');


/**************Tr***Client ID************************************************************************/	
	clientIdSelectElementGenerator(dditTableBody,'client_id_','Client Name');
/**********************************************************************************************************/

/**************Tr***Element Type*******START*******************************************************************/
	var dditTrElementType = elementGenerator('','','','tr','');
	var dditTrTdElementType = elementGenerator('','','','td','');
	var ElementTypeTextNode = document.createTextNode('Element Type');
	var dditTrTdElementTypeValue = elementGenerator('','','','td','');
	var dditTrTdDivElementType = elementGenerator("ui-widget",'','','div','');
	var dditTrTdLabelElementType = elementGenerator('','','','label','');
	dditTrTdLabelElementType.setAttribute("style", 'float:left');
	var elementTypeName = 'element_type_'+divCounter;
	var dditTrTdElementTypeSelect = elementGenerator(elementTypeName,elementTypeName,'select_style','select','');
	dditTrTdLabelElementType.appendChild(dditTrTdElementTypeSelect);
	dditTrTdElementTypeSelect.setAttribute("onchange","onChangeElement("+divCounter+")");
	createElementTypeSelect(dditTrTdElementTypeSelect);

	dditTrTdDivElementType.appendChild(dditTrTdLabelElementType);
	dditTrTdElementType.appendChild(ElementTypeTextNode);
	dditTrElementType.appendChild(dditTrTdElementType);
	dditTrTdElementTypeValue.appendChild(dditTrTdDivElementType);
	dditTrElementType.appendChild(dditTrTdElementTypeValue);
	dditTableBody.appendChild(dditTrElementType);
/***********************************************************************************************************/

/**************Tr***Element Name************START**************************************************************/
	var dditTrElementName = elementGenerator('','','','tr','');
	var dditTrTdElementName = elementGenerator('','','','td','');
	var ElementNameTextNode = document.createTextNode('Element Name');
	var dditTrTdElementNameValue = elementGenerator('','','','td','');
	var dditTrTdDivElementName = elementGenerator("ui-widget",'','','div','');
	var elementNameName = 'element_name_'+divCounter;
	var dditTrTdElementNameALink = elementGenerator(elementNameName,elementNameName,'','a','');
	dditTrTdElementNameALink.setAttribute("href", 'javascript:void();');
	dditTrTdElementNameALink.setAttribute("onclick", 'elementScript('+divCounter+')');

	//dditTrTdElementNameALink.setAttribute('href',"Javascript:elementScript('"+divCounter+"')");
	var dditTrTdElementNameTextarea = elementGenerator('form-control input-transparent keydownDisabled',elementNameName,elementNameName,'textarea','');
	//dditTrTdElementNameTextarea.readOnly = true;
	dditTrTdElementNameALink.appendChild(dditTrTdElementNameTextarea);
	dditTrTdDivElementName.appendChild(dditTrTdElementNameALink);
	dditTrTdElementName.appendChild(ElementNameTextNode);
	dditTrElementName.appendChild(dditTrTdElementName);
	dditTrTdElementNameValue.appendChild(dditTrTdDivElementName);
	dditTrElementName.appendChild(dditTrTdElementNameValue);
	dditTableBody.appendChild(dditTrElementName);
/***********************************************************************************************************/
	
	hiddenInputElementGenerator('Element ID','element_id_',dditTableBody);

	inputElementGenerator('VLAN ID','vlan_id_',dditTableBody);
	inputElementGenerator('Link ID','link_id_',dditTableBody);
	inputElementGenerator('Site Ip Address','site_ip_address_',dditTableBody);
	faultStatusSelectElementGenerator(dditTableBody);


	dynamicDivInnerTable.appendChild(dditTableBody);
	dynamicDivInnerColMod.appendChild(dynamicDivInnerTable);
	dynamicDivInnerRow.appendChild(dynamicDivInnerColMod);
	var dynamicDivInnerColMod = elementGenerator("col-md-3",'','','div','');
	var dynamicDivInnerTable = elementGenerator('','','','table','');
	var dditTableBody = elementGenerator('','','','tbody','');


	inputElementGenerator('District','district_',dditTableBody);
	inputElementGenerator('Region','region_',dditTableBody);
	textareaElementGenerator('SMS Group','sms_group_',dditTableBody);
	inputElementGenerator('Client Priority','client_priority_',dditTableBody);
	textareaElementGenerator('Client Side Impact','client_side_impact_',dditTableBody);
	linkTypeSelectElementGenerator(dditTableBody);

	dynamicDivInnerTable.appendChild(dditTableBody);
	dynamicDivInnerColMod.appendChild(dynamicDivInnerTable);
	dynamicDivInnerRow.appendChild(dynamicDivInnerColMod);
	var dynamicDivInnerColMod = elementGenerator("col-md-3",'','','div','');
	var dynamicDivInnerTable = elementGenerator('','','','table','');
	var dditTableBody = elementGenerator('','','','tbody','');

	inputElementGenerator('Responsible Field Team','responsible_field_team_',dditTableBody);
	clientIdSelectElementGenerator(dditTableBody,'provider_','Provider');
	reasonSelectElementGenerator(dditTableBody);
	issueTypeSelectElementGenerator(dditTableBody);
	problemCategorySelectElementGenerator(dditTableBody);
	problemSourceSelectElementGenerator(dditTableBody);
	inputElementGenerator('Responsible Vendor','responsible_vendor_',dditTableBody);

	dynamicDivInnerTable.appendChild(dditTableBody);
	dynamicDivInnerColMod.appendChild(dynamicDivInnerTable);
	dynamicDivInnerRow.appendChild(dynamicDivInnerColMod);
	var dynamicDivInnerColMod = elementGenerator("col-md-3",'','','div','');
	var dynamicDivInnerTable = elementGenerator('','','','table','');
	var dditTableBody = elementGenerator('','','','tbody','');


/*******************TR**ESCALATION TIME**********START*****************************************/
	var dditTrEscalationTime = elementGenerator('','','','tr','');
	var dditTrTdEscalationTime = elementGenerator('','','','td','');
	var EscalationTimeTextNode = document.createTextNode('Escalation Time');
	var dditTrTdEscalationTimeValue = elementGenerator('','','','td','');
	var TempEscalationTime= 'escalation_time_'+divCounter;
	var dditTrTdDivEscalationTime = elementGenerator("input-group",'',TempEscalationTime,'div','');
	var dditTrTdEscalationTimeText = elementGenerator('form-control input-transparent',TempEscalationTime,'datepicker2i','input','');
	dditTrTdEscalationTimeText.setAttribute('type','text');
	// dditTrTdEscalationTimeText.readOnly = true;
	var dditTrTdSpan= elementGenerator('input-group-addon btn btn-info','','','span','');
	var dditTrTdSpanInner= elementGenerator('glyphicon glyphicon-calendar','','','span','');

	dditTrTdSpan.appendChild(dditTrTdSpanInner);
	dditTrTdDivEscalationTime.appendChild(dditTrTdEscalationTimeText);
	dditTrTdDivEscalationTime.appendChild(dditTrTdSpan);
	dditTrTdEscalationTime.appendChild(EscalationTimeTextNode);
	dditTrEscalationTime.appendChild(dditTrTdEscalationTime);
	dditTrTdEscalationTimeValue.appendChild(dditTrTdDivEscalationTime);
	dditTrEscalationTime.appendChild(dditTrTdEscalationTimeValue);
	dditTableBody.appendChild(dditTrEscalationTime);
/*****************************************************************************************/	

/**************Tr***RESPONSIBLE CONCERN************START**************************************************************/
	var dditTrResponsibleConcern = elementGenerator('','','','tr','');
	var dditTrTdResponsibleConcern = elementGenerator('','','','td','');
	var ResponsibleConcernTextNode = document.createTextNode('Responsible Concern');
	var dditTrTdResponsibleConcernValue = elementGenerator('','','','td','');
	var dditTrTdDivResponsibleConcern = elementGenerator("ui-widget",'','','div','');
	var ResponsibleConcernName = 'responsible_concern_'+divCounter;
	var dditTrTdResponsibleConcernALink = elementGenerator(ResponsibleConcernName,ResponsibleConcernName,'','a','');
	dditTrTdResponsibleConcernALink.setAttribute('href',"#");
	dditTrTdResponsibleConcernALink.setAttribute('onclick',"responsibleScript('"+ResponsibleConcernName+"')");
	var dditTrTdResponsibleConcernTextarea = elementGenerator('form-control input-transparent keydownDisabled',ResponsibleConcernName,ResponsibleConcernName,'textarea','');
	//dditTrTdResponsibleConcernTextarea.readOnly = true;
	dditTrTdResponsibleConcernALink.appendChild(dditTrTdResponsibleConcernTextarea);
	dditTrTdDivResponsibleConcern.appendChild(dditTrTdResponsibleConcernALink);
	dditTrTdResponsibleConcern.appendChild(ResponsibleConcernTextNode);
	dditTrResponsibleConcern.appendChild(dditTrTdResponsibleConcern);
	dditTrTdResponsibleConcernValue.appendChild(dditTrTdDivResponsibleConcern);
	dditTrResponsibleConcern.appendChild(dditTrTdResponsibleConcernValue);
	dditTableBody.appendChild(dditTrResponsibleConcern);
/***********************************************************************************************************/

/*******************TR**EVENT TIME*******************START********************************/
	var dditTrEventTime = elementGenerator('','','','tr','');
	var dditTrTdEventTime = elementGenerator('','','','td','');
	var EventTimeTextNode = document.createTextNode('Event Time');
	var dditTrTdEventTimeValue = elementGenerator('','','','td','');
	var TempEventTime= 'event_time_'+divCounter;
	var dditTrTdDivEventTime = elementGenerator("input-group",'',TempEventTime,'div','');
	var dditTrTdEventTimeText = elementGenerator('form-control input-transparent',TempEventTime,'datepicker2i','input','');
	dditTrTdEventTimeText.setAttribute('type','text');
	var dditTrTdSpan= elementGenerator('input-group-addon btn btn-info','','','span','');
	var dditTrTdSpanInner= elementGenerator('glyphicon glyphicon-calendar','','','span','');

	dditTrTdSpan.appendChild(dditTrTdSpanInner);
	dditTrTdDivEventTime.appendChild(dditTrTdEventTimeText);
	dditTrTdDivEventTime.appendChild(dditTrTdSpan);
	dditTrTdEventTime.appendChild(EventTimeTextNode);
	dditTrEventTime.appendChild(dditTrTdEventTime);
	dditTrTdEventTimeValue.appendChild(dditTrTdDivEventTime);
	dditTrEventTime.appendChild(dditTrTdEventTimeValue);
	dditTableBody.appendChild(dditTrEventTime);
/*****************************************************************************************/	
	
	textareaElementGenerator('Provider Side Impact','provider_side_impact_',dditTableBody);
	textareaElementGenerator('Remarks','remarks_',dditTableBody);
	

	listAdd.appendChild(linkAdd);
	listCopy.appendChild(linkCopy);
	listAddTask.appendChild(linkAddTask);
	if(divCounter != 1){
		listDelete.appendChild(linkDelete);
	}
	dropMenuRight.appendChild(listAdd);
	dropMenuRight.appendChild(listCopy);
	dropMenuRight.appendChild(listAddTask);
	if(divCounter != 1){
		dropMenuRight.appendChild(listDelete);
	}
/**************Header START************************************/
	widgetControlsDropdown.appendChild(dropMenuRight);
	cog.appendChild(icon);
	widgetControlsDropdown.appendChild(cog);
	header.appendChild(widgetControlsDropdown);
	header.appendChild(h4);
	section.appendChild(header);
/**************Header END************************************/

	dynamicDivInnerTable.appendChild(dditTableBody);
	dynamicDivInnerColMod.appendChild(dynamicDivInnerTable);
	dynamicDivInnerRow.appendChild(dynamicDivInnerColMod);
	dynamicDiv.appendChild(dynamicDivInnerRow);
	section.appendChild(dynamicDiv);

	header.style.zIndex = "10";

	var staticTableObject = document.getElementById('ticket_static_table');
	addFaultHiddenForTaskIds(staticTableObject);
	addFaultHiddenCounterForTasks(staticTableObject);
	
	dynamicMasterDiv.appendChild(section);
	taskDivGenerator(dynamicMasterDiv,divCounter);
	form.appendChild(dynamicMasterDiv);
	parentDiv.appendChild(form);

	


	// alert(TempEscalationTime);
	// alert(TempEventTime);
	//alert(divCounter);
	$.getScript("js/bootstrap-datetimepicker.min.js", function(){
		try{
			$("#"+TempEscalationTime).datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss'
			});
			$("#"+TempEventTime).datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss'
			});
			for(var i=1;i<divCounter+1;i++){
				for(var j=1;j<20;j++){
					var tempIdStart = "#"+'fault_'+i+'_task_'+j+'_start_time';
					var tempIdEnd = "#"+'fault_'+i+'_task_'+j+'_end_time';
					$(tempIdStart).datetimepicker({
						format: 'YYYY-MM-DD HH:mm:ss'
					});
					$(tempIdEnd).datetimepicker({
						format: 'YYYY-MM-DD HH:mm:ss'
					});
				}
				
				// alert('asdf');
			}
		
		}
		catch(Exception){

		}
	});
	
	$('.client_id_'+divCounter).change(function(){
     	var id = $(this).val();
       $('#client_priority_'+divCounter).val(client_arr[id]); 
    });
    
    
    resetFaultHeader();

    $(".keydownDisabled").keydown(function(e){
        e.preventDefault();
    });

}

function addFaultHiddenForTaskIds(appendParentObj){
	var tempName = 'fault_'+divCounter+'_task_hidden_ids';
	var tempHiddenField = elementGenerator('form-control input-transparent',tempName,tempName,'input','');
	tempHiddenField.setAttribute('type','hidden');
	tempHiddenField.setAttribute('value','0');
	appendParentObj.appendChild(tempHiddenField);
}
function addFaultHiddenCounterForTasks(appendParentObj){
	var tempName = 'fault_'+divCounter+'_task_counter';
	var tempHiddenField = elementGenerator('form-control input-transparent',tempName,tempName,'input','');
	tempHiddenField.setAttribute('type','hidden');
	tempHiddenField.setAttribute('value','0');
	appendParentObj.appendChild(tempHiddenField);
}

function copyFault(previousId){
	addFault();
/*************************CLIENT ID SET PREVIOUS VALUE**************START*************************************/
	try
	{
		var indexNumber = $(".client_id_"+previousId).find(":selected").index();
		var tempOption = 'client_id_'+divCounter+' option';
		$("."+tempOption)[indexNumber].selected = true;
	}
	catch(Exception){

	}


	
/********************************************************************************************************/	

/*************************ELEMENT TYPE SET PREVIOUS VALUE**************START************************************/
	var indexNumber1 = $(".element_type_"+previousId).val();
	var tempOption1 = 'element_type_'+divCounter;
	$('[name='+tempOption1+'] option').filter(function() { 
    	return ($(this).val() == indexNumber1);
	}).prop('selected', true);
/********************************************************************************************************/	

// /*************************ELEMENT NAME SET PREVIOUS VALUE**************START*************************************/
// 	var tempPreviousValue = $("#element_name_"+previousId).val();
// 	var tempId = 'element_name_'+divCounter;
// 	$('#'+tempId).val(tempPreviousValue);
// /********************************************************************************************************/	

// /*************************VLAN ID SET PREVIOUS VALUE********************START*******************************/
// 	var tempPreviousValue = $("#vlan_id_"+previousId).val();
// 	var tempId = 'vlan_id_'+divCounter;
// 	$('#'+tempId).val(tempPreviousValue);
// /********************************************************************************************************/	

// /*************************LINK ID SET PREVIOUS VALUE*********************START******************************/
// 	var tempPreviousValue = $("#link_id_"+previousId).val();
// 	var tempId = 'link_id_'+divCounter;
// 	$('#'+tempId).val(tempPreviousValue);
// /********************************************************************************************************/	

// /*************************SITE IP ADDRESS SET PREVIOUS VALUE****************START***********************************/
// 	var tempPreviousValue = $("#site_ip_address_"+previousId).val();
// 	var tempId = 'site_ip_address_'+divCounter;
// 	$('#'+tempId).val(tempPreviousValue);
// /********************************************************************************************************/	

// /*************************DISTRICT SET PREVIOUS VALUE*******************START********************************/
// 	var tempPreviousValue = $("#district_"+previousId).val();
// 	var tempId = 'district_'+divCounter;
// 	$('#'+tempId).val(tempPreviousValue);
// /********************************************************************************************************/	

// /*************************DISTRICT SET PREVIOUS VALUE*******************START********************************/
// 	var tempPreviousValue = $("#region_"+previousId).val();
// 	var tempId = 'region_'+divCounter;
// 	$('#'+tempId).val(tempPreviousValue);
// /********************************************************************************************************/	

// /*************************SMS GROUP SET PREVIOUS VALUE********************START*******************************/
// 	var tempPreviousValue = $("#sms_group_"+previousId).val();
// 	var tempId = 'sms_group_'+divCounter;
// 	$('#'+tempId).val(tempPreviousValue);
// /********************************************************************************************************/	

// /*************************PROBLEM SOURCE SET PREVIOUS VALUE***************************************************/
// 	var tempPreviousValue = $("#problem_source_"+previousId).val();
// 	var tempId = 'problem_source_'+divCounter;
// 	$('#'+tempId).val(tempPreviousValue);
// /********************************************************************************************************/

// /*************************CLIENT PRIORITY SET PREVIOUS VALUE***************START************************************/
// 	var tempPreviousValue = $("#client_priority_"+previousId).val();
// 	var tempId = 'client_priority_'+divCounter;
// 	$('#'+tempId).val(tempPreviousValue);
// /********************************************************************************************************/

/*************************CLIENT PRIORITY SET PREVIOUS VALUE*****************START**********************************/
	var tempPreviousValue = $("#client_side_impact_"+previousId).val();
	var tempId = 'client_side_impact_'+divCounter;
	$('#'+tempId).val(tempPreviousValue);
/********************************************************************************************************/

/*************************RESPONSIBLE FIELD TEAM SET PREVIOUS VALUE***********START****************************************/
	var tempPreviousValue = $("#responsible_field_team_"+previousId).val();
	var tempId = 'responsible_field_team_'+divCounter;
	$('#'+tempId).val(tempPreviousValue);
/********************************************************************************************************/

/*************************PROVIDER SET PREVIOUS VALUE*********************START******************************/
	try{
		var indexNumber = $(".provider_"+previousId).find(":selected").index();
		var tempOption = 'provider_'+divCounter+' option';
		$("."+tempOption)[indexNumber].selected = true;
	}
	catch(exception){

	}
/********************************************************************************************************/	

/*************************REASON SET PREVIOUS VALUE************************START***************************/
	var indexNumber = $(".reason_"+previousId).val();
	var tempOption = 'reason_'+divCounter;
	$('[name='+tempOption+'] option').filter(function() { 
    	return ($(this).val() == indexNumber);
	}).prop('selected', true);
/********************************************************************************************************/	

/*************************REASON SET PREVIOUS VALUE***********************START****************************/
	var indexNumber = $(".issue_type_"+previousId).val();
	var tempOption = 'issue_type_'+divCounter;
	$('[name='+tempOption+'] option').filter(function() { 
    	return ($(this).val() == indexNumber);
	}).prop('selected', true);
/********************************************************************************************************/	

/*************************PROBLEM CATEGORY PREVIOUS VALUE*********************START******************************/
	var indexNumber = $(".problem_category_"+previousId).val();
	var tempOption = 'problem_category_'+divCounter;
	$('[name='+tempOption+'] option').filter(function() { 
    	return ($(this).val() == indexNumber);
	}).prop('selected', true);
/********************************************************************************************************/	

/*************************PROBLEM SOURCE PREVIOUS VALUE**********************START*****************************/
	var indexNumber = $(".problem_source_"+previousId).val();
	var tempOption = 'problem_source_'+divCounter;
	$('[name='+tempOption+'] option').filter(function() { 
    	return ($(this).val() == indexNumber);
	}).prop('selected', true);
/********************************************************************************************************/	

/*************************RESPONSIBLE VENDOR TEAM SET PREVIOUS VALUE************START***************************************/
	// var tempPreviousValue = $("#responsible_vendor_"+previousId).val();
	// var tempId = 'responsible_vendor_'+divCounter;
	// $('#'+tempId).val(tempPreviousValue);
/********************************************************************************************************/

/*************************ESCALATION TIME SET PREVIOUS VALUE**************************START*************************/
	var tempPreviousValue = document.getElementsByName("escalation_time_"+previousId)[0].value;
	var tempId = 'escalation_time_'+divCounter;
	document.getElementsByName(tempId)[0].value = tempPreviousValue;
/********************************************************************************************************/

/*************************RESPONSIBLE CONCERN SET PREVIOUS VALUE*********************START******************************/
	var tempPreviousValue = $("#responsible_concern_"+previousId).val();
	var tempId = 'responsible_concern_'+divCounter;
	$('#'+tempId).val(tempPreviousValue);
/********************************************************************************************************/

/*************************EVENT TIME SET PREVIOUS VALUE******************************START*********************/
	var tempPreviousValue =  document.getElementsByName("event_time_"+previousId)[0].value;
	var tempId = 'event_time_'+divCounter;
	document.getElementsByName(tempId)[0].value = tempPreviousValue;
/********************************************************************************************************/

/*************************PROVIDER SIDE IMPACT SET PREVIOUS VALUE*****************START**********************************/
	var tempPreviousValue = $("#provider_side_impact_"+previousId).val();
	var tempId = 'provider_side_impact_'+divCounter;
	$('#'+tempId).val(tempPreviousValue);
/********************************************************************************************************/

/*************************REMARKS SET PREVIOUS VALUE*******************************START**************************/
	var tempPreviousValue = $("#remarks_"+previousId).val();
	var tempId = 'remarks_'+divCounter;
	$('#'+tempId).val(tempPreviousValue);
/**********************************************************************************************************/

/*************************FAULT STATUS SET PREVIOUS VALUE**************************START*************************/
	var indexNumber = $(".fault_status_"+previousId).val();
	var tempOption = 'fault_status_'+divCounter;
	$('[name='+tempOption+'] option').filter(function() { 
    	return ($(this).val() == indexNumber);
	}).prop('selected', true);
/********************************************************************************************************/	

/*************************LINK TYPE SET PREVIOUS VALUE******************************START*********************/
	var indexNumber = $(".link_type_"+previousId).val();
	var tempOption = 'link_type_'+divCounter;
	$('[name='+tempOption+'] option').filter(function() { 
    	return ($(this).val() == indexNumber);
	}).prop('selected', true);
/********************************************************************************************************/	

// /*************************Element  SET PREVIOUS VALUE******************************START*********************/
// 	var tempPreviousValue = $("#element_id_"+previousId).val();
// 	var tempId = 'element_id_'+divCounter;
// 	$('#'+tempId).val(tempPreviousValue);
// /********************************************************************************************************/	

	
	$('.client_id_'+divCounter).change(function() {
     	var id = $(this).val();
       $('#client_priority_'+divCounter).val(client_arr[id]);
    });
}

function DeleteFault(previousId){
	var elem = document.getElementById("dynamic_div_"+previousId);
 	elem.parentElement.removeChild(elem);
 	var tempPreviousValue = $("#hidden_fault_ids").val();
 	var res = tempPreviousValue.split(",");
 	var tempVal = previousId+',';
 	var tempVal = tempPreviousValue.replace(tempVal, "");
 	$("#hidden_fault_ids").val(tempVal);	
 	resetFaultHeader();
}

function resetFaultHeader(){
	var newId = 2;
 	for(var i=2;i<=divCounter;i++){	
 		var faultId = document.getElementById('fault_header_id_'+i);
 		if(faultId){
 		$("#"+'fault_header_id_'+i).text('Fault '+newId);
 			newId++;
 		}
 	}
}

function elementGenerator(className,name,id,type,value){
	var ele = document.createElement(type);
	if(className != ''){
		ele.setAttribute("class", className);
	}
	if(id != ''){
		ele.setAttribute("id", id);
	}
	if(name != ''){
		ele.setAttribute("name", name);
	}
	if(value != ''){
		ele.setAttribute("value", value);
	}
	ele.setAttribute("required", '');
	return ele;
}
function taskDivGenerator(dynamicMasterDiv,divCounter){
	var taskCounterName = 'fault_'+divCounter+'_task_counter';
	var taskCounter = document.getElementById(taskCounterName).value;
	taskCounter = parseInt(taskCounter)+1;

	var dynamicMainTaskDiv = elementGenerator('row','','mainTaskDiv_'+taskCounter,'div','');
	var dynamicLeftDiv = elementGenerator("col-md-1",'','leftDiv','div','');
	var dynamicMediumDiv = elementGenerator("col-md-10",'','taskDiv','div','');
	var dynamicRightDiv = elementGenerator("col-md-1",'','rightsDiv','div','');
	var section = elementGenerator("widget",'',"default-widget",'section','');
	var dynamicTaskTable = elementGenerator('','','','table','');
	var dditTaskTableBody = elementGenerator('','','','tbody','');

	
	
	taskGenerator(divCounter,dditTaskTableBody);
	dynamicTaskTable.appendChild(dditTaskTableBody);
	section.appendChild(dynamicTaskTable);
	dynamicMediumDiv.appendChild(section);
	dynamicMainTaskDiv.appendChild(dynamicLeftDiv);
	dynamicMainTaskDiv.appendChild(dynamicMediumDiv);
	dynamicMainTaskDiv.appendChild(dynamicRightDiv);
	dynamicMasterDiv.appendChild(dynamicMainTaskDiv);
	//alert('asdf');
}

function addFaultTask(divCounter){
	$.getScript("js/bootstrap-datetimepicker.min.js", function(){
	   	var staticTableObject = document.getElementById('ticket_static_table');
		var dynamicMasterDiv = document.getElementById('dynamic_div_'+divCounter);
		var tempIdStart ='';
		var tempIdEnd = '';
		taskDivGenerator(dynamicMasterDiv,divCounter);
		var taskCounterName = 'fault_'+divCounter+'_task_counter';
		var taskCounter = document.getElementById(taskCounterName).value;
		taskCounter = parseInt(taskCounter);

		tempIdStart = 'fault_'+divCounter+'_task_'+taskCounter+'_start_time';					 
		tempIdEnd= 'fault_'+divCounter+'_task_'+taskCounter+'_end_time';
		datePick(tempIdStart);
		datePick(tempIdEnd);
	});
}
function datePick(id){
	$("#"+id).datetimepicker({
		ignoreReadonly: true,
		format: 'YYYY-MM-DD HH:mm:ss'
	});
}
// function addFaultTask(divCounter){
// 	var staticTableObject = document.getElementById('ticket_static_table');
// 	var dynamicMasterDiv = document.getElementById('dynamic_div_'+divCounter);
// 	var tempIdStart ='';
// 	var tempIdEnd = '';
// 	taskDivGenerator(dynamicMasterDiv,divCounter);
// 	setTimeout(function(){
// 		var taskCounterName = 'fault_'+divCounter+'_task_counter';
// 		var taskCounter = document.getElementById(taskCounterName).value;
// 		taskCounter = parseInt(taskCounter);
// 				//alert('taskcounter '+taskCounter);
// 				// for(var j=1;j<5;j++){
// 					// alert(j);
// 					tempIdStart = 'fault_'+divCounter+'_task_'+taskCounter+'_start_time';
					 
// 					tempIdEnd= 'fault_'+divCounter+'_task_'+taskCounter+'_end_time';
// 					 if(document.getElementById(tempIdStart) !== null){
// 					    alert("Element exists");
// 					} else {
// 					    alert("Element does not exist");
// 					}

// 					$("#"+tempIdStart).datetimepicker();
// 					// alert(tempIdStart+'datetimepicker');
// 					$("#"+tempIdEnd).datetimepicker();
// 					// alert(tempIdEnd+'datetimepicker');
// 					//alert(tempIdStart);

// 	}, 1000);
// 	// try{
// 	// 	for(var i=1;i<divCounter+1;i++){
// 			// try{
				
					
// 				//}
// 	// 		}
// 	// 		catch(exception){

// 	// 		}
// 	// 	}
// 	// }
// 	// catch(exception){

// 	// }
// }

function taskGenerator(divCounter,dditTaskTableBody){
	addHiddenTaskId(divCounter); 

	var taskCounterName = 'fault_'+divCounter+'_task_counter';
	var taskCounter = document.getElementById(taskCounterName).value;

	var header = elementGenerator('','','','header','');
	faultHeaderName = 'fault_header_id_'+divCounter;
	var h5 = elementGenerator('','',faultHeaderName,'h3','');
	var faultName = "Task";
	var textNode = document.createTextNode(faultName);  
	h5.appendChild(textNode);

	var widgetControlsDropdown = elementGenerator("widget-controls dropdown",'','','div','')
	var cog = elementGenerator("dropdown-toggle",'','','a','');
	cog.setAttribute("data-toggle",'dropdown');
	var icon = elementGenerator("fa fa-cog",'','','i','');	
	var dropMenuRight = elementGenerator('dropdown-menu dropdown-menu-right','','','ul','');

	var linkDeleteTaskName = 'linkDeleteTask_'+divCounter;
	var listDeleteTask = elementGenerator("listDeleteTask",'','','li','');
	var linkDeleteTask = elementGenerator("linkDeleteTask",'','','a','');
	linkDeleteTask.setAttribute("href", 'javascript:void();');
	if(taskCounter == '1'){
		linkDeleteTask.setAttribute("onclick", '');
	}
	else{
		linkDeleteTask.setAttribute("onclick", 'deleteTask('+divCounter+','+taskCounter+')');
	}
	
	var linkDeleteTextNode = document.createTextNode('Delete');
	linkDeleteTask.appendChild(linkDeleteTextNode);
	listDeleteTask.appendChild(linkDeleteTask);


	/***************************23 Jan 2018**************************************/

	var linkCopyTaskName = 'linkCopyTask_'+divCounter;
	var listCopyTask = elementGenerator("listCopyTask",'','','li','');
	var linkCopyTask = elementGenerator("linkCopyTask",'','','a','');
	linkCopyTask.setAttribute("href", 'javascript:void();');
	
	linkCopyTask.setAttribute("onclick", 'copyTask('+divCounter+','+taskCounter+')');
	
	
	var linkCopyTextNode = document.createTextNode('Copy');
	linkCopyTask.appendChild(linkCopyTextNode);
	listCopyTask.appendChild(linkCopyTask);


	var linkPasteTaskName = 'linkPasteTask_'+divCounter;
	var listPasteTask = elementGenerator("listPasteTask",'','','li','');
	var linkPasteTask = elementGenerator("linkPasteTask",'','','a','');
	linkPasteTask.setAttribute("href", 'javascript:void();');
	
	linkPasteTask.setAttribute("onclick", 'pasteTask('+divCounter+','+taskCounter+')');
	
	
	var linkPasteTextNode = document.createTextNode('Paste');
	linkPasteTask.appendChild(linkPasteTextNode);
	listPasteTask.appendChild(linkPasteTask);

	if(taskCounter != '1'){
		dropMenuRight.appendChild(listDeleteTask);
	}
	dropMenuRight.appendChild(listCopyTask);
	dropMenuRight.appendChild(listPasteTask);
	/*********************************************************************************/



	widgetControlsDropdown.appendChild(dropMenuRight);
	cog.appendChild(icon);
	widgetControlsDropdown.appendChild(cog);	
	header.appendChild(h5);
	header.appendChild(widgetControlsDropdown);
	


	dditTaskTableBody.appendChild(header);

	var headerTr = elementGenerator('','','','tr','');

	var tdHeader = elementGenerator('','','','td','');
	var headerTextNode = document.createTextNode('Task Name');
	tdHeader.appendChild(headerTextNode);
	headerTr.appendChild(tdHeader);

	var tdHeader = elementGenerator('','','','td','');
	var headerTextNode = document.createTextNode('Task Description');
	tdHeader.appendChild(headerTextNode);
	headerTr.appendChild(tdHeader);

	var tdHeader = elementGenerator('','','','td','');
	var headerTextNode = document.createTextNode('Assigned Department');
	tdHeader.appendChild(headerTextNode);
	headerTr.appendChild(tdHeader);

	var tdHeader = elementGenerator('','','','td','');
	var headerTextNode = document.createTextNode('Subcenter/Subsection');
	tdHeader.appendChild(headerTextNode);
	headerTr.appendChild(tdHeader);

	var tdHeader = elementGenerator('','','','td','');
	var headerTextNode = document.createTextNode('Task Start Time');
	tdHeader.appendChild(headerTextNode);
	headerTr.appendChild(tdHeader);

	var tdHeader = elementGenerator('','','','td','');
	var headerTextNode = document.createTextNode('Responsible Concern');
	tdHeader.appendChild(headerTextNode);
	headerTr.appendChild(tdHeader);

	var tdHeader = elementGenerator('','','','td','');
	var headerTextNode = document.createTextNode('Task End Time');

	// tdHeader.appendChild(headerTextNode);
	// headerTr.appendChild(tdHeader);

	var tdHeader = elementGenerator('','','','td','');
	var headerTextNode = document.createTextNode('Task Comment');
	tdHeader.appendChild(headerTextNode);
	headerTr.appendChild(tdHeader);

	var tdHeader = elementGenerator('','','','td','');
	var headerTextNode = document.createTextNode('Task Resolver');
	// tdHeader.appendChild(headerTextNode);
	// headerTr.appendChild(tdHeader);

	dditTaskTableBody.appendChild(headerTr);

	var taskCounterName = 'fault_'+divCounter+'_task_counter';
	var taskCounter = document.getElementById(taskCounterName).value;
	// /alert(taskCounter);
	var taskName = 'fault_'+divCounter+'_task_'+taskCounter+'_name';
	taskTitleSelectElementGenerator('Task Name',taskName,dditTaskTableBody);
	var taskDescription = 'fault_'+divCounter+'_task_'+taskCounter+'_description';
	textareaElementGenerator('Task Description',taskDescription,dditTaskTableBody);
	var assignedDept = 'fault_'+divCounter+'_task_'+taskCounter+'_assigned_dept';
	assignedDeptSelectElementGenerator('Assigned Dept',assignedDept,dditTaskTableBody);
	var subcenterNames = 'fault_'+divCounter+'_task_'+taskCounter+'_subcenter_names';	
	subcenterSelectElementGenerator('Subcenter',subcenterNames,dditTaskTableBody);

	/*******************Task**Start Time**********START*****************************************/
	var dditTrTdTaskStartTimeValue = elementGenerator('','','','td','');
	var taskStartTimeName = 'fault_'+divCounter+'_task_'+taskCounter+'_start_time';
	var dditTrTdDivTaskStartTime = elementGenerator("input-group",'',taskStartTimeName,'div','');
	var dditTrTdTaskStartTimeText = elementGenerator('form-control input-transparent',taskStartTimeName,'datepicker2i','input','');
	dditTrTdTaskStartTimeText.setAttribute('type','text');
	var dditTrTdSpan= elementGenerator('input-group-addon btn btn-info','','','span','');
	var dditTrTdSpanInner= elementGenerator('glyphicon glyphicon-calendar','','','span','');

	dditTrTdSpan.appendChild(dditTrTdSpanInner);
	dditTrTdDivTaskStartTime.appendChild(dditTrTdTaskStartTimeText);
	dditTrTdDivTaskStartTime.appendChild(dditTrTdSpan);
	dditTrTdTaskStartTimeValue.appendChild(dditTrTdDivTaskStartTime);
	dditTaskTableBody.appendChild(dditTrTdTaskStartTimeValue);

	/*******************Task**End Time**********START*****************************************/
	var dditTrTdTaskEndTime = elementGenerator('','','','td','');
	var TaskEndTimeTextNode = document.createTextNode('Task End Time');
	var dditTrTdTaskEndTimeValue = elementGenerator('','','','td','');
	var taskEndTimeName = 'fault_'+divCounter+'_task_'+taskCounter+'_end_time';
	var dditTrTdDivTaskEndTime = elementGenerator("input-group",'',taskEndTimeName,'div','');
	var dditTrTdTaskEndTimeText = elementGenerator('form-control input-transparent',taskEndTimeName,'datepicker2i','input','');
	dditTrTdTaskEndTimeText.setAttribute('type','text');
	var dditTrTdSpan= elementGenerator('input-group-addon btn btn-info','','','span','');
	var dditTrTdSpanInner= elementGenerator('glyphicon glyphicon-calendar','','','span','');

	// dditTrTdSpan.appendChild(dditTrTdSpanInner);
	// dditTrTdDivTaskEndTime.appendChild(dditTrTdTaskEndTimeText);
	// dditTrTdDivTaskEndTime.appendChild(dditTrTdSpan);
	// dditTrTdTaskEndTimeValue.appendChild(dditTrTdDivTaskEndTime);
	// dditTaskTableBody.appendChild(dditTrTdTaskEndTimeValue);


/**************Tr***RESPONSIBLE CONCERN**************************************************************************/
	//var dditTrResponsibleConcern = elementGenerator('','','','tr','');
	//var dditTrTdResponsibleConcern = elementGenerator('','','','td','');
	//var ResponsibleConcernTextNode = document.createTextNode('Responsible Concern');
	var dditTrTdResponsibleConcernValue = elementGenerator('','','','td','');
	var dditTrTdDivResponsibleConcern = elementGenerator("ui-widget",'','','div','');

	var ResponsibleConcernName ='fault_'+divCounter+'_task_'+taskCounter+'_responsible_concern';
	var dditTrTdResponsibleConcernALink = elementGenerator(ResponsibleConcernName,ResponsibleConcernName,'','a','');
	dditTrTdResponsibleConcernALink.setAttribute('href',"#");
	dditTrTdResponsibleConcernALink.setAttribute('onclick',"responsibleScript('"+ResponsibleConcernName+"')");
	var dditTrTdResponsibleConcernTextarea = elementGenerator('form-control input-transparent keydownDisabled',ResponsibleConcernName,ResponsibleConcernName,'textarea','');
	//dditTrTdResponsibleConcernTextarea.readOnly = true;
	dditTrTdResponsibleConcernALink.appendChild(dditTrTdResponsibleConcernTextarea);
	dditTrTdDivResponsibleConcern.appendChild(dditTrTdResponsibleConcernALink);
	//dditTrTdResponsibleConcern.appendChild(ResponsibleConcernTextNode);
	//dditTrResponsibleConcern.appendChild(dditTrTdResponsibleConcern);
	dditTrTdResponsibleConcernValue.appendChild(dditTrTdDivResponsibleConcern);

	//dditTrTdResponsibleConcern.appendChild(dditTrTdResponsibleConcernValue);
	dditTaskTableBody.appendChild(dditTrTdResponsibleConcernValue);
/***********************************************************************************************************/


	var taskComment = 'fault_'+divCounter+'_task_'+taskCounter+'_comment';
	textareaElementGenerator('Task Comment',taskComment,dditTaskTableBody);

	var taskResolver = 'fault_'+divCounter+'_task_'+taskCounter+'_resolver';

	var dditTrTdTaskResolver = elementGenerator('','','','td','');
	var TaskResolverTextNode = document.createTextNode('Task Resolver');
	var dditTrTdTaskResolverValue = elementGenerator('','','','td','');
	var dditTrTdDivTaskResolver = elementGenerator("ui-widget",'','','div','');
	var dditTrTdTaskResolverALink = elementGenerator(taskResolver,taskResolver,'','a','');
	dditTrTdTaskResolverALink.setAttribute('href',"#");
	dditTrTdTaskResolverALink.setAttribute('onclick',"responsibleScript('"+taskResolver+"')");
	var dditTrTdTaskResolverTextarea = elementGenerator('form-control input-transparent',taskResolver,taskResolver,'textarea','');




	// dditTrTdTaskResolverALink.appendChild(dditTrTdTaskResolverTextarea);
	// dditTrTdDivTaskResolver.appendChild(dditTrTdTaskResolverALink);
	// dditTrTdTaskResolver.appendChild(TaskResolverTextNode);
	// dditTrTdTaskResolverValue.appendChild(dditTrTdDivTaskResolver);
	// dditTaskTableBody.appendChild(dditTrTdTaskResolverValue);



}

function deleteTask(faultId,taskId){
	var faultElem = document.getElementById('dynamic_div_'+faultId);
	var elem = document.getElementById("mainTaskDiv_"+taskId);
 	faultElem.removeChild(elem);
 	var taskHiddenValues = '#fault_'+faultId+'_task_hidden_ids';
 	var tempPreviousValue = $(taskHiddenValues).val();
 	var res = tempPreviousValue.split(",");
 	var tempVal = ','+taskId;
 	var tempVal = tempPreviousValue.replace(tempVal, "");
 	$(taskHiddenValues).val(tempVal);	
 	//resetTaskHeader();
}

/*****************************************************23 Jan 2018*********************************/
function copyTask(faultId,taskId){
	var taskNameStr = 'fault_'+faultId+'_task_'+taskId+'_name';
	var taskName = document.getElementsByName(taskNameStr)[0].value;
	document.getElementById('taskName').value = taskName;

	var taskDescriptionStr = 'fault_'+faultId+'_task_'+taskId+'_description';
	var taskDescription = document.getElementsByName(taskDescriptionStr)[0].value;
	document.getElementById('taskDescription').value = taskDescription;

	var taskAssignedDeptStr = 'fault_'+faultId+'_task_'+taskId+'_assigned_dept';
	var taskAssignedDept = document.getElementsByName(taskAssignedDeptStr)[0].value;
	document.getElementById('taskAssignedDept').value = taskAssignedDept;

	var taskSubcenterStr = 'fault_'+faultId+'_task_'+taskId+'_subcenter_names';
	var taskSubcenter = document.getElementsByName(taskSubcenterStr)[0].value;
	document.getElementById('taskSubcenter').value = taskSubcenter;

	var taskStartTimeStr = 'fault_'+faultId+'_task_'+taskId+'_start_time';
	var taskStartTime = document.getElementsByName(taskStartTimeStr)[0].value;
	document.getElementById('taskStartTime').value = taskStartTime;

	var taskResponsibleConcernStr = 'fault_'+faultId+'_task_'+taskId+'_responsible_concern';
	var taskResponsibleConcern = document.getElementById(taskResponsibleConcernStr).value;
	document.getElementById('taskResponsibleConcern').value = taskResponsibleConcern;

	var taskCommentStr = 'fault_'+faultId+'_task_'+taskId+'_comment';
	var taskComment = document.getElementsByName(taskCommentStr)[0].value;
	document.getElementById('taskComment').value = taskComment;

}

function pasteTask(faultId,taskId){
	var taskNameStr = 'fault_'+faultId+'_task_'+taskId+'_name';
	var taskName = document.getElementById('taskName').value;
	$('[name='+taskNameStr+'] option').filter(function() { 
    	return ($(this).val() == taskName);
	}).prop('selected', true);


	var taskDescriptionStr = 'fault_'+faultId+'_task_'+taskId+'_description';
	var taskDescription = document.getElementById('taskDescription').value;
	document.getElementById(taskDescriptionStr).value = taskDescription;

	var taskAssignedDeptStr = 'fault_'+faultId+'_task_'+taskId+'_assigned_dept';
	var taskAssignedDept = document.getElementById('taskAssignedDept').value;
	$('[name='+taskAssignedDeptStr+'] option').filter(function() { 
    	return ($(this).val() == taskAssignedDept);
	}).prop('selected', true);

	var taskSubcenterStr = 'fault_'+faultId+'_task_'+taskId+'_subcenter_names';
	var taskSubcenter = document.getElementById('taskSubcenter').value;
	$('[name='+taskSubcenterStr+'] option').filter(function() { 
    	return ($(this).val() == taskSubcenter);
	}).prop('selected', true);

	var taskStartTimeStr = 'fault_'+faultId+'_task_'+taskId+'_start_time';
	var taskStartTime = document.getElementById('taskStartTime').value;
	document.getElementsByName(taskStartTimeStr)[0].value = taskStartTime;

	var taskResponsibleConcernStr = 'fault_'+faultId+'_task_'+taskId+'_responsible_concern';
	var taskResponsibleConcern = document.getElementById('taskResponsibleConcern').value;
	document.getElementById(taskResponsibleConcernStr).value = taskResponsibleConcern;

	var taskCommentStr = 'fault_'+faultId+'_task_'+taskId+'_comment';
	var taskComment = document.getElementById('taskComment').value;
	document.getElementById(taskCommentStr).value = taskComment;


}
/***************************************************************************************************/
function addHiddenTaskId(divCounter){
	var taskCounterName = 'fault_'+divCounter+'_task_counter';
	var taskName = 'fault_'+divCounter+'_task_hidden_ids';
	var taskCounterStr = document.getElementById(taskCounterName).value;
	var taskCounter = parseInt(taskCounterStr);
	document.getElementById(taskCounterName).value = taskCounter+1;
	document.getElementById(taskName).value += ','+(taskCounter+1);
}

function inputElementGenerator(textNode,id,tableObject){
	var checkTaskExists = textNode.includes("Task");
	//var checkReadonlyExists = textNode."VLAN ID");
	// var checkReadonlyExists = textNoincludes(de.includes("LINK ID");
	// var checkReadonlyExists = textNode.includes("Site Ip Address");
	// var checkReadonlyExists = textNode.includes("District");
	// var checkReadonlyExists = textNode.includes("Region");
	// var checkReadonlyExists = textNode.includes("SMS Group");
	// var checkReadonlyExists = textNode.includes("Client Priority");
	if(checkTaskExists == true){
		var TempElementName = id;
	}
	else{
		var TempElementName = id+divCounter;
		var dditTrTempElement= elementGenerator('','','','tr','');	
		var dditTrTdTempElement = elementGenerator('','','','td','');
		var TempElementTextNode = document.createTextNode(textNode);	
	}

	var dditTrTdTempElementValue = elementGenerator('','','','td','');
	var dditTrTdDivTempElement = elementGenerator("ui-widget",'','','div','');
	
	var dditTrTdTempElementTextarea = elementGenerator('form-control input-transparent',TempElementName,TempElementName,'input','');
	dditTrTdTempElementTextarea.setAttribute('type','text');
	if(textNode == 'VLAN ID' || textNode == 'Link ID' || textNode == 'Site Ip Address' || textNode == 'District' || textNode == 'Region' || textNode == 'SMS Group' || textNode == 'Client Priority'){
		dditTrTdTempElementTextarea.readOnly = true;
		//alert(textNode);
	}
	dditTrTdDivTempElement.appendChild(dditTrTdTempElementTextarea);
	
	if(checkTaskExists == true){
		dditTrTdTempElementValue.appendChild(dditTrTdDivTempElement);
		tableObject.appendChild(dditTrTdTempElementValue);
	}
	else{
		dditTrTdTempElement.appendChild(TempElementTextNode);
		dditTrTempElement.appendChild(dditTrTdTempElement);
		dditTrTdTempElementValue.appendChild(dditTrTdDivTempElement);
		dditTrTempElement.appendChild(dditTrTdTempElementValue);
		tableObject.appendChild(dditTrTempElement);
	}
	
}

function hiddenInputElementGenerator(textNode,id,tableObject){
	var dditTrTempElement= elementGenerator('','','','tr','');
	dditTrTempElement.setAttribute("style", 'display:none');
	var dditTrTdTempElement = elementGenerator('','','','td','');
	// var TempElementTextNode = document.createTextNode(textNode);
	var dditTrTdTempElementValue = elementGenerator('','','','td','');
	var dditTrTdDivTempElement = elementGenerator("ui-widget",'','','div','');
	var TempElementName = id+divCounter;
	var dditTrTdTempElementTextarea = elementGenerator('form-control input-transparent',TempElementName,TempElementName,'input','');
	dditTrTdTempElementTextarea.setAttribute('type','hidden');

	dditTrTdDivTempElement.appendChild(dditTrTdTempElementTextarea);
	// dditTrTdTempElement.appendChild(TempElementTextNode);
	dditTrTempElement.appendChild(dditTrTdTempElement);
	dditTrTdTempElementValue.appendChild(dditTrTdDivTempElement);
	dditTrTempElement.appendChild(dditTrTdTempElementValue);
	tableObject.appendChild(dditTrTempElement);
}

function textareaElementGenerator(textNode,id,tableObject){
	var checkTaskExists = textNode.includes("Task");
	if(checkTaskExists == true){
		var TempElementName = id;
	}
	else{
		var TempElementName = id+divCounter;
		var dditTrTempElement= elementGenerator('','','','tr','');	
		var dditTrTdTempElement = elementGenerator('','','','td','');
		var TempElementTextNode = document.createTextNode(textNode);	
	}

	var dditTrTdTempElementValue = elementGenerator('','','','td','');
	var dditTrTdDivTempElement = elementGenerator("ui-widget",'','','div','');
	var dditTrTdTempElementTextarea = elementGenerator('form-control input-transparent',TempElementName,TempElementName,'textarea','');
	if(textNode == 'SMS Group'){
		dditTrTdTempElementTextarea.readOnly = true;
	}
	dditTrTdDivTempElement.appendChild(dditTrTdTempElementTextarea);
	
	if(checkTaskExists == true){
		dditTrTdTempElementValue.appendChild(dditTrTdDivTempElement);
		tableObject.appendChild(dditTrTdTempElementValue);
	}
	else{
		dditTrTdTempElement.appendChild(TempElementTextNode);
		dditTrTempElement.appendChild(dditTrTdTempElement);
		dditTrTdTempElementValue.appendChild(dditTrTdDivTempElement);
		dditTrTempElement.appendChild(dditTrTdTempElementValue);
		tableObject.appendChild(dditTrTempElement);
	}
}

function reasonSelectElementGenerator(tableObject){
	var dditTr = elementGenerator('','','','tr','');
	var dditTrTdTempElement = elementGenerator('','','','td','');
	var TempElementTextNode = document.createTextNode('Reason');
	var dditTrTdTempElementValue = elementGenerator('','','','td','');
	var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
	var dditTrTdLabel = elementGenerator('','','','label','');
	dditTrTdLabel.setAttribute("style", 'float:left;');
	var TempElementName = 'reason_'+divCounter;
	var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
	dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
	createReasonElementSelect(dditTrTdTempElementSelect);

	dditTrTdDiv.appendChild(dditTrTdLabel);
	dditTrTdTempElement.appendChild(TempElementTextNode);
	dditTr.appendChild(dditTrTdTempElement);
	dditTrTdTempElementValue.appendChild(dditTrTdDiv);
	dditTr.appendChild(dditTrTdTempElementValue);
	tableObject.appendChild(dditTr);
}

function issueTypeSelectElementGenerator(tableObject){
	var dditTr = elementGenerator('','','','tr','');
	var dditTrTdTempElement = elementGenerator('','','','td','');
	var TempElementTextNode = document.createTextNode('Issue Type');
	var dditTrTdTempElementValue = elementGenerator('','','','td','');
	var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
	var dditTrTdLabel = elementGenerator('','','','label','');
	dditTrTdLabel.setAttribute("style", 'float:left;');
	var TempElementName = 'issue_type_'+divCounter;
	var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
	dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
	createIssueTypeElementSelect(dditTrTdTempElementSelect);

	dditTrTdDiv.appendChild(dditTrTdLabel);
	dditTrTdTempElement.appendChild(TempElementTextNode);
	dditTr.appendChild(dditTrTdTempElement);
	dditTrTdTempElementValue.appendChild(dditTrTdDiv);
	dditTr.appendChild(dditTrTdTempElementValue);
	tableObject.appendChild(dditTr);
}
function assignedDeptSelectElementGenerator(textnode,id,tableObject){
	// var dditTr = elementGenerator('','','','tr','');
	// var dditTrTdTempElement = elementGenerator('','','','td','');
	// var TempElementTextNode = document.createTextNode(textnode);
	var dditTrTdTempElementValue = elementGenerator('','','','td','');
	var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
	var dditTrTdLabel = elementGenerator('','','','label','');
	dditTrTdLabel.setAttribute("style", 'float:left;');
	var TempElementName = id;
	var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
	dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
	createAssignedDeptElementSelect(dditTrTdTempElementSelect);

	dditTrTdDiv.appendChild(dditTrTdLabel);
	// dditTrTdTempElement.appendChild(TempElementTextNode);
	// dditTr.appendChild(dditTrTdTempElement);
	dditTrTdTempElementValue.appendChild(dditTrTdDiv);
	// dditTr.appendChild(dditTrTdTempElementValue);
	// tableObject.appendChild(dditTrTdTempElement);
	tableObject.appendChild(dditTrTdTempElementValue);
}
function subcenterSelectElementGenerator(textnode,id,tableObject){

	var dditTrTdTempElementValue = elementGenerator('','','','td','');
	var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
	var dditTrTdLabel = elementGenerator('','','','label','');
	dditTrTdLabel.setAttribute("style", 'float:left;');
	var TempElementName = id;
	var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
	dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
	createSubcenterElementSelect(dditTrTdTempElementSelect);

	dditTrTdDiv.appendChild(dditTrTdLabel);
	dditTrTdTempElementValue.appendChild(dditTrTdDiv);
	tableObject.appendChild(dditTrTdTempElementValue);
}
function taskTitleSelectElementGenerator(textnode,id,tableObject){

	var dditTrTdTempElementValue = elementGenerator('','','','td','');
	var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
	var dditTrTdLabel = elementGenerator('','','','label','');
	dditTrTdLabel.setAttribute("style", 'float:left;');
	var TempElementName = id;
	var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
	dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
	createTaskTitleElementSelect(dditTrTdTempElementSelect);

	dditTrTdDiv.appendChild(dditTrTdLabel);
	dditTrTdTempElementValue.appendChild(dditTrTdDiv);
	tableObject.appendChild(dditTrTdTempElementValue);
}
function linkTypeSelectElementGenerator(tableObject){
	var dditTr = elementGenerator('','','','tr','');
	var dditTrTdTempElement = elementGenerator('','','','td','');
	var TempElementTextNode = document.createTextNode('Link Type/Alarm Type');
	var dditTrTdTempElementValue = elementGenerator('','','','td','');
	var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
	var dditTrTdLabel = elementGenerator('','','','label','');
	dditTrTdLabel.setAttribute("style", 'float:left;');
	var TempElementName = 'link_type_'+divCounter;
	var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
	dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
	createLinkTypeElementSelect(dditTrTdTempElementSelect);

	dditTrTdDiv.appendChild(dditTrTdLabel);
	dditTrTdTempElement.appendChild(TempElementTextNode);
	dditTr.appendChild(dditTrTdTempElement);
	dditTrTdTempElementValue.appendChild(dditTrTdDiv);
	dditTr.appendChild(dditTrTdTempElementValue);
	tableObject.appendChild(dditTr);
}

function problemCategorySelectElementGenerator(tableObject){
	var dditTr = elementGenerator('','','','tr','');
	var dditTrTdTempElement = elementGenerator('','','','td','');
	var TempElementTextNode = document.createTextNode('Problem Category');
	var dditTrTdTempElementValue = elementGenerator('','','','td','');
	var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
	var dditTrTdLabel = elementGenerator('','','','label','');
	dditTrTdLabel.setAttribute("style", 'float:left;');
	var TempElementName = 'problem_category_'+divCounter;
	var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
	dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
	createProblemCategoryElementSelect(dditTrTdTempElementSelect);

	dditTrTdDiv.appendChild(dditTrTdLabel);
	dditTrTdTempElement.appendChild(TempElementTextNode);
	dditTr.appendChild(dditTrTdTempElement);
	dditTrTdTempElementValue.appendChild(dditTrTdDiv);
	dditTr.appendChild(dditTrTdTempElementValue);
	tableObject.appendChild(dditTr);
}

function problemSourceSelectElementGenerator(tableObject){
	var dditTr = elementGenerator('','','','tr','');
	var dditTrTdTempElement = elementGenerator('','','','td','');
	var TempElementTextNode = document.createTextNode('Problem Source');
	var dditTrTdTempElementValue = elementGenerator('','','','td','');
	var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
	var dditTrTdLabel = elementGenerator('','','','label','');
	dditTrTdLabel.setAttribute("style", 'float:left;');
	var TempElementName = 'problem_source_'+divCounter;
	var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
	dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
	createProblemSourceElementSelect(dditTrTdTempElementSelect);

	dditTrTdDiv.appendChild(dditTrTdLabel);
	dditTrTdTempElement.appendChild(TempElementTextNode);
	dditTr.appendChild(dditTrTdTempElement);
	dditTrTdTempElementValue.appendChild(dditTrTdDiv);
	dditTr.appendChild(dditTrTdTempElementValue);
	tableObject.appendChild(dditTr);
}
function faultStatusSelectElementGenerator(tableObject){
	var dditTr = elementGenerator('','','','tr','');
	var dditTrTdTempElement = elementGenerator('','','','td','');
	var TempElementTextNode = document.createTextNode('Fault Status');
	var dditTrTdTempElementValue = elementGenerator('','','','td','');
	var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
	var dditTrTdLabel = elementGenerator('','','','label','');
	dditTrTdLabel.setAttribute("style", 'float:left;');
	var TempElementName = 'fault_status_'+divCounter;
	var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
	dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
	createfaultStatusElementSelect(dditTrTdTempElementSelect);

	dditTrTdDiv.appendChild(dditTrTdLabel);
	dditTrTdTempElement.appendChild(TempElementTextNode);
	dditTr.appendChild(dditTrTdTempElement);
	dditTrTdTempElementValue.appendChild(dditTrTdDiv);
	dditTr.appendChild(dditTrTdTempElementValue);
	tableObject.appendChild(dditTr);
}




function clientIdSelectElementGenerator(tableObject,id,name){
	var dditTr = elementGenerator('','','','tr','');
	var dditTrTdClientID = elementGenerator('','','','td','');
	var ClientIdTextNode = document.createTextNode(name);
	var dditTrTdClientIDValue = elementGenerator('','','','td','');
	var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
	var dditTrTdLabel = elementGenerator('','','','label','');
	dditTrTdLabel.setAttribute("style", 'float:left;');
	var clientIdName = id+divCounter;
	var dditTrTdClientIDSelect = elementGenerator(clientIdName,clientIdName,'select_style','select','');
	dditTrTdLabel.appendChild(dditTrTdClientIDSelect);
	createClientIdSelect(dditTrTdClientIDSelect);
	if(id == "client_id_"){
		dditTrTdClientIDSelect.setAttribute("onchange","onChangeClient("+divCounter+")");
	}
	

	dditTrTdDiv.appendChild(dditTrTdLabel);
	dditTrTdClientID.appendChild(ClientIdTextNode);
	dditTr.appendChild(dditTrTdClientID);
	dditTrTdClientIDValue.appendChild(dditTrTdDiv);
	dditTr.appendChild(dditTrTdClientIDValue);
	tableObject.appendChild(dditTr);
}



function createReasonElementSelect(classObject){
	var opt = document.createElement('option');
	    opt.value = "";
	    opt.innerHTML = "";
	    classObject.appendChild(opt);
	for (var i = 0; i<reason_js_arr.length; i++){
	    var opt = document.createElement('option');
	    opt.value = reason_js_arr[i];
	    opt.innerHTML = reason_js_arr[i];
	    if(i == 40){
	    	opt.selected = 'true';
	    }
	    classObject.appendChild(opt);
	}
}
function createAssignedDeptElementSelect(classObject){
	var opt = document.createElement('option');
	    opt.value = "";
	    opt.innerHTML = "";
	    classObject.appendChild(opt);
	for (var i = 0; i<department_list_js_arr.length; i++){
	    var opt = document.createElement('option');
	    opt.value = department_id_list_js_arr[i];
	    opt.innerHTML = department_list_js_arr[i];
	    classObject.appendChild(opt);
	}
}
function createSubcenterElementSelect(classObject){
	var opt = document.createElement('option');
	    opt.value = "";
	    opt.innerHTML = "";
	    classObject.appendChild(opt);
	for (var i = 0; i<subcenter_list_js_arr.length; i++){
	    var opt = document.createElement('option');
	    opt.value = subcenter_list_js_arr[i];
	    opt.innerHTML = subcenter_list_js_arr[i];
	    classObject.appendChild(opt);
	}
}
function createTaskTitleElementSelect(classObject){
	var opt = document.createElement('option');
	    opt.value = "";
	    opt.innerHTML = "";
	    classObject.appendChild(opt);
	for (var i = 0; i<task_name_js_arr.length; i++){
	    var opt = document.createElement('option');
	    opt.value = task_name_js_arr[i];
	    opt.innerHTML = task_name_js_arr[i];
	    classObject.appendChild(opt);
	}
}
function createIssueTypeElementSelect(classObject){
	var opt = document.createElement('option');
	    opt.value = "";
	    opt.innerHTML = "";
	    classObject.appendChild(opt);
	for (var i = 0; i<issue_type_js_arr.length; i++){
	    var opt = document.createElement('option');
	    opt.value = issue_type_js_arr[i];
	    opt.innerHTML = issue_type_js_arr[i];
	    classObject.appendChild(opt);
	}
}

function createProblemCategoryElementSelect(classObject){
	var opt = document.createElement('option');
	    opt.value = "";
	    opt.innerHTML = "";
	    classObject.appendChild(opt);	
	for (var i = 0; i<problem_category_js_arr.length; i++){
	    var opt = document.createElement('option');
	    opt.value = problem_category_js_arr[i];
	    opt.innerHTML = problem_category_js_arr[i];
	    classObject.appendChild(opt);
	}
}

function createProblemSourceElementSelect(classObject){
	var opt = document.createElement('option');
	    opt.value = "";
	    opt.innerHTML = "";
	    classObject.appendChild(opt);
	for (var i = 0; i<problem_source_js_arr.length; i++){
	    var opt = document.createElement('option');
	    opt.value = problem_source_js_arr[i];
	    opt.innerHTML = problem_source_js_arr[i];
	    classObject.appendChild(opt);
	}
}
function createLinkTypeElementSelect(classObject){
	var opt = document.createElement('option');
	    opt.value = "";
	    opt.innerHTML = "";
	    classObject.appendChild(opt);
	for (var i = 0; i<link_type_js_arr.length; i++){
	    var opt = document.createElement('option');
	    opt.value = link_type_js_arr[i];
	    opt.innerHTML = link_type_js_arr[i];
	    classObject.appendChild(opt);
	}
}
function createfaultStatusElementSelect(classObject){
	// var opt = document.createElement('option');
	//     opt.value = "";
	//     opt.innerHTML = "";
	//     classObject.appendChild(opt);
	var fault_status_js_arr  =  ["open"] ;
	for (var i = 0; i<fault_status_js_arr.length; i++){
	    var opt = document.createElement('option');
	    opt.value = fault_status_js_arr[i];
	    opt.innerHTML = fault_status_js_arr[i];
	    classObject.appendChild(opt);
	}
}

function elementScript(id){
	var client_id = document.getElementsByName('client_id_'+id)[0].value;
	var element_type = document.getElementsByName('element_type_'+id)[0].value;

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
	window.open('ElementView?element_type='+element_type+'&client_id='+client_id+'&id='+id,'_blank');
  		

    
}

function responsibleScript(id){
	window.open('ResponsibleConcernView?id='+id,'_blank');
  		

    
}
function incidentScript(){
	window.open('IncidentList','_blank');
}

function onChangeClient(id){

		// /var idArr = id.split('_');

		var idTemp = id;

		//alert(id);


		element_name =  "element_name_"+idTemp;
		vlan_id = "vlan_id_"+idTemp;
		link_id ="link_id_"+idTemp;
		site_ip_address = "site_ip_address_"+idTemp;
		district = "district_"+idTemp;
		region = "region_"+idTemp;
		sms_group ="sms_group_"+idTemp;
 		responsible_vendor = "responsible_vendor_"+idTemp;



 			document.getElementById(element_name).value = "";
			document.getElementsByName(vlan_id)[0].value = "";
			document.getElementsByName(link_id)[0].value = "";
			document.getElementsByName(site_ip_address)[0].value = "";
			document.getElementsByName(district)[0].value = "";
			document.getElementsByName(region)[0].value = "";
			document.getElementsByName(sms_group)[0].value = "";
			document.getElementsByName(responsible_vendor)[0].value = "";

			$('#client_id_'+idTemp).change(function(){
		     	var id = $(this).val();
		       $('#client_priority_'+idTemp).val(client_arr[id]); 
		    });		

}

function onChangeElement(id){

		//alert(id);

		//var idArr = id.split('_');

		var idTemp = id;



		element_name =  "element_name_"+idTemp;
		vlan_id = "vlan_id_"+idTemp;
		link_id ="link_id_"+idTemp;
		site_ip_address = "site_ip_address_"+idTemp;
		district = "district_"+idTemp;
		region = "region_"+idTemp;
		sms_group ="sms_group_"+idTemp;
 		responsible_vendor = "responsible_vendor_"+idTemp;



 		document.getElementById(element_name).value = "";
			document.getElementsByName(vlan_id)[0].value = "";
			document.getElementsByName(link_id)[0].value = "";
			document.getElementsByName(site_ip_address)[0].value = "";
			document.getElementsByName(district)[0].value = "";
			document.getElementsByName(region)[0].value = "";
			document.getElementsByName(sms_group)[0].value = "";
			document.getElementsByName(responsible_vendor)[0].value = "";			

}