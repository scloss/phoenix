var resolutionDivCounter = 1;	
	function elementListFunction(id){


		var idArr = id.split('_');

		var idTemp = idArr[2];

		var element_type_id = 'element_type_'+idTemp;
		var client_id_id = 'client_id_'+idTemp;

  		element_type =document.getElementsByName(element_type_id)[0].value;
  		client_id =document.getElementsByName(client_id_id)[0].value;

  		window.open('/phoenix/public/ElementView?element_type='+element_type+'&client_id='+client_id+'&id='+idTemp);


	}


	function onChangeClient(id){

		var idArr = id.split('_');

		var idTemp = idArr[2];

		// alert(idTemp);

		element_name =  "element_name_"+idTemp;
		vlan_id = "vlan_id_"+idTemp;
		link_id ="link_id_"+idTemp;
		site_ip_address = "site_ip_address_"+idTemp;
		district = "district_"+idTemp;
		region = "region_"+idTemp;
		sms_group ="sms_group_"+idTemp;
 		responsible_vendor = "responsible_vendor_"+idTemp;
 		client_priority = "client_priority_"+idTemp;


 		var e = document.getElementsByName(id)[0];
		var tempVal = e.options[e.selectedIndex].text;
		var tempValArr = tempVal.split("--");

 			document.getElementsByName(element_name)[0].value = "";
			document.getElementsByName(vlan_id)[0].value = "";
			document.getElementsByName(link_id)[0].value = "";
			document.getElementsByName(site_ip_address)[0].value = "";
			document.getElementsByName(district)[0].value = "";
			document.getElementsByName(region)[0].value = "";
			document.getElementsByName(sms_group)[0].value = "";
			document.getElementsByName(responsible_vendor)[0].value = "";
			document.getElementsByName(client_priority)[0].value = tempValArr[1];

	

	}

	function onChangeElement(id){


		var idArr = id.split('_');

		var idTemp = idArr[2];



		element_name =  "element_name_"+idTemp;
		vlan_id = "vlan_id_"+idTemp;
		link_id ="link_id_"+idTemp;
		site_ip_address = "site_ip_address_"+idTemp;
		district = "district_"+idTemp;
		region = "region_"+idTemp;
		sms_group ="sms_group_"+idTemp;
 		responsible_vendor = "responsible_vendor_"+idTemp;



 			document.getElementsByName(element_name)[0].value = "";
			document.getElementsByName(vlan_id)[0].value = "";
			document.getElementsByName(link_id)[0].value = "";
			document.getElementsByName(site_ip_address)[0].value = "";
			document.getElementsByName(district)[0].value = "";
			document.getElementsByName(region)[0].value = "";
			document.getElementsByName(sms_group)[0].value = "";
			document.getElementsByName(responsible_vendor)[0].value = "";			

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


	function responsibleFieldView(id){


		var idTemp = id;

  		window.open('/phoenix/public/ResponsibleConcernView?id='+id);


	}

	function TaskResolutionView(id,ticket_id,fault_id){

		var idArr = id.split('_resolution');

		var idTemp = idArr[0];
		var task_id_str = idTemp+'_id';

  		task_id =document.getElementsByName(task_id_str)[0].value;

		window.location.replace('/phoenix/public/TaskResolutionView?id='+id+'&task_id='+task_id+'&ticket_id='+ticket_id+'&fault_id='+fault_id);

	}

	function checkTaskStatus(id,fault_count){

		var idArr = id.split('_status');
		var idTemp = idArr[0];
		var task_resolution_str = idTemp+'_resolution';
		var task_resolver_str = idTemp+'_resolver';
		var clear_time_str = idTemp+'_clear_time';

		// alert(task_resolution_str)

		var status = document.getElementsByName(id)[0].value;

		// alert(status);

		if(status=="RTI"){

			document.getElementsByName(task_resolution_str)[0].required=true;
			document.getElementsByName(task_resolver_str)[0].required=true;
			document.getElementsByName(clear_time_str)[0].required=true;

		}
		else if(status=="NMI"){

			document.getElementsByName(task_resolution_str)[0].required=true;
			document.getElementsByName(task_resolver_str)[0].required=true;
			document.getElementsByName(clear_time_str)[0].required=true;

		}

		else if(status=="FWD"){

			addFaultTask(fault_count);
		}		
		else{
			document.getElementsByName(task_resolution_str)[0].required=false;
			document.getElementsByName(task_resolver_str)[0].required=false;
			document.getElementsByName(clear_time_str)[0].required=false;
		}
		

	}

	function addTaskResolution(){

		resolutionDivCounter++;

		var dynamicMasterDiv = elementGenerator("col-md-8",'',"static_div",'div','');
		var section = elementGenerator("widget",'',"default-widget",'section','');
		var header = elementGenerator('','','','header','');
		faultHeaderName = 'resolution_header_id_'+resolutionDivCounter;
		var h5 = elementGenerator('','',faultHeaderName,'h5','');
		var faultName = "Resolution "+resolutionDivCounter;
		var textNode = document.createTextNode(faultName);  
		h5.appendChild(textNode);

		var widgetControlsDropdown = elementGenerator("widget-controls dropdown",'','','div','')
		var cog = elementGenerator("dropdown-toggle",'','','a','');
		cog.setAttribute("data-toggle",'dropdown');
		var icon = elementGenerator("fa fa-cog",'','','i','');	
		var dropMenuRight = elementGenerator('dropdown-menu dropdown-menu-right','','','ul','');

		var linkAddName = 'linkAdd_'+resolutionDivCounter;
		var listAdd = elementGenerator("listAdd",'','','li','');
		var linkAdd = elementGenerator("linkAdd",'','','a','');
		linkAdd.setAttribute("href", '#');
		linkAdd.setAttribute("onclick", 'addTaskResolution('+resolutionDivCounter+')');
		var linkAddTextNode = document.createTextNode('Add Resolution');
		linkAdd.appendChild(linkAddTextNode);

		// var linkDeleteName = 'linkDelete_'+resolutionDivCounter;
		// var listDelete = elementGenerator("listDelete",'','','li','');
		// var linkDelete = elementGenerator(linkDeleteName,'','','a','');
		// linkDelete.setAttribute("href", '#');
		// linkDelete.setAttribute("onclick", 'DeleteResolution('+resolutionDivCounter+')');
		// var linkDeleteTextNode = document.createTextNode('Delete');
		// linkDelete.appendChild(linkDeleteTextNode);

		listAdd.appendChild(linkAdd);

		// listDelete.appendChild(linkDelete);

		dropMenuRight.appendChild(listAdd);

		// dropMenuRight.appendChild(listDelete);




	/**************Header START************************************/
		widgetControlsDropdown.appendChild(dropMenuRight);
		cog.appendChild(icon);
		widgetControlsDropdown.appendChild(cog);
		header.appendChild(widgetControlsDropdown);
		header.appendChild(h5);
		section.appendChild(header);




		var dynamicTable = elementGenerator('','','','table','');
		var dditTableBody = elementGenerator('','','','tbody','');

		resolutionReasonSelectElementGenerator(dditTableBody);
		resolutionTypeSelectElementGenerator(dditTableBody);
		resolutionInventoryTypeSelectElementGenerator(dditTableBody);
		resolutionInventoryDetailSelectElementGenerator(dditTableBody);

		resolutionInputElementGenerator('Quantity','task_resolution_quantity_',dditTableBody);
		resolutionInputElementGenerator('Remark','task_resolution_remarks_',dditTableBody);

		dynamicTable.appendChild(dditTableBody);
		section.appendChild(dynamicTable);


		dynamicMasterDiv.appendChild(section);	

		var masterMasterFormDiv = document.getElementById("resolution_form_div");	

		masterMasterFormDiv.appendChild(dynamicMasterDiv);

		var oldResolutionCounter = document.getElementById("resolution_counter").value;

		newResolutionCounter = parseInt(oldResolutionCounter)+1;

		document.getElementById("resolution_counter").value = newResolutionCounter;
	}

	function resolutionReasonSelectElementGenerator(tableObject){

		var dditTr = elementGenerator('','','','tr','');
		var dditTrTdTempElement = elementGenerator('','','','td','');
		var TempElementTextNode = document.createTextNode('Reason');
		var dditTrTdTempElementValue = elementGenerator('','','','td','');
		var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
		var dditTrTdLabel = elementGenerator('','','','label','');
		dditTrTdLabel.setAttribute("style", 'float:left;');
		var TempElementName = 'task_resolution_reason_'+resolutionDivCounter;
		var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
		dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
		createResolutionReasonElementSelect(dditTrTdTempElementSelect);

		dditTrTdDiv.appendChild(dditTrTdLabel);
		dditTrTdTempElement.appendChild(TempElementTextNode);
		dditTr.appendChild(dditTrTdTempElement);
		dditTrTdTempElementValue.appendChild(dditTrTdDiv);
		dditTr.appendChild(dditTrTdTempElementValue);
		tableObject.appendChild(dditTr);
	}

	function resolutionTypeSelectElementGenerator(tableObject){

		var dditTr = elementGenerator('','','','tr','');
		var dditTrTdTempElement = elementGenerator('','','','td','');
		var TempElementTextNode = document.createTextNode('Resolution Type');
		var dditTrTdTempElementValue = elementGenerator('','','','td','');
		var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
		var dditTrTdLabel = elementGenerator('','','','label','');
		dditTrTdLabel.setAttribute("style", 'float:left;');
		var TempElementName = 'task_resolution_type_'+resolutionDivCounter;
		var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
		dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
		createResolutionTypeElementSelect(dditTrTdTempElementSelect);

		dditTrTdDiv.appendChild(dditTrTdLabel);
		dditTrTdTempElement.appendChild(TempElementTextNode);
		dditTr.appendChild(dditTrTdTempElement);
		dditTrTdTempElementValue.appendChild(dditTrTdDiv);
		dditTr.appendChild(dditTrTdTempElementValue);
		tableObject.appendChild(dditTr);
	}	

	function resolutionInventoryTypeSelectElementGenerator(tableObject){

		var dditTr = elementGenerator('','','','tr','');
		var dditTrTdTempElement = elementGenerator('','','','td','');
		var TempElementTextNode = document.createTextNode('Inventory Type');
		var dditTrTdTempElementValue = elementGenerator('','','','td','');
		var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
		var dditTrTdLabel = elementGenerator('','','','label','');
		dditTrTdLabel.setAttribute("style", 'float:left;');
		var TempElementName = 'task_resolution_inventory_type_'+resolutionDivCounter;
		var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
		dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
		createResolutionInventoryTypeElementSelect(dditTrTdTempElementSelect);

		dditTrTdDiv.appendChild(dditTrTdLabel);
		dditTrTdTempElement.appendChild(TempElementTextNode);
		dditTr.appendChild(dditTrTdTempElement);
		dditTrTdTempElementValue.appendChild(dditTrTdDiv);
		dditTr.appendChild(dditTrTdTempElementValue);
		tableObject.appendChild(dditTr);
	}

	function resolutionInventoryDetailSelectElementGenerator(tableObject){

		var dditTr = elementGenerator('','','','tr','');
		var dditTrTdTempElement = elementGenerator('','','','td','');
		var TempElementTextNode = document.createTextNode('Inventory Detail');
		var dditTrTdTempElementValue = elementGenerator('','','','td','');
		var dditTrTdDiv = elementGenerator("ui-widget",'','','div','');
		var dditTrTdLabel = elementGenerator('','','','label','');
		dditTrTdLabel.setAttribute("style", 'float:left;');
		var TempElementName = 'task_resolution_inventory_detail_'+resolutionDivCounter;
		var dditTrTdTempElementSelect = elementGenerator(TempElementName,TempElementName,'select_style','select','');
		dditTrTdLabel.appendChild(dditTrTdTempElementSelect);
		createResolutionInventoryDetailElementSelect(dditTrTdTempElementSelect);

		dditTrTdDiv.appendChild(dditTrTdLabel);
		dditTrTdTempElement.appendChild(TempElementTextNode);
		dditTr.appendChild(dditTrTdTempElement);
		dditTrTdTempElementValue.appendChild(dditTrTdDiv);
		dditTr.appendChild(dditTrTdTempElementValue);
		tableObject.appendChild(dditTr);

	}	
	function responsibleScript(id){
		window.open('ResponsibleConcernView?id='+id,'_blank');
	  		

	    
	}	
		


	function createResolutionReasonElementSelect(classObject){
		var opt = document.createElement('option');
		    opt.value = "";
		    opt.innerHTML = "";
		    classObject.appendChild(opt);
		for (var i = 0; i<task_resolution_reason_js_arr.length; i++){
		    var opt = document.createElement('option');
		    opt.value = task_resolution_reason_js_arr[i];
		    opt.innerHTML = task_resolution_reason_js_arr[i];
		    classObject.appendChild(opt);
		}
	}

	function createResolutionTypeElementSelect(classObject){
		var opt = document.createElement('option');
		    opt.value = "";
		    opt.innerHTML = "";
		    classObject.appendChild(opt);
		for (var i = 0; i<task_resolution_type_js_arr.length; i++){
		    var opt = document.createElement('option');
		    opt.value = task_resolution_type_js_arr[i];
		    opt.innerHTML = task_resolution_type_js_arr[i];
		    classObject.appendChild(opt);
		}
	}

	function createResolutionInventoryTypeElementSelect(classObject){
		var opt = document.createElement('option');
		    opt.value = "";
		    opt.innerHTML = "";
		    classObject.appendChild(opt);
		for (var i = 0; i<task_resolution_inventory_type_js_arr.length; i++){
		    var opt = document.createElement('option');
		    opt.value = task_resolution_inventory_type_js_arr[i];
		    opt.innerHTML = task_resolution_inventory_type_js_arr[i];
		    classObject.appendChild(opt);
		}
	}

	function createResolutionInventoryDetailElementSelect(classObject){
		var opt = document.createElement('option');
		    opt.value = "";
		    opt.innerHTML = "";
		    classObject.appendChild(opt);
		for (var i = 0; i<task_resolution_inventory_detail_js_arr.length; i++){
		    var opt = document.createElement('option');
		    opt.value = task_resolution_inventory_detail_js_arr[i];
		    opt.innerHTML = task_resolution_inventory_detail_js_arr[i];
		    classObject.appendChild(opt);
		}
	}

	function resolutionInputElementGenerator(textNode,id,tableObject){
		var checkTaskExists = textNode.includes("Task");
		if(checkTaskExists == true){
			var TempElementName = id;
		}
		else{
			var TempElementName = id+resolutionDivCounter;
			var dditTrTempElement= elementGenerator('','','','tr','');	
			var dditTrTdTempElement = elementGenerator('','','','td','');
			var TempElementTextNode = document.createTextNode(textNode);	
		}

		var dditTrTdTempElementValue = elementGenerator('','','','td','');
		var dditTrTdDivTempElement = elementGenerator("ui-widget",'','','div','');
		
		var dditTrTdTempElementTextarea = elementGenerator('form-control input-transparent',TempElementName,TempElementName,'input','');
		dditTrTdTempElementTextarea.setAttribute('type','text');
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

	function onBehalf(obj,id){

		var onBehalfChecker = id+"_checker";

		var idArr = id.split('_on_behalf');
		var idTemp = idArr[0];

		var task_resolution_str = idTemp+'_resolution';
		var task_resolver_str = idTemp+'_resolver';
		var comment_time_str = idTemp+'_comment';
		var status_str = idTemp+'_status'
		// alert(id);
		    if(obj.checked == true){

        		document.getElementById(onBehalfChecker).value = 1;


				document.getElementsByName(task_resolution_str)[0].disabled=false; 
				document.getElementsByName(task_resolver_str)[0].disabled=false; 
				document.getElementsByName(comment_time_str)[0].readonly=false; 
				document.getElementsByName(status_str)[0].disabled=false; 


		    }else{

        		
        		document.getElementById(onBehalfChecker).value = 0;		    


				document.getElementsByName(task_resolution_str)[0].disabled=true; 
				document.getElementsByName(task_resolver_str)[0].disabled=true; 
				document.getElementsByName(comment_time_str)[0].readonly=true;     
				document.getElementsByName(status_str)[0].disabled=true;    		    
		   }

	}
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
	linkDeleteTask.setAttribute("href", '#');
	if(taskCounter == '1'){
		linkDeleteTask.setAttribute("onclick", '');
	}
	else{
		linkDeleteTask.setAttribute("onclick", 'deleteTask('+divCounter+','+taskCounter+')');
	}
	
	var linkDeleteTextNode = document.createTextNode('Delete');
	linkDeleteTask.appendChild(linkDeleteTextNode);
	listDeleteTask.appendChild(linkDeleteTask);
	if(taskCounter != '1'){
		dropMenuRight.appendChild(listDeleteTask);
	}
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
	var headerTextNode = document.createTextNode('Subcenter');
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
	inputElementGenerator('Task Name',taskName,dditTaskTableBody);
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
	var dditTrTdResponsibleConcernTextarea = elementGenerator('form-control input-transparent',ResponsibleConcernName,ResponsibleConcernName,'textarea','');

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
	function datePick(id){
		$("#"+id).datetimepicker();
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
			//alert("asdf");
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

	function addHiddenTaskId(divCounter){
		var taskCounterName = 'fault_'+divCounter+'_task_counter';
		var taskName = 'fault_'+divCounter+'_task_hidden_ids';
		var taskCounterStr = document.getElementById(taskCounterName).value;
		var taskCounter = parseInt(taskCounterStr);
		document.getElementById(taskCounterName).value = taskCounter+1;
		document.getElementById(taskName).value += ','+(taskCounter+1);
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



	$(document).ready(function(){

		var fault_count=document.getElementById("fault_count").value;


		for(var i=1;i<(parseInt(fault_count)+1);i++){


			var escalation_id = "escalation_time_"+i;
			var escalation_time = document.getElementsByName(escalation_id)[0].value;

			var event_id = "event_time_"+i;
			var event_time = document.getElementsByName(event_id)[0].value;			
			
			var clear_id = "clear_time_"+i;
			var clear_time = document.getElementsByName(clear_id)[0].value;		

			$("#escalation_time_"+i).datetimepicker();		
			$("#event_time_"+i).datetimepicker();
			$("#clear_time_"+i).datetimepicker();

			
			document.getElementsByName(escalation_id)[0].value = escalation_time;
			document.getElementsByName(event_id)[0].value = event_time;
			document.getElementsByName(clear_id)[0].value = clear_time;

			var task_id = "fault_"+i+"_task_counter";

			var task_count = document.getElementById(task_id).value;


			for(var j=1;j<(parseInt(task_count)+1);j++){


				var start_id = "fault_"+i+"_task_"+j+"_start_time";
				// alert(start_id);
				var start_time = document.getElementsByName(start_id)[0].value;

				var end_id = "fault_"+i+"_task_"+j+"_end_time";
				var end_time = document.getElementsByName(end_id)[0].value;

				$("#fault_"+i+"_task_"+j+"_start_time").datetimepicker();		
				$("#fault_"+i+"_task_"+j+"_end_time").datetimepicker();

				document.getElementsByName(start_id)[0].value = start_time;
				document.getElementsByName(end_id)[0].value = end_time;
			}
		}	

	});

	