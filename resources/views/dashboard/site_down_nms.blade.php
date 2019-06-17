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

  function export_csv(){

      var arr_count = {{count($down_lists)}};

      var rows = [["host_name", "ip_addr","down_time","duration","client","district","device_type","memory_size","location","os_version","sysdescr","division","vendor","description","upazilla","serial_number","country","alarm_id","address","domain","alias","operating_system","model","mac_address","owner","technology"]];
    
      for(var i = 0; i<arr_count ; i++){
            var host_name = document.getElementById("host-name-"+i).innerText;
            //alert(host_name);
            var ip_addr = document.getElementById("ip-"+i).innerText;
            //alert(ip_addr);
            var down_time = document.getElementById("down-time-"+i).innerText;
            //alert(down_time);
            var duration = document.getElementById("duration-"+i).innerText;
            //alert(duration);
            var client = document.getElementById("client-"+i).innerText;
            //alert(client);

            var  district =  document.getElementById("district-"+i).value;
            var  device_type =  document.getElementById("device_type-"+i).value;
            var  memory_size =  document.getElementById("memory_size-"+i).value;
            var  location =  document.getElementById("location-"+i).value;
            var  os_version =  document.getElementById("os_version-"+i).value;
            var  sysdescr =  document.getElementById("sysdescr-"+i).value;
            var  division =  document.getElementById("division-"+i).value;
            var  vendor =  document.getElementById("vendor-"+i).value;
            var  description =  document.getElementById("description-"+i).value;
            var  upazilla =  document.getElementById("upazilla-"+i).value;
            var  serial_number =  document.getElementById("serial_number-"+i).value;
            var  country =  document.getElementById("country-"+i).value;
            var  alarm_id =  document.getElementById("alarm_id-"+i).value;
            var  address =  document.getElementById("address-"+i).value;
            var  domain =  document.getElementById("domain-"+i).value;
            var  alias =  document.getElementById("alias-"+i).value;
            var  operating_system =  document.getElementById("operating_system-"+i).value;
            var  model =  document.getElementById("model-"+i).value;
            var  mac_address =  document.getElementById("mac_address-"+i).value;
            var  owner =  document.getElementById("owner-"+i).value;
            var  technology =  document.getElementById("technology-"+i).value;


            host_name='"'+host_name+'"';
            ip_addr='"'+ip_addr+'"';
            down_time='"'+down_time+'"';
            duration='"'+duration+'"';
            client='"'+client+'"';
            district='"'+district+'"';
            device_type='"'+device_type+'"';
            memory_size='"'+memory_size+'"';
            location='"'+location+'"';
            os_version='"'+os_version+'"';
            sysdescr='"'+sysdescr+'"';
            division='"'+division+'"';
            vendor='"'+vendor+'"';
            description='"'+description+'"';
            upazilla='"'+upazilla+'"';
            serial_number='"'+serial_number+'"';
            country='"'+country+'"';
            alarm_id='"'+alarm_id+'"';
            address='"'+address+'"';
            domain='"'+domain+'"';
            alias='"'+alias+'"';
            operating_system='"'+operating_system+'"';
            mac_address='"'+mac_address+'"';
            model='"'+model+'"';
            owner='"'+owner+'"';
            technology='"'+technology+'"';

            var row = [host_name,ip_addr,down_time,duration,client,district,device_type,memory_size,location,os_version,sysdescr,division,vendor,description,upazilla,serial_number,country,alarm_id,address,domain,alias,operating_system,mac_address,model,owner,technology];
            rows.push(row);
      }   

      
            let csvContent = "data:text/csv;charset=utf-8,";
            rows.forEach(function(rowArray){
            let row = rowArray.join(",");
            csvContent += row + "\r\n";
            });

            // var encodedUri = encodeURI(csvContent);
            // window.open(encodedUri);


            var encodedUri = encodeURI(csvContent);

            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "my_data.csv");
            link.innerHTML= "Click Here to download";
            link.setAttribute("hidden", "true");
            document.body.appendChild(link); // Required for FF
            link.click();

            //alert(arr_count);
  }     
    
