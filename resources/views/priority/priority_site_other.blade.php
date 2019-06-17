<!DOCTYPE html>
<html lang="en">
<head>
    <title>Priority Site Other Issues</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="{{asset('responsive_site_table/images/icons/favicon.ico')}}"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_site_table/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_site_table/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_site_table/vendor/animate/animate.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_site_table/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_site_table/vendor/perfect-scrollbar/perfect-scrollbar.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_site_table/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_site_table/css/main.css?v2')}}">
<!--===============================================================================================-->
</head>
<body>
    
    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <center><h3 style="color: white">Priority Site Other Issues List</h3></center>
                    <center>
                    <a href="{{ url('show_priority') }}" class="fa fa-backward" style="margin: 20px; color: red"></a>
                    </center>
                    <br>
                    <table>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">Ticket ID</th>
                                <th class="column2">Site Name</th>
                                <th class="column3">Client</th>
                                <th class="column4">Event Time</th>
                                <th class="column5">Duration</th>
                                <th class="column6">Remark</th>
                            </tr>
                        </thead>
                        <tbody>

                                @foreach($site_other_lists as $site_other_list)
                                <tr>
                                    <td class="column1">{{ $site_other_list->ticket_id }}</td>
                                    <td class="column2"><strong>{{ $site_other_list->site_name }}</strong></td>
                                    <td class="column3">{{ $site_other_list->client_name }}</td>
                                    <td class="column4">{{ $site_other_list->event_time }}</td>
                                    <td class="column5">{{ round($site_other_list->duration,2) }} Hr</td>
                                    <td class="column6">{{ $site_other_list->remark }}</td>    
                                </tr>
                                @endforeach
                                
                                
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    

<!--===============================================================================================-->  
    <script src="{{asset('responsive_site_table/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('responsive_site_table/vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{asset('responsive_site_table/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('responsive_site_table/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('responsive_site_table/js/main.js')}}"></script>

</body>
</html>