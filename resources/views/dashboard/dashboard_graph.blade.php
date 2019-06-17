@include('navigation.p_header')

<link href="{{asset('css/jquery.contextMenu.css')}}" rel="stylesheet">
 <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('css/material.css')}}">
<script> $jq = jQuery.noConflict();</script>  

<!-- <script src="https://code.jquery.com/jquery-1.4.2.js"></script> -->
<!-- <script src="{{asset('js/jquery-1.4.2.min.js')}}"></script> -->
<script src="{{asset('js/jquery.contextMenu.js')}}"></script>
<script src="{{asset('js/ticket.js')}}"></script>
<script src="{{asset('lib/bootstrap-sass/assets/javascripts/bootstrap.min.js')}}"></script>
<!-- <script src="{{asset('/js/highcharts.js')}}"></script> -->
<script src="{{asset('js/canvasjs.min.js')}}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="{{asset('js/custom_theme.js')}}"></script>
<script src="{{asset('js/link_12_hour.js')}}"></script>
<script src="{{asset('js/backbone_link_12_hour.js')}}"></script>
<script src="{{asset('js/site_12_hour.js')}}"></script>
<script src="{{asset('js/agg_site_12_hour.js')}}"></script>
<!-- <script src="{{asset('js/preagg_site_12_hour.js')}}"></script> -->
<script src="{{asset('js/district_link_12_hour.js')}}"></script>
<script src="{{asset('js/district_site_12_hour.js')}}"></script>
<script src="{{asset('js/robi_site_hour.js?v2')}}"></script>
<script src="{{asset('js/gp_site_hour.js')}}"></script>
<!-- <script src="{{asset('js/test.js')}}"></script> -->
<script type="text/javascript">
    
    document.getElementById('dashboard-collapse').className = 'panel-collapse collapse in';
    document.getElementById('dashboard_graph').className = 'active';

    function AutoRefresh( t ) 
    {
      setTimeout("location.reload(true);", t);
    }
</script>
<!-- <script src="{{asset('js/robi_link_hour.js')}}"></script>
<script src="{{asset('js/gp_link_hour.js')}}"></script> -->

