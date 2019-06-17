<!DOCTYPE html>
<html>
<head>
    

    <title>Phoenix</title>

        <link href="{{asset('css/application.min.css')}}" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="{{asset('css/header_tt.css')}}">
        <script type="text/javascript" src="{{asset('js/header_tt.js')}}"></script>
    <link rel="shortcut icon" href="img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    

    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
           chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
                      https://code.google.com/p/chromium/issues/detail?id=332189
        */
        var tempNotifiCount = 0;

    </script>
    <style type="text/css">
        #notification_box{
            z-index: 100000000000000 !important;
          }
          #support-menu{
            z-index: 1000000000000 !important;
          }
          .wrap{
            margin-left:-2%;
          }
          .sidebar{
            position:relative;
          }
    </style>
    
</head>

<!-- <script src="{{asset('lib/jquery/dist/jquery.min.js')}}"></script> -->

<!-- <script src="{{asset('lib/widgster/widgster.js')}}"></script> -->
<script src="{{asset('lib/underscore/underscore.js')}}"></script>

<!-- common application js -->
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/settings.js')}}"></script>
<link href="{{asset('css/read_only.css')}}" rel="stylesheet">

<script type="text/javascript">
function toggle_nav() {
    var x = document.getElementById('nav_div');
    if (x.style.display === 'none') {
        x.style.display = 'block';
        document.getElementById("toggle_wrap").style.marginLeft = "0px";
        document.getElementById("wrap_div").className = "col-md-10";
    } 
    else {
        x.style.display = 'none';
        document.getElementById("toggle_wrap").style.marginLeft = "0px";
        document.getElementById("wrap_div").className = "col-md-12";
    }
}
function toggle_dashboard() {
    var x = document.getElementById('toggleDashboard');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } 
    else {
        x.style.display = 'none';
    }
}
function toggle_graph() {
    var x = document.getElementById('toggleGraph');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } 
    else {
        x.style.display = 'none';
    }
}

</script>



<script type="text/template" id="sidebar-settings-template">
    <% auto = sidebarState == 'auto'%>
    <% if (auto) {%>
    <button type="button"
            data-value="icons"
            class="btn-icons btn btn-transparent btn-sm">Icons</button>
    <button type="button"
            data-value="auto"
            class="btn-auto btn btn-transparent btn-sm">Auto</button>
    <%} else {%>
    <button type="button"
            data-value="auto"
            class="btn btn-transparent btn-sm">Auto</button>
    <% } %>
</script>

