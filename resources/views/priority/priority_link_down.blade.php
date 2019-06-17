<!DOCTYPE html>
<html lang="en">
<head>
    <title>Priority Link Down</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="{{asset('responsive_link_table/images/icons/favicon.ico')}}"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_link_table/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_link_table/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_link_table/vendor/animate/animate.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_link_table/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_link_table/vendor/perfect-scrollbar/perfect-scrollbar.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_link_table/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('responsive_link_table/css/main.css?v2')}}">
<!--===============================================================================================-->
</head>
<body>
    
    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <center><h3 style="color: white">Priority Link Down List</h3></center>
                    <center>
                    <a href="{{ url('show_priority') }}" class="fa fa-backward" style="margin: 20px; color: red"></a>
                    </center>
                    <br>
                    <table>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">Ticket ID</th>
                                <th class="column2">NTTN Link Name</th>
                                <th class="column3">GW Link Name</th>
                                <th class="column4">Client</th>
                                <th class="column5">Problem Category</th>
                                <th class="column6">Link Capacity</th>
                                <th class="column7">Event Time</th>
                                <th class="column8">Duration</th>
                                <th class="column9">Remark</th>
                            </tr>
                        </thead>
                        <tbody>

                                @foreach($link_down_lists as $link_down_list)
                                <tr>
                                    <td class="column1">{{ $link_down_list->ticket_id }}</td>
                                    <td class="column2"><strong>{{ $link_down_list->link_name_nttn }}</strong></td>
                                    <td class="column3"><strong>{{ $link_down_list->link_name_gateway }}</strong></td>
                                    <td class="column4">{{ $link_down_list->client_name }}</td>
                                    <td class="column5">{{ $link_down_list->problem_category }}</td>
                                    <td class="column6">{{ $link_down_list->capacity_nttn }}</td>
                                    <td class="column7">{{ $link_down_list->event_time }}</td>
                                    <td class="column8">{{ round($link_down_list->duration,2) }} Hr</td>
                                    <td class="column9">{{ $link_down_list->remark }}</td>    
                                </tr>
                                @endforeach
                                
                                
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    

<!--===============================================================================================-->  
    <script src="{{asset('responsive_link_table/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('responsive_link_table/vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{asset('responsive_link_table/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('responsive_link_table/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('responsive_link_table/js/main.js')}}"></script>

</body>
</html>