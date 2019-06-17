@include('navigation.p_header')
<link rel="stylesheet" type="text/css" href="{{asset('css/ticket_style.css')}}">
<style type="text/css">
	td{
    padding:10px;
    border:1px solid grey;
    text-align:center;
    /*background:#202A3A;*/
    font-size : 30px;
  }
  th{
    padding:10px;
    border:4px solid grey;
    text-align:center;
    font-weight: bold;
    background:#202A3A;
    font-size : 26px;

  }
</style>
<script type="text/javascript">
    
</script>
<body onload="JavaScript:AutoRefresh(300000);">
<div class="content container">
    <h2 class="page-title">Site Down from NMS<span class="fw-semi-bold"></span></h2>  
	<div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <div class="body">
                        <table id="incident_search_table">
                            <thead>
	                            <tr>
	                                <th>Site Name</th>
	                                <th>IP Address</th>
	                                <th>Downtime</th>
	                                <th>Duration</th>
	                                <th>Client</th>
	                            </tr>
                            </thead>
                            <tbody>
                            @for($i=0;$i<count($down_lists);$i++)
                                    <tr id="myDiv">
                                        <td><b>{{$down_lists[$i]->nodelabel}}</b></td>
                                        <td>{{$down_lists[$i]->ipaddr}}</td>
                                        <td>{{$down_lists[$i]->lasteventtime}}</td>
                                        <td>{{$down_lists[$i]->hr}} hr {{$down_lists[$i]->mnt}} min</td>
                                        <td>{{$down_lists[$i]->length}}</td>
                                    </tr>
                            @endfor
                            </tbody>
                        </table>
                        <div class="clearfix">

                        </div>
                    </div>
                </section>
            </div>
        </div>
</div>
</body>


@include('navigation.p_footer')