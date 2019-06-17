@include('navigation.p_header')

<style type="text/css">
    table{
        width:100%;
    }
    table td{
        text-align:left;
        border:1px solid grey !important;
        max-width:30px !important;
        word-wrap: break-word;
    }
    #taskTableView tr:nth-child(2) td{
        max-width:30px !important;
        word-wrap: break-word;
        max-height:90px !important;
        overflow-y:auto;
    }
    #taskTableView tr:nth-child(2) td p{
       /* max-width:30px !important;*/
        word-wrap: break-word;
        height:60px !important;
        overflow-y:auto;
    }
    #header_position{
        text-align:center;
        width:100%;
    }
    #header_position td{
        text-align:center;
        color:#fff !important;
    }
    #green_invoice {
        border: 2px solid #5be68f;
        padding-top:10px;

    }
    #header_task{
        color:#fff !important;
        opacity:1.0;
    }
</style>

<script type="text/javascript">
    
    function create_sms(){

        var sms_type = document.getElementById("sms_type").value; 
        var sms_header = document.getElementById("sms_header").value;
        var sms_group = document.getElementById("sms_group").value;
        var sms_body = document.getElementById("sms_body").value;
        var ticket_id = document.getElementById("ticket_id").value;
        var notice_type ="";
        var user_id = document.getElementById("user_id").value;

        if(sms_type!=""){

            sms_header = sms_type+': <br>';

        }

        if(sms_type=="FN"||sms_type=="FRN"||sms_type=="FNU"||sms_type=="Notice"||sms_type=="Notice Update"){

            notice_type = sms_type;

        }

        sms_body = sms_header + sms_body;
        // console.log('http://172.16.136.80/scl_sms_system/public/create_sms?sms='+sms_body.replace(/(\r\n|\n|\r|\t)/gm,"")+'&fault_id='+ticket_id+'&notice_type='+notice_type+'&sms_group='+sms_group);

        // window.open('http://172.16.136.80/scl_sms_system/public/create_sms?sms='+sms_body.replace(/(\r\n|\n|\r|\t)/gm,"")+'&fault_id='+ticket_id+'&notice_type='+notice_type+'&sms_group='+sms_group);

        console.log('http://172.16.136.80/scl_sms_system/public/create_sms?sms='+sms_body.replace(/(\r\n|\n|\r|\t)/gm,"")+'&fault_id='+ticket_id+'&notice_type='+notice_type+'&sms_group='+sms_group+'&ticket_id='+ticket_id);

        window.open('http://172.16.136.80/scl_sms_system/public/create_sms?sms='+sms_body.replace(/(\r\n|\n|\r|\t)/gm,"")+'&fault_id='+ticket_id+'&notice_type='+notice_type+'&sms_group='+sms_group+'&ticket_id='+ticket_id+'&user_id='+user_id);

        // console.log('http://172.20.17.50/scl_sms_system/public/create_sms?sms='+sms_body.replace(/(\r\n|\n|\r|\t)/gm,"")+'&fault_id='+ticket_id+'&notice_type='+notice_type+'&sms_group='+sms_group+'&ticket_id='+ticket_id);

        // window.open('http://172.20.17.50/scl_sms_system/public/create_sms?sms='+sms_body.replace(/(\r\n|\n|\r|\t)/gm,"")+'&fault_id='+ticket_id+'&notice_type='+notice_type+'&sms_group='+sms_group+'&ticket_id='+ticket_id+'&user_id='+user_id);
        

    }


function create_notice_sms(){

        var incidentId = {{$incidentId}}; 

       
        var user_id = document.getElementById("user_id").value;

        //////////////////////////////// Uncomment this line to refirect it to 80 /////////////////////////////////
        console.log('http://172.16.136.80/scl_sms_system/public/noticesms?incidentId='+incidentId+'&user_id='+user_id);

        window.open('http://172.16.136.80/scl_sms_system/public/noticesms?incidentId='+incidentId+'&user_id='+user_id);
        ////////////////////////////////////////////Comment below line//////////////////////////////////////////////////////////////////
        // console.log('http://172.20.17.50/scl_sms_system/public/noticesms?incidentId='+incidentId+'&user_id='+user_id);

        // window.open('http://172.20.17.50/scl_sms_system/public/noticesms?incidentId='+incidentId+'&user_id='+user_id);


}