</script>
<body onload="JavaScript:AutoRefresh(300000);">
<div class="content container">
    <input type="hidden" id="json_data" name="json_data" value="{{$json_data}}">
    <h2 class="page-title">Site Down from NMS  <a href="javascript:export_csv();"><i class="fa fa-download"></i></a><span class="fw-semi-bold"></span></h2>  
	<div class="row">
            <div class="col-md-12">
                
                    <div class="body">
                        <table class="widget" id="incident_search_table">
                            <thead>
	                            <tr>
	                                <th>Site Name</th>
	                                <th>IP Address</th>
	                                <th>Downtime</th>
	                                <th>Duration</th>
	                                <th>Client</th>
                                    <th>Comment</th>
	                            </tr>
                            </thead>
                            <tbody>
                            @for($i=0;$i<count($down_lists);$i++)
                                    <tr id="myDiv">
                                        <td id="host-name-{{$i}}"><b>{{$down_lists[$i]->host_name}}</b></td>
                                        <td id="ip-{{$i}}">{{$down_lists[$i]->ip_addr}}</td>
                                        <td id="down-time-{{$i}}">{{$down_lists[$i]->down_time}}</td>
                                        <td id="duration-{{$i}}">{{$down_lists[$i]->duration}}</td>
                                        <td id="client-{{$i}}">{{$down_lists[$i]->client}}</td>
                                        <?php
                                            $comment = "";
                                            if($down_lists[$i]->comments == "-NA-"){
                                                $comment = "";
                                            }
                                            else{
                                                $temp_comment_arr = explode(",", $down_lists[$i]->comments);
                                                if(count($temp_comment_arr)>0){
                                                    foreach($temp_comment_arr as $single_comment){
                                                        $single_comment_arr = explode("-", $single_comment);
                                                        if(count($single_comment_arr)>1){
                                                            $comment .= $single_comment_arr[1].",";
                                                        }
                                                    }
                                                }else{

                                                }
                                            }
                                            $comment = rtrim($comment,',');
                                        ?>
                                        <td id="comments-{{$i}}">
                                            {{$comment}}
                                        </td>

                                        <input type="hidden" id="district-{{$i}}" value="{{$down_lists[$i]->district}}">
                                        <input type="hidden" id="device_type-{{$i}}" value="{{$down_lists[$i]->device_type}}">
                                        <input type="hidden" id="memory_size-{{$i}}" value="{{$down_lists[$i]->memory_size}}">
                                        <input type="hidden" id="location-{{$i}}" value="{{$down_lists[$i]->location}}">
                                        <input type="hidden" id="os_version-{{$i}}" value="{{$down_lists[$i]->os_version}}">
                                        <input type="hidden" id="sysdescr-{{$i}}" value="{{$down_lists[$i]->sysdescr}}">
                                        <input type="hidden" id="division-{{$i}}" value="{{$down_lists[$i]->division}}">
                                        <input type="hidden" id="vendor-{{$i}}" value="{{$down_lists[$i]->vendor}}">
                                        <input type="hidden" id="description-{{$i}}" value="{{$down_lists[$i]->description}}">
                                        <input type="hidden" id="upazilla-{{$i}}" value="{{$down_lists[$i]->upazilla}}">
                                        <input type="hidden" id="serial_number-{{$i}}" value="{{$down_lists[$i]->serial_number}}">
                                        <input type="hidden" id="country-{{$i}}" value="{{$down_lists[$i]->country}}">
                                        <input type="hidden" id="alarm_id-{{$i}}" value="{{$down_lists[$i]->alarm_id}}">
                                        <input type="hidden" id="address-{{$i}}" value="{{$down_lists[$i]->address}}">
                                        <input type="hidden" id="domain-{{$i}}" value="{{$down_lists[$i]->domain}}">
                                        <input type="hidden" id="alias-{{$i}}" value="{{$down_lists[$i]->alias}}">
                                        <input type="hidden" id="operating_system-{{$i}}" value="{{$down_lists[$i]->operating_system}}">
                                        <input type="hidden" id="model-{{$i}}" value="{{$down_lists[$i]->model}}">
                                        <input type="hidden" id="mac_address-{{$i}}" value="{{$down_lists[$i]->mac_address}}">
                                        <input type="hidden" id="owner-{{$i}}" value="{{$down_lists[$i]->owner}}">
                                        <input type="hidden" id="technology-{{$i}}" value="{{$down_lists[$i]->technology}}">


                                    </tr>
                            @endfor
                            </tbody>
                        </table>
                        <div class="clearfix">

                        </div>
                    </div>
            </div>
        </div>
</div>
</body>


@include('navigation.p_footer')