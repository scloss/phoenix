<div id="incident_box">
    @if(isset($_SESSION["CURRENT_LIST"]))
    <section class="widget">
        <header>
            <center>
                <h4>Incident Cart</h4>
            </center>
        </header>
        <div class="body">
            @if(isset($_SESSION["CURRENT_LIST"]))
                <?php 
                $incident_list_arr = explode(',',$_SESSION["CURRENT_LIST"]);
                ?>
            @endif
            <table id="incident_cart_table">
                <tr>
                    <th>ID</th><th>Incident Title</th><th></th>
                </tr>
                @if(isset($_SESSION["CURRENT_LIST"]))
                    @for($i=0;$i<count($incident_list_arr);$i++)
                        <?php
                            $single_incident_arr = explode('|', $incident_list_arr[$i]);
                            $tempVar='';
                        ?>
                        <tr>
                        @for($j=0;$j<count($single_incident_arr);$j++)
                            <td>{{$single_incident_arr[$j]}}</td> 
                            <?php 
                                $tempVar .= $single_incident_arr[$j].'|';
                            ?>              
                        @endfor
                        <?php 
                            $tempVar = trim($tempVar,'|');  
                        ?>
                        <td><a href="#" id="{{$tempVar}}" onclick="incident_delete(this.id)"><span class="glyphicon glyphicon-remove-sign"></a></span></td>
                        </tr>
                    @endfor
                @endif
                <tr>
                    <td colspan="3"><a href="{{url('IncidentMerge')}}" class="btn btn-primary">Start Merging</a></td>
                </tr>
            </table>
        </div>
    </section>
    @endif
</div>
