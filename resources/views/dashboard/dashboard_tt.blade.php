@include('navigation.p_header')

<link href="{{asset('css/jquery.contextMenu.css')}}" rel="stylesheet">
 <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
<script> $jq = jQuery.noConflict();</script>  

<script src="https://code.jquery.com/jquery-1.4.2.js"></script>
<!-- <script src="{{asset('js/jquery-1.4.2.min.js')}}"></script> -->
<script src="{{asset('js/jquery.contextMenu.js')}}"></script>
<script src="{{asset('js/ticket.js')}}"></script>

<script type="text/javascript">
    document.getElementById('dashboard-collapse').className = 'panel-collapse collapse in';
    document.getElementById('dashboard_live').className = 'active';
</script>
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">

<style type="text/css">

	.row{
		padding-bottom: 0.5cm;
	}
	.btn-lg{
		padding-bottom: 1.5cm;
	}
	a{
		text-decoration:none !important; 
	}

</style>
<style type="text/css">

  #notification_box{
    z-index: 100000000000000 !important;
  }
  #support-menu{
    z-index: 1000000000000 !important;
  }
  #mainDiv{
    margin:2%;
  }
  .row{
    padding-bottom: 0.5cm;
  }
  .btn-lg{
    padding-bottom: 1.5cm;
  }
  a{
    text-decoration:none !important; 
  }
  .panel-footer{
    color:#3f51b5;
  }
  .panel-red {
    background-color: #d9534f;
    color:#fff;
  }
  .panel-green {
    background-color: #5cb85c;
    color:#fff;
  }
  .panel-yellow {
    background-color: #f0ad4e;
    color:#fff;
  }
  .panel-heading {
    height: 150px;
  }

</style>