<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
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
    color : #ffffff;
  }
  a:hover{
    color : #ffffff;
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
</style>

<script type="text/javascript">
  var site_down_time = "<?php echo $site_availability_count; ?>";
  var site_up_time = "<?php echo $site_total_hour_count; ?>";
  var link_up_time = "<?php echo $link_total_hour_count; ?>";
  var link_down_time = "<?php echo $link_availability_count; ?>";
  var backbone_link_up_time = "<?php echo $backbone_link_total_hour_count; ?>";
  var backbone_link_down_time = "<?php echo $backbone_link_availability_count; ?>";
  var agg_up_time = "<?php echo $agg_total_hour_count; ?>";
  var agg_down_time = "<?php echo $agg_site_availability_count; ?>";
  var preagg_up_time = "<?php echo $preagg_total_hour_count; ?>";
  var preagg_down_time = "<?php echo $preagg_site_availability_count; ?>";

  var top_5_district_site_arr = <?php echo json_encode($top_5_district_site_arr) ?>;
  var top_5_district_site_arr_keys = <?php echo json_encode($top_5_district_site_arr_keys) ?>;
  var top_5_district_link_arr = <?php echo json_encode($top_5_district_link_arr) ?>;
  var top_5_district_link_arr_keys = <?php echo json_encode($top_5_district_link_arr_keys) ?>;

  var top_5_district_site_count_arr = <?php echo json_encode($top_5_district_site_count_arr) ?>;
  var top_5_district_link_count_arr = <?php echo json_encode($top_5_district_link_count_arr) ?>;


  var robi_site_availability_count_arr = <?php echo json_encode($robi_site_availability_count_arr) ?>;

  console.log("arraY:");
  console.log(robi_site_availability_count_arr[0]);

  var gp_site_availability_count_arr = <?php echo json_encode($gp_site_availability_count_arr) ?>;
  var robi_link_availability_count_arr = <?php echo json_encode($robi_link_availability_count_arr) ?>;
  var gp_link_availability_count_arr = <?php echo json_encode($gp_link_availability_count_arr) ?>;


  //alert(top_5_district_arr);
</script>
<body onload="JavaScript:AutoRefresh(300000);">
<div  class="container-fluid" id="mainDiv">
    <a href="#" onClick="toggle_nav()" style="color:#fff;"><i class="fa fa-plus-square" ></i></a> <a href="#" onClick="toggle_dashboard()" style="color:#fff;"><i class="fa fa-plus-square" ></i></a> <a href="#" onClick="toggle_graph()" style="color:#fff;"><i class="fa fa-plus-square" ></i></a> 
    <div id="toggleDashboard">
    <section class="widget" id="widget_style">
    <div class="row" id="row_style">
      <div class="col-md-3 col-sm-3" id="grid_box">
        <div class="style-box-one Style-sky">
            <a href="{{ url('FaultView?dashboard_value=nms_site_down') }}">
              <h1>{{$down_site_nms_count}}</h1> 
              <!-- <h1>15</h1> -->
              <span>Site Down</span>
              <br>
              <span style="font-size:22px">( As per UNMS )</span>
            </a>
        </div>
      </div>
      <div class=" col-md-3 col-sm-3" id="grid_box">
        <div class="style-box-one Style-sky">
            <a href="{{ url('FaultView?dashboard_value=site_down') }}">
              <h1>{{$down_site_count}}</h1>
              <!-- <h1>20</h1> -->
              <span>Site Down</span>
              <br>
              <span style="font-size:22px">( As per Ticketing Tool )</span>

            </a>
        </div>
      </div>
      <div class=" col-md-3 col-sm-3" id="grid_box">
        <a href="{{ url('FaultView?dashboard_value=oh_link_down') }}">
        <div class="style-box-one Style-forest-green">
            
              <h1>{{$oh_count}}</h1>
              <!-- <h1>31</h1> -->
              <span>OH Link Down</span>
            
        </div>
        </a>
      </div>
      <div class=" col-md-3 col-sm-3" id="grid_box">
        <a href="{{ url('FaultView?dashboard_value=ug_link_down') }}">
        <div class="style-box-one Style-mud">
            
              <h1>{{$ug_count}}</h1>
              <span>UG Link Down</span>
            
        </div>
        </a>
      </div>
      <div class=" col-md-3 col-sm-3" id="grid_box">
        <a href="{{ url('FaultView?dashboard_value=quality_problem') }}">
        <div class="style-box-one Style-forest-green">
            
              <h1>{{$quality_count}}</h1>
              <span>Quality Problem</span>
            
        </div>
        </a>
      </div>
      <div class=" col-md-3 col-sm-3" id="grid_box">
        <a href="{{ url('FaultView?dashboard_value=external_power_alarm') }}">
        <div class="style-box-one Style-mud">
            
              <h1>{{$external_power_count}}</h1>
              <span>External Power Alarm</span>
            
        </div>
        </a>
      </div>
      <div class=" col-md-3 col-sm-3" id="grid_box">
        <a href="{{ url('FaultView?dashboard_value=iig_issue') }}">
        <div class="style-box-one Style-orange">
            
              <h1>{{$iig_count}}</h1>
              <span>IIG Issue</span>
            
        </div>
        </a>
      </div>
      <div class=" col-md-3 col-sm-3" id="grid_box">
        <a href="{{ url('FaultView?dashboard_value=icx_issue') }}">
        <div class="style-box-one Style-light-purple">
            
              <h1>{{$icx_count}}</h1>
              <span>ICX Issue</span>
            
        </div>
        </a>
      </div>
      <div class=" col-md-3 col-sm-3" id="grid_box">
        <a href="{{ url('FaultView?dashboard_value=itc_issue') }}">
        <div class="style-box-one Style-purple">
            
              <h1>{{$itc_count}}</h1>
              <span>ITC Issue</span>
            
        </div>
        </a>
      </div>
      <div class=" col-md-3 col-sm-3" id="grid_box">
        <a href="{{ url('FaultView?dashboard_value=info_banbeis_issue') }}">
        <div class="style-box-one Style-green">
            
              <h1>{{$info_banbeis_count}}</h1>
              <h3 >Info Sarker & BANBEIS Issues</h3>
           
        </div>
         </a>
      </div>
      <div class=" col-md-3 col-sm-3" id="grid_box">
        <a href="{{ url('FaultView?dashboard_value=implementation_issue') }}">
        <div class="style-box-one Style-dark-green">
            
              <h1>{{$implementation_count}}</h1>
              <h3>Implementation Issues</h3>
            
        </div>
        </a>
      </div>
      <div class=" col-md-3 col-sm-3" id="grid_box">
        <a href="{{ url('FaultView?dashboard_value=lhtx_issue') }}">
        <div class="style-box-one Style-purple">
            
              <h1>{{$lx_tx_issue_count}}</h1>
              <!-- <h1>33</h1> -->
              <span>LH/TX Issue</span>
            
        </div>
        </a>
      </div>
      <div class=" col-md-3 col-sm-3" id="grid_box">
        <div class="style-box-one Style-blue">
           <a href="{{ url('FaultView?dashboard_value=long_pending') }}">
              <h1>{{$long_pending_count}}</h1>
              <!-- <h1>76</h1> -->
              <span>Long Pending Issue</span>
            </a>
        </div>
      </div>

      <div class=" col-md-3 col-sm-3" id="grid_box">
        <div class="style-box-one Style-light-purple">
           <a href="{{ url('FaultView?dashboard_value=qa_issue') }}">
              <h1>{{$qa_fault_count}}</h1>
              <span>QA Issue</span>
            </a>
        </div>
      </div>


    </section>  
    </div>
    </div>
 <div class="container-fluid" id="mainDiv">
    <div id="toggleGraph">
    <section class="widget" id="widget_style">    
      <div class="row">
          <div class="col-md-6" id="containerSitePie" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
          <div class="col-md-6" id="containerLinkPie" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>        
      </div>
      <br>
      <div class="row">
          <div class="col-md-6" id="containerDistrictSiteBar" style="min-width: 310px; max-width: 800px; height: 600px; margin: 0 auto"></div>
          <div class="col-md-6" id="containerDistrictLinkBar" style="min-width: 310px; max-width: 800px; height: 600px; margin: 0 auto"></div>
      </div>
      <br>
      <div class="row">
          <div class="col-md-6" id="containerRobiSitePie" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
          <div class="col-md-6" id="containerGPSitePie" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
      </div>
      <br>
  <!--     <div class="row">
          <div class="col-md-6" id="containerRobiLinkPie" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
          <div class="col-md-6" id="containerGPLinkPie" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
      </div> -->
      <div class="row">
          <div class="col-md-6" id="containerAggSitePie" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
          <div class="col-md-6" id="containerBackboneLinkPie" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
      </div>
      <br>
      <div class="row">
          
          <!-- <div class="col-md-6" id="containerTest" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div> -->
      </div>
      <br>
    </section>  
    </div>
</div>
</body>
@include('navigation.p_footer')




