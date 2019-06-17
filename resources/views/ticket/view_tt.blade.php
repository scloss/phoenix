@include('navigation.p_header')
<link href="{{asset('css\jquery.contextMenu.css')}}" rel="stylesheet">
 <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
<!-- <script> $jq = jQuery.noConflict();</script>  

<script src="https://code.jquery.com/jquery-1.4.2.js"></script> -->
<!-- <script src="{{asset('js/jquery-1.4.2.min.js')}}"></script> -->
<!-- <script src="{{asset('js/jquery.contextMenu.js')}}"></script> -->
<script src="{{asset('js/ticket.js?v=1.1')}}"></script>



<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<script type="text/javascript">
    
    document.getElementById('ticket-collapse').className = 'panel-collapse collapse in';
    document.getElementById('ticket_view').className = 'active';

    function AutoRefresh( t ) 
    {
      setTimeout("location.reload(true);", t);
    }
</script>

<style type="text/css">
	label {
    display: inline-block;
    /*width: 5em;*/
  }
  td{
    padding:10px;
    border:1px solid grey;
    text-align:center;
  }
  div.dt-searchPanes div.pane div.title{
        background-color: transparent !important;
    }

</style>


<body onload="JavaScript:AutoRefresh(300000);">

<div class="content container">
    @if($dashboard_value)
        <h2 class="page-title"><?php echo strtoupper(str_replace("_"," ","$dashboard_value"));?><span class="fw-semi-bold"></span></h2>
    @else
        <h2 class="page-title">View Tickets <span class="fw-semi-bold"></span></h2>
    @endif
        
		<ul id="myMenu" class="contextMenu">
			<li class="edit"><a href="#view" ><b>View</b></a></li>
			<li class="cut separator"><a href="#edit"><b>Edit</b></b></a></li>
			<li class="copy"><a href="#copy"><b>Copy</b></a></li>
			<li class="paste"><a href="#paste"><b>Paste</b></a></li>
			<li class="delete"><a href="#delete"><b>Delete</b></a></li>
			<li class="quit separator"><a href="#quit"><b>Quit</b></a></li>
		</ul>
        <div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <div class="body">
                        <table id="incident_search_table">
                            <form id="incident_search" action="{{url('ViewTT')}}" method="GET">
                               
                                <tr>
                                    <td>Ticket ID</td>
                                    <td>Ticket Title</td>
                                    <td>Ticket Status</td>
                                    <td>Assigned Dept</td>
                                    <td>Assigned Subcenter</td>

                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="ticket_id" class="form-control input-transparent" value="{{$ticket_id}}">
                                    </td>
                                    <td>
                                        <input type="text" name="ticket_title" class="form-control input-transparent" value="{{$ticket_title}}">
                                        @if($dashboard_value !='')
                                            <input type="hidden" name="dashboard_value" value="{{$dashboard_value}}">
                                        @endif
                                    </td>
                                    <td>
                                        <label>
                                            <select id="select_style" name="ticket_status">
                                                <option selected></option>
                                                @if($ticket_status == 'not_closed')
                                                    <option selected value="not_closed">Not Closed</option>
                                                @else
                                                    <option value="not_closed">Not Closed</option>
                                                @endif
                                                
                                                @foreach($ticket_status_lists as $ticket_status_list)
                                                    @if($ticket_status_list->ticket_status_name==$ticket_status)
                                                        <option selected value="{{$ticket_status_list->ticket_status_name}}">{{$ticket_status_list->ticket_status_name}}</option>
                                                    @else
                                                         <option value="{{$ticket_status_list->ticket_status_name}}">{{$ticket_status_list->ticket_status_name}}</option>
                                                    @endif  
                                                @endforeach
                                            </select>    
                                        </label>
                                    </td>
                                    <td>
                                        <label >
                                            <select id="select_style" name="assigned_dept" >
                                                <option selected></option>
                                                @foreach($department_lists as $department_list) 
                                                    @if($department_list->dept_row_id==$assigned_dept)
                                                        <option selected value="{{$department_list->dept_row_id}}">{{$department_list->dept_name}}</option>
                                                    @else
                                                        <option value="{{$department_list->dept_row_id}}">{{$department_list->dept_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </label>
                                    </td>

                                    <td>
                                        <label >
                                            <select id="select_style" name="assigned_subcenter" >
                                                <option selected></option>
                                                @foreach($subcenter_lists as $subcenter) 
                                                    @if($subcenter->subcenter_name==$assigned_subcenter)
                                                        <option selected value="{{$subcenter->subcenter_name}}">{{$subcenter->subcenter_name}}</option>
                                                    @else
                                                        <option value="{{$subcenter->subcenter_name}}">{{$subcenter->subcenter_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </label>
                                    </td>
                                </tr>    
<!--                                 <tr>     
                                    <td>Ticket Time From</td>
                                    <td>
                                        <div id="ticket_time_from" class="input-group">
                                            <input id="datepicker2i" type="text" name="ticket_time_from" class="form-control input-transparent" >
                                            <span class="input-group-addon btn btn-info">
                                                <span class="glyphicon glyphicon-calendar"></span>                    
                                            </span>
                                        </div> 
                                    </td> 
                                    <td>Ticket Time To</td>
                                    <td>
                                        <div id="ticket_time_to" class="input-group">
                                            <input id="datepicker2i" type="text" name="ticket_time_to" class="form-control input-transparent" >
                                            <span class="input-group-addon btn btn-info">
                                                <span class="glyphicon glyphicon-calendar"></span>                    
                                            </span>
                                        </div> 
                                    </td>  
                                    <td>Ticket Closing Time From</td>
                                    <td>
                                        <div id="ticket_closing_time_from" class="input-group">
                                            <input id="datepicker2i" type="text" name="ticket_closing_time_from" class="form-control input-transparent" >
                                            <span class="input-group-addon btn btn-info">
                                                <span class="glyphicon glyphicon-calendar"></span>                    
                                            </span>
                                        </div> 
                                    </td>
                                    <td>Ticket Closing Time to</td>
                                    <td>
                                        <div id="ticket_closing_time_to" class="input-group">
                                            <input id="datepicker2i" type="text" name="ticket_closing_time_to" class="form-control input-transparent" >
                                            <span class="input-group-addon btn btn-info">
                                                <span class="glyphicon glyphicon-calendar"></span>                    
                                            </span>
                                        </div> 
                                    </td> 
                                </tr>
 -->

                                
                                <tr>
                                    <td colspan="14">
                                        <input type="submit" class="btn btn-primary"  name="Search" value="Search">
                                    </td>
                                </tr>
                            </form>
                        </table> 
                    </div> 
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <section class="widget">
                   <!--  <header>
                        <h4>
                            Table <span class="fw-semi-bold">Styles</span>
                        </h4>
                    </header> -->
                    <div class="body">
                    <center><h4>Total Tickets : {{$ticket_lists->total()}}</h4></center>
                    @if(count($ticket_lists)>0)
                    <div class="pagination"> {!! str_replace('/?', '?', $ticket_lists->appends(Input::except('page'))->render()) !!} </div>
                        <table class="table table-striped" id="ticket_table_view">
                            <thead>
                            <tr>
                                <th class="hidden-xs">TT ID</th>
                                <th class="hidden-xs">Ticket Title</th>
        
                                <th class="hidden-xs">Assigned To</th>
                                <th class="hidden-xs">Opening Time</th>
                                <th class="hidden-xs">TT Duration</th>
                                <th class="hidden-xs">Status</th>
                                <th class="hidden-xs">Pending Task Owner Dept</th>
                                <th class="hidden-xs">Subcenter</th>
                                <th class="hidden-xs">Edit</th>
                                <th class="hidden-xs">View</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ticket_lists as $ticket_list)
                            
                            <tr id="myDiv">
                                <td class="hidden-xs">{{$ticket_list->ticket_id}}</td>
                                <td class="context-menu-one">
                                    {{$ticket_list->ticket_title}}
                                </td>
                                <td class="hidden-xs">
                                    <?php
                                    $assigned_dept_arr = explode(',', $ticket_list->assigned_dept);
                                    //echo count($assigned_dept_arr);
                                    if(count($assigned_dept_arr) > 0){
                                       $assigned_dept_arr = array_unique($assigned_dept_arr); 
                                       //print_r($assigned_dept_arr);

                                    }
                                    $assigned_dept_temp = '';
                                    // $assigned_dept_arr = array_unique($assigned_dept_arr);
                                    // print_r($assigned_dept_arr);
                                    ?>
                                @for($i=0;$i<count($assigned_dept_arr);$i++)
                                    @foreach($department_lists as $department_list)

                                        @if(array_key_exists($i,$assigned_dept_arr))
                                            @if($department_list->dept_row_id == $assigned_dept_arr[$i]) 
                                                @if($i == count($assigned_dept_arr)-1)
                                                {{$department_list->dept_name}}
                                                <?php $assigned_dept_temp .= $department_list->dept_name.','; ?>
                                            </h5>
                                                @else
                                                {{$department_list->dept_name}},
                                                <?php $assigned_dept_temp .= $department_list->dept_name.','; ?>
                                            </h5>
                                                @endif
                                            @endif
                                        @endif

                                    @endforeach  
                                @endfor
                                </td>
                                <td class="hidden-xs">
                                    {{$ticket_list->ticket_row_created_date}}
                                </td>
                                <td >
                                
                                   @if($ticket_list->ticket_status != 'Closed')
                                    {{round($ticket_list->duration_now / 60,2)}} Hr
                                    @else
                                    {{round($ticket_list->closing_duration / 60,2)}} Hr
                                    @endif
                                    
                                </td>
                                <td class="hidden-xs">
                                    @if($ticket_list->ticket_status != 'Closed')
                                    <span class="label label-important"> {{$ticket_list->ticket_status}}</span>
                                    @else
                                    <span class="label label-success"> {{$ticket_list->ticket_status}}</span>
                                    @endif
                                	                          
                                </td>
                                <td class="hidden-xs">
                                    {{$ticket_list->task_assigned_dept}} 
                                </td>
                                <td class="hidden-xs">   
                                    {{$ticket_list->task_subcenter}}                       	
                                </td>
                                <td>
                                    <?php
                                    //echo $assigned_dept_temp;
                                    $session_dept = $_SESSION['department'];
                                    $session_dept_id = $_SESSION['dept_id'];
                                    if (preg_match("/$session_dept/i", $assigned_dept_temp) || preg_match("/$session_dept_id/i", $ticket_list->ticket_initiator_dept) ){ ?>
                                      <a href="{{ url('EditTT')}}?ticket_id={{$ticket_list->ticket_id}}" style="color:#fff"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a>
                                   <?php 
                                    }
                                    ?>
                                	
                                </td>
                                <td>
                                    <a href="{{ url('ViewTTSingle')}}?ticket_id={{$ticket_list->ticket_id}}" style="color:#fff"><h3><span class="glyphicon glyphicon-eye-open"></span></i></h3></a>
                                </td>
                            </tr>
                            @endforeach

                            </tbody>

                        </table>
                        <div class="clearfix">

                        </div>
                    </div>
                    @endif
                </section>
            </div>
        </div>
        @if($_SESSION["dept_id"] == 10)
        <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.searchPane.min.css')}}">
<script type="text/javascript" src="{{asset('js/dataTables.searchPane.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.yadcf.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
            
            var table = $('#ticket_table_view_op').DataTable({
                searchPane: true,
                sort:false,
                pageLength: 100,
                bStateSave: true
            });
            $('.pane').each(function(i, obj) {
                if(i != 2 && i != 3 && i != 5 ){
                    $(obj).hide();
                }
            });

        });
</script>
        <div class="row">
            <div class="col-md-12">
                <div class="content container">
                <h2 class="page-title"><center>RFO List ({{count($rfo_lists)}})</center><span class="fw-semi-bold"></span></h2>  
                <div class="row">
                        <div class="col-md-12">
                            <section class="widget">
                                <div class="body">
                              
                                <table class="table table-striped" id="ticket_table_view_rfo">
                                        <thead>
                                        <tr>
                                            <th class="hidden-xs">Ticket ID</th>
                                            <th class="hidden-xs">Ticket Title</th>
                                            <th class="hidden-xs">Element Name</th>
                                            <th class="hidden-xs">Event Time</th>
                                            <th class="hidden-xs">Task Description</th>
                                            <th class="hidden-xs">Client</th>
                                            <th class="hidden-xs">Issue Type</th>
                                            <th class="hidden-xs">Action</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($rfo_lists as $rfo_list)
                                                <tr id="myDiv">
                                                    <td class="hidden-xs">{{$rfo_list->ticket_id}}</td>
                                                    <td class="hidden-xs">{{$rfo_list->ticket_title}}</td>
                                                    <td class="hidden-xs">{{$rfo_list->element_name}}</td>
                                                    <td class="hidden-xs">{{$rfo_list->event_time}}</td>
                                                    <td class="hidden-xs" style="word-break: break-word;">{{$rfo_list->task_description}}</td>
                                                    <td class="hidden-xs">{{$rfo_list->client_name}}</td>
                                                    <td class="hidden-xs">{{$rfo_list->issue_type}}</td>
                                                    <td>
                                                        <a href="{{ url('EditTT')}}?ticket_id={{$rfo_list->ticket_id}}#{{$rfo_list->fault_id}}" id="edit_button" style="color:#fff;font-size:1.3em"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a>
                                                    </td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="clearfix">

                                    </div>
                                </div>
                            </section>
                        </div>

                    </div>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="content container">
                <h2 class="page-title"><center>OP List ({{count($op_lists)}})</center><span class="fw-semi-bold"></span></h2>  
                <div class="row">
                        <div class="col-md-12">
                            <section class="widget">
                                <div class="body">
                              
                                    <table class="table table-striped" id="ticket_table_view_op">
                                        <thead>
                                        <tr>
                                            <th class="hidden-xs">Ticket ID</th>
                                            <th class="hidden-xs">Ticket Title</th>
                                            <th class="hidden-xs">Client</th>
                                            <th class="hidden-xs">Link Type</th>
                                            <th class="hidden-xs">OP Comment</th>
                                            <th class="hidden-xs">Issue Type</th>
                                            <th class="hidden-xs">Action</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($op_lists as $op_list)
                                                <tr id="myDiv">
                                                    <td class="hidden-xs">{{$op_list->ticket_id}}</td>
                                                    <td class="hidden-xs">{{$op_list->ticket_title}}</td>
                                                    <td class="hidden-xs">{{$op_list->client}}</td>
                                                    <td class="hidden-xs">{{$op_list->link_type}}</td>
                                                    
                                                    <td class="hidden-xs">
                                                        <i><span style="color : #7cff48;font-size:13px"><b>{{$op_list->task_comment_user_id}} </b>[{{$op_list->task_comment_time}}] </span></i> : {{$op_list->task_comments}}
                                                    </td>
                                                
                                                    
                                                    <td class="hidden-xs">
                                                        {{$op_list->issue_type}}
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('EditTT')}}?ticket_id={{$op_list->ticket_id}}" id="edit_button" style="color:#fff;font-size:1.3em"><i class="fa fa-pencil-square-o" aria-hidden="true" id="edit_icon"></i></a>
                                                    </td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="clearfix">

                                    </div>
                                </div>
                            </section>
                        </div>

                    </div>
            </div>
            </div>
        </div>
        @endif
        
 </body>    
@include('navigation.p_footer')