<body>
    <div class="col-md-2" id="nav_div">
    <div >
    <div class="logo">
        <h4><a href="{{ url('DashboardTT') }}"><!-- <img src="{{asset('/img/phoenix.gif')}}" width="100px"> --><strong>SCL</strong> Ticketing Tool</a></h4>
    </div>
        <nav id="sidebar" class="sidebar nav-collapse collapse">
            <ul id="side-nav" class="side-nav">
                <li class="panel">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#dashboard-collapse"><i class="fa fa-home"></i> <span class="name">Dashboard</span></a>
                    <ul id="dashboard-collapse" class="panel-collapse collapse">
                        <li id="dashboard_live" class=""><a href="{{ url('DashboardTT') }}">Ticket Dashboard</a></li>
                        <li id="dashboard_graph" class=""><a href="{{ url('DashboardGraph') }}">Fault Dashboard</a></li>
                       
                    </ul>
                </li>
                <li class="panel ">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#ticket-collapse"><i class="fa fa-ticket"></i> <span class="name">TIcket</span></a>
                    <ul id="ticket-collapse" class="panel-collapse collapse ">
                        <li id="ticket_create" class=""><a href="{{ url('CreateTT') }}">Create a Ticket</a></li>
                        <li id="ticket_view" class=""><a href="{{ url('ViewTT') }}">View Tickets</a></li>
                    </ul>
                </li>
                <li class="panel ">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#fault-collapse"><i class="fa fa-area-chart"></i> <span class="name">Fault Manager</span></a>
                    <ul id="fault-collapse" class="panel-collapse collapse ">
                        <li id="fault_view" class=""><a href="{{url('FaultView')}}">View Fault</a></li>         
                    </ul>
                </li>
                <li class="panel ">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#task-collapse"><i class="fa fa-stack-overflow"></i> <span class="name">Task Manager</span></a>
                    <ul id="task-collapse" class="panel-collapse collapse ">
                        <li id="task_view" class=""><a href="{{url('TaskView')}}">View Task</a></li>         
                    </ul>
                </li> 
                <li class="panel ">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#kpi-collapse"><i class="fa fa-area-chart"></i> <span class="name">KPI Manager</span></a>
                    <ul id="kpi-collapse" class="panel-collapse collapse ">
                        <li  id="kpi_module"  class=""><a href="{{url('KpiView')}}">KPI Task</a></li> 
                        <li  id="kpi_module_fault"  class=""><a href="{{url('KpiViewFault')}}">KPI Fault</a></li>          
                    </ul>
                </li> 
               <li class="panel ">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#link-collapse"><i class="fa fa-tasks"></i> <span class="name">Link Manager</span></a>
                    <ul id="link-collapse" class="panel-collapse collapse ">
                        <li id="link_create"  class=""><a href="{{url('create_link')}}">Create a Link</a></li>   
                        <li id="link_view" class=""><a href="{{url('view_link')}}">View Links</a></li>   
                        <!-- <li id="create_reason" class=""><a href="{{url('#')}}">Create Reason</a></li>        -->
                    </ul>
                </li> 
                <li class="panel ">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#site-collapse"><i class="fa fa-tasks"></i> <span class="name">Site Manager</span></a>
                    <ul id="site-collapse" class="panel-collapse collapse ">
                        <li id="site_create"  class=""><a href="{{url('create_site')}}">Create a Site</a></li>  
                        <li id="site_view"  class=""><a href="{{url('view_site')}}">View Sites</a></li>         
                    </ul>
                </li>

                <li class="panel ">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#incident-collapse"><i class="fa fa-area-chart"></i> <span class="name">Incident Manager</span></a>
                    <ul id="incident-collapse" class="panel-collapse collapse ">
                        <li id="incident_view"  class=""><a href="{{url('IncidentView')}}">View Incident</a></li>
                        <li id="incident_merge"  class=""><a href="{{url('IncidentMerge')}}">Merge Incident</a></li>
                        
                    </ul>
                </li>  
                
                 @if($_SESSION['access_type']=='SL')                 
                  <li class="panel ">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#client-collapse"><i class="fa fa-users"></i> <span class="name">Client Manager</span></a>
                    <ul id="client-collapse" class="panel-collapse collapse ">
                        <li id="client_create"  class=""><a href="{{url('create_client')}}">Create a Client</a></li>   
                        <li id="client_view" class=""><a href="{{url('view_client')}}">View Clients</a></li>         
                    </ul>
                </li> 
                                              
                

                 
                
                <!-- <li class="panel ">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#report-collapse"><i class="fa fa-magic"></i> <span class="name">Reporting</span></a>
                    <ul id="report-collapse" class="panel-collapse collapse ">
                        <li  id="report_module" class=""><a href="{{url('Reporting')}}">Reporting Module</a></li>
                    </ul>
                </li> -->
                @endif

                @if($_SESSION['dept_id'] == 10)
                <li class="panel ">
                    <a class="accordion-toggle collapsed" href="http://172.16.136.80/scl_sms_system/public/noticehistory?phoenix_user={{$_SESSION['user_id']}}" target="_blank"><i class="fa fa-envelope-square"></i> <span class="name">Notice History</span></a>
                    
                </li>
                @endif
            </ul>
            @include('navigation.p_cart')
            
        </nav> 

     </div>   
</div>
<div id="wrap_div" class="col-md-10">
        <div class="wrap" id="toggle_wrap" >
        <header class="page-header">

            <div class="navbar">
                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="visible-phone-landscape">
                        <a href="#" id="search-toggle">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                    <input type="hidden" name="hiddenNotificationCount" id="hiddenNotificationCount" value="">
                    <li class="dropdown" id="notification_box">
                        
                        
                    </li>
                    <li class="divider"></li>
                    <li class="hidden-xs dropdown">
                        <a href="#" title="Account" id="account" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                        </a>
                        <ul id="account-menu" class="dropdown-menu account" role="menu" style="padding:3px;">
                            <li role="presentation" class="account-picture">
                                <img src="{{asset('img/2.png')}}" alt="">
                                {{$_SESSION['user_name']}}
                            </li>
                            <li role="presentation">
                               
                                    <i class="fa fa-user"></i>
                                    {{$_SESSION['designation']}}
                                
                            </li>
                            <li role="presentation" >
                                
                                    <i class="fa fa-calendar"></i>
                                    {{$_SESSION['department']}}
                              
                            </li>
                            <li role="presentation" >
                                    <p style="width:180px;word-wrap: break-word;"><i class="fa fa-inbox" style="display:inline;margin-right:2px;"></i>{{$_SESSION['email']}}</p>
                            </li>
                            <li role="presentation">
                               
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                    {{$_SESSION['phone']}}
                               
                            </li>                            
                        </ul>
                    </li>
                    <li class="visible-xs">
                        <a href="#" class="btn-navbar" data-toggle="collapse" data-target=".sidebar" title="">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                    <li class="hidden-xs"><a href="{{ url('logout')}}"><i class="glyphicon glyphicon-off"></i></a></li>
                </ul>


            </div>
            

        </header>