</script>
        <section class="widget">
            <div class="body no-margin">

                <div class="row">
                    <div class="col-sm-6 col-print-6">
                        <div class="invoice-info well">
                                <h4 class="invoice-number text-align-left">Ticket ID  &nbsp;:&nbsp;  {{$ticketId}}&nbsp;&nbsp; 
                                    <?php $assigned_dept_concated = ''; ?>
                                    @for($i=0;$i<count($assigned_dept_arr);$i++)
                                        @foreach($department_lists as $department_list)
                                            @if($department_list->dept_row_id == $assigned_dept_arr[$i]) 
                                                <?php $assigned_dept_concated .= $department_list->dept_name.','; ?></h5>
                                            @endif

                                        @endforeach  
                                    @endfor
                                    <?php 
                                    $session_dept = $_SESSION['department'];
                                    $session_dept_id = $_SESSION['dept_id'];
                                    if (preg_match("/$session_dept/i", $assigned_dept_concated) || preg_match("/$session_dept_id/i", $ticket_initiator_dept)){ ?>
                                    <a href="{{ url('EditTT')}}?ticket_id={{$ticketId}}" style="color:#fff"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a>&nbsp;&nbsp;
                                    <?php
                                    }
                                    ?>
                                    @if($_SESSION['dept_id'] ==10)

                                    <a href="{{ url('CreateTTEmail')}}?ticket_id={{$ticketId}}" style="color:#fff"><i class="fa fa-envelope-o" aria-hidden="true" id="edit_icon"></i></a>&nbsp;&nbsp;
                                    
                                        <!-- <i class="fa fa-paper-plane" aria-hidden="true" onclick="create_sms()"></i> -->
                                        <input type="hidden" name="sms_body" id="sms_body" value="{{$sms_body}}">
                                        <input type="hidden" name="sms_header" id="sms_header" value="{{$sms_header}}">
                                        <input type="hidden" name="sms_group" id="sms_group" value="{{$sms_group}}">
                                        <input type="hidden" name="ticket_id" id="ticket_id" value="{{$ticketId}}">
                                        <input type="hidden" name="user_id" id="user_id" value="{{$_SESSION['user_id']}}">
                                        <!-- <select name="sms_type" id="sms_type" style="color:black">
                                            <option value="">Default</option>
                                            @foreach($sms_type_lists as $sms_type_list)
                                                     
                                                <option value="{{$sms_type_list->sms_type}}" style="color:black">{{$sms_type_list->sms_type}}</option>

                                             @endforeach  
                                        </select> -->
                                        <i class="fa fa-paper-plane" aria-hidden="true" onclick="create_notice_sms()"></i>
                                    @endif
                                </h4>
                                <h4>Title  &nbsp;:&nbsp;  <b>{{$ticketTitle}}</b></h4>
                                <h5>Status  &nbsp;:&nbsp; 
                                    @if($ticketStatus != 'Closed')
                                    <span class="label label-important"> {{$ticketStatus}}</span>
                                    @else
                                    <span class="label label-success"> {{$ticketStatus}}</span>
                                    @endif
                                </h5>
                                @if($attachment_path!="")
                                    <h5>Attached Files  &nbsp;:&nbsp;  
                                    <a href="{{ url('downloadZip?ticket_id=') }}{{$ticketId}}" ><span class="glyphicon glyphicon-download-alt"> Download</span></a></h5>
                                    
                                @endif
                                <h5>Assigned Department  &nbsp;:&nbsp; {{trim($assigned_dept_concated,',')}}
                                    
                                <h4>Ticket Initiator  &nbsp;:&nbsp;  <b>{{$ticket_initiator}}</b></h4>    
                                
                        </div>
                        
                    </div>
                    <!-- <div class="col-sm-5 col-print-5">
                    </div> -->
                    <div class="col-sm-6 col-print-6">
                        <div class="invoice-info well">
                            <div class="invoice-number text-align-left">
                                This ticket is under Incident ID : {{$incidentId}}
                            </div>
                            <div class="invoice-number-info text-align-left">
                                Incident Title : {{$incidentTitle}}
                            </div>
                            <div class="invoice-number-info text-align-left">
                                Description : {{$incidentDescription}}
                            </div>  
                        </div>
                    </div>
                </div>
                <hr>
                
                <section class="invoice-info well">
                    <?php $count=0; ?>

                    @foreach($fault_lists as $fault_list)
                    <?php $count++;$task_count = 0; ?>
                    @if($fault_list->fault_status =="closed")
                        <div class="row">
                    @else
                        <div class="row" id="green_invoice">
                    @endif
                    
                        <div class="col-sm-12 col-print-12" >
                            <table class="table table-bordered table-striped" id="header_position">                         
                                <tr>
                                    <td><h4> Fault : {{$count}} ( Fault ID - {{$fault_list->fault_id}})</h4></td>
                                </tr>
                            </table>
                            
                        </div>

                        <div class="col-sm-3 col-print-3">
                            <br>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td>ID</td><td>{{$fault_list->fault_id}}</td>
                                </tr>   
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        @if($fault_list->fault_status !="closed")
                                            <span class="label label-important">{{$fault_list->fault_status}}</span>
                                        @else
                                            <span class="label label-success">{{$fault_list->fault_status}}</span>
                                        @endif  
                                    </td>
                                </tr>   
                                <tr>    
                                    <td>Client ID</td>
                                    <td>
                                        
                                        <b>{{$fault_list->client_name}}</b>
                                              
                                    </td>
                                </tr>   
                                <tr>    
                                    <td>Element Type</td><td><b>{{$fault_list->element_type}}</b></td>
                                </tr>   
                                <tr>    
                                    <td>Element Name</td>
                                    <td>
                                 
                                        @if($fault_list->element_type=="link")
                                            
                                            <b>{{$fault_list->name}}</b>
                                                
                                        @else
                                          
                                            <b> <?php echo $fault_list->name; ?></b>
                                                
                                        @endif
                                    </td>
                                </tr>   
                                <tr>    
                                    <td>VLAN ID</td>
                                    <td>
                                        @if($fault_list->element_type=="link")
                                          
                                            <b>{{$fault_list->vlan_id}}</b>
                                                
                                        @endif
                                    </td>
                                </tr>
                                <tr>    
                                    <td>Link ID</td>
                                    <td>
                                        @if($fault_list->element_type=="link")
                                          
                                            <b>{{$fault_list->link_id}}</b>
                                               
                                        @endif
                                    </td>
                                </tr>
                                <tr>    
                                    <td>Site IP Address</td>
                                    <td>
                                       
                                                <b>{{$fault_list->site_ip_address}}</b>
                                           
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 col-print-3">
                            <br>

                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td>District</td>
                                    <td>
                                        @if($fault_list->element_type=="link")
                                            
                                            {{$fault_list->district}}
                                                
                                        @else
                                            
                                                   
                                            {{$fault_list->district}}
                                                
                                        @endif  
                                    </td>
                                </tr>
                                <tr>    
                                    <td>Region</td>
                                    <td>
                                        @if($fault_list->element_type=="link")
                                            
                                            {{$fault_list->region}}
                                                
                                        @else
                                            
                                            {{$fault_list->region}}
                                                
                                        @endif  
                                    </td>
                                </tr>
                                <tr>    
                                    <td>SMS Group</td>
                                    <td>
                                        @if($fault_list->element_type=="link")
                                            
                                            {{$fault_list->sms_group}}
                                                
                                        @else
                                            
                                            {{$fault_list->sms_group}}
                                               
                                        @endif  
                                    </td>
                                </tr>
                                <tr>    
                                    <td>Client Priority</td>
                                    <td>
                                        @foreach($client_lists as $client_list)
                                            @if($client_list->client_id == $fault_list->client_id) 
                                                <b>{{$client_list->priority}}</b>
                                            @endif
                                        @endforeach 
                                    </td>
                                </tr>
                                <tr>    
                                    <td>Client Side Impact</td><td>{{$fault_list->client_side_impact}}</td>
                                </tr>
                                <tr>    
                                    <td>Link Type</td>
                                    <td>
                                        @foreach($link_type_lists as $link_type_list)
                                            @if($link_type_list->link_type_name == $fault_list->link_type) 
                                                <b>{{$link_type_list->link_type_name}}</b>
                                            @endif
                                        @endforeach 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Responsible Field Team</td>
                                    <td>
                                        {{$fault_list->responsible_field_team}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Provider</td>
                                    <td>
                                        {{$fault_list->client_name}}
                                       
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 col-print-3">
                            <br>

                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td>Reason</td>
                                    <td>
                                        @foreach($reason_lists as $reason_list)
                                            @if($reason_list->reason_name == $fault_list->reason) 
                                                {{$reason_list->reason_name}}
                                            @endif
                                        @endforeach  
                                    </td>
                                </tr>
                                <tr>
                                    <td>Issue Type</td>
                                    <td>
                                        {{$fault_list->issue_type}}
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>Problem Category</td>
                                    <td>
                                        {{$fault_list->problem_category}}
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>Problem Source</td>
                                    <td>
                                        {{$fault_list->problem_source}}
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>Responsible Vendor</td>
                                    <td>
                                        @if($fault_list->element_type=="link")
                                           
                                            {{$fault_list->vendor}}
                                               
                                        @else
                                            
                                            {{$fault_list->vendor}}
                                                
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Escalation Time</td>
                                    <td>
                                        {{$fault_list->escalation_time}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Responsible Concern</td>
                                    <td>
                                        {{$fault_list->responsible_concern}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 col-print-3">
                        <br>

                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td>Event Time</td>
                                    <td>
                                        <b>{{$fault_list->event_time}}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Clear Time</td>
                                    <td>
                                        <b>{{$fault_list->clear_time}}</b>
                                    </td>
                                </tr>
                                <tr >
                                    <td style="height:105px">Provider Side Impact</td>
                                    <td style="height:105px">
                                        {{$fault_list->provider_side_impact}}
                                    </td>
                                </tr>
                                <tr>
                                    <td  style="height:105px">Remarks</td>
                                    <td  style="height:105px">
                                        {{$fault_list->remarks}}
                                    </td>
                                </tr>
                            </table>
                        </div>        
                    </div>
                    @foreach($task_lists as $task_list)
                        @if($task_list->fault_id==$fault_list->fault_id)
                        <?php
                            $task_count = $task_count+1;
                        ?>
                        @if($fault_list->fault_status =="closed")
                            <div class="row">
                        @else
                            <div class="row" id="green_invoice">
                        @endif
                        
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-10">
                                    <div class="container-fluid">
                                        <div class="col-sm-12 col-print-12" >
                                            <table class="table table-bordered table-striped" id="header_position">
                                                <tr>
                                                    <td><h4 id="header_task">Task : {{$task_count}} (Task ID - {{$task_list->task_id}})</h4></td>
                                                </tr>
                                            </table>                                            
                                        </div>
                                    </div>
                                    <section class="widget" id="default-widget">
                                        <div class="container-fluid">
                                            <div class="col-md-3">
                                                <table class="table table-bordered table-striped" id="taskTableView">
                                                    <tr>
                                                        <td>Task Title</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$task_list->task_name}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-3">
                                                <table class="table table-bordered table-striped" id="taskTableView">
                                                    <tr>
                                                        <td>Task Description</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$task_list->task_description}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-3">
                                                <table class="table table-bordered table-striped" id="taskTableView">        
                                                    <tr>  
                                                        <td>Assigned Department</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                             @foreach($department_lists as $department_list)
                                                                @if($department_list->dept_row_id== $task_list->task_assigned_dept) 
                                                                    {{$department_list->dept_name}}
                                                                @endif
                                                             @endforeach 
                                                        </td>                             
                                                    </tr>
                                                </table> 
                                            </div>
                                            <div class="col-md-3">
                                                <table class="table table-bordered table-striped" id="taskTableView">
                                                    <tr>
                                                        <td>Task Start Time</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$task_list->task_start_time}}</td>
                                                    </tr>
                                                </table>
                                            </div> 


                                            <div class="col-md-3">
                                                <table class="table table-bordered table-striped" id="taskTableView">
                                                    <tr>
                                                        <td>Task End Time</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$task_list->task_end_time}}</td>                                                       
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-3">
                                                <table class="table table-bordered table-striped" id="taskTableView">
                                                    <tr>
                                                        <td>Task Status</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            @foreach($task_status_lists as $task_status_list)
                                                                @if($task_status_list->task_status == $task_list->task_status) 
                                                                    {{$task_status_list->task_status}}
                                                                @endif
                                                            @endforeach 
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-bordered table-striped" id="taskTableView">        
                                                    <tr>  
                                                        <td>Task Comment</td>                                           
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <textarea style="background-color: rgba(51, 51, 51, 0.3); width:100%;"><?php echo str_replace(" || ","\r\n",$task_list->task_comments); ?></textarea>
                                                        </td>                          
                                                    </tr>
                                                </table> 
                                            </div>

                                            
                                            <div class="col-md-3">
                                                <table class="table table-bordered table-striped" id="taskTableView">
                                                    <tr>                                         
                                                        <td>Subcenter</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$task_list->subcenter}}</td> 
                                                    </tr>
                                                </table>
                                            </div> 
                                            <div class="col-md-3">
                                                <table class="table table-bordered table-striped" id="taskTableView">
                                                    <tr>                                         
                                                        <td>Task Responsible</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$task_list->task_responsible}}</td> 
                                                    </tr>
                                                </table>
                                            </div> 
                                            <div class="col-md-3">
                                                <table class="table table-bordered table-striped" id="taskTableView">
                                                    <tr>                                         
                                                        <td>Task Resolver</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$task_list->task_resolver}}</td> 
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                
                                                <?php 
                                                    if(array_key_exists($task_list->task_id,$task_res_big_arr)){
                                                        $inner_lists = array();
                                                        $inner_lists = $task_res_big_arr[$task_list->task_id];    
                                                        for($i=0;$i<count($inner_lists);$i++){ ?>
                                                            <div class="container-fluid">
                                                                <div class="col-sm-12 col-print-12" >
                                                                    <table class="table table-bordered table-striped" id="header_position">
                                                                        <tr>
                                                                            <td><h4 id="header_task">Resolution - {{$i+1}}</h4></td>
                                                                        </tr>
                                                                    </table>                                            
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <table class="table table-bordered table-striped" id="taskTableView">
                                                                        <tr>
                                                                            <td>Task Resolution ID</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo $inner_lists[$i][0]; ?></td>  
                                                                        </tr>
                                                                    </table>    
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <table class="table table-bordered table-striped" id="taskTableView">
                                                                        <tr>
                                                                            <td>Reason</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo $inner_lists[$i][1]; ?></td>  
                                                                        </tr>
                                                                    </table>    
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <table class="table table-bordered table-striped" id="taskTableView">
                                                                        <tr>
                                                                            <td>Resolution Type</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo $inner_lists[$i][2]; ?></td>  
                                                                        </tr>
                                                                    </table>    
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <table class="table table-bordered table-striped" id="taskTableView">
                                                                        <tr>
                                                                            <td>Inventory Type</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo $inner_lists[$i][3]; ?></td>  
                                                                        </tr>
                                                                    </table>    
                                                                </div>
                                                            </div>
                                                            <div class="row">   
                                                                <div class="col-md-3">
                                                                    <table class="table table-bordered table-striped" id="taskTableView">
                                                                        <tr>
                                                                            <td>Inventory Detail</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo $inner_lists[$i][4]; ?></td>  
                                                                        </tr>
                                                                    </table>    
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <table class="table table-bordered table-striped" id="taskTableView">
                                                                        <tr>
                                                                            <td>Quantity</td>
                                                                        </tr>    
                                                                        <tr>
                                                                            <td><?php echo $inner_lists[$i][5]; ?></td>  
                                                                        </tr>
                                                                    </table>    
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <table class="table table-bordered table-striped" id="taskTableView">
                                                                        <tr>
                                                                            <td>Remark</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo $inner_lists[$i][6]; ?></td>  
                                                                        </tr>
                                                                    </table>    
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <table class="table table-bordered table-striped" id="taskTableView">
                                                                        <tr>
                                                                            <td>Resolution Creation Time</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo $inner_lists[$i][7]; ?></td>  
                                                                        </tr>
                                                                    </table>    
                                                                </div>
                                                            </div>        
                                                <?php   }
                                                    }
                                                ?>
                                                </table>
                                            </div>
                                        </div> 
                                    </section>  
                                </div>
                                <div class="col-md-1">
                                </div>
                        </div>
                        @endif

                    @endforeach
                    @endforeach 
                </section> 
                <section class="widget">
                    <div class="body no-margin">
                        <div class="row"> 
                            <div class="col-md-4">
                                <table class="table table-bordered table-striped" id="taskTableView">
                                    <tr>
                                        <td colspan="2"> SCL Comments</td>
                                    </tr>
                                    @foreach($scl_comment_lists as $scl_comment_list)
                                    <tr>
                                        <td>{{$scl_comment_list->user_id}} [{{$scl_comment_list->comment_row_created_date}}]
                                            (
                                            @foreach($department_lists as $department_list)
                                                @if($department_list->dept_row_id== $scl_comment_list->dept_id) 
                                                    {{$department_list->dept_name}}
                                                @endif
                                            @endforeach 
                                            ) : 
                                        </td>
                                        <td>{{$scl_comment_list->comment}}</td>
                                    </tr>
                                    @endforeach                                   
                                </table>
                            </div>
                            
                            <div class="col-md-4">
                                <table class="table table-bordered table-striped" id="taskTableView">
                                    <tr>
                                        <td colspan="2"> Client Comments</td>
                                    </tr>
                                    @foreach($client_comment_lists as $client_comment_list)
                                    <tr>
                                        <td>{{$client_comment_list->user_id}} [{{$client_comment_list->comment_row_created_date}}]
                                            (
                                            @foreach($department_lists as $department_list)
                                                @if($department_list->dept_row_id== $client_comment_list->dept_id) 
                                                    {{$department_list->dept_name}}
                                                @endif
                                            @endforeach 
                                            ) : 
                                        </td>
                                        <td>{{$client_comment_list->comment}}</td>
                                    </tr>
                                    @endforeach                                   
                                </table>
                            </div>
                            @if($_SESSION['dept_id'] ==10)
                            <div class="col-md-4">
                                <table class="table table-bordered table-striped" id="taskTableView">
                                    <tr>
                                        <td colspan="2"> {{$_SESSION['department']}} Internal Comments</td>
                                    </tr>
                                    @foreach($noc_comment_lists as $noc_comment_list)
                                    <tr>
                                        <td>{{$noc_comment_list->user_id}} [{{$noc_comment_list->comment_row_created_date}}]
                                            (
                                            @foreach($department_lists as $department_list)
                                                @if($department_list->dept_row_id== $noc_comment_list->dept_id) 
                                                    {{$department_list->dept_name}}
                                                @endif
                                            @endforeach 
                                            ) : 
                                        </td>
                                        <td>{{$noc_comment_list->comment}}</td>
                                    </tr>
                                    @endforeach                                   
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>                   
            </div>
        </section>
        

@include('navigation.p_footer')