<div class="content container">
        <div class="row">
          <h2 class="page-title">Dashboard <span class="fw-semi-bold"></span></h2>

          <div class="row">
              <div class="col-md-12">
                  <section class="widget">
                      <div class="body">

                      <!-- <div class="well well-sm"> -->
                              
                              <div class="row">
                                  <div class="col-md-3">
                                    <a href="{{ url('ViewTT?dashboard_value=my_open_tickets') }}">
                                    <div class="panel panel-primary">                                     
                                        <div class="panel-heading">

                                            <div class="row">
                                                <div class="col-xs-1">
                                                </div>
                                                <div class="col-xs-3">
                                                    <br>
                                                    <i class="fa fa-folder-open-o fa-5x"></i>
                                                </div>
                                                <div class="col-xs-7 text-right">
                                                    <h3><b>{{$my_open_tickets_count}}</b></h3>
                                                    <h4><b>My Open Tickets</b></h4><br>
                                                </div>
                                                <div class="col-xs-1">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                    </div>
                                    </a>
                                  </div>
                                  <div class="col-md-3">
                                  <a href="{{ url('ViewTT?dashboard_value=my_inititated_open_tickets') }}">
                                      <div class="panel panel-green">                                     
                                        <div class="panel-heading">

                                            <div class="row">
                                                <div class="col-xs-1">
                                                </div>
                                                <div class="col-xs-3">
                                                    <br>
                                                    <i class="fa fa-desktop fa-5x"></i>
                                                </div>
                                                <div class="col-xs-7 text-right">
                                                    <h3><b>{{$my_inititated_open_tickets_count}}</b></h3>
                                                    <h4><b>My Initiated Open Tickets</b></h4>
                                                </div>
                                                <div class="col-xs-1">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                       
                                      </div>
                                  </a>
                                  </div>
                                  <div class="col-md-3">
                                    <a href="{{ url('ViewTT?dashboard_value=total_open_tickets') }}">
                                        <div class="panel panel-yellow">                                     
                                          <div class="panel-heading">

                                              <div class="row">
                                                  <div class="col-xs-1">
                                                  </div>
                                                  <div class="col-xs-3">
                                                      <br>
                                                      <i class="fa fa-rss fa-5x"></i>
                                                  </div>
                                                  <div class="col-xs-7 text-right">
                                                      <h3><b>{{$total_open_tickets_count}}</b></h3>
                                                      <h4><b>Total Open Tickets</b></h4><br>
                                                  </div>
                                                  <div class="col-xs-1">
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <div class="panel-footer">
                                              <span class="pull-left">View Details</span>
                                              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                              <div class="clearfix"></div>
                                          </div>
                                        
                                        </div>
                                    </a>
                                  </div>
                                  <div class="col-md-3">
                                    <a href="{{ url('ViewTT?dashboard_value=my_notification_count') }}">
                                        <div class="panel panel-red">                                     
                                          <div class="panel-heading">

                                              <div class="row">
                                                  <div class="col-xs-1">
                                                  </div>
                                                  <div class="col-xs-3">
                                                      <br>
                                                      <i class="fa fa-bell fa-5x"></i>
                                                  </div>
                                                  <div class="col-xs-7 text-right">
                                                      <h3><b>{{$my_notification_count}}</b></h3>
                                                      <h4><b>My Notifications</b></h4><br>
                                                  </div>
                                                  <div class="col-xs-1">
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <div class="panel-footer">
                                              <span class="pull-left">View Details</span>
                                              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                              <div class="clearfix"></div>
                                          </div>
                                        
                                        </div>
                                    </a>
                                  </div>
                              </div>
                              <!-- ************************** -->
                              <div class="row">
                              <div class="col-md-3">
                                
                                    <a href="{{ url('ViewTT?dashboard_value=last_hour_closed') }}">
                                        <div class="panel panel-green">                                     
                                          <div class="panel-heading">

                                              <div class="row">
                                                  <div class="col-xs-1">
                                                  </div>
                                                  <div class="col-xs-3">
                                                      <br>
                                                      <i class="fa fa-exclamation-triangle fa-5x"></i>
                                                  </div>
                                                  <div class="col-xs-7 text-right">
                                                      <h3><b>{{$dashboard_last_hour_closed_ticket_count}}</b></h3>
                                                      <h4><b>My Initiated Tickets Closed in Last Hour</b></h4>
                                                  </div>
                                                  <div class="col-xs-1">
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <div class="panel-footer">
                                              <span class="pull-left">View Details</span>
                                              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                              <div class="clearfix"></div>
                                          </div>
                                        
                                        </div>
                                    </a>
                                  </div>
                              <div class="col-md-3">
                                    <a href="{{ url('ViewTT?dashboard_value=client_confirmation_pending') }}">
                                        <div class="panel panel-primary">                                     
                                          <div class="panel-heading">

                                              <div class="row">
                                                  <div class="col-xs-1">
                                                  </div>
                                                  <div class="col-xs-3">
                                                      <br>
                                                      <i class="fa fa-file-excel-o fa-5x"></i>
                                                  </div>
                                                  <div class="col-xs-7 text-right">
                                                      <h3><b>{{$dashboard_client_confirmation_pending_count}}</b></h3>
                                                      <h4><b>Client Confirmation Pending</b></h4>
                                                  </div>
                                                  <div class="col-xs-1">
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <div class="panel-footer">
                                              <span class="pull-left">View Details</span>
                                              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                              <div class="clearfix"></div>
                                          </div>
                                        
                                        </div>
                                    </a>
                                  </div>
                                  <!-- <div class="col-md-3">
                                    <a href="{{ url('ViewTT?dashboard_value=dashboard_open_tasks') }}">
                                        <div class="panel panel-red">                                     
                                          <div class="panel-heading">

                                              <div class="row">
                                                  <div class="col-xs-1">
                                                  </div>
                                                  <div class="col-xs-3">
                                                      <br>
                                                      <i class="fa fa-tasks fa-5x"></i>
                                                  </div>
                                                  <div class="col-xs-7 text-right">
                                                      <h3><b>{{$dashboard_open_task_count}}</b></h3>
                                                      <h4><b>Open Tasks</b></h4><br>
                                                  </div>
                                                  <div class="col-xs-1">
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <div class="panel-footer">
                                              <span class="pull-left">View Details</span>
                                              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                              <div class="clearfix"></div>
                                          </div>
                                        
                                        </div>
                                    </a>
                                  </div> -->
                                  <div class="col-md-3">
                                     <a href="{{ url('ViewTT?dashboard_value=pending_task') }}">
                                        <div class="panel panel-yellow">                                     
                                          <div class="panel-heading">

                                              <div class="row">
                                                  <div class="col-xs-1">
                                                  </div>
                                                  <div class="col-xs-3">
                                                      <br>
                                                      <i class="fa fa-ticket fa-5x"></i>
                                                  </div>
                                                  <div class="col-xs-7 text-right">
                                                      <h3><b>{{$dashboard_pending_task_count}}</b></h3>
                                                      <h4><b>My Pending Tasks</b></h4><br>
                                                  </div>
                                                  <div class="col-xs-1">
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <div class="panel-footer">
                                              <span class="pull-left">View Details</span>
                                              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                              <div class="clearfix"></div>
                                          </div>
                                        
                                        </div>
                                    </a>
                                  </div>

                                <div class="col-md-3">
                                     <a href="{{ url('ViewTT?dashboard_value=qa_tickets') }}">
                                        <div class="panel panel-blue">                                     
                                          <div class="panel-heading">

                                              <div class="row">
                                                  <div class="col-xs-1">
                                                  </div>
                                                  <div class="col-xs-3">
                                                      <br>
                                                      <i class="fa fa-line-chart fa-5x"></i>
                                                  </div>
                                                  <div class="col-xs-7 text-right">
                                                      <h3><b>{{$count_qa_tt}}</b></h3>
                                                      <h4><b>My QA Tickets</b></h4><br>
                                                  </div>
                                                  <div class="col-xs-1">
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <div class="panel-footer">
                                              <span class="pull-left">View Details</span>
                                              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                              <div class="clearfix"></div>
                                          </div>
                                        
                                        </div>
                                        </a>
                                    </div>

                              </div>
                             
                          </div>

                          <div class="clearfix">

                          </div>
                      </div>
                  </section>
              </div>
          </div>
      </div>
</div>        
@include('navigation.p_footer')