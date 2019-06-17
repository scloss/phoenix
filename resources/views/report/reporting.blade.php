@include('navigation.p_header')
<link href="{{asset('css\jquery.contextMenu.css')}}" rel="stylesheet">
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
    
    document.getElementById('report-collapse').className = 'panel-collapse collapse in';
    document.getElementById('report_module').className = 'active';
</script>

<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/report_style.css')}}">

<div class="container-fluid" id="incident_main_div">
    <h2 class="page-title">Reporting<span class="fw-semi-bold"></span></h2>
    <!-- @if(isset($_SESSION["CURRENT_LIST"]))
    <p style="color:#fff;">{{$_SESSION["CURRENT_LIST"]}}</p>
    @endif -->
    <div clss="row">
        <section class="widget" id="default-widget"">
            <div class="body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="report_template">
                            <tr>
                                <form action="{{ url('ExportReport') }}" id="tt_report_form" method="post" enctype="multipart/form-data">
                                <td>
                                    Select Week
                                </td>
                                <td>
                                    <label style="float:left;">
                                        <select id="select_style" name="weekNum">
                                                <option value="">Last 7 Days</option>
                                            @for($i=1;$i<54;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor                                         
                                        </select>
                                    </label>    
                                </td>
                                <td>Select Template</td>
                                <td>
                                    <label style="float:left;">
                                        <select id="select_style" name="reportTemplateName">
                                            <option value="top_10_isp_reports_downtime_weekly">Top 10 ISP Report on Downtime - Weekly</option>
                                            <option value="top_10_robi_site_reports_downtime_weekly">Top 10 Robi Site Report on Downtime - Weekly</option>
                                            <option value="top_10_gp_site_reports_downtime_weekly">Top 10 GP Site Report on Downtime - Weekly</option>
                                            <option value="top_10_teletalk_site_reports_downtime_weekly">Top 10 Teletalk Site Report on Downtime - Weekly</option>
                                            <option value="top_10_robi_link_reports_downtime_weekly">Top 10 Robi Site Report on Downtime - Weekly</option>
                                            <option value="top_10_gp_link_reports_downtime_weekly">Top 10 GP Site Report on Downtime - Weekly</option>
                                            <option value="top_10_teletalk_link_reports_downtime_weekly">Top 10 Teletalk Site Report on Downtime - Weekly</option></option>
                                            <option value="top_10_banglalink_link_reports_downtime_weekly">Top 10 Banglalink Site Report on Downtime - Weekly</option>
                                            <option value="top_10_airtel_link_reports_downtime_weekly">Top 10 Airtel Site Report on Downtime - Weekly</option>
                                            <option value="top_10_client_oh_problem_downtime_weekly">Top 10 Client Report on Downtime(Reason : OH) - Weekly</option>
                                            <option value="top_10_client_ug_problem_downtime_weekly">Top 10 Client Report on Downtime(Reason : UG) - Weekly</option>
                                            <!-- <option value="allFaults">All Faults</option> -->
                                        </select>
                                    </label>
                                </td>
                                <td><input type="submit" id="submit-button" value="Export" class="form-control input-transparent"></td>

                                </form>
                                <tr>
                                    <td>
                                        @if($_SESSION['dept_id']==10)
                                            <a href="{{ url('ExportUGCCP')}}" class="form-control input-transparent">Export Current CCP</a>
                                        @endif
                                    </td>
                                </tr>
                            </tr>
                        </table>

                       
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@include('navigation.p_footer')


